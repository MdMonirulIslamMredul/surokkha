<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>{{ !empty($prescription['prescription']->patient->patientUser->full_name) ? $prescription['prescription']->patient->patientUser->full_name : 'Prescription' }}</title>
    <style>
        @page {
            size: 210mm 297mm; /* ISO A4 standard (210mm x 297mm) */
            margin: 6mm 8mm 12mm 8mm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, 'kalpurush', 'Vrinda', sans-serif;
            color: #181c32;
            margin: 0;
            padding: 0;
            font-size: 8.5pt;
            line-height: 1.25;
            width: 100%;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .clinic-bangla {
            font-family: 'kalpurush', 'Vrinda', sans-serif;
            font-size: 15pt;
            font-weight: bold;
            color: #0b3954;
            line-height: 1.2;
            margin-bottom: 1px;
        }
        .clinic-eng {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10.5pt;
            font-weight: bold;
            color: #007791;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .clinic-subtitle {
            font-size: 7.5pt;
            color: #555555;
            font-style: italic;
        }
        .doc-name {
            font-size: 12pt;
            font-weight: bold;
            color: #0b3954;
            margin-bottom: 2px;
        }
        .doc-qual {
            font-size: 7.5pt;
            color: #4a5568;
            line-height: 1.2;
        }
        .doc-specialist {
            font-size: 9pt;
            font-weight: bold;
            color: #007791;
            margin-top: 1px;
        }
        .doc-clinic {
            font-size: 7.5pt;
            color: #4a5568;
        }

        /* Patient Vitals Bar */
        .patient-box {
            background-color: #f1f9fa;
            border: 1px solid #9ed4dc;
            border-radius: 5px;
            padding: 3px 8px;
            margin-top: 3px;
            margin-bottom: 4px;
        }
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        .patient-table td {
            padding: 1.5px 3px;
            vertical-align: middle;
        }
        .p-lbl {
            font-weight: bold;
            color: #0b3954;
        }
        .p-val {
            color: #1a202c;
            border-bottom: 1px solid #718096;
            padding-bottom: 1px;
            display: inline-block;
            min-width: 45px;
        }

        /* Main Body Table: Expands to fill page to footer with equal height per section */
        .body-table {
            width: 100%;
            border-collapse: collapse;
        }
        .col-left {
            width: 46%;
            vertical-align: top;
            padding: 1.5mm 10px 1.5mm 0;
            border-right: 1.5px dotted #718096;
            height: 32.5mm;
        }
        .col-right {
            width: 54%;
            vertical-align: top;
            padding-left: 12px;
        }

        /* Section Headers with Icons */
        .sec-header {
            font-size: 9pt;
            font-weight: bold;
            color: #0b3954;
            margin-top: 1mm;
            margin-bottom: 1mm;
        }
        .sec-icon {
            display: inline-block;
            margin-right: 4px;
            vertical-align: middle;
        }
        .lined-row {
            border-bottom: 1px dotted #a0aec0;
            min-height: 5.4mm;
            line-height: 5.4mm;
            font-size: 8.5pt;
            color: #1a202c;
            padding-left: 2px;
            white-space: pre-line;
            font-family: 'DejaVu Sans', Arial, 'kalpurush', sans-serif;
        }
        .dx-row {
            border-bottom: 1px dotted #a0aec0;
            min-height: 5.4mm;
            line-height: 5.4mm;
            font-size: 9pt;
            font-weight: bold;
            color: #c53030;
            padding-left: 2px;
            font-family: 'DejaVu Sans', Arial, 'kalpurush', sans-serif;
        }

        /* VAS Scale Gauge */
        .vas-container {
            margin: 2px 0 2px 0;
        }
        .vas-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        .vas-cell {
            color: #ffffff;
            font-weight: bold;
            font-size: 7.5pt;
            padding: 2px 0;
            width: 9%;
        }
        .vas-active {
            border: 2px solid #000000 !important;
            font-size: 8pt !important;
        }
        .vas-labels {
            width: 100%;
            border-collapse: collapse;
            font-size: 6.5pt;
            margin-top: 1px;
        }

        /* Rx Header */
        .rx-header {
            font-size: 10pt;
            font-weight: bold;
            color: #0b3954;
            margin-bottom: 2px;
            margin-top: 2px;
        }
        .rx-symbol {
            display: inline-block;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* Signature Line */
        .signature-line {
            border-top: 1.5px solid #1a202c;
            width: 165px;
            text-align: center;
            padding-top: 3px;
            font-weight: bold;
            font-size: 9pt;
            color: #1a202c;
            float: right;
        }

        /* Footer Bar */
        .footer-bar {
            background-color: #0b3954;
            color: #ffffff;
            text-align: center;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 7.5pt;
            line-height: 1.35;
            border-top: 2.5px solid #00a3c4;
            width: 100%;
        }
    </style>
</head>
<body>
    @php
        $pres = $prescription['prescription'];
        $patient = $pres->patient;
        $doctor = $pres->doctor;
        $docUser = $doctor ? $doctor->doctorUser : null;
        $patUser = $patient ? $patient->patientUser : null;
        $clinicBangla = !empty($data['clinic_name_bangla']) ? $data['clinic_name_bangla'] : 'সুরক্ষা ফিজিওথেরাপি এন্ড অটিজম কেয়ার';
        $clinicEng = !empty($data['clinic_name_eng']) ? $data['clinic_name_eng'] : (!empty($data['app_name']) ? $data['app_name'] : 'SUROKKHA PHYSIOTHERAPY AND AUTISM CARE');
        $clinicSubtitle = !empty($data['clinic_subtitle']) ? $data['clinic_subtitle'] : 'A Specialized Center for Physical Rehabilitation & Neurodevelopment';
        $vasScore = isset($pres->vas) ? (int)$pres->vas : null;
        $vasColors = [
            0 => '#1b8a3e', 1 => '#3fa446', 2 => '#65be45',
            3 => '#8fc742', 4 => '#b8ce3b', 5 => '#e0c832',
            6 => '#e69f2e', 7 => '#ea7326', 8 => '#ed4b20',
            9 => '#ee2617', 10 => '#d32020'
        ];

        // Resolve dynamic logo path
        $logoPath = null;
        if (!empty($data['app_logo'])) {
            $rawLogo = $data['app_logo'];
            if (filter_var($rawLogo, FILTER_VALIDATE_URL)) {
                $pathOnly = parse_url($rawLogo, PHP_URL_PATH);
                $cand = public_path(ltrim($pathOnly, '/\\'));
                if (file_exists($cand)) {
                    $logoPath = $cand;
                } else {
                    $logoPath = $rawLogo;
                }
            } elseif (file_exists(public_path($rawLogo))) {
                $logoPath = public_path($rawLogo);
            } elseif (file_exists(storage_path('app/public/' . $rawLogo))) {
                $logoPath = storage_path('app/public/' . $rawLogo);
            }
        }
        if (!$logoPath && file_exists(public_path('web/img/logo.jpg'))) {
            $logoPath = public_path('web/img/logo.jpg');
        }
        if (!$logoPath && file_exists(public_path('uploads/clinic/clinic_emblem.png'))) {
            $logoPath = public_path('uploads/clinic/clinic_emblem.png');
        }

        if (!function_exists('renderPrescriptionLines')) {
            function renderPrescriptionLines($text, $minRows = 3, $extraItems = [], $isDx = false) {
                $lines = [];
                if (!empty($text)) {
                    $rawLines = explode("\n", str_replace(["\r\n", "\r"], "\n", trim($text)));
                    foreach ($rawLines as $l) {
                        $l = trim($l);
                        if ($l !== '') {
                            $lines[] = $l;
                        }
                    }
                }
                if (!empty($extraItems)) {
                    foreach ($extraItems as $item) {
                        $lines[] = $item;
                    }
                }
                $total = max(count($lines), $minRows);
                $html = '';
                $cls = $isDx ? 'dx-row' : 'lined-row';
                for ($i = 0; $i < $total; $i++) {
                    $val = isset($lines[$i]) ? htmlspecialchars($lines[$i]) : '&nbsp;';
                    $html .= '<div class="' . $cls . '">' . $val . '</div>';
                }
                return $html;
            }
        }

        // Prepare any attached medicines
        $medItems = [];
        if (isset($pres->getMedicine) && count($pres->getMedicine) > 0) {
            foreach ($pres->getMedicine as $idx => $m) {
                $medObj = \App\Models\Medicine::find($m->medicine);
                $mName = $medObj ? $medObj->name : 'Medicine';
                $medItems[] = ($idx + 1) . '. ' . $mName . ' - ' . $m->dosage . ' (' . $m->day . ' days)' . ($m->comment ? ' [' . $m->comment . ']' : '');
            }
        }
    @endphp

    {{-- Header Section (Matching Photo Pad) --}}
    <table class="header-table">
        <tr>
            <td style="width: 48%; vertical-align: middle;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 52px; vertical-align: middle;">
                            @if($logoPath)
                                <img src="{{ $logoPath }}" style="height: 48px; width: auto; max-width: 52px;" alt="Logo">
                            @else
                                <div style="width: 44px; height: 44px; background-color: #0b3954; border-radius: 50%; color: #fff; text-align: center; line-height: 44px; font-weight: bold; font-size: 20px;">S</div>
                            @endif
                        </td>
                        <td style="padding-left: 8px; vertical-align: middle;">
                            <div class="clinic-bangla">{{ $clinicBangla }}</div>
                            <div class="clinic-eng">{{ $clinicEng }}</div>
                            <div class="clinic-subtitle">{{ $clinicSubtitle }}</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 18%; vertical-align: middle; text-align: left; border-left: 1px solid #cbd5e0; padding: 0 6px; font-size: 8.5pt;">
                <div style="margin-bottom: 6px;">
                    <span style="color: #4a5568; font-weight: bold;">Reg. No:</span>
                    <span style="border-bottom: 1px dotted #718096; display: inline-block; min-width: 60px; font-weight: bold; color: #0b3954;">{{ $patient ? $patient->patient_unique_id : '' }}</span>
                </div>
                <div>
                    <span style="color: #4a5568; font-weight: bold;">Date:</span>
                    <span style="border-bottom: 1px dotted #718096; display: inline-block; min-width: 60px; font-weight: bold; color: #1a202c;">{{ \Carbon\Carbon::parse($pres->created_at)->format('d/m/Y') }}</span>
                </div>
            </td>
            <td style="width: 34%; vertical-align: middle; text-align: right; border-left: 1px solid #cbd5e0; padding-left: 8px;">
                <div class="doc-name">
                    {{ $docUser ? 'DR. ' . strtoupper($docUser->full_name) : 'DR. DEBAJIT GHOSH' }}
                </div>
                <div class="doc-qual">
                    {{ $docUser && !empty($docUser->qualification) ? $docUser->qualification : 'BPT (DU), MD (Physiotherapy), PGT (Pediatric & Adult Rehab)' }}
                </div>
                <div class="doc-specialist">
                    {{ $doctor && !empty($doctor->specialist) ? $doctor->specialist : 'Consultant Physiotherapist & Autism Specialist' }}
                </div>
                <div class="doc-clinic">
                    {{ $clinicEng }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Patient Vitals Box (Matching Photo Pad) --}}
    <div class="patient-box">
        <table class="patient-table">
            <tr>
                <td style="width: 38%;"><span class="p-lbl">Name:</span> <span class="p-val" style="min-width: 130px; font-weight: bold;">{{ $patUser ? $patUser->full_name : '' }}</span></td>
                <td style="width: 18%;"><span class="p-lbl">Age:</span> <span class="p-val" style="min-width: 40px;">{{ $pres->patient_age ?? ($patient->age ?? '') }} Yrs</span></td>
                <td style="width: 18%;"><span class="p-lbl">Sex:</span> <span class="p-val" style="min-width: 45px;">{{ $patUser ? ($patUser->gender == 0 ? 'M' : 'F') : 'M / F' }}</span></td>
                <td style="width: 26%; text-align: right;"><span class="p-lbl">Date:</span> <span class="p-val" style="min-width: 75px;">{{ \Carbon\Carbon::parse($pres->created_at)->format('d/m/20y') }}</span></td>
            </tr>
            <tr>
                <td><span class="p-lbl">Height:</span> <span class="p-val" style="min-width: 60px;">{{ $pres->patient_height ?? ($patient->height ?? '') }} cm</span></td>
                <td><span class="p-lbl">Weight:</span> <span class="p-val" style="min-width: 50px;">{{ $pres->patient_weight ?? ($patient->weight ?? '') }} kg</span></td>
                <td><span class="p-lbl">BMI:</span> <span class="p-val" style="min-width: 50px;">{{ $pres->patient_bmi ?? ($patient->bmi ?? '') }}</span></td>
                <td style="text-align: right;"><span class="p-lbl">Occupation:</span> <span class="p-val" style="min-width: 80px;">{{ $pres->patient_occupation ?? ($patient->occupation ?? '') }}</span></td>
            </tr>
        </table>
    </div>

    {{-- Body Layout (Table expanding to footer, with td tags divided in equal height: 32.5mm each) --}}
    <table class="body-table">
        <!-- Row 1: C/C (32.5mm) | PT Rx (spans top 4 rows = 130mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-8-2h4v2h-4V4zm-1 9H9v2h2v2h2v-2h2v-2h-2v-2h-2v2z"/></svg>
                    C/C (Chief Complaints):
                </div>
                {!! renderPrescriptionLines($pres->c_c, 4) !!}
            </td>
            <td class="col-right" rowspan="4" style="height: 130mm; vertical-align: top; padding-top: 1.5mm;">
                <div class="rx-header">
                    <svg class="rx-symbol" width="15" height="15" viewBox="0 0 24 24" fill="#0b3954"><path d="M19.5 16.5l-2-2 2-2-1.41-1.41-2 2-2-2-1.42 1.41 2 2-2 2 1.42 1.42 2-2 2 2 1.41-1.42zM5 4h6.5c2.48 0 4.5 2.02 4.5 4.5 0 1.84-1.12 3.42-2.73 4.12l3.23 7.38H13.8l-2.8-6.5H7.5V20H5V4zm2.5 6.5h4c1.1 0 2-.9 2-2s-.9-2-2-2h-4v4z"/></svg>
                    PT Rx (Physiotherapy Treatment):
                </div>
                {!! renderPrescriptionLines($pres->pt_rx, 22) !!}
            </td>
        </tr>

        <!-- Row 2: H/O (32.5mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    H/O (History Of):
                </div>
                {!! renderPrescriptionLines($pres->h_o, 4) !!}
            </td>
        </tr>

        <!-- Row 3: S/S (32.5mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-14 0v1z"/></svg>
                    S/S (Signs & Symptoms):
                </div>
                {!! renderPrescriptionLines($pres->s_s, 4) !!}
            </td>
        </tr>

        <!-- Row 4: Investigation (32.5mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                    Investigation:
                </div>
                {!! renderPrescriptionLines($pres->investigation, 4) !!}
            </td>
        </tr>

        <!-- Row 5: VAS (32.5mm) | Medication / Other Support (spans rows 5 & 6 = 65mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M3 13h3.5l2-5 3.5 10 2.5-7 1.5 2H21v-2h-6l-1.5 3.5L10 3 6.5 11H3v2z"/></svg>
                    VAS (Pain Scale):
                </div>
                <div class="vas-container">
                    <table class="vas-table">
                        <tr>
                            @for($i = 0; $i <= 10; $i++)
                                <td class="vas-cell {{ ($vasScore !== null && $vasScore == $i) ? 'vas-active' : '' }}"
                                    style="background-color: {{ $vasColors[$i] }}; {{ ($vasScore !== null && $vasScore == $i) ? 'border: 2px solid #000; font-weight: bold; color: #fff;' : '' }}">
                                    {{ $i }}
                                </td>
                            @endfor
                        </tr>
                    </table>
                    <table class="vas-labels">
                        <tr>
                            <td style="text-align: left; color: #1b8a3e; font-weight: bold;">No Pain (0)</td>
                            <td style="text-align: right; color: #d32020; font-weight: bold;">Severe Pain (10)</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="col-right" rowspan="2" style="height: 65mm; vertical-align: top; padding-top: 1.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M4.5 10.5C3.67 10.5 3 11.17 3 12s.67 1.5 1.5 1.5h15c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5h-15z"/></svg>
                    Medication / Other Support:
                </div>
                {!! renderPrescriptionLines($pres->medication_other_support, 10, $medItems) !!}
            </td>
        </tr>

        <!-- Row 6: Dx (32.5mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    <svg class="sec-icon" width="13" height="13" viewBox="0 0 24 24" fill="#0b3954"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    Dx (Diagnosis):
                </div>
                {!! renderPrescriptionLines($pres->dx, 3, [], true) !!}
            </td>
        </tr>

        <!-- Row 7: Advice (32.5mm) | Doctor Signature (32.5mm) -->
        <tr style="height: 32.5mm;">
            <td class="col-left" style="height: 32.5mm;">
                <div class="sec-header">
                    Advice:
                </div>
                {!! renderPrescriptionLines($pres->advice, 4) !!}
            </td>
            <td class="col-right" style="height: 32.5mm; vertical-align: bottom; text-align: right; padding-bottom: 2mm;">
                <div class="signature-line">
                    Doctor's Signature
                </div>
            </td>
        </tr>
    </table>

    {{-- Footer Bar (Matching Photo Pad) --}}
    <htmlpagefooter name="docFooter">
        <div class="footer-bar">
            <div>
                Address: {{ !empty($data['hospital_address']) ? $data['hospital_address'] : 'House No: 13, Road No: 03, Rupnagar Housing Society, Mohammadpur, Dhaka' }}
            </div>
            <div>
                Mobile: {{ !empty($data['hospital_phone']) ? $data['hospital_phone'] : '+8801712-194950, +8801732-821813' }} |
                Email: {{ !empty($data['hospital_email']) ? $data['hospital_email'] : 'Surokkhaphyz@gmail.com' }}
            </div>
        </div>
    </htmlpagefooter>
    <sethtmlpagefooter name="docFooter" value="on" />
</body>
</html>