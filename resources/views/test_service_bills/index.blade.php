@extends('layouts.app')
@section('title')
    Test & Therapy Service Bills
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Diagnostic & Service Bills</h1>
            <div>
                <a href="{{ route('test-service-bills.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> New Test/Service Bill
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <form method="GET" action="{{ route('test-service-bills.index') }}" class="w-100">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Search by Bill #, Patient Name, or Phone..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('test-service-bills.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="ps-4 rounded-start">Bill #</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Referrer</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Net Amount</th>
                                <th>Ref. Incentive</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="rounded-end text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bills as $bill)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        <a href="{{ route('test-service-bills.show', $bill->id) }}" class="text-primary">
                                            {{ $bill->bill_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold">{{ $bill->patient->patientUser->full_name ?? 'N/A' }}</span>
                                            <span class="text-muted fs-7">{{ $bill->patient->patientUser->phone ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $bill->doctor ? ($bill->doctor->doctorUser->full_name ?? 'Doctor') : 'Self / General' }}
                                    </td>
                                    <td>
                                        @if($bill->referrer)
                                            <span class="badge bg-light-primary text-primary">
                                                {{ $bill->referrer->user->full_name ?? $bill->referrer->refer_code }}
                                                ({{ $bill->referrer->refer_code }})
                                            </span>
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                    <td>{{ getCurrencySymbol() }} {{ number_format($bill->total_amount, 2) }}</td>
                                    <td class="text-danger">
                                        @if($bill->discount_amount > 0)
                                            -{{ getCurrencySymbol() }} {{ number_format($bill->discount_amount, 2) }}
                                            <small>({{ $bill->discount_type == 'percentage' ? $bill->discount_value.'%' : 'flat' }})</small>
                                        @else
                                            0.00
                                        @endif
                                    </td>
                                    <td class="fw-bolder text-success">
                                        {{ getCurrencySymbol() }} {{ number_format($bill->net_amount, 2) }}
                                    </td>
                                    <td>
                                        @if($bill->referral_commission_amount > 0)
                                            <span class="badge bg-light-success text-success fw-bold">
                                                {{ getCurrencySymbol() }} {{ number_format($bill->referral_commission_amount, 2) }} ({{ $bill->referral_commission_percent }}%)
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Paid</span>
                                    </td>
                                    <td>{{ $bill->created_at->format('d M, Y h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('test-service-bills.show', $bill->id) }}" class="btn btn-icon btn-sm btn-light-info me-1" title="View Bill">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('test-service-bills.pdf', $bill->id) }}" class="btn btn-icon btn-sm btn-light-primary" target="_blank" title="Print PDF">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-8 text-muted">
                                        No bills found. Click <strong>"New Test/Service Bill"</strong> to create one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $bills->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

