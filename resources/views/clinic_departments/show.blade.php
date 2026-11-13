@extends('layouts.app')
@section('title')
    {{ $clinicDepartment->title }} - Department Details
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">{{ $clinicDepartment->title }}</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('clinic-departments.edit', $clinicDepartment->id) }}" class="btn btn-primary me-2">
                    <i class="fa-solid fa-pen-to-square me-1"></i> {{ __('messages.common.edit') }}
                </a>
                <a href="{{ route('clinic-departments.index') }}" class="btn btn-outline-primary">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <img src="{{ $clinicDepartment->image_url }}" alt="{{ $clinicDepartment->title }}"
                                 class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="text-gray-900 fw-bold me-3 mb-0">{{ $clinicDepartment->title }}</h2>
                                @if($clinicDepartment->is_active)
                                    <span class="badge bg-light-success text-success">Active</span>
                                @else
                                    <span class="badge bg-light-danger text-danger">Inactive</span>
                                @endif
                            </div>
                            <p class="text-muted mb-2">
                                <i class="fa-solid fa-link me-1"></i> Slug: <code>{{ $clinicDepartment->slug }}</code>
                            </p>
                            @if($clinicDepartment->short_description)
                                <div class="alert alert-secondary p-4 mt-3 mb-0">
                                    <strong>Overview:</strong> {{ $clinicDepartment->short_description }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Department Details & Treatment Information</h3>
                </div>
                <div class="card-body p-8">
                    @if($clinicDepartment->details)
                        <div class="clinic-department-content fs-5 text-gray-800">
                            {!! $clinicDepartment->details !!}
                        </div>
                    @else
                        <div class="text-muted fst-italic">No detailed content provided yet.</div>
                    @endif
                </div>
            </div>

            @if(count($clinicDepartment->gallery_urls) > 0)
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fa-solid fa-images text-primary me-2"></i> Department Photo Gallery ({{ count($clinicDepartment->gallery_urls) }})
                        </h3>
                        <a href="{{ route('clinic-departments.edit', $clinicDepartment->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Manage Gallery Photos
                        </a>
                    </div>
                    <div class="card-body p-6">
                        <div class="row g-4">
                            @foreach($clinicDepartment->gallery_urls as $imgUrl)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card border shadow-xs overflow-hidden h-100">
                                        <a href="{{ $imgUrl }}" target="_blank" title="Click to view full photo">
                                            <img src="{{ $imgUrl }}" class="card-img-top" style="height: 180px; object-fit: cover; transition: transform 0.25s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'" alt="Department gallery photo">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
