@extends('layouts.app')
@section('title')
    Referrers Management
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Referrers Management</h1>
            <div>
                <a href="{{ route('referral-payouts.create') }}" class="btn btn-success me-2">
                    <i class="fas fa-hand-holding-usd me-1"></i> Disburse Payout
                </a>
                <a href="{{ route('referrers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add New Referrer
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <form method="GET" action="{{ route('referrers.index') }}" class="w-100">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search by Referrer Code, Name, Phone, Occupation..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('referrers.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="ps-4 rounded-start">Refer Code</th>
                                <th>Referrer Name</th>
                                <th>Phone / Email</th>
                                <th>Occupation</th>
                                <th class="text-center">Referred Patients</th>
                                <th>Total Earnings</th>
                                <th>Total Paid</th>
                                <th>Available Balance</th>
                                <th class="rounded-end text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($referrers as $referrer)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-light-primary text-primary fw-bolder fs-6">
                                            {{ $referrer->refer_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('referrers.show', $referrer->id) }}" class="text-dark fw-bold text-hover-primary">
                                            {{ $referrer->user->full_name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ $referrer->phone }}</div>
                                        <small class="text-muted">{{ $referrer->user->email ?? 'No email' }}</small>
                                    </td>
                                    <td>{{ $referrer->occupation ?? 'General' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light-info text-info fw-bold">
                                            {{ $referrer->patients->count() }}
                                        </span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        {{ getCurrencySymbol() }} {{ number_format($referrer->total_earnings, 2) }}
                                    </td>
                                    <td class="text-muted">
                                        {{ getCurrencySymbol() }} {{ number_format($referrer->total_paid, 2) }}
                                    </td>
                                    <td class="fw-bolder {{ $referrer->balance > 0 ? 'text-primary' : 'text-muted' }}">
                                        {{ getCurrencySymbol() }} {{ number_format($referrer->balance, 2) }}
                                    </td>
                                    <td class="text-center">
                                        @if($referrer->balance > 0)
                                            <a href="{{ route('referral-payouts.create', ['referrer_id' => $referrer->id]) }}" class="btn btn-sm btn-light-success me-1" title="Disburse Payout">
                                                <i class="fas fa-money-bill-wave"></i> Pay
                                            </a>
                                        @endif
                                        <a href="{{ route('referrers.show', $referrer->id) }}" class="btn btn-icon btn-sm btn-light-info me-1" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('referrers.edit', $referrer->id) }}" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-8 text-muted">
                                        No referrers found. Click <strong>"Add New Referrer"</strong> to create one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $referrers->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

