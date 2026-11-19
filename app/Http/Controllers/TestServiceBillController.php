<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\PathologyTest;
use App\Models\Patient;
use App\Models\RadiologyTest;
use App\Models\Referrer;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TestServiceBill;
use App\Models\TestServiceBillItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestServiceBillController extends AppBaseController
{
    public function index(Request $request)
    {
        $query = TestServiceBill::with(['patient.patientUser', 'doctor.doctorUser', 'referrer.user'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('bill_number', 'like', "%{$search}%")
                    ->orWhereHas('patient.patientUser', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $bills = $query->paginate(15);

        return view('test_service_bills.index', compact('bills'));
    }

    public function create()
    {
        $patients = Patient::with('patientUser', 'referrer.user')->get()->mapWithKeys(function ($p) {
            $name = $p->patientUser->full_name ?? 'N/A';
            $phone = $p->patientUser->phone ?? '';
            return [$p->id => "{$name} ({$phone}) - ID: {$p->patient_unique_id}"];
        });

        $doctors = Doctor::with('doctorUser')->get()->mapWithKeys(function ($d) {
            return [$d->id => $d->doctorUser->full_name ?? 'Dr. ' . $d->id];
        });

        $pathologyTests = PathologyTest::orderBy('test_name')->get(['id', 'test_name', 'standard_charge']);
        $radiologyTests = RadiologyTest::orderBy('test_name')->get(['id', 'test_name', 'standard_charge']);
        $services = Service::where('status', 1)->orderBy('name')->get(['id', 'name', 'rate']);

        $globalCommission = (float) (Setting::where('key', 'referral_commission_percentage')->value('value') ?? 10);

        return view('test_service_bills.create', compact(
            'patients',
            'doctors',
            'pathologyTests',
            'radiologyTests',
            'services',
            'globalCommission'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'items' => 'required|array|min:1',
            'items.*.item_type' => 'required|in:pathology,radiology,service',
            'items.*.item_id' => 'required',
            'items.*.item_name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,amount',
            'discount_value' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $patient = Patient::findOrFail($request->patient_id);
            $referrerId = $patient->referrer_id;

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += ((float) $item['price'] * (int) $item['quantity']);
            }

            $discountType = $request->discount_type;
            $discountValue = (float) ($request->discount_value ?? 0);
            $discountAmount = 0;

            if ($discountType === 'percentage') {
                $discountAmount = round(($totalAmount * $discountValue) / 100, 2);
            } else {
                $discountAmount = min($discountValue, $totalAmount);
            }

            $netAmount = max(0, round($totalAmount - $discountAmount, 2));

            // Referral commission calculation on net amount
            $commissionPercent = (float) (Setting::where('key', 'referral_commission_percentage')->value('value') ?? 10);
            $commissionAmount = 0;

            if (! empty($referrerId)) {
                $commissionAmount = round(($netAmount * $commissionPercent) / 100, 2);
            }

            $bill = TestServiceBill::create([
                'bill_number' => TestServiceBill::generateBillNumber(),
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'referrer_id' => $referrerId,
                'total_amount' => $totalAmount,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'discount_amount' => $discountAmount,
                'net_amount' => $netAmount,
                'payment_status' => TestServiceBill::STATUS_PAID,
                'payment_method' => $request->payment_method ?? 'Cash',
                'referral_commission_percent' => ! empty($referrerId) ? $commissionPercent : 0,
                'referral_commission_amount' => $commissionAmount,
                'note' => $request->note,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                TestServiceBillItem::create([
                    'test_service_bill_id' => $bill->id,
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'price' => (float) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'amount' => (float) $item['price'] * (int) $item['quantity'],
                ]);
            }

            DB::commit();

            Flash::success('Diagnostic & Service Bill created successfully. Bill #: ' . $bill->bill_number);

            return redirect()->route('test-service-bills.show', $bill->id);
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Error creating bill: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $bill = TestServiceBill::with([
            'patient.patientUser',
            'patient.address',
            'doctor.doctorUser',
            'referrer.user',
            'items',
            'creator',
        ])->findOrFail($id);

        return view('test_service_bills.show', compact('bill'));
    }

    public function printPdf($id)
    {
        $bill = TestServiceBill::with([
            'patient.patientUser',
            'patient.address',
            'doctor.doctorUser',
            'referrer.user',
            'items',
            'creator',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('test_service_bills.bill_pdf', compact('bill'));

        return $pdf->stream("Bill-{$bill->bill_number}.pdf");
    }

    public function getPatientDetails($id): JsonResponse
    {
        $patient = Patient::with(['patientUser', 'referrer.user'])->find($id);

        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $patient->id,
                'name' => $patient->patientUser->full_name ?? '',
                'phone' => $patient->patientUser->phone ?? '',
                'age' => $patient->age ?? '',
                'gender' => $patient->patientUser->gender == 0 ? 'Male' : 'Female',
                'unique_id' => $patient->patient_unique_id,
                'referrer' => $patient->referrer ? [
                    'id' => $patient->referrer->id,
                    'name' => $patient->referrer->user->full_name ?? '',
                    'code' => $patient->referrer->refer_code,
                ] : null,
            ],
        ]);
    }
}

