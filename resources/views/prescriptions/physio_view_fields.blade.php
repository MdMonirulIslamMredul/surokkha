@php
    $pres = $prescription['prescription'];
    $patient = $pres->patient;
    $doctor = $pres->doctor;
    $docUser = $doctor ? $doctor->doctorUser : null;
    $patUser = $patient ? $patient->patientUser : null;
    $appName = !empty($data['app_name']) ? $data['app_name'] : 'Surokkha Physiotherapy and Autism Care';
    $vasScore = isset($pres->vas) ? (int)$pres->vas : null;
    $vasColors = [
        0 => '#28a745', 1 => '#48b846', 2 => '#6cbd45',
        3 => '#8fc244', 4 => '#b5c742', 5 => '#e0be38',
        6 => '#e69830', 7 => '#ea7328', 8 => '#ed4e20',
        9 => '#f02818', 10 => '#dc3545'
    ];
@endphp

{{-- Header Banner --}}
<div class="row align-items-center mb-5 pb-4 border-bottom">
    <div class="col-md-5 d-flex align-items-center">
        @php
            $viewLogo = null;
            if (!empty($data['app_logo'])) {
                $rawLogo = $data['app_logo'];
                if (filter_var($rawLogo, FILTER_VALIDATE_URL)) {
                    $viewLogo = $rawLogo;
                } elseif (file_exists(public_path($rawLogo))) {
                    $viewLogo = asset($rawLogo);
                } elseif (file_exists(storage_path('app/public/' . $rawLogo))) {
                    $viewLogo = asset('storage/' . $rawLogo);
                }
            }
            if (!$viewLogo && file_exists(public_path('uploads/clinic/clinic_emblem.png'))) {
                $viewLogo = asset('uploads/clinic/clinic_emblem.png');
            }
            if (!$viewLogo && file_exists(public_path('web/img/logo.jpg'))) {
                $viewLogo = asset('web/img/logo.jpg');
            }
        @endphp
        @if($viewLogo)
            <img src="{{ $viewLogo }}" style="height: 55px; max-width: 65px;" class="me-3" alt="Logo">
        @else
            <div class="me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 24px; font-weight: bold;">S</div>
        @endif
        <div>
            <h4 class="mb-0 fw-bolder text-primary">{{ !empty($data['clinic_name_bangla']) ? $data['clinic_name_bangla'] : 'সুরক্ষা ফিজিওথেরাপি এন্ড অটিজম কেয়ার' }}</h4>
            <h6 class="mb-0 text-success fw-bold">{{ !empty($data['clinic_name_eng']) ? $data['clinic_name_eng'] : (!empty($data['app_name']) ? $data['app_name'] : 'SUROKKHA PHYSIOTHERAPY AND AUTISM CARE') }}</h6>
            <small class="text-muted fst-italic">{{ !empty($data['clinic_subtitle']) ? $data['clinic_subtitle'] : 'A Specialized Center for Physical Rehabilitation & Neurodevelopment' }}</small>
        </div>
    </div>
    <div class="col-md-3 text-center border-start border-end">
        <div class="fs-6 fw-bold text-gray-700">Reg. No: <span class="text-primary">{{ $patient ? $patient->patient_unique_id : 'N/A' }}</span></div>
        <div class="fs-7 text-muted">Date: <span class="fw-bold">{{ \Carbon\Carbon::parse($pres->created_at)->format('d/m/Y') }}</span></div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <h4 class="mb-0 fw-bolder text-dark">{{ $docUser ? 'DR. ' . strtoupper($docUser->full_name) : 'DR. DEBAJIT GHOSH' }}</h4>
        <div class="text-muted fs-7">{{ $docUser && !empty($docUser->qualification) ? $docUser->qualification : 'BPT (DU), MD (Physiotherapy), PGT (Pediatric & Adult Rehab)' }}</div>
        <div class="text-primary fw-bold fs-7">{{ $doctor && !empty($doctor->specialist) ? $doctor->specialist : 'Consultant Physiotherapist & Autism Specialist' }}</div>
        <div class="text-muted fs-7">{{ !empty($data['clinic_name_eng']) ? $data['clinic_name_eng'] : (!empty($data['app_name']) ? $data['app_name'] : 'Surokkha Physiotherapy and Autism Care') }}</div>
    </div>
</div>

{{-- Patient Vitals Box --}}
<div class="rounded p-4 mb-6" style="background-color: #e6f4f6; border: 1px solid #b2dfe5;">
    <div class="row g-3">
        <div class="col-md-4"><span class="fw-bold text-primary">Patient Name:</span> <span class="text-gray-800 fw-bold">{{ $patUser ? $patUser->full_name : '' }}</span></div>
        <div class="col-md-2"><span class="fw-bold text-primary">Age:</span> <span class="text-gray-800">{{ $pres->patient_age ?? ($patient->age ?? 'N/A') }} Yrs</span></div>
        <div class="col-md-2"><span class="fw-bold text-primary">Sex:</span> <span class="text-gray-800">{{ $patUser ? ($patUser->gender == 0 ? 'Male' : 'Female') : 'M / F' }}</span></div>
        <div class="col-md-4 text-md-end"><span class="fw-bold text-primary">Date:</span> <span class="text-gray-800">{{ \Carbon\Carbon::parse($pres->created_at)->format('d/m/Y') }}</span></div>

        <div class="col-md-3"><span class="fw-bold text-primary">Height:</span> <span class="text-gray-800">{{ $pres->patient_height ?? ($patient->height ?? 'N/A') }} cm</span></div>
        <div class="col-md-3"><span class="fw-bold text-primary">Weight:</span> <span class="text-gray-800">{{ $pres->patient_weight ?? ($patient->weight ?? 'N/A') }} kg</span></div>
        <div class="col-md-3"><span class="fw-bold text-primary">BMI:</span> <span class="badge badge-light-success fw-bolder fs-7">{{ $pres->patient_bmi ?? ($patient->bmi ?? 'N/A') }} kg/m²</span></div>
        <div class="col-md-3 text-md-end"><span class="fw-bold text-primary">Occupation:</span> <span class="text-gray-800">{{ $pres->patient_occupation ?? ($patient->occupation ?? 'N/A') }}</span></div>
    </div>
