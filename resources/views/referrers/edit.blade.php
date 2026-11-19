@extends('layouts.app')
@section('title')
    Edit Referrer
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Edit Referrer: {{ $referrer->user->full_name ?? '' }}</h1>
            <a href="{{ route('referrers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Referrers
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('referrers.update', $referrer->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Referral Code (Fixed):</label>
                            <input type="text" class="form-control bg-light" value="{{ $referrer->refer_code }}" readonly>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label required">Phone Number:</label>
                            <input type="tel" name="phone" class="form-control" required value="{{ old('phone', $referrer->phone) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label required">First Name:</label>
                            <input type="text" name="first_name" class="form-control" required value="{{ old('first_name', $referrer->user->first_name ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Last Name:</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $referrer->user->last_name ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $referrer->user->email ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Occupation / Designation:</label>
                            <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $referrer->occupation) }}">
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Address:</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $referrer->address) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Update Referrer</button>
                        <a href="{{ route('referrers.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

