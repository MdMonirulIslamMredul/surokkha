<div class="card mb-5 border border-primary border-dashed">
    <div class="card-header bg-light-primary py-3">
        <h4 class="card-title text-primary mb-0">
            <i class="fas fa-user-injured me-2"></i> Patient Clinical Vitals & Consultation Snapshot
        </h4>
        <span class="badge badge-light-info text-gray-700">Auto-filled from Patient Profile & Editable</span>
    </div>
    <div class="card-body py-4 bg-light">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Patient Reg. No:</label>
                <input type="text" id="patientRegNo" class="form-control bg-white" readonly placeholder="Auto-populated">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Age (Years):</label>
                <input type="number" name="patient_age" id="patientAge" class="form-control bg-white"
                       value="{{ isset($prescription) ? $prescription->patient_age : '' }}" placeholder="e.g. 35">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Sex:</label>
                <input type="text" id="patientSex" class="form-control bg-white" readonly
                       value="{{ isset($prescription) && $prescription->patient ? ($prescription->patient->patientUser->gender == 0 ? 'Male' : 'Female') : '' }}"
                       placeholder="M / F">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Occupation:</label>
                <input type="text" name="patient_occupation" id="patientOccupation" class="form-control bg-white"
                       value="{{ isset($prescription) ? $prescription->patient_occupation : '' }}" placeholder="e.g. Teacher, Engineer">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Height (cm):</label>
                <input type="number" step="0.1" name="patient_height" id="patientHeight" class="form-control bg-white"
                       value="{{ isset($prescription) ? $prescription->patient_height : '' }}" placeholder="e.g. 170">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Weight (kg):</label>
                <input type="number" step="0.1" name="patient_weight" id="patientWeight" class="form-control bg-white"
                       value="{{ isset($prescription) ? $prescription->patient_weight : '' }}" placeholder="e.g. 72">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">BMI (kg/m²):</label>
                <input type="text" name="patient_bmi" id="patientBmi" class="form-control bg-light fw-bold" readonly
                       value="{{ isset($prescription) ? $prescription->patient_bmi : '' }}" placeholder="Auto calculated">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-gray-700">Date:</label>
                <input type="text" class="form-control bg-white" readonly value="{{ date('d/m/Y') }}">
            </div>
        </div>
    </div>
</div>

