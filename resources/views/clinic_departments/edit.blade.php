@extends('layouts.app')
@section('title')
    Edit Clinic Department
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('clinic-departments.index') }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
            </div>
            <div class="card">
                <div class="card-body p-12">
                    {{ Form::model($clinicDepartment, ['route' => ['clinic-departments.update', $clinicDepartment->id], 'method' => 'patch', 'files' => true, 'id' => 'editClinicDepartmentForm']) }}

                    @include('clinic_departments.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
