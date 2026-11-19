@extends('layouts.app')
@section('title')
    Disburse Referral Payout
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Disburse Commission Payout</h1>
            <a href="{{ route('referral-payouts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Payouts
            </a>
        </div>

        <div class="card col-lg-8 mx-auto">
            <div class="card-body p-8">
                <form method="POST" action="{{ route('referral-payouts.store') }}" id="payoutForm">
                    @csrf

                    <div class="mb-5">
                        <label class="form-label required">Select Referrer:</label>
                        <select name="referrer_id" id="referrerSelect" class="form-select" data-control="select2" required>
                            <option value="">-- Choose Referrer --</option>
                            @foreach($referrers as $id => $label)
                                <option value="{{ $id }}" {{ (old('referrer_id') == $id || $selectedReferrerId == $id) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Live Balance Info Banner -->
                    <div id="balanceBanner" class="alert alert-light-primary border border-primary d-none mb-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold" id="bannerReferrerName"></span>
                                <span class="badge bg-primary text-white ms-2" id="bannerReferrerCode"></span>
                            </div>
                            <div class="text-end">
                                <span class="fs-7 text-muted">Available Unpaid Balance:</span>
                                <div class="fs-3 fw-bolder text-success" id="bannerAvailableBalance">0.00</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label required">Payout Amount ({{ getCurrencySymbol() }}):</label>
                        <input type="number" step="0.01" min="1" name="amount" id="payoutAmountInput" class="form-control fs-4" required placeholder="0.00" value="{{ old('amount') }}">
                        <span class="text-muted fs-7">Amount cannot exceed available unpaid balance.</span>
                    </div>

                    <div class="mb-5">
                        <label class="form-label required">Payment Method:</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash" selected>Cash</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="form-label">Reference Note / Transaction ID (Optional):</label>
                        <textarea name="reference_note" class="form-control" rows="2" placeholder="e.g. Cash voucher #492, bKash TrxID, Bank receipt...">{{ old('reference_note') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success py-3 px-6 fs-5" id="confirmPayoutBtn">
                            <i class="fas fa-check-circle me-1"></i> Confirm & Disburse Payout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let maxBalance = 0;

        document.addEventListener('DOMContentLoaded', function () {
            $('#referrerSelect').on('change', function () {
                const refId = $(this).val();
                if (!refId) {
                    $('#balanceBanner').addClass('d-none');
                    maxBalance = 0;
                    return;
                }

                $.ajax({
                    url: '{{ url("referral-balance-details") }}/' + refId,
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            const d = res.data;
                            maxBalance = parseFloat(d.balance) || 0;
                            $('#bannerReferrerName').text(d.name);
                            $('#bannerReferrerCode').text(d.code);
                            $('#bannerAvailableBalance').text('{{ getCurrencySymbol() }} ' + maxBalance.toFixed(2));
                            $('#balanceBanner').removeClass('d-none');

                            // Pre-fill amount with full available balance
                            if (maxBalance > 0) {
                                $('#payoutAmountInput').val(maxBalance.toFixed(2));
                            } else {
                                $('#payoutAmountInput').val(0);
                            }
                        }
                    }
                });
            });

            // Trigger change if already selected
            if ($('#referrerSelect').val()) {
                $('#referrerSelect').trigger('change');
            }

            $('#payoutForm').on('submit', function (e) {
                const amt = parseFloat($('#payoutAmountInput').val()) || 0;
                if (amt <= 0) {
                    e.preventDefault();
                    alert('Please enter an amount greater than 0.');
                    return false;
                }
                if (amt > maxBalance) {
                    e.preventDefault();
                    alert('Payout amount cannot exceed available balance of ' + maxBalance.toFixed(2));
                    return false;
                }
            });
        });
    </script>
@endsection