{{-- Two-Column Clinical Assessment & Treatment --}}
<div class="row g-5">
    {{-- Left Column: Clinical Assessment --}}
    <div class="col-lg-6">
        <div class="card h-100 border border-gray-300 shadow-sm">
            <div class="card-header bg-light py-3 border-bottom">
                <h4 class="card-title text-gray-800 mb-0">
                    <i class="fas fa-stethoscope text-primary me-2"></i> Clinical Assessment
                </h4>
            </div>
            <div class="card-body p-4">
                {{-- C/C (Chief Complaints) --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-primary text-white me-2">C/C</span>
                        Chief Complaints:
                    </label>
                    <textarea name="c_c" class="form-control" rows="3"
                              placeholder="e.g., Severe lower back pain radiating to left leg for 2 weeks, morning stiffness in knees">{{ isset($prescription) ? $prescription->c_c : '' }}</textarea>
                    <small class="text-muted">Primary symptoms or reasons the patient is seeking care.</small>
                </div>

                {{-- H/O (History Of) --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-primary text-white me-2">H/O</span>
                        History Of:
                    </label>
                    <textarea name="h_o" class="form-control" rows="3"
                              placeholder="e.g., Trauma/sports injury 3 months ago, HTN (controlled), DM (Type 2)">{{ isset($prescription) ? $prescription->h_o : '' }}</textarea>
                    <small class="text-muted">Medical history relevant to the condition (trauma, surgeries, chronic disease).</small>
                </div>

                {{-- S/S (Signs & Symptoms) --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-primary text-white me-2">S/S</span>
                        Signs & Symptoms:
                    </label>
                    <textarea name="s_s" class="form-control" rows="3"
                              placeholder="e.g., Tenderness at L4-L5, restricted lumbar flexion by 40%, positive SLR at 45°">{{ isset($prescription) ? $prescription->s_s : '' }}</textarea>
                    <small class="text-muted">Objective clinical findings observed by doctor and subjective problems reported.</small>
                </div>

                {{-- Investigation --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-primary text-white me-2"><i class="fas fa-microscope text-white"></i></span>
                        Investigation:
                    </label>
                    <textarea name="investigation" class="form-control" rows="3"
                              placeholder="e.g., MRI Lumbar Spine: L4-L5 disc protrusion; X-Ray Knee: Reduced joint space">{{ isset($prescription) ? $prescription->investigation : '' }}</textarea>
                    <small class="text-muted">Lab findings, diagnostic imaging (X-Ray, MRI, USG), or tests advised.</small>
                </div>

                {{-- VAS (Visual Analogue Scale 0-10) --}}
                <div class="mb-4 p-3 rounded bg-light border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold fs-6 text-gray-800 mb-0 d-flex align-items-center">
                            <span class="badge bg-danger text-white me-2">VAS</span>
                            Visual Analogue Scale (Pain Measurement 0–10):
                        </label>
                        <span class="badge bg-dark fs-7" id="vasCurrentBadge">
                            Score: {{ isset($prescription->vas) ? $prescription->vas : '0' }} / 10
                        </span>
                    </div>
                    <input type="hidden" name="vas" id="prescriptionVas"
                           value="{{ isset($prescription->vas) ? $prescription->vas : '0' }}">

                    {{-- Colored Buttons Gauge --}}
                    <div class="d-flex justify-content-between align-items-center gap-1 my-2">
                        @php
                            $currentVas = isset($prescription->vas) ? (int)$prescription->vas : 0;
                            $vasColors = [
                                0 => '#28a745', 1 => '#48b846', 2 => '#6cbd45',
                                3 => '#8fc244', 4 => '#b5c742', 5 => '#e0be38',
                                6 => '#e69830', 7 => '#ea7328', 8 => '#ed4e20',
                                9 => '#f02818', 10 => '#dc3545'
                            ];
                        @endphp
                        @for($i = 0; $i <= 10; $i++)
                            <button type="button" class="btn btn-sm text-white fw-bold vas-btn flex-fill px-1 py-2 {{ $currentVas == $i ? 'border-3 border-dark shadow' : 'opacity-75' }}"
                                    data-val="{{ $i }}"
                                    style="background-color: {{ $vasColors[$i] }}; border-radius: 6px;">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>
                    <div class="d-flex justify-content-between text-muted fs-8 mt-1">
                        <span class="text-success fw-bold">0 = No Pain</span>
                        <span class="text-warning fw-bold">5 = Moderate</span>
                        <span class="text-danger fw-bold">10 = Severe Pain</span>
                    </div>
                </div>

                {{-- Dx (Diagnosis) --}}
                @php
                    $allDiagnoses = \App\Models\ClinicalDiagnosis::where('status', true)
                        ->orderBy('category')->orderBy('subcategory')->orderBy('name')->get()
                        ->groupBy(function($item) {
                            return $item->category . ($item->subcategory ? ' - ' . $item->subcategory : '');
                        });
                @endphp
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold fs-6 text-gray-800 mb-0 d-flex align-items-center">
                            <span class="badge bg-primary text-white me-2">Dx</span>
                            Diagnosis:
                        </label>
                        <a href="{{ route('clinical-diagnoses.index') }}" target="_blank" class="fs-8 text-primary fw-bold">
                            <i class="fas fa-external-link-alt me-1"></i> Manage Dx Library
                        </a>
                    </div>
                    <div class="mb-2">
                        <select id="quickDxSelect" class="form-select form-select-sm" data-placeholder="Quick select from Diagnosis Library...">
                            <option value="">-- Quick Select Diagnosis from Library (268 conditions) --</option>
                            @foreach($allDiagnoses as $grpName => $grpItems)
                                <optgroup label="{{ $grpName }}">
                                    @foreach($grpItems as $diagItem)
                                        <option value="{{ $diagItem->name }}">
                                            {{ $diagItem->name }}{{ $diagItem->code ? ' (' . $diagItem->code . ')' : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <textarea name="dx" id="prescriptionDxInput" class="form-control" rows="2"
                              placeholder="e.g., Lumbar Spondylosis with Radiculopathy, Osteoarthritis Knee Grade II">{{ isset($prescription) ? $prescription->dx : '' }}</textarea>
                    <small class="text-muted">Confirmed condition or clinical impression identified by doctor. Select from library or type custom notes.</small>
                </div>

                {{-- Advice --}}
                <div class="mb-3">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-primary text-white me-2"><i class="fas fa-heartbeat text-white"></i></span>
                        Advice & Precautions:
                    </label>
                    <textarea name="advice" class="form-control" rows="3"
                              placeholder="e.g., Avoid forward bending, use lumbar support cushion, cold pack 15 mins twice daily">{{ isset($prescription) ? $prescription->advice : '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Physiotherapy Treatment & Medication --}}
    <div class="col-lg-6">
        <div class="card h-100 border border-gray-300 shadow-sm">
            <div class="card-header bg-light py-3 border-bottom">
                <h4 class="card-title text-gray-800 mb-0">
                    <i class="fas fa-hand-holding-medical text-success me-2"></i> Treatment & Prescription
                </h4>
            </div>
            <div class="card-body p-4">
                {{-- PT Rx (Physiotherapy Treatment) --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-success text-white me-2 fs-7">PT Rx</span>
                        Physiotherapy Treatment / Prescription:
                    </label>
                    <textarea name="pt_rx" class="form-control font-monospace" rows="10"
                              placeholder="Specify physical therapy modalities, manual therapy, and therapeutic exercises:
• IFT (Interferential Therapy): 15 mins (Frequency: 4-pole, 100Hz)
• UST (Ultrasound Therapy): 1 MHz @ 1.2 W/cm², pulsed mode, 8 mins
• Mechanical Lumbar Traction: 20 kg, static mode, 15 mins
• Core Strengthening & Pelvic Bridging Exercises: 10 reps x 2 sets
• Quadriceps Isometric Exercises: Hold 10 secs, 15 reps">{{ isset($prescription) ? $prescription->pt_rx : '' }}</textarea>
                    <small class="text-muted">Specific physical therapy modalities, manual therapy techniques, exercises, or equipment.</small>
                </div>

                {{-- Medication / Other Support --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-6 text-gray-800 d-flex align-items-center">
                        <span class="badge bg-info text-white me-2 fs-7">Med</span>
                        Medication / Other Support:
                    </label>
                    <textarea name="medication_other_support" class="form-control" rows="5"
                              placeholder="e.g., Tab. Paracetamol 500mg - 1 tab SOS for severe pain after meal
• Neuro-vitamin B1+B6+B12 - 1 tab daily at night for 1 month
• Knee brace / Lumbar support belt while standing or traveling">{{ isset($prescription) ? $prescription->medication_other_support : '' }}</textarea>
                    <small class="text-muted">Supportive medical treatments, supplements, orthotics, or rehabilitation notes.</small>
                </div>

                {{-- Optional Pharmacy Medicines Box --}}
                <div class="accordion mb-3" id="pharmacyMedicinesAccordion">
                    <div class="accordion-item border border-gray-200">
                        <h2 class="accordion-header" id="headingPharmacy">
                            <button class="accordion-button collapsed py-3 bg-light-info text-primary fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsePharmacy" aria-expanded="false" aria-controls="collapsePharmacy">
                                <i class="fas fa-pills me-2"></i> Attach Medicines from Clinic Pharmacy (Optional)
                            </button>
                        </h2>
                        <div id="collapsePharmacy" class="accordion-collapse collapse" aria-labelledby="headingPharmacy" data-bs-parent="#pharmacyMedicinesAccordion">
                            <div class="accordion-body p-3">
                                <p class="text-muted fs-7 mb-3">Add specific pharmacy stock medicines to bill them through the clinic pharmacy system:</p>
                                @include('prescriptions.medical-table')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

