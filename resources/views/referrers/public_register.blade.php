@extends('layouts.auth_app')
@section('title')
    Referrer Registration
@endsection
@section('content')
    @php
        $settingValue = getSettingValue();
    @endphp
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('front') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{ $settingValue['app_logo']['value'] }}" class="img-fluid logo-fix-size">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h1 class="text-center mb-2">Referrer Partner Registration</h1>
            <p class="text-center text-muted mb-7">Register as a hospital referral partner to earn commissions on tests & therapy services.</p>

            <form method="POST" action="{{ route('referrer.register.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label required">First Name:</label>
                        <input type="text" name="first_name" class="form-control" required placeholder="First name" value="{{ old('first_name') }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Last Name:</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label required">Phone Number (Login ID):</label>
                        <input type="tel" name="phone" class="form-control" required placeholder="01XXXXXXXXX" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Email (Optional):</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Occupation / Profession:</label>
                        <input type="text" name="occupation" class="form-control" placeholder="e.g. Doctor, Medical Officer, Pharmacist, Health Worker" value="{{ old('occupation') }}">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Address:</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Full address...">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label required">Password:</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Password (min 6 chars)">
                    </div>
                    <div class="col-md-6 mb-5">
                        <label class="form-label required">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="6" placeholder="Repeat password">
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary py-3 fs-5">
                        <i class="fas fa-user-plus me-1"></i> Register as Referrer
                    </button>
                </div>

                <div class="text-center text-gray-700">
                    Already registered? <a href="{{ route('login') }}" class="link-info fw-bold">Sign In here</a>
                </div>
            </form>
        </div>
    </div>
@endsection

