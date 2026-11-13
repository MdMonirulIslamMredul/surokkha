@extends('web.layouts.front')
@section('title')
    Our Clinic Departments | {{ getAppName() }}
@endsection
@section('page_css')
<style>
    .dept-card {
        transition: all 0.35s ease;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }
    .dept-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 32px rgba(26, 115, 232, 0.12);
        border-color: rgba(26, 115, 232, 0.25);
    }
    .dept-card-img-wrap {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: #f8fafc;
    }
    .dept-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .dept-card:hover .dept-card-img {
        transform: scale(1.08);
    }
    .dept-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        color: #0d6efd;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dept-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
    }
    .dept-card-title {
        font-size: 1.22rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
        transition: color 0.2s;
    }
    .dept-card:hover .dept-card-title {
        color: #0d6efd;
    }
    .dept-card-text {
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.55;
        margin-bottom: 18px;
        flex-grow: 1;
    }
    .dept-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 0.92rem;
        color: #0d6efd;
        text-decoration: none;
        transition: gap 0.2s;
    }
    .dept-btn:hover {
        gap: 12px;
        color: #0a58ca;
    }
</style>
@endsection
@section('content')
    <div class="departments-page">
        <!-- start hero section -->
        <section class="hero-section position-relative p-t-60 border-bottom-right-rounded border-bottom-left-rounded bg-gray overflow-hidden">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 {{ App::getLocale() == 'ar' ? 'text-lg-end' : 'text-lg-start' }} text-center">
                        <div class="hero-content">
                            <h1 class="mb-3 pb-1">
                                Our Clinic Departments
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-lg-start justify-content-center mb-lg-0 mb-5">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}">
                                            {{ __('messages.web_home.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Departments
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-end text-center">
                        <img src="{{ asset('web_front/images/page-banner/Services.png') }}" alt="Surokkha Departments" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start department-section -->
        <section class="department-section p-t-100 p-b-120">
            <div class="container">
                <div class="col-lg-7 text-center mx-auto mb-5">
                    <h6 class="text-primary text-uppercase fw-bold mb-2">Excellence in Specialized Healthcare</h6>
                    <h2 class="mb-3 fw-bold">Comprehensive Specialized Departments</h2>
                    <p class="text-muted">Explore our state-of-the-art physiotherapy, autism therapy, and neuro-rehabilitation departments equipped with advanced medical modalities and dedicated specialists.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @forelse($clinicDepartments as $department)
                        <div class="col-xl-4 col-lg-4 col-md-6 d-flex align-items-stretch">
                            <div class="dept-card d-flex flex-column w-100 shadow-sm">
                                <div class="dept-card-img-wrap">
                                    <a href="{{ route('department-details', $department->slug) }}">
                                        <img src="{{ $department->image_url }}" class="dept-card-img" alt="{{ $department->title }}">
                                    </a>
                                    <span class="dept-badge"><i class="fa-solid fa-stethoscope me-1"></i> Department</span>
                                </div>
                                <div class="dept-card-body">
                                    <h4 class="dept-card-title">
                                        <a href="{{ route('department-details', $department->slug) }}" class="text-decoration-none text-dark">
                                            {{ $department->title }}
                                        </a>
                                    </h4>
                                    <p class="dept-card-text">
                                        {{ \Illuminate\Support\Str::limit($department->short_description ?: strip_tags($department->details), 130) }}
                                    </p>
                                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                        <a href="{{ route('department-details', $department->slug) }}" class="dept-btn">
                                            <span>Read Details</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                        <a href="{{ route('appointment') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                                            <i class="fa-regular fa-calendar-check me-1"></i> Book
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted fs-5">No departments found at the moment.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $clinicDepartments->links() }}
                </div>
            </div>
        </section>
        <!-- end department-section -->
    </div>
@endsection
