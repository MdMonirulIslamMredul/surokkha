@extends('web.layouts.front')
@section('title')
    {{ $clinicDepartment->title }} | {{ getAppName() }}
@endsection
@section('page_css')
<style>
    .dept-details-hero {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    .dept-featured-img {
        width: 100%;
        max-height: 440px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }
    .dept-rich-content {
        color: #334155;
        font-size: 1.05rem;
        line-height: 1.8;
    }
    .dept-rich-content h1, .dept-rich-content h2, .dept-rich-content h3, .dept-rich-content h4 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 1.8rem;
        margin-bottom: 0.9rem;
    }
    .dept-rich-content h3 {
        font-size: 1.45rem;
        border-left: 4px solid #0d6efd;
        padding-left: 12px;
    }
    .dept-rich-content h4 {
        font-size: 1.2rem;
        color: #1e293b;
    }
    .dept-rich-content ul {
        padding-left: 24px;
        margin-bottom: 1.5rem;
    }
    .dept-rich-content ul li {
        margin-bottom: 8px;
    }
    .dept-rich-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .dept-rich-content table th, .dept-rich-content table td {
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
    }
    .dept-rich-content table th {
        background: #f1f5f9;
        font-weight: 600;
    }
    .dept-sidebar-widget {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        margin-bottom: 30px;
    }
    .dept-nav-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-radius: 10px;
        color: #334155;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        margin-bottom: 6px;
    }
    .dept-nav-link:hover {
        background: #f1f5f9;
        color: #0d6efd;
        padding-left: 20px;
    }
    .dept-nav-link.active {
        background: #0d6efd;
        color: #fff;
    }
    .gallery-thumb-wrap {
        border-radius: 12px;
        overflow: hidden;
        height: 140px;
        background: #f1f5f9;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .gallery-thumb-wrap:hover {
        transform: scale(1.04);
    }
    .gallery-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cta-appointment-box {
        background: linear-gradient(135deg, #0d6efd 0%, #004ecc 100%);
        border-radius: 16px;
        color: #fff;
        padding: 30px;
    }
</style>
@endsection
@section('content')
@php
    $settingValue = getSettingValue();
@endphp
<div class="department-details-page">
    <!-- start hero section -->
    <section class="hero-section position-relative p-t-60 border-bottom-right-rounded border-bottom-left-rounded bg-gray overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 {{ App::getLocale() == 'ar' ? 'text-lg-end' : 'text-lg-start' }} text-center">
                    <div class="hero-content">
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3 text-uppercase">Clinic Department</span>
                        <h1 class="mb-3 pb-1">
                            {{ $clinicDepartment->title }}
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-start justify-content-center mb-lg-0 mb-4">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">
                                        {{ __('messages.web_home.home') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('our-departments') }}">
                                        Departments
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $clinicDepartment->title }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-end text-center">
                    <img src="{{ asset('web_front/images/page-banner/Services.png') }}" alt="{{ $clinicDepartment->title }}" class="img-fluid" style="max-height: 220px;" />
                </div>
            </div>
        </div>
    </section>
    <!-- end hero section -->

    <!-- start details section -->
    <section class="details-section p-t-80 p-b-120">
        <div class="container">
            <div class="row g-5">
                <!-- Main Content Left (8 cols) -->
                <div class="col-lg-8">
                    <!-- Featured Image -->
                    <div class="mb-4">
                        <img src="{{ $clinicDepartment->image_url }}" alt="{{ $clinicDepartment->title }}" class="dept-featured-img img-fluid">
                    </div>

                    <!-- Short Description Lead Box -->
                    @if($clinicDepartment->short_description)
                        <div class="alert alert-primary bg-light-primary border-primary p-4 rounded-3 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="fa-solid fa-circle-info fs-3 text-primary me-3 mt-1"></i>
                                <div>
                                    <h5 class="fw-bold text-primary mb-1">Department Overview</h5>
                                    <p class="mb-0 text-dark fs-6">{{ $clinicDepartment->short_description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Decorated HTML Details -->
                    <div class="dept-rich-content mb-5 bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                        {!! $clinicDepartment->details !!}
                    </div>

                    <!-- Department Photo Gallery -->
                    @php
                        $galleryUrls = $clinicDepartment->gallery_urls;
                    @endphp

                    @if(count($galleryUrls) > 0)
                        <div class="dept-gallery-section mb-5">
                            <h3 class="fw-bold mb-3"><i class="fa-solid fa-camera-retro me-2 text-primary"></i> Department Gallery</h3>
                            <div class="row g-3">
                                @foreach(array_slice($galleryUrls, 0, 12) as $gUrl)
                                    <div class="col-md-4 col-6">
                                        <div class="gallery-thumb-wrap">
                                            <a href="{{ $gUrl }}" target="_blank">
                                                <img src="{{ $gUrl }}" alt="{{ $clinicDepartment->title }} Photo" class="gallery-thumb">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- In-content CTA -->
                    <div class="cta-appointment-box d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <h3 class="text-white fw-bold mb-2">Need Treatment in This Department?</h3>
                            <p class="text-white-50 mb-0">Schedule an assessment session with our department specialist doctors and physiotherapists.</p>
                        </div>
                        <a href="{{ route('appointment') }}" class="btn btn-light text-primary fw-bold px-4 py-3 rounded-pill text-nowrap">
                            <i class="fa-regular fa-calendar-check me-2"></i> Book Appointment
                        </a>
                    </div>
                </div>

                <!-- Sidebar Right (4 cols) -->
                <div class="col-lg-4">
                    <!-- Other Departments Widget -->
                    <div class="dept-sidebar-widget">
                        <h4 class="fw-bold mb-3 pb-2 border-bottom">
                            <i class="fa-solid fa-layer-group text-primary me-2"></i> Our Departments
                        </h4>
                        <div class="dept-nav-list">
                            @foreach($allDepartments as $otherDept)
                                <a href="{{ route('department-details', $otherDept->slug) }}" class="dept-nav-link">
                                    <span>{{ $otherDept->title }}</span>
                                    <i class="fa-solid fa-chevron-right fs-small text-muted"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Consultation Quick Card -->
                    <div class="dept-sidebar-widget text-center bg-primary text-white">
                        <div class="icon-circle bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-user-doctor fs-2"></i>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Professional Care</h4>
                        <p class="text-white-50 mb-4">Have questions about symptoms, recovery time, or treatment plans? Talk to our healthcare coordinators.</p>
                        <a href="tel:{{ $settingValue['hospital_phone']['value'] ?? '' }}" class="btn btn-warning fw-bold w-100 py-3 mb-2 rounded-pill">
                            <i class="fa-solid fa-phone me-2"></i> Call: {{ $settingValue['hospital_phone']['value'] ?? 'Contact Us' }}
                        </a>
                        <a href="{{ route('appointment') }}" class="btn btn-outline-light w-100 py-3 rounded-pill">
                            Book Online Appointment
                        </a>
                    </div>

                    <!-- Working Hours Widget -->
                    <div class="dept-sidebar-widget">
                        <h4 class="fw-bold mb-3 pb-2 border-bottom">
                            <i class="fa-regular fa-clock text-primary me-2"></i> Working Hours
                        </h4>
                        <p class="text-muted mb-3">{{ $settingValue['hospital_from_time']['value'] ?? 'Saturday - Thursday: 8:00 AM - 10:00 PM' }}</p>
                        <div class="d-flex align-items-center text-muted">
                            <i class="fa-solid fa-location-dot text-primary me-2"></i>
                            <span>{{ $settingValue['hospital_address']['value'] ?? 'Surokkha Healthcare Clinic' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end details section -->
</div>
@endsection
