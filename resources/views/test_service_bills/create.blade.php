@extends('layouts.app')
@section('title')
    New Test & Therapy Service Bill
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">New Diagnostic & Service Bill</h1>
            <a href="{{ route('test-service-bills.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Bills
            </a>
        </div>

        <form method="POST" action="{{ route('test-service-bills.store') }}" id="testBillForm">
            @csrf
            <div class="row">
                <!-- Left: Patient & Doctor Selection -->
                <div class="col-lg-8">
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Patient & Doctor Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">Select Patient:</label>
                                    <select name="patient_id" id="patientSelect" class="form-select" data-control="select2" required>
                                        <option value="">-- Choose Patient by Name / Phone / ID --</option>
                                        @foreach($patients as $id => $label)
                                            <option value="{{ $id }}" {{ old('patient_id') == $id ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Prescribing Doctor (Optional):</label>
                                    <select name="doctor_id" id="doctorSelect" class="form-select" data-control="select2">
                                        <option value="">-- Self / No Doctor --</option>
                                        @foreach($doctors as $id => $name)
                                            <option value="{{ $id }}" {{ old('doctor_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Patient Info Banner -->
                            <div id="patientInfoBanner" class="alert alert-primary d-none mb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold" id="bannerPatientName"></span>
                                        <span class="badge bg-white text-primary ms-2" id="bannerPatientId"></span>
                                        <span class="ms-3 text-dark">Phone: <span id="bannerPatientPhone"></span></span>
                                    </div>
                                    <div id="bannerReferrerWrapper">
                                        <span class="badge bg-success fs-7" id="bannerReferrerBadge"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tests & Services Table -->
                    <div class="card mb-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Tests & Therapy Services</h3>
                            <button type="button" class="btn btn-sm btn-primary" id="addRowBtn">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle" id="itemsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 45%;">Test / Therapy Service</th>
                                            <th style="width: 20%;">Price ({{ getCurrencySymbol() }})</th>
                                            <th style="width: 15%;">Qty</th>
                                            <th style="width: 20%;">Total ({{ getCurrencySymbol() }})</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <!-- Dynamic Rows -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-muted fs-7">
                                Tip: You can select Pathology tests, Radiology tests, or Therapy services prescribed by the doctor.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary & Payment -->
                <div class="col-lg-4">
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Payment & Discount</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">Subtotal:</span>
                                <span class="fw-bolder fs-4" id="displaySubtotal">{{ getCurrencySymbol() }} 0.00</span>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Discount Type:</label>
                                <div class="d-flex">
                                    <div class="form-check me-4">
                                        <input class="form-check-input discount-type-radio" type="radio" name="discount_type" id="discountPercent" value="percentage" checked>
                                        <label class="form-check-label" for="discountPercent">Percentage (%)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input discount-type-radio" type="radio" name="discount_type" id="discountFlat" value="amount">
                                        <label class="form-check-label" for="discountFlat">Flat Amount ({{ getCurrencySymbol() }})</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" id="discountLabel">Discount Value (%):</label>
                                <input type="number" step="0.01" min="0" name="discount_value" id="discountValueInput" class="form-control" value="0" placeholder="0">
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center text-danger">
                                <span>Discount Amount:</span>
                                <span class="fw-bold" id="displayDiscountAmount">-{{ getCurrencySymbol() }} 0.00</span>
                            </div>

                            <hr>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <span class="fw-bolder fs-4 text-dark">Net Payable:</span>
                                <span class="fw-bolder fs-2 text-success" id="displayNetAmount">{{ getCurrencySymbol() }} 0.00</span>
                            </div>

                            <!-- Referral Incentive Preview -->
                            <div class="alert alert-light-success border border-success d-none mb-4" id="referralIncentiveBox">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hand-holding-usd fs-2 text-success me-3"></i>
                                    <div>
                                        <div class="fw-bold text-success">Referral Incentive ({{ $globalCommission }}%)</div>
                                        <div class="fs-7 text-muted">
                                            Referrer: <strong id="boxReferrerName"></strong>
                                        </div>
                                        <div class="fs-6 fw-bolder text-dark mt-1">
                                            Earns: <span id="boxIncentiveAmount">{{ getCurrencySymbol() }} 0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label required">Payment Method:</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="Cash" selected>Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="bKash">bKash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Notes / Remarks:</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-3 fs-5" id="submitBtn">
                                <i class="fas fa-check-circle me-1"></i> Save & Print Bill
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Hidden Raw Items Data -->
    <script>
        const pathologyTests = @json($pathologyTests);
        const radiologyTests = @json($radiologyTests);
        const therapyServices = @json($services);
        const globalCommissionPercent = {{ $globalCommission }};
        const currencySymbol = '{{ getCurrencySymbol() }}';
        let rowCounter = 0;
        let currentPatientReferrer = null;

        document.addEventListener('DOMContentLoaded', function () {
            // Add initial row
            addNewRow();

            document.getElementById('addRowBtn').addEventListener('click', addNewRow);

            // Patient change lookup
            $('#patientSelect').on('change', function () {
                const patientId = $(this).val();
                if (!patientId) {
                    $('#patientInfoBanner').addClass('d-none');
                    currentPatientReferrer = null;
                    updateTotals();
                    return;
                }

                $.ajax({
                    url: '{{ url("test-service-bills-patient-details") }}/' + patientId,
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            const p = res.data;
                            $('#bannerPatientName').text(p.name);
                            $('#bannerPatientId').text('ID: ' + p.unique_id);
                            $('#bannerPatientPhone').text(p.phone || 'N/A');

                            if (p.referrer) {
                                currentPatientReferrer = p.referrer;
                                $('#bannerReferrerBadge').text('Referrer: ' + p.referrer.name + ' (' + p.referrer.code + ')');
                                $('#bannerReferrerWrapper').removeClass('d-none');
                                $('#boxReferrerName').text(p.referrer.name + ' (' + p.referrer.code + ')');
                                $('#referralIncentiveBox').removeClass('d-none');
                            } else {
                                currentPatientReferrer = null;
                                $('#bannerReferrerWrapper').addClass('d-none');
                                $('#referralIncentiveBox').addClass('d-none');
                            }

                            $('#patientInfoBanner').removeClass('d-none');
                            updateTotals();
                        }
                    }
                });
            });

            // Discount type change
            $('.discount-type-radio').on('change', function () {
                if ($('#discountPercent').is(':checked')) {
                    $('#discountLabel').text('Discount Value (%):');
                } else {
                    $('#discountLabel').text('Discount Value (' + currencySymbol + '):');
                }
                updateTotals();
            });

            $('#discountValueInput').on('input', updateTotals);
        });

        function addNewRow() {
            rowCounter++;
            const tbody = document.getElementById('itemsTableBody');

            let optionsHtml = '<option value="">-- Choose Test or Service --</option>';

            optionsHtml += '<optgroup label="Pathology Tests">';
            pathologyTests.forEach(t => {
                optionsHtml += `<option value="pathology|${t.id}|${t.test_name}|${t.standard_charge}">[Pathology] ${t.test_name} - ${currencySymbol} ${t.standard_charge}</option>`;
            });
            optionsHtml += '</optgroup>';

            optionsHtml += '<optgroup label="Radiology Tests">';
            radiologyTests.forEach(t => {
                optionsHtml += `<option value="radiology|${t.id}|${t.test_name}|${t.standard_charge}">[Radiology] ${t.test_name} - ${currencySymbol} ${t.standard_charge}</option>`;
            });
            optionsHtml += '</optgroup>';

            optionsHtml += '<optgroup label="Therapy & Clinical Services">';
            therapyServices.forEach(s => {
                optionsHtml += `<option value="service|${s.id}|${s.name}|${s.rate}">[Service] ${s.name} - ${currencySymbol} ${s.rate}</option>`;
            });
            optionsHtml += '</optgroup>';

            const tr = document.createElement('tr');
            tr.id = `row_${rowCounter}`;
            tr.innerHTML = `
                <td>
                    <select class="form-select item-select" data-row="${rowCounter}" required>
                        ${optionsHtml}
                    </select>
                    <input type="hidden" name="items[${rowCounter}][item_type]" id="item_type_${rowCounter}">
                    <input type="hidden" name="items[${rowCounter}][item_id]" id="item_id_${rowCounter}">
                    <input type="hidden" name="items[${rowCounter}][item_name]" id="item_name_${rowCounter}">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="items[${rowCounter}][price]" id="price_${rowCounter}" class="form-control item-price" data-row="${rowCounter}" value="0" required>
                </td>
                <td>
                    <input type="number" min="1" name="items[${rowCounter}][quantity]" id="qty_${rowCounter}" class="form-control item-qty" data-row="${rowCounter}" value="1" required>
                </td>
                <td>
                    <span class="fw-bold item-total-display" id="total_display_${rowCounter}">${currencySymbol} 0.00</span>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-icon btn-sm btn-light-danger remove-row-btn" onclick="removeRow(${rowCounter})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);

            // Bind change on the select
            $(`#row_${rowCounter} .item-select`).on('change', function () {
                const val = $(this).val();
                if (val) {
                    const parts = val.split('|');
                    const type = parts[0];
                    const id = parts[1];
                    const name = parts[2];
                    const price = parseFloat(parts[3]) || 0;

                    $(`#item_type_${rowCounter}`).val(type);
                    $(`#item_id_${rowCounter}`).val(id);
                    $(`#item_name_${rowCounter}`).val(name);
                    $(`#price_${rowCounter}`).val(price);
                } else {
                    $(`#item_type_${rowCounter}`).val('');
                    $(`#item_id_${rowCounter}`).val('');
                    $(`#item_name_${rowCounter}`).val('');
                    $(`#price_${rowCounter}`).val(0);
                }
                updateRowTotal(rowCounter);
            });

            $(`#row_${rowCounter} .item-price, #row_${rowCounter} .item-qty`).on('input', function () {
                updateRowTotal(rowCounter);
            });
        }

        function removeRow(id) {
            const row = document.getElementById(`row_${id}`);
            if (row) {
                row.remove();
                updateTotals();
            }
        }

        function updateRowTotal(id) {
            const price = parseFloat($(`#price_${id}`).val()) || 0;
            const qty = parseInt($(`#qty_${id}`).val()) || 1;
            const total = price * qty;
            $(`#total_display_${id}`).text(`${currencySymbol} ${total.toFixed(2)}`);
            updateTotals();
        }

        function updateTotals() {
            let subtotal = 0;
            $('.item-price').each(function () {
                const row = $(this).data('row');
                const price = parseFloat($(this).val()) || 0;
                const qty = parseInt($(`#qty_${row}`).val()) || 1;
                subtotal += (price * qty);
            });

            $('#displaySubtotal').text(`${currencySymbol} ${subtotal.toFixed(2)}`);

            const discountType = $('input[name="discount_type"]:checked').val();
            const discountVal = parseFloat($('#discountValueInput').val()) || 0;
            let discountAmount = 0;

            if (discountType === 'percentage') {
                discountAmount = (subtotal * discountVal) / 100;
            } else {
                discountAmount = Math.min(discountVal, subtotal);
            }

            $('#displayDiscountAmount').text(`-${currencySymbol} ${discountAmount.toFixed(2)}`);

            const netAmount = Math.max(0, subtotal - discountAmount);
            $('#displayNetAmount').text(`${currencySymbol} ${netAmount.toFixed(2)}`);

            // Referral commission
            if (currentPatientReferrer) {
                const incentive = (netAmount * globalCommissionPercent) / 100;
                $('#boxIncentiveAmount').text(`${currencySymbol} ${incentive.toFixed(2)}`);
                $('#referralIncentiveBox').removeClass('d-none');
            } else {
                $('#referralIncentiveBox').addClass('d-none');
            }
        }
    </script>
@endsection

