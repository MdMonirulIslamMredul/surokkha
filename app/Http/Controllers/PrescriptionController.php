<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicineRequest;
use App\Http\Requests\CreatePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Repositories\MedicineRepository;
use App\Repositories\PrescriptionRepository;
use \PDF;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use OpenAI;

class PrescriptionController extends AppBaseController
{
    /** @var  PrescriptionRepository
     * @var DoctorRepository
     */
    private $prescriptionRepository;

    private $doctorRepository;

    private $medicineRepository;

    public function __construct(
        PrescriptionRepository $prescriptionRepo,
        DoctorRepository $doctorRepository,
        MedicineRepository $medicineRepository

    ) {
        $this->prescriptionRepository = $prescriptionRepo;
        $this->doctorRepository = $doctorRepository;
        $this->medicineRepository = $medicineRepository;
    }

    public function index()
    {
        $data['statusArr'] = Prescription::STATUS_ARR;

        return view('prescriptions.index', $data);
    }

    public function create()
    {
        $patients = $this->prescriptionRepository->getPatients();
        $medicines = $this->prescriptionRepository->getMedicines();
        $doctors = $this->doctorRepository->getDoctors();
        $data = $this->medicineRepository->getSyncList();
        $medicineList = $this->medicineRepository->getMedicineList($medicines['medicines']);
        $mealList = $this->medicineRepository->getMealList();
        $doseDurationList = $this->medicineRepository->getDoseDurationList();
        $doseIntervalList = $this->medicineRepository->getDoseIntervalList();

        return view(
            'prescriptions.create',
            compact('patients', 'doctors', 'medicines', 'medicineList', 'mealList', 'doseDurationList', 'doseIntervalList')
        )->with($data);
    }

    public function store(CreatePrescriptionRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $input['prescription_type'] = $input['prescription_type'] ?? Prescription::TYPE_PHYSIOTHERAPY;

        $hasMedicines = isset($input['medicine']) && is_array($input['medicine']) && count(array_filter($input['medicine'])) > 0;

        if (! $hasMedicines && $input['prescription_type'] === Prescription::TYPE_GENERAL) {
            return $this->sendError(__('messages.medicine_bills.medicine_not_selected'));
        }

        if ($hasMedicines) {
            $arr = collect($input['medicine']);
            $duplicateIds = $arr->duplicates();

            foreach ($input['medicine'] as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $medicine = Medicine::find($value);
                if (!empty($duplicateIds) && isset($duplicateIds[$key])) {
                    Flash::error(__('messages.medicine_bills.duplicate_medicine'));

                    return Redirect::back();
                }

                $qty = ($input['day'][$key] ?? 1) * ($input['dose_interval'][$key] ?? 1);

                if ($medicine && $medicine->available_quantity < $qty) {
                    $available = $medicine->available_quantity == null ? 0 : $medicine->available_quantity;
                    Flash::error(__('messages.medicine_bills.available_quantity') . ' ' . $medicine->name . ' ' . __('messages.medicine_bills.is') . ' ' . $available . '.');

                    return Redirect::back();
                }
            }
        }

        $prescription = $this->prescriptionRepository->create($input);
        if ($hasMedicines) {
            $this->prescriptionRepository->createPrescription($input, $prescription);
        }
        $this->prescriptionRepository->createNotification($input);
        Flash::success(__('messages.prescription.prescription') . ' ' . __('messages.common.saved_successfully'));

        return redirect(route('prescriptions.index'));
    }

    public function show(Prescription $prescription)
    {
        $prescription = $this->prescriptionRepository->find($prescription->id);

        if (empty($prescription)) {
            Flash::error(__('messages.prescription.prescription') . ' ' . __('messages.common.not_found'));

            return redirect(route('prescriptions.index'));
        }

        return view('prescriptions.show')->with('prescription', $prescription);
    }

    public function edit(Prescription $prescription)
    {
        if (getLoggedinDoctor() && checkRecordAccess($prescription->doctor_id)) {
            return view('errors.404');
        } else {

            $prescription->getMedicine;
            $patients = $this->prescriptionRepository->getPatients();
            $doctors = $this->doctorRepository->getDoctors();
            $medicines = $this->prescriptionRepository->getMedicines();
            $data = $this->medicineRepository->getSyncList();
            $medicineList = $this->medicineRepository->getMedicineList($medicines['medicines']);
            $mealList = $this->medicineRepository->getMealList();
            $doseDurationList = $this->medicineRepository->getDoseDurationList();
            $doseIntervalList = $this->medicineRepository->getDoseIntervalList();
            $medicineQty = Medicine::pluck('available_quantity', 'id');

            return view(
                'prescriptions.edit',
                compact('patients', 'prescription', 'doctors', 'medicines', 'medicineList', 'mealList', 'doseDurationList', 'doseIntervalList', 'medicineQty')
            )->with($data);
        }
    }

    public function update(Prescription $prescription, UpdatePrescriptionRequest $request)
    {
        $prescription = $this->prescriptionRepository->find($prescription->id);

        if (empty($prescription)) {
            Flash::error(__('messages.medicine_bills.prescription_not_found'));

            return redirect(route('prescriptions.index'));
        }

        $prescription->load('getMedicine');
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $input['prescription_type'] = $input['prescription_type'] ?? $prescription->prescription_type ?? Prescription::TYPE_PHYSIOTHERAPY;

        $hasMedicines = isset($input['medicine']) && is_array($input['medicine']) && count(array_filter($input['medicine'])) > 0;

        if ($hasMedicines) {
            $prescriptionMedicineArray = [];
            $inputdoseAndMedicine = [];

            foreach ($prescription->getMedicine as $prescriptionMedicine) {
                $prescriptionMedicineArray[$prescriptionMedicine->medicine] = $prescriptionMedicine->dosage;
            }
            if (isset($request->medicine) && is_array($request->medicine)) {
                foreach ($request->medicine as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $inputdoseAndMedicine[$value] = $request->dosage[$key] ?? '';
                }
            }

            $arr = collect($input['medicine']);
            $duplicateIds = $arr->duplicates();

            foreach ($input['medicine'] as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $result = array_intersect($prescriptionMedicineArray, $inputdoseAndMedicine);
                $medicine = Medicine::find($value);
                $qty = ($input['day'][$key] ?? 1) * ($input['dose_interval'][$key] ?? 1);

                if (!empty($duplicateIds) && isset($duplicateIds[$key])) {
                    Flash::error(__('messages.medicine_bills.duplicate_medicine'));

                    return Redirect::back();
                }

                if ($medicine && !array_key_exists($value, $result) && $medicine->available_quantity < $qty) {
                    $available = $medicine->available_quantity == null ? 0 : $medicine->available_quantity;
                    Flash::error(__('messages.common.available_quantity_of') . $medicine->name . __('messages.common.is') . $available . '.');

                    return Redirect::back();
                }
            }
        }

        $this->prescriptionRepository->updatePrescription($prescription, $input);

        Flash::success(__('messages.prescription.prescription') . ' ' . __('messages.common.updated_successfully'));

        return redirect(route('prescriptions.index'));
    }

    public function destroy(Prescription $prescription)
    {
        if (checkRecordAccess($prescription->doctor_id)) {
            $this->sendError(__('messages.prescription.prescription') . ' ' . __('messages.common.not_found'));
        } else {
            $prescription = $this->prescriptionRepository->find($prescription->id);

            if (empty($prescription)) {
                Flash::error(__('messages.prescription.prescription') . ' ' . __('messages.common.not_found'));

                return redirect(route('prescriptions.index'));
            }
            $prescription->delete();

            return $this->sendSuccess(__('messages.prescription.prescription') . ' ' . __('messages.common.deleted_successfully'));
        }
    }

    public function activeDeactiveStatus($id)
    {
        $prescription = Prescription::find($id);

        if (getLoggedinDoctor() && checkRecordAccess($prescription->doctor_id)) {
            return $this->sendError(__('messages.prescription.prescription') . ' ' . __('messages.common.not_found'));
        } else {
            $status = !$prescription->status;
            $prescription->update(['status' => $status]);

            return $this->sendSuccess(__('messages.common.status_updated_successfully'));
        }
    }

    public function prescriptionsView($id)
    {
        $data = $this->prescriptionRepository->getSettingList();

        $prescription = $this->prescriptionRepository->getData($id);

        if (getLoggedinDoctor() && checkRecordAccess($prescription['prescription']->doctor_id)) {
            return view('errors.404');
        } else {
            $medicines = $this->prescriptionRepository->getMedicineData($id);

            return view('prescriptions.view', compact('prescription', 'medicines', 'data'));
        }
    }

    public function prescreptionMedicineStore(CreateMedicineRequest $request)
    {
        $input = $request->all();

        $this->medicineRepository->create($input);

        return $this->sendSuccess(__('messages.medicine.medicine') . ' ' . __('messages.common.saved_successfully'));
    }

    public function convertToPDF($id)
    {
        $data = $this->prescriptionRepository->getSettingList();

        $prescription = $this->prescriptionRepository->getData($id);

        $medicines = $this->prescriptionRepository->getMedicineData($id);

        $viewName = ($prescription['prescription']->prescription_type === Prescription::TYPE_PHYSIOTHERAPY)
            ? 'prescriptions.physio_prescription_pdf'
            : 'prescriptions.prescription_pdf';

        return $this->generateMpdfResponse($viewName, compact('prescription', 'medicines', 'data'), $prescription['prescription']);
    }

    private function generateMpdfResponse($viewName, $compactData, $prescriptionModel)
    {
        try {
            $tempDir = storage_path('mpdf');
            if (!file_exists($tempDir)) {
                @mkdir($tempDir, 0777, true);
            }
            if (!file_exists($tempDir . '/mpdf')) {
                @mkdir($tempDir . '/mpdf', 0777, true);
            }
            if (!file_exists($tempDir . '/ttfontdata')) {
                @mkdir($tempDir . '/ttfontdata', 0777, true);
            }

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => $tempDir,
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 8,
                'margin_right' => 8,
                'margin_top' => 6,
                'margin_bottom' => 12,
                'margin_header' => 0,
                'margin_footer' => 3,
                'fontDir' => array_merge($fontDirs, [
                    public_path('fonts/bangla'),
                ]),
                'fontdata' => $fontData + [
                    'kalpurush' => [
                        'R' => 'kalpurush.ttf',
                        'useOTL' => 0xFF,
                        'useKashida' => 75,
                    ],
                    'vrinda' => [
                        'R' => 'vrinda.ttf',
                        'B' => 'vrindab.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],
                'default_font' => 'kalpurush',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ]);

            // Set dynamic watermark if available
            $logoPath = null;
            $data = $compactData['data'] ?? [];
            if (!empty($data['app_logo'])) {
                $rawLogo = $data['app_logo'];
                if (filter_var($rawLogo, FILTER_VALIDATE_URL)) {
                    $pathOnly = parse_url($rawLogo, PHP_URL_PATH);
                    $cand = public_path(ltrim($pathOnly, '/\\'));
                    if (file_exists($cand)) {
                        $logoPath = $cand;
                    }
                } elseif (file_exists(public_path($rawLogo))) {
                    $logoPath = public_path($rawLogo);
                } elseif (file_exists(storage_path('app/public/' . $rawLogo))) {
                    $logoPath = storage_path('app/public/' . $rawLogo);
                }
            }
            if (!$logoPath && file_exists(public_path('uploads/clinic/clinic_emblem.png'))) {
                $logoPath = public_path('uploads/clinic/clinic_emblem.png');
            }
            if (!$logoPath && file_exists(public_path('web/img/logo.jpg'))) {
                $logoPath = public_path('web/img/logo.jpg');
            }

            if ($logoPath && file_exists($logoPath)) {
                $mpdf->SetWatermarkImage($logoPath, 0.04, [65, 65], [72, 105]);
                $mpdf->showWatermarkImage = true;
            }

            $html = view($viewName, $compactData)->render();
            $mpdf->WriteHTML($html);

            $patientName = ($prescriptionModel->patient && $prescriptionModel->patient->patientUser)
                ? $prescriptionModel->patient->patientUser->full_name
                : 'Prescription';
            $fileName = $patientName . '-' . $prescriptionModel->id . '.pdf';

            return response($mpdf->Output($fileName, 'S'))
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
        } catch (\Throwable $e) {
            \Log::error('mPDF Generation failed, falling back to Dompdf: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            $pdf = PDF::loadView($viewName, $compactData);
            $fileName = ($prescriptionModel->patient && $prescriptionModel->patient->patientUser ? $prescriptionModel->patient->patientUser->full_name : 'Prescription') . '-' . $prescriptionModel->id;
            return $pdf->stream($fileName);
        }
    }

    public function getPatientVitals($id)
    {
        $patient = \App\Models\Patient::with('patientUser')->find($id);
        if (! $patient) {
            return $this->sendError('Patient not found');
        }

        $age = $patient->age;
        if (empty($age) && ! empty($patient->patientUser->dob)) {
            $age = \Carbon\Carbon::parse($patient->patientUser->dob)->age;
        }

        return $this->sendResponse([
            'id' => $patient->id,
            'name' => $patient->patientUser->full_name,
            'gender' => $patient->patientUser->gender == 0 ? 'M' : 'F',
            'gender_text' => $patient->patientUser->gender == 0 ? 'Male' : 'Female',
            'age' => $age,
            'height' => $patient->height,
            'weight' => $patient->weight,
            'bmi' => $patient->bmi,
            'occupation' => $patient->occupation,
            'unique_id' => $patient->patient_unique_id,
            'phone' => $patient->patientUser->phone,
        ], 'Patient vitals retrieved successfully');
    }

    public function printBlankPad(Request $request)
    {
        $data = $this->prescriptionRepository->getSettingList();
        $patient = null;
        if ($request->has('patient_id') && ! empty($request->patient_id)) {
            $patient = \App\Models\Patient::with('patientUser')->find($request->patient_id);
        }
        $doctor = null;
        if (getLoggedinDoctor()) {
            $doctor = \App\Models\Doctor::with('doctorUser', 'address')->where('user_id', \Auth::id())->first();
        } elseif ($request->has('doctor_id') && ! empty($request->doctor_id)) {
            $doctor = \App\Models\Doctor::with('doctorUser', 'address')->find($request->doctor_id);
        } else {
            $doctor = \App\Models\Doctor::with('doctorUser', 'address')->first();
        }

        return view('prescriptions.blank_pad', compact('data', 'patient', 'doctor'));
    }

    public function getAvailableMedicineQuantity(Medicine $medicine)
    {
        return $this->sendResponse($medicine, 'Retrieved successfully');
    }

    public function openAiPrompt(Request $request)
    {
        $patientDetails = $request->all();

        try {
            if (empty(array_filter($patientDetails))) {
                return $this->sendError(__('messages.open_ai.provide_prompt'));
            }

            $patientInfo = "Patient Details:\n";
            foreach ($patientDetails as $key => $value) {
                if ($value === null) {
                    continue;
                }
                $patientInfo .= "- " . ucwords($key) . ": " . $value . "\n";
            }

            $prompt = <<<PROMPT
                $patientInfo

                Prescription Request:

                1. Dose Duration: Choose one:
                    - Only one day
                    - Upto Three days
                    - Upto One week
                    - Upto two week
                    - Upto one month

                2. Dose Interval: Choose one:
                    - Daily morning
                    - Daily morning and evening
                    - Daily morning, noon, and evening
                    - 4 times in a day

                3. Time: Choose one:
                    - After Meal
                    - Before Meal

                Please provide the prescription details for multiple medicines in JSON format, choosing from the options provided. Ensure to include at least 3 or more medicine entries. Use the format below:

                json


                                {
                    "medicines": [
                        {
                            "Real Medicine Name": "Provide real Medicine name",
                            "Dosage": "Provide Dosage count in only number",
                            "Dose Duration": "Choose from the options from Dose Duration",
                            "Dose Interval": "Choose from the options from Dose Interval",
                            "Time": "Choose from the options from Time",
                            "Comment": "Please give guide"
                        },
                        ...
                    ]
                }
                PROMPT;

            // Retrieve API key from settings or configuration
            $openAiKey = Setting::where('key', '=', 'open_ai_key')->first()->value;
            $openAiModelName = Setting::where('key', '=', 'model_name')->first()->value;

            if (empty($openAiKey)) {
                $openAiKey = config('services.open_ai.open_api_key');
            }

            if (empty($openAiModelName)) {
                $openAiModelName = 'gpt-3.5-turbo';
            }

            if (!$openAiKey) {
                return $this->sendError(__('messages.open_ai.open_ai_key_not_found'));
            }

            $client = new \GuzzleHttp\Client();

            $data = \Illuminate\Support\Facades\Http::withToken($openAiKey)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $openAiModelName,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                ]);

            if (isset($data->json()['error'])) {
                return $this->sendError($data->json()['error']['message']);
            } else {
                $response = json_decode($data->json()['choices'][0]['message']['content'], true);
                return $this->sendResponse($response, __('messages.open_ai.repsonse_retrive_successfully'));
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
