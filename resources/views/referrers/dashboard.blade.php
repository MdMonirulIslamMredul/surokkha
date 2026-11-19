@extends('layouts.app')
@section('title')
    Referrer Portal Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')

        <!-- Welcome Banner with Code -->
        <div class="card bg-primary text-white mb-5 shadow-sm">
            <div class="card-body p-8 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="text-white mb-1">Welcome back, {{ $referrer->user->full_name }}!</h2>
                    <p class="mb-0 text-white-50 fs-6">Here is your referral performance, lifetime earnings, and payment history.</p>
                </div>
                <div class="mt-4 mt-md-0 text-md-end">
                    <div class="fs-7 text-white-50 text-uppercase fw-bold">Your Unique Referral Code</div>
                    <div class="bg-white text-primary fw-bolder fs-2 px-4 py-2 rounded d-inline-block mt-1 shadow-sm">
                        {{ $referrer->refer_code }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="row g-5 mb-5">
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Total Earnings</div>
                        <div class="fs-1 fw-bolder text-primary mt-2">
                            {{ getCurrencySymbol() }} {{ number_format($totalEarnings, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Total Paid to You</div>
                        <div class="fs-1 fw-bolder text-success mt-2">
                            {{ getCurrencySymbol() }} {{ number_format($totalPaid, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Available / Unpaid Balance</div>
                        <div class="fs-1 fw-bolder text-warning mt-2">
                            {{ getCurrencySymbol() }} {{ number_format($balance, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-muted fw-bold">Referred Patients</div>
                        <div class="fs-1 fw-bolder text-info mt-2">
                            {{ $patientsCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#refPatientsTab" role="tab">
                            <i class="fas fa-users me-1"></i> My Referred Patients ({{ $referrer->patients->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#refBillsTab" role="tab">
                            <i class="fas fa-coins me-1"></i> Commission History ({{ $referrer->testServiceBills->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#refPayoutsTab" role="tab">
                            <i class="fas fa-receipt me-1"></i> Received Payouts ({{ $referrer->payouts->count() }})
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Tab 1: Patients -->
                    <div class="tab-pane fade show active" id="refPatientsTab" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Age / Gender</th>
                                        <th>Joined On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->patients as $patient)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $patient->patient_unique_id }}</td>
                                            <td class="fw-bold text-dark">{{ $patient->patientUser->full_name ?? 'N/A' }}</td>
                                            <td>{{ $patient->patientUser->phone ?? '-' }}</td>
                                            <td>{{ $patient->age ?? '-' }} yrs / {{ $patient->patientUser->gender == 0 ? 'Male' : 'Female' }}</td>
                                            <td>{{ $patient->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-muted">
                                                No patients bound yet. Share your Referral Code <strong>{{ $referrer->refer_code }}</strong> with patients to start earning incentives!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2: Commission Bills -->
                    <div class="tab-pane fade" id="refBillsTab" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Bill #</th>
                                        <th>Patient</th>
                                        <th>Bill Paid Amount</th>
                                        <th>Commission %</th>
                                        <th>Your Earnings</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->testServiceBills as $bill)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $bill->bill_number }}</td>
                                            <td>{{ $bill->patient->patientUser->full_name ?? 'N/A' }}</td>
                                            <td>{{ getCurrencySymbol() }} {{ number_format($bill->net_amount, 2) }}</td>
                                            <td>{{ $bill->referral_commission_percent }}%</td>
                                            <td class="text-success fw-bolder">
                                                +{{ getCurrencySymbol() }} {{ number_format($bill->referral_commission_amount, 2) }}
                                            </td>
                                            <td>{{ $bill->created_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-6 text-muted">
                                                No test or service commissions recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3: Payouts Received -->
                    <div class="tab-pane fade" id="refPayoutsTab" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle">
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Payout #</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Reference / Note</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($referrer->payouts as $payout)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $payout->payout_number }}</td>
                                            <td class="fw-bolder text-success">
                                                {{ getCurrencySymbol() }} {{ number_format($payout->amount, 2) }}
                                            </td>
                                            <td><span class="badge bg-light-primary text-primary">{{ $payout->payment_method }}</span></td>
                                            <td>{{ $payout->reference_note ?? '-' }}</td>
                                            <td>{{ $payout->paid_at->format('d M, Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-muted">
                                                No payouts received yet.
                                            </td>
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

