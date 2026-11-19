@extends('layouts.app')
@section('title')
    Edit Clinical Diagnosis (Dx)
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">Edit Clinical Diagnosis: {{ $clinicalDiagnosis->name }}</h1>
            <a href="{{ route('clinical-diagnoses.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Back to Diagnoses
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card shadow-sm border border-gray-300">
            <div class="card-header bg-light-primary py-4">
                <h3 class="card-title text-primary mb-0">
                    <i class="fa-solid fa-edit me-2"></i> Update Diagnosis Details
                </h3>
            </div>
            <div class="card-body p-6">
                <form action="{{ route('clinical-diagnoses.update', $clinicalDiagnosis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('clinical_diagnoses.fields')
                </form>
            </div>
        </div>
    </div>
@endsection