</div>

{{-- Two Columns --}}
<div class="row g-5">
    {{-- Left Column: Clinical Assessment --}}
    <div class="col-lg-6 border-end">
        @if(!empty($pres->c_c))
            <div class="mb-4">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-comment-medical me-2"></i> C/C (Chief Complaints):</h6>
                <p class="text-gray-800 bg-light p-3 rounded mb-0">{{ $pres->c_c }}</p>
            </div>
        @endif

        @if(!empty($pres->h_o))
            <div class="mb-4">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-history me-2"></i> H/O (History Of):</h6>
                <p class="text-gray-800 bg-light p-3 rounded mb-0">{{ $pres->h_o }}</p>
            </div>
        @endif

        @if(!empty($pres->s_s))
            <div class="mb-4">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-stethoscope me-2"></i> S/S (Signs & Symptoms):</h6>
                <p class="text-gray-800 bg-light p-3 rounded mb-0">{{ $pres->s_s }}</p>
            </div>
        @endif

        @if(!empty($pres->investigation))
            <div class="mb-4">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-microscope me-2"></i> Investigation:</h6>
                <p class="text-gray-800 bg-light p-3 rounded mb-0">{{ $pres->investigation }}</p>
            </div>
        @endif

        {{-- VAS Pain Scale --}}
        <div class="mb-4 p-3 bg-light rounded border">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-primary fw-bold mb-0"><i class="fas fa-tachometer-alt me-2"></i> VAS (Pain Scale):</h6>
                @if($vasScore !== null)
                    <span class="badge bg-danger">Patient Score: {{ $vasScore }} / 10</span>
                @endif
            </div>
            <div class="d-flex gap-1 my-2">
                @for($i = 0; $i <= 10; $i++)
                    <div class="flex-fill text-center py-2 text-white fw-bold fs-7 rounded {{ ($vasScore !== null && $vasScore == $i) ? 'border border-3 border-dark shadow-lg' : 'opacity-75' }}"
                         style="background-color: {{ $vasColors[$i] }};">
                        {{ $i }}
                    </div>
                @endfor
            </div>
            <div class="d-flex justify-content-between fs-8 text-muted">
                <span class="text-success fw-bold">0 = No Pain</span>
                <span class="text-warning fw-bold">5 = Moderate</span>
                <span class="text-danger fw-bold">10 = Severe Pain</span>
            </div>
        </div>

        @if(!empty($pres->dx))
            <div class="mb-4">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-diagnoses me-2"></i> Dx (Diagnosis):</h6>
                <p class="text-danger fw-bold bg-light-danger p-3 rounded mb-0">{{ $pres->dx }}</p>
            </div>
        @endif

        @if(!empty($pres->advice))
            <div class="mb-3">
                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-lightbulb me-2"></i> Advice:</h6>
                <p class="text-gray-800 bg-light p-3 rounded mb-0">{{ $pres->advice }}</p>
            </div>
        @endif
    </div>

    {{-- Right Column: Treatment --}}
    <div class="col-lg-6">
        <div class="mb-5">
            <h5 class="text-success fw-bolder mb-2 d-flex align-items-center">
                <span class="fs-2 me-2" style="font-family: serif;">&#8478;</span> PT Rx (Physiotherapy Treatment):
            </h5>
            <div class="bg-light-success p-4 rounded border border-success border-dashed text-gray-800 fs-6 font-monospace" style="white-space: pre-line; min-height: 180px;">
                {{ $pres->pt_rx ?: 'No specific physical therapy modalities recorded.' }}
            </div>
        </div>

        @if(!empty($pres->medication_other_support))
            <div class="mb-5">
                <h6 class="text-info fw-bold mb-2"><i class="fas fa-pills me-2"></i> Medication / Other Support:</h6>
                <div class="bg-light-info p-3 rounded border border-info border-dashed text-gray-800" style="white-space: pre-line;">
                    {{ $pres->medication_other_support }}
                </div>
            </div>
        @endif

        @if(isset($pres->getMedicine) && count($pres->getMedicine) > 0)
            <div class="mb-5">
                <h6 class="text-primary fw-bold mb-2"><i class="fas fa-capsules me-2"></i> Pharmacy Medicines:</h6>
                <div class="table-responsive">
                    <table class="table table-row-dashed table-striped align-middle">
                        <thead class="bg-light">
                            <tr class="fw-bold text-gray-700">
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pres->getMedicine as $item)
                                @php
                                    $medObj = \App\Models\Medicine::find($item->medicine);
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $medObj ? $medObj->name : 'N/A' }}</td>
                                    <td>{{ $item->dosage }}</td>
                                    <td>{{ $item->day }} days</td>
                                    <td>{{ $item->comment ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="text-end mt-10 pt-5">
            <div class="d-inline-block text-center border-top border-dark pt-2" style="min-width: 180px;">
                <span class="fw-bold text-gray-700">Doctor's Signature</span>
            </div>
        </div>
    </div>
</div>

