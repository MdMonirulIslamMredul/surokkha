@extends('layouts.app')
@section('title')
    Add New Referrer
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Add New Referrer</h1>
            <a href="{{ route('referrers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Referrers
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('referrers.store') }}">
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
                            <input type="tel" name="phone" class="form-control" required placeholder="Phone number" value="{{ old('phone') }}">
                            <span class="text-muted fs-7">This phone number will be used by the referrer to log in.</span>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email (Optional):</label>
                            <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Password (Default: 12345678):</label>
                            <input type="password" name="password" class="form-control" placeholder="12345678" value="12345678">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Occupation / Designation:</label>
                            <input type="text" name="occupation" class="form-control" placeholder="e.g. Doctor, Pharmacist, Agent, Teacher" value="{{ old('occupation') }}">
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Address:</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Referrer address...">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="alert alert-light-primary border border-primary p-4 mb-5">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        A unique <strong>Referral Code (e.g. REF-XXXXXX)</strong> will be automatically generated upon saving.
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save me-1"></i> Register Referrer
                        </button>
                        <a href="{{ route('referrers.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

