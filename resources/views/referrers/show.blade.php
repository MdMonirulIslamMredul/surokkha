@extends('layouts.app')
@section('title')
    Referrer: {{ $referrer->user->full_name ?? $referrer->refer_code }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="mb-1">{{ $referrer->user->full_name ?? 'Referrer' }}</h1>
                <span class="badge bg-primary fs-6">{{ $referrer->refer_code }}</span>
                <span class="text-muted ms-2">{{ $referrer->occupation ?? 'General Referrer' }}</span>
            </div>
            <div>
                @if($referrer->balance > 0 && Auth::user()->hasRole('Admin|Accountant|Receptionist'))
                    <a href="{{ route('referral-payouts.create', ['referrer_id' => $referrer->id]) }}" class="btn btn-success me-2">
                        <i class="fas fa-hand-holding-usd me-1"></i> Disburse Payout
                    </a>
                @endif
                <a href="{{ route('referrers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Referrers
                </a>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="row g-5 mb-5">
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light-primary">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Total Earnings</div>
                        <div class="fs-2 fw-bolder text-primary mt-1">{{ getCurrencySymbol() }} {{ number_format($referrer->total_earnings, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light-success">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Total Paid Out</div>
                        <div class="fs-2 fw-bolder text-success mt-1">{{ getCurrencySymbol() }} {{ number_format($referrer->total_paid, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light-warning">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Available Balance</div>
                        <div class="fs-2 fw-bolder text-warning mt-1">{{ getCurrencySymbol() }} {{ number_format($referrer->balance, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light-info">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Referred Patients</div>
                        <div class="fs-2 fw-bolder text-info mt-1">{{ $referrer->patients->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Tabs -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="referrerTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="patients-tab" data-bs-toggle="tab" href="#patientsPane" role="tab">
                            <i class="fas fa-user-injured me-1"></i> Bound Patients ({{ $referrer->patients->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bills-tab" data-bs-toggle="tab" href="#billsPane" role="tab">
                            <i class="fas fa-file-invoice-dollar me-1"></i> Commission History ({{ $referrer->testServiceBills->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payouts-tab" data-bs-toggle="tab" href="#payoutsPane" role="tab">
                            <i class="fas fa-money-check-alt me-1"></i> Payout Disbursements ({{ $referrer->payouts->count() }})
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="referrerTabContent">
                    <!-- Bound Patients -->
                    <div class="tab-pane fade show active" id="patientsPane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Age / Gender</th>
                                        <th>Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->patients as $pat)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $pat->patient_unique_id }}</td>
                                            <td class="fw-bold text-dark">{{ $pat->patientUser->full_name ?? 'N/A' }}</td>
                                            <td>{{ $pat->patientUser->phone ?? 'N/A' }}</td>
                                            <td>{{ $pat->age ?? '-' }} yrs / {{ $pat->patientUser->gender == 0 ? 'Male' : 'Female' }}</td>
                                            <td>{{ $pat->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">No patients referred yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Commission Bills -->
                    <div class="tab-pane fade" id="billsPane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Bill #</th>
                                        <th>Patient</th>
                                        <th>Bill Net Total</th>
                                        <th>Commission %</th>
                                        <th>Commission Earned</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->testServiceBills as $bill)
                                        <tr>
                                            <td class="fw-bold">
                                                <a href="{{ route('test-service-bills.show', $bill->id) }}" class="text-primary">
                                                    {{ $bill->bill_number }}
                                                </a>
                                            </td>
                                            <td>{{ $bill->patient->patientUser->full_name ?? 'N/A' }}</td>
                                            <td>{{ getCurrencySymbol() }} {{ number_format($bill->net_amount, 2) }}</td>
                                            <td>{{ $bill->referral_commission_percent }}%</td>
                                            <td class="text-success fw-bold">
                                                +{{ getCurrencySymbol() }} {{ number_format($bill->referral_commission_amount, 2) }}
                                            </td>
                                            <td>{{ $bill->created_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">No commissions generated yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payouts -->
                    <div class="tab-pane fade" id="payoutsPane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Payout #</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Reference / Note</th>
                                        <th>Disbursed By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->payouts as $payout)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $payout->payout_number }}</td>
                                            <td class="fw-bolder text-danger">-{{ getCurrencySymbol() }} {{ number_format($payout->amount, 2) }}</td>
                                            <td><span class="badge bg-light-primary text-primary">{{ $payout->payment_method }}</span></td>
                                            <td>{{ $payout->reference_note ?? '-' }}</td>
                                            <td>{{ $payout->paidBy->full_name ?? 'Staff' }}</td>
                                            <td>{{ $payout->paid_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">No payouts disbursed yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

