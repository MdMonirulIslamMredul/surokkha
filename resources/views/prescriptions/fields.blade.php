<div class="row gx-10 mb-3">
    <div class="form-group col-md-4 mb-5">
        {{ Form::label('patient_id', __('messages.prescription.patient') . ':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('patient_id', $patients, null, ['class' => 'form-select', 'required', 'id' => 'prescriptionPatientId', 'placeholder' => __('messages.document.select_patient')]) }}
    </div>
    @if (Auth::user()->hasRole('Doctor'))
        <input type="hidden" name="doctor_id" value="{{ Auth::user()->owner_id }}">
    @else
        <div class="form-group col-md-4 mb-5">
            {{ Form::label('doctor_name', __('messages.case.doctor') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::select('doctor_id', $doctors, null, ['class' => 'form-select', 'required', 'id' => 'prescriptionDoctorId', 'placeholder' => __('messages.web_home.select_doctor')]) }}
        </div>
    @endif
    <div class="col-md-4">
        <div class="form-group mb-5">
            {{ Form::label('status', __('messages.common.status') . ':', ['class' => 'form-label']) }}
            <br>
            <div class="form-check form-switch">
                <input name="status" class="form-check-input is-active" value="1" type="checkbox" checked>
                <label class="form-check-label" for="allowmarketing"></label>
            </div>
        </div>
    </div>

    {{-- Format Selector --}}
    <div class="col-12 mt-2">
        <div class="p-4 rounded bg-light-info border border-info d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="fw-bolder fs-5 text-gray-800 me-2"><i class="fas fa-file-prescription text-primary me-2"></i> Prescription Layout / Format:</span>
                <span class="text-muted fs-7">Choose between specialized physiotherapy pad or standard general layout.</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="prescription_type" id="typePhysio" value="physiotherapy" checked>
                    <label class="form-check-label fw-bold text-gray-800 cursor-pointer" for="typePhysio">
                        <i class="fas fa-child text-primary me-1"></i> Physiotherapy & Autism Care (Recommended)
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="prescription_type" id="typeGeneral" value="general">
                    <label class="form-check-label fw-bold text-gray-800 cursor-pointer" for="typeGeneral">
                        <i class="fas fa-stethoscope text-secondary me-1"></i> General Medical Prescription
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- General specific optional fields (only shown when General is selected) --}}
    <div class="col-12 mt-4 d-none" id="generalMetaFields">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-5">
                    {{ Form::label('health_insurance', __('messages.prescription.health_insurance').(':'), ['class' => 'form-label']) }}
                    {{ Form::text('health_insurance', null, ['class' => 'form-control','placeholder'=>__('messages.prescription.health_insurance')]) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-5">
                    {{ Form::label('low_income', __('messages.prescription.low_income').(':'), ['class' => 'form-label']) }}
                    {{ Form::text('low_income', null, ['class' => 'form-control','placeholder'=>__('messages.prescription.low_income')]) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-5">
                    {{ Form::label('reference', __('messages.prescription.reference').(':'), ['class' => 'form-label']) }}
                    {{ Form::text('reference', null, ['class' => 'form-control','placeholder'=>__('messages.prescription.reference')]) }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="d-flex justify-content-end"> --}}
{{--    {!! Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2 btnPrescriptionSave','id' => 'prescriptionSave']) !!} --}}
{{--    <a href="{!! route('prescriptions.index') !!}" --}}
{{--       class="btn btn-secondary">{!! __('messages.common.cancel') !!}</a> --}}
{{-- </div> --}}
