@extends('layouts.app')
@section('title')
    Bill #{{ $bill->bill_number }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Bill Details: {{ $bill->bill_number }}</h1>
            <div>
                <a href="{{ route('test-service-bills.pdf', $bill->id) }}" target="_blank" class="btn btn-primary me-2">
                    <i class="fas fa-print me-1"></i> Print / Download PDF
                </a>
                <a href="{{ route('test-service-bills.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Bills
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-lg-15 p-5">
                <!-- Top Header -->
                <div class="d-flex justify-content-between align-items-start border-bottom pb-8 mb-8">
                    <div>
                        <h2 class="fw-bolder text-primary mb-1">{{ getAppName() }}</h2>
                        <div class="text-muted fs-6">Diagnostic & Therapy Services Billing</div>
                        <div class="mt-2 text-dark fs-7">
                            <strong>Date:</strong> {{ $bill->created_at->format('d M, Y h:i A') }}<br>
                            <strong>Payment Method:</strong> {{ $bill->payment_method }}<br>
                            <strong>Billed By:</strong> {{ $bill->creator->full_name ?? 'Staff' }}
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fs-4 fw-bolder text-dark mb-1">INVOICE / RECEIPT</div>
                        <div class="badge bg-light-primary text-primary fs-6 mb-2">{{ $bill->bill_number }}</div><br>
                        <span class="badge bg-success fs-7">PAID</span>
                    </div>
                </div>

                <!-- Patient & Doctor Info -->
                <div class="row g-5 mb-8">
                    <div class="col-sm-6">
                        <h5 class="fw-bolder text-gray-800 mb-3">PATIENT DETAILS:</h5>
                        <div class="text-dark fs-6">
                            <strong>Name:</strong> {{ $bill->patient->patientUser->full_name ?? 'N/A' }}<br>
                            <strong>Patient ID:</strong> {{ $bill->patient->patient_unique_id }}<br>
                            <strong>Phone:</strong> {{ $bill->patient->patientUser->phone ?? 'N/A' }}<br>
                            <strong>Age / Gender:</strong> {{ $bill->patient->age ?? 'N/A' }} yrs / {{ $bill->patient->patientUser->gender == 0 ? 'Male' : 'Female' }}<br>
                            @if($bill->patient->height || $bill->patient->weight)
                                <strong>Height / Weight / BMI:</strong> {{ $bill->patient->height ?? '-' }} cm / {{ $bill->patient->weight ?? '-' }} kg (BMI: {{ $bill->patient->bmi ?? '-' }})<br>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h5 class="fw-bolder text-gray-800 mb-3">DOCTOR & REFERRAL:</h5>
                        <div class="text-dark fs-6">
                            <strong>Prescribed By:</strong> {{ $bill->doctor ? ($bill->doctor->doctorUser->full_name ?? 'Doctor') : 'Self / General OPD' }}<br>
                            @if($bill->referrer)
                                <div class="mt-2">
                                    <span class="badge bg-light-info text-info fs-7">
                                        Referrer: {{ $bill->referrer->user->full_name ?? $bill->referrer->refer_code }} ({{ $bill->referrer->refer_code }})
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive mb-8">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="bg-light">
                            <tr class="fw-bolder text-dark">
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Test / Service Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill->items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $item->item_name }}</td>
                                    <td class="text-center text-capitalize">
                                        <span class="badge bg-light-secondary text-dark">{{ $item->item_type }}</span>
                                    </td>
                                    <td class="text-end">{{ getCurrencySymbol() }} {{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold">{{ getCurrencySymbol() }} {{ number_format($item->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="d-flex justify-content-end mb-8">
                    <div class="w-100 w-md-50">
                        <div class="d-flex justify-content-between mb-2 fs-6">
                            <span>Subtotal:</span>
                            <span class="fw-bold">{{ getCurrencySymbol() }} {{ number_format($bill->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 fs-6 text-danger">
                            <span>Discount ({{ $bill->discount_type == 'percentage' ? $bill->discount_value.'%' : 'Flat' }}):</span>
                            <span class="fw-bold">-{{ getCurrencySymbol() }} {{ number_format($bill->discount_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3 fs-4 fw-bolder text-success">
                            <span>Total Paid:</span>
                            <span>{{ getCurrencySymbol() }} {{ number_format($bill->net_amount, 2) }}</span>
                        </div>

                        @if($bill->referral_commission_amount > 0 && Auth::user()->hasRole('Admin|Accountant|Receptionist'))
                            <div class="mt-4 p-3 bg-light-success rounded">
                                <span class="fs-7 text-success fw-bold">
                                    <i class="fas fa-check-circle me-1"></i> Referrer Commission Credited: {{ getCurrencySymbol() }} {{ number_format($bill->referral_commission_amount, 2) }} ({{ $bill->referral_commission_percent }}%)
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($bill->note)
                    <div class="border p-4 rounded bg-light mb-5">
                        <strong>Note:</strong> {{ $bill->note }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

