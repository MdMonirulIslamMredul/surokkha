@extends('layouts.app')
@section('title')
    {{ __('messages.prescription.new_prescription') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                    @include('flash::message')
                </div>
            </div>
            {{ Form::hidden('createMedicineFromPrescriptionPost', route('prescription.medicine.store'), ['id' => 'createMedicineFromPrescriptionPost']) }}
            {{ Form::hidden('uniqueId', 2, ['id' => 'prescriptionUniqueId']) }}
            {{ Form::hidden('associateMedicines', json_encode($medicineList), ['class' => 'associatePrescriptionMedicines']) }}
            {{ Form::hidden('associateMeals', json_encode($mealList), ['class' => 'associatePrescriptionMeals']) }}
            {{ Form::hidden('associateDuration', json_encode($doseDurationList), ['class' => 'associatePrescriptionDurations']) }}
            {{ Form::hidden('associateInterval', json_encode($doseIntervalList), ['class' => 'associatePrescriptionIntervals']) }}
            {{ Form::hidden('openAiPrompt', route('prescription.open-ai-prompt'), ['id' => 'openAiPromptURL']) }}
            {{ Form::open(['route' => 'prescriptions.store', 'id' => 'createPrescription']) }}

            @csrf
            <div class="card">
                <div class="card-body">
                    @include('prescriptions.fields')
                </div>
            </div>

            {{-- Specialized Physiotherapy & Autism Care Prescription Section --}}
            <div id="physioPrescriptionWrapper" class="mt-5">
                @include('prescriptions.physio_fields')
                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-primary me-2 btnPrescriptionSave">{{ __('messages.common.save') }}</button>
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
                </div>
            </div>

            {{-- General Medical Prescription Section --}}
            <div id="generalPrescriptionWrapper" class="mt-5 d-none">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('messages.medicines') }}</h3>
                        <div class="">
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#add_new_medicine">
                                {{ __('messages.prescription.new_medicine') }}
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary" id="openAiPrompt"
                                data-loading-text = "<span class='spinner-border spinner-border-sm'></span> Processing..."> <i
                                    class="fa-solid fa-wand-magic-sparkles"></i> {{ __('messages.open_ai.suggest_medicines') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('prescriptions.medical-table')
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>{{ __('messages.prescription.physical_information') }}</h3>
                    </div>
                    <div class="card-body">
                        @include('prescriptions.physical-info-fields')
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-body">
                        @include('prescriptions.other-fields')
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            @include('prescriptions.add_new_medicine')
            @include('prescriptions.templates.templates')
            @include('prescriptions.suggest_medicine_model')
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Layout / Format Switcher
            const typePhysio = document.getElementById('typePhysio');
            const typeGeneral = document.getElementById('typeGeneral');
            const physioWrapper = document.getElementById('physioPrescriptionWrapper');
            const generalWrapper = document.getElementById('generalPrescriptionWrapper');
            const generalMetaFields = document.getElementById('generalMetaFields');

            function toggleLayout() {
                if (typeGeneral && typeGeneral.checked) {
                    if (physioWrapper) physioWrapper.classList.add('d-none');
                    if (generalWrapper) generalWrapper.classList.remove('d-none');
                    if (generalMetaFields) generalMetaFields.classList.remove('d-none');
                } else {
                    if (physioWrapper) physioWrapper.classList.remove('d-none');
                    if (generalWrapper) generalWrapper.classList.add('d-none');
                    if (generalMetaFields) generalMetaFields.classList.add('d-none');
                }
            }

            if (typePhysio) typePhysio.addEventListener('change', toggleLayout);
            if (typeGeneral) typeGeneral.addEventListener('change', toggleLayout);

            // Fetch Patient Vitals on Patient Selection
            const patientSelect = $('#prescriptionPatientId');
            function fetchPatientVitals(patientId) {
                if (!patientId) return;
                $.ajax({
                    url: '/prescriptions-patient-vitals/' + patientId,
                    type: 'GET',
                    success: function (res) {
                        if (res.success && res.data) {
                            const p = res.data;
                            $('#patientRegNo').val(p.unique_id || 'N/A');
                            $('#patientAge').val(p.age || '');
                            $('#patientSex').val(p.gender_text || (p.gender === 'M' ? 'Male' : 'Female'));
                            $('#patientOccupation').val(p.occupation || '');
                            $('#patientHeight').val(p.height || '');
                            $('#patientWeight').val(p.weight || '');
                            $('#patientBmi').val(p.bmi || '');
                            calculateBmi();
                        }
                    }
                });
            }

            if (patientSelect.length) {
                patientSelect.on('change', function () {
                    fetchPatientVitals($(this).val());
                });
                if (patientSelect.val()) {
                    fetchPatientVitals(patientSelect.val());
                }
            }

            // Live BMI Calculation
            function calculateBmi() {
                const h = parseFloat($('#patientHeight').val());
                const w = parseFloat($('#patientWeight').val());
                if (h > 0 && w > 0) {
                    const hInM = h / 100;
                    const bmi = (w / (hInM * hInM)).toFixed(2);
                    $('#patientBmi').val(bmi);
                }
            }
            $('#patientHeight, #patientWeight').on('input', calculateBmi);

            // VAS Pain Gauge Click Handler
            $('.vas-btn').on('click', function () {
                const val = $(this).data('val');
                $('#prescriptionVas').val(val);
                $('#vasCurrentBadge').text('Score: ' + val + ' / 10');

                $('.vas-btn').removeClass('border-3 border-dark shadow').addClass('opacity-75');
                $(this).removeClass('opacity-75').addClass('border-3 border-dark shadow');
            });

            // Quick Diagnosis Selection from Dx Library
            $('#quickDxSelect').on('change', function () {
                const val = $(this).val();
                if (!val) return;
                const current = $('#prescriptionDxInput').val().trim();
                if (current) {
                    if (!current.includes(val)) {
                        $('#prescriptionDxInput').val(current + ', ' + val);
                    }
                } else {
                    $('#prescriptionDxInput').val(val);
                }
            });
        });
    </script>
