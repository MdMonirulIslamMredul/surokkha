<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Referrer;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReferrerController extends AppBaseController
{
    public function index(Request $request)
    {
        $query = Referrer::with(['user', 'patients', 'testServiceBills', 'payouts'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('refer_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('occupation', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $referrers = $query->paginate(15);

        return view('referrers.index', compact('referrers'));
    }

    public function create()
    {
        return view('referrers.create');
    }

    public function store(Request $request)
    {
        $request->validate(Referrer::$rules);

        try {
            DB::beginTransaction();

            $referralDept = Department::where('name', 'Referral')->first();
            $deptId = $referralDept ? $referralDept->id : null;

            $password = ! empty($request->password) ? $request->password : '12345678';

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? '',
                'email' => $request->email ?: null,
                'phone' => $request->phone,
                'password' => Hash::make($password),
                'gender' => $request->gender ?? 0,
                'status' => 1,
                'department_id' => $deptId,
                'email_verified_at' => Carbon::now(),
            ]);

            $referCode = Referrer::generateReferCode();

            $referrer = Referrer::create([
                'user_id' => $user->id,
                'refer_code' => $referCode,
                'occupation' => $request->occupation,
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => 1,
            ]);

            $user->update([
                'owner_id' => $referrer->id,
                'owner_type' => Referrer::class,
            ]);

            if ($deptId) {
                $user->assignRole($deptId);
            }

            DB::commit();

            Flash::success("Referrer registered successfully! Generated Referral Code: {$referCode}");

            return redirect()->route('referrers.index');
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Error registering referrer: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $referrer = Referrer::with([
            'user',
            'patients.patientUser',
            'testServiceBills.patient.patientUser',
            'payouts.paidBy',
        ])->findOrFail($id);

        return view('referrers.show', compact('referrer'));
    }

    public function edit($id)
    {
        $referrer = Referrer::with('user')->findOrFail($id);

        return view('referrers.edit', compact('referrer'));
    }

    public function update(Request $request, $id)
    {
        $referrer = Referrer::with('user')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:100',
            'occupation' => 'nullable|string|max:100',
            'address' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $referrer->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? '',
                'email' => $request->email ?: null,
                'phone' => $request->phone,
            ]);

            $referrer->update([
                'occupation' => $request->occupation,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

            DB::commit();

            Flash::success('Referrer updated successfully.');

            return redirect()->route('referrers.index');
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Error updating referrer: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function dashboard()
    {
        $user = Auth::user();
        $referrer = Referrer::with([
            'patients.patientUser',
            'testServiceBills.patient.patientUser',
            'payouts.paidBy',
        ])->where('user_id', $user->id)->firstOrFail();

        $totalEarnings = $referrer->total_earnings;
        $totalPaid = $referrer->total_paid;
        $balance = $referrer->balance;
        $patientsCount = $referrer->patients->count();
        $recentBills = $referrer->testServiceBills()->orderBy('created_at', 'desc')->take(10)->get();
        $recentPayouts = $referrer->payouts()->orderBy('created_at', 'desc')->take(10)->get();

        return view('referrers.dashboard', compact(
            'referrer',
            'totalEarnings',
            'totalPaid',
            'balance',
            'patientsCount',
            'recentBills',
            'recentPayouts'
        ));
    }

    public function publicRegister()
    {
        return view('referrers.public_register');
    }

    public function publicStore(Request $request)
    {
        $request->validate(Referrer::$rules);

        try {
            DB::beginTransaction();

            $referralDept = Department::where('name', 'Referral')->first();
            $deptId = $referralDept ? $referralDept->id : null;

            $password = ! empty($request->password) ? $request->password : '12345678';

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? '',
                'email' => $request->email ?: null,
                'phone' => $request->phone,
                'password' => Hash::make($password),
                'gender' => $request->gender ?? 0,
                'status' => 1,
                'department_id' => $deptId,
                'email_verified_at' => Carbon::now(),
            ]);

            $referCode = Referrer::generateReferCode();

            $referrer = Referrer::create([
                'user_id' => $user->id,
                'refer_code' => $referCode,
                'occupation' => $request->occupation,
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => 1,
            ]);

            $user->update([
                'owner_id' => $referrer->id,
                'owner_type' => Referrer::class,
            ]);

            if ($deptId) {
                $user->assignRole($deptId);
            }

            DB::commit();

            Flash::success("Registration successful! Your Referrer Code is {$referCode}. You can now log in using your Phone Number or Email with your password.");

            return redirect()->route('login');
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}

