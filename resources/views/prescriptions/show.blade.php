@extends('layouts.app')
@section('title')
    {{ __('messages.prescription.prescription_details') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0 d-print-none">
                <a href="{{ route('prescriptions.pdf', $prescription->id) }}" target="_blank"
                   class="btn btn-success me-2">
                    <i class="fas fa-file-pdf me-1"></i> {{ __('messages.ipd_patient_prescription.print_prescription') }} (PDF)
                </a>
                <button type="button" onclick="window.print()" class="btn btn-info me-2">
                    <i class="fas fa-print me-1"></i> Quick Print
                </button>
                <a  class="btn btn-primary"
                    href="{{route('prescriptions.edit',['prescription' => $prescription->id])}}">{{ __('messages.common.edit') }}</a>
                <a href="{{ url()->previous() }}"
                   class="btn btn-outline-primary ms-2">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-lg-10">
                    @if(!isset($prescription->prescription_type) || $prescription->prescription_type === 'physiotherapy')
                        @include('prescriptions.physio_view_fields', ['prescription' => ['prescription' => $prescription], 'data' => \App\Models\Setting::pluck('value', 'key')])
                    @else
                        @include('prescriptions.show_fields')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
@media print {
    /* Hide layout chrome on print */
    header, aside, .aside, .header, .header-toolbar, .header_toolbar, .d-print-none, .footer, #kt_aside, #kt_header, #kt_footer, .breadcrumb, nav {
        display: none !important;
    }
    body, .wrapper, .content, .container-fluid, .card, .card-body {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
        border: none !important;
        box-shadow: none !important;
        width: 100% !important;
    }
    @page {
        size: A4 portrait;
        margin: 8mm 10mm 10mm 10mm;
    }
}
</style>
@endpush
