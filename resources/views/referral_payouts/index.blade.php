@extends('layouts.app')
@section('title')
    Referral Commission Payouts
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Referral Payout Disbursements</h1>
            <div>
                <a href="{{ route('referrers.index') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-users me-1"></i> Referrers List
                </a>
                <a href="{{ route('referral-payouts.create') }}" class="btn btn-success">
                    <i class="fas fa-hand-holding-usd me-1"></i> Disburse New Payout
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="ps-4 rounded-start">Payout #</th>
                                <th>Referrer</th>
                                <th>Refer Code</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Reference / Note</th>
                                <th>Disbursed By</th>
                                <th class="rounded-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payouts as $payout)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $payout->payout_number }}</td>
                                    <td>
                                        <a href="{{ route('referrers.show', $payout->referrer_id) }}" class="fw-bold text-dark text-hover-primary">
                                            {{ $payout->referrer->user->full_name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-primary text-primary fw-bold">
                                            {{ $payout->referrer->refer_code ?? '' }}
                                        </span>
                                    </td>
                                    <td class="fw-bolder text-success fs-6">
                                        {{ getCurrencySymbol() }} {{ number_format($payout->amount, 2) }}
                                    </td>
                                    <td><span class="badge bg-light-info text-info">{{ $payout->payment_method }}</span></td>
                                    <td>{{ $payout->reference_note ?? '-' }}</td>
                                    <td>{{ $payout->paidBy->full_name ?? 'Staff' }}</td>
                                    <td>{{ $payout->paid_at->format('d M, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-muted">
                                        No payouts recorded yet. Click <strong>"Disburse New Payout"</strong> to issue commission payments.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $payouts->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

