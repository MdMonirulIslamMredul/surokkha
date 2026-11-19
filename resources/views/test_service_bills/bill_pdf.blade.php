<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Bill #{{ $bill->bill_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, "Helvetica", sans-serif;
            color: #333;
            font-size: 13px;
            margin: 20px;
        }
        .header-table { width: 100%; margin-bottom: 20px; border-bottom: 2px solid #009ef7; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; color: #009ef7; }
        .subtitle { font-size: 14px; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { vertical-align: top; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background: #f5f8fa; border: 1px solid #ddd; padding: 8px; text-align: left; }
        .items-table td { border: 1px solid #ddd; padding: 8px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-table { width: 40%; margin-left: auto; border-collapse: collapse; }
        .total-table td { padding: 5px 8px; }
        .net-total { font-size: 16px; font-weight: bold; color: #50cd89; border-top: 1px solid #ddd; }
        .badge { background: #50cd89; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td>
                <div class="title">{{ getAppName() }}</div>
                <div class="subtitle">Diagnostic & Therapy Services Bill</div>
                <div style="margin-top: 5px;">Date: {{ $bill->created_at->format('d M, Y h:i A') }}</div>
            </td>
            <td class="text-right">
                <div style="font-size: 18px; font-weight: bold;">INVOICE / RECEIPT</div>
                <div style="font-size: 14px; color: #009ef7; font-weight: bold;">#{{ $bill->bill_number }}</div>
                <div style="margin-top: 5px;"><span class="badge">PAID</span></div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <strong>PATIENT INFORMATION:</strong><br>
                Name: {{ $bill->patient->patientUser->full_name ?? 'N/A' }}<br>
                Patient ID: {{ $bill->patient->patient_unique_id }}<br>
                Phone: {{ $bill->patient->patientUser->phone ?? 'N/A' }}<br>
                Age / Gender: {{ $bill->patient->age ?? 'N/A' }} yrs / {{ $bill->patient->patientUser->gender == 0 ? 'Male' : 'Female' }}<br>
                @if($bill->patient->height || $bill->patient->weight)
                    Height/Weight: {{ $bill->patient->height ?? '-' }} cm / {{ $bill->patient->weight ?? '-' }} kg (BMI: {{ $bill->patient->bmi ?? '-' }})<br>
                @endif
            </td>
            <td style="width: 50%;" class="text-right">
                <strong>CLINICAL DETAILS:</strong><br>
                Prescribed By: {{ $bill->doctor ? ($bill->doctor->doctorUser->full_name ?? 'Doctor') : 'Self / General OPD' }}<br>
                Payment Method: {{ $bill->payment_method }}<br>
                @if($bill->referrer)
                    Referrer: {{ $bill->referrer->user->full_name ?? $bill->referrer->refer_code }} ({{ $bill->referrer->refer_code }})<br>
                @endif
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Test / Service Item</th>
                <th class="text-center" style="width: 80px;">Type</th>
                <th class="text-right" style="width: 100px;">Price</th>
                <th class="text-center" style="width: 50px;">Qty</th>
                <th class="text-right" style="width: 110px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td class="text-center" style="text-transform: capitalize;">{{ $item->item_type }}</td>
                    <td class="text-right">{{ getCurrencySymbol() }} {{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ getCurrencySymbol() }} {{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="total-table">
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">{{ getCurrencySymbol() }} {{ number_format($bill->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #f1416c;">Discount ({{ $bill->discount_type == 'percentage' ? $bill->discount_value.'%' : 'Flat' }}):</td>
            <td class="text-right" style="color: #f1416c;">-{{ getCurrencySymbol() }} {{ number_format($bill->discount_amount, 2) }}</td>
        </tr>
        <tr class="net-total">
            <td>Net Total Paid:</td>
            <td class="text-right">{{ getCurrencySymbol() }} {{ number_format($bill->net_amount, 2) }}</td>
        </tr>
    </table>

    @if($bill->note)
        <div style="margin-top: 30px; font-size: 11px; color: #777;">
            <strong>Note:</strong> {{ $bill->note }}
        </div>
    @endif

    <div style="margin-top: 50px; text-align: center; color: #888; font-size: 11px; border-top: 1px dashed #ccc; padding-top: 10px;">
        Thank you for choosing {{ getAppName() }}. For inquiries or test collection, please bring this slip.
    </div>
</body>
</html>

