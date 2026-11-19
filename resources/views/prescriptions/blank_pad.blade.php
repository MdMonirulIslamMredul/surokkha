<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blank Prescription Pad - {{ !empty($data['app_name']) ? $data['app_name'] : 'Surokkha' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 12mm 15mm 12mm;
        }
        body {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            color: #1a202c;
            margin: 0;
            padding: 15px;
            font-size: 11px;
            background: #fff;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .header-logo-col {
            width: 44%;
            vertical-align: top;
        }
        .header-center-col {
            width: 16%;
            vertical-align: top;
            text-align: center;
            border-left: 1px dotted #cbd5e0;
            border-right: 1px dotted #cbd5e0;
            padding: 0 5px;
            font-size: 10.5px;
        }
        .header-doctor-col {
            width: 40%;
            vertical-align: top;
            text-align: right;
            padding-left: 10px;
        }
        .clinic-bangla {
            font-size: 15px;
            font-weight: bold;
            color: #0b3954;
            line-height: 1.2;
            margin-bottom: 2px;
        }
        .clinic-eng {
            font-size: 12px;
            font-weight: bold;
            color: #087e8b;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .clinic-subtitle {
            font-size: 8.5px;
            color: #4a5568;
            font-style: italic;
        }
        .doc-name {
            font-size: 14px;
            font-weight: bold;
            color: #0b3954;
            margin-bottom: 2px;
        }
        .doc-qual {
            font-size: 9.5px;
            color: #4a5568;
            margin-bottom: 2px;
        }
        .doc-specialist {
            font-size: 10.5px;
            font-weight: bold;
            color: #087e8b;
            margin-bottom: 2px;
        }
        .doc-org {
            font-size: 9.5px;
            color: #718096;
        }
        /* Patient Bar */
        .patient-bar {
            background-color: #e6f4f6;
            border: 1px solid #b2dfe5;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 15px;
        }
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .patient-table td {
            padding: 3px 4px;
        }
        .lbl {
            font-weight: bold;
            color: #0b3954;
        }
        .val-line {
            display: inline-block;
            border-bottom: 1px dotted #718096;
            min-width: 100px;
            padding-left: 5px;
        }
        /* Two Column Body */
        .body-table {
            width: 100%;
            border-collapse: collapse;
        }
        .col-left {
            width: 46%;
            vertical-align: top;
            padding-right: 15px;
            border-right: 1px dashed #cbd5e0;
        }
        .col-right {
            width: 54%;
            vertical-align: top;
            padding-left: 15px;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #0b3954;
            margin-top: 8px;
            margin-bottom: 4px;
        }
        .dotted-line {
            border-bottom: 1px dotted #cbd5e0;
            height: 18px;
            margin-bottom: 3px;
        }
        /* VAS Scale Gauge */
        .vas-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin: 4px 0;
        }
        .vas-cell {
            color: #ffffff;
            font-weight: bold;
            font-size: 9px;
            padding: 3px 0;
            width: 9%;
        }
        .vas-labels {
            width: 100%;
            font-size: 8px;
            color: #718096;
            margin-top: 2px;
        }
        /* Footer */
        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #0b2356;
            border-top: 3px solid #00a8cc;
            color: #ffffff;
            text-align: center;
            padding: 8px 12px;
            font-size: 9px;
            line-height: 1.4;
        }
        .signature-box {
            margin-top: 50px;
            text-align: right;
            padding-right: 20px;
        }
        .signature-line {
            display: inline-block;
            border-top: 1px solid #4a5568;
            width: 180px;
            text-align: center;
            padding-top: 4px;
            font-weight: bold;
            font-size: 10.5px;
            color: #2d3748;
        }
        .watermark {
            position: fixed;
            top: 35%;
            left: 30%;
            width: 40%;
            opacity: 0.05;
            z-index: -1000;
            text-align: center;
        }
        .print-btn-bar {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 9999;
            background: #ffffff;
            padding: 8px 14px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .print-btn {
            background: #087e8b;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }
        .print-btn:hover {
            background: #0b3954;
        }
        @media print {
            .print-btn-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-btn-bar">
        <button class="print-btn" onclick="window.print()">
            &#128438; Print Prescription Pad
        </button>
    </div>

    @php
        $docUser = $doctor ? $doctor->doctorUser : null;
        $patUser = $patient ? $patient->patientUser : null;
        $appName = !empty($data['app_name']) ? $data['app_name'] : 'Surokkha Physiotherapy and Autism Care';
        $clinicBangla = !empty($data['clinic_name_bangla']) ? $data['clinic_name_bangla'] : 'সুরক্ষা ফিজিওথেরাপি এন্ড অটিজম কেয়ার';
        $clinicEng = !empty($data['clinic_name_eng']) ? $data['clinic_name_eng'] : (!empty($data['app_name']) ? $data['app_name'] : 'SUROKKHA PHYSIOTHERAPY AND AUTISM CARE');
        $clinicSubtitle = !empty($data['clinic_subtitle']) ? $data['clinic_subtitle'] : 'A Specialized Center for Physical Rehabilitation & Neurodevelopment';
        $vasColors = [
            0 => '#28a745', 1 => '#48b846', 2 => '#6cbd45',
            3 => '#8fc244', 4 => '#b5c742', 5 => '#e0be38',
            6 => '#e69830', 7 => '#ea7328', 8 => '#ed4e20',
            9 => '#f02818', 10 => '#dc3545'
        ];

        // Resolve dynamic logo path
        $viewLogo = null;
        if (!empty($data['app_logo'])) {
            $rawLogo = $data['app_logo'];
            if (filter_var($rawLogo, FILTER_VALIDATE_URL)) {
                $viewLogo = $rawLogo;
            } elseif (file_exists(public_path($rawLogo))) {
                $viewLogo = asset($rawLogo);
            } elseif (file_exists(storage_path('app/public/' . $rawLogo))) {
                $viewLogo = asset('storage/' . $rawLogo);
            }
        }
        if (!$viewLogo && file_exists(public_path('uploads/clinic/clinic_emblem.png'))) {
            $viewLogo = asset('uploads/clinic/clinic_emblem.png');
        }
        if (!$viewLogo && file_exists(public_path('web/img/logo.jpg'))) {
            $viewLogo = asset('web/img/logo.jpg');
        }
    @endphp

    {{-- Watermark --}}
    @if($viewLogo)
        <div class="watermark">
            <img src="{{ $viewLogo }}" style="width: 280px;" alt="Watermark">
        </div>
    @endif

    {{-- Header Section --}}
    <table class="header-table">
        <tr>
            <td class="header-logo-col">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 58px; vertical-align: middle;">
                            @if($viewLogo)
                                <img src="{{ $viewLogo }}" style="width: 52px; max-height: 52px;" alt="Logo">
                            @else
                                <div style="width: 48px; height: 48px; background-color: #087e8b; border-radius: 50%; color: #fff; text-align: center; line-height: 48px; font-weight: bold; font-size: 22px;">S</div>
                            @endif
                        </td>
                        <td style="padding-left: 10px; vertical-align: middle;">
                            <div class="clinic-bangla">{{ $clinicBangla }}</div>
                            <div class="clinic-eng">{{ $clinicEng }}</div>
                            <div class="clinic-subtitle">{{ $clinicSubtitle }}</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="header-center-col">
                <div style="margin-top: 8px;">
                    <span style="font-weight: bold; color: #4a5568;">Reg. No:</span><br>
                    <span style="color: #0b3954; font-weight: bold; font-size: 11px;">{{ $patient ? $patient->patient_unique_id : '....................' }}</span>
                </div>
                <div style="margin-top: 10px;">
                    <span style="font-weight: bold; color: #4a5568;">Date:</span><br>
                    <span>____/____/202__</span>
                </div>
            </td>
            <td class="header-doctor-col">
                <div class="doc-name">
                    {{ $docUser ? 'DR. ' . strtoupper($docUser->full_name) : 'DR. DEBAJIT GHOSH' }}
                </div>
                <div class="doc-qual">
                    {{ $docUser && !empty($docUser->qualification) ? $docUser->qualification : 'BPT (DU), MD (Physiotherapy), PGT (Pediatric & Adult Rehab)' }}
                </div>
                <div class="doc-specialist">
                    {{ $doctor && !empty($doctor->specialist) ? $doctor->specialist : 'Consultant Physiotherapist & Autism Specialist' }}
                </div>
                <div class="doc-org">
                    {{ !empty($data['clinic_name_eng']) ? $data['clinic_name_eng'] : (!empty($data['app_name']) ? $data['app_name'] : 'Surokkha Physiotherapy and Autism Care') }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Patient Bar --}}
    <div class="patient-bar">
        <table class="patient-table">
            <tr>
                <td style="width: 42%;"><span class="lbl">Name:</span> <span class="val-line" style="min-width: 180px;">{{ $patUser ? $patUser->full_name : '' }}</span></td>
                <td style="width: 18%;"><span class="lbl">Age:</span> <span class="val-line" style="min-width: 40px;">{{ $patient && $patient->age ? $patient->age : '' }}</span></td>
                <td style="width: 15%;"><span class="lbl">Sex:</span> <span class="val-line" style="min-width: 40px;">{{ $patUser ? ($patUser->gender == 0 ? 'M' : 'F') : 'M / F' }}</span></td>
                <td style="width: 25%; text-align: right;"><span class="lbl">Date:</span> <span class="val-line" style="min-width: 70px;">____/____/202__</span></td>
            </tr>
            <tr>
                <td><span class="lbl">Height:</span> <span class="val-line" style="min-width: 120px;">{{ $patient && $patient->height ? $patient->height . ' cm' : '' }}</span></td>
                <td><span class="lbl">Weight:</span> <span class="val-line" style="min-width: 40px;">{{ $patient && $patient->weight ? $patient->weight . ' kg' : '' }}</span></td>
                <td><span class="lbl">BMI:</span> <span class="val-line" style="min-width: 40px;">{{ $patient && $patient->bmi ? $patient->bmi : '' }}</span></td>
                <td style="text-align: right;"><span class="lbl">Occupation:</span> <span class="val-line" style="min-width: 100px;">{{ $patient && $patient->occupation ? $patient->occupation : '' }}</span></td>
            </tr>
        </table>
    </div>

    {{-- Two Column Body with Dotted Writing Lines --}}
    <table class="body-table">
        <tr>
            {{-- Left Column --}}
            <td class="col-left">
                <div class="section-title">&#129657; C/C (Chief Complaints):</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>

                <div class="section-title">&#128203; H/O (History Of):</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>

                <div class="section-title">&#129489;&#8205;&#9877;&#65039; S/S (Signs & Symptoms):</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>

                <div class="section-title">&#128196; Investigation:</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>

                <div class="section-title">&#128200; VAS (Pain Scale):</div>
                <table class="vas-table">
                    <tr>
                        @for($i = 0; $i <= 10; $i++)
                            <td class="vas-cell" style="background-color: {{ $vasColors[$i] }};">{{ $i }}</td>
                        @endfor
                    </tr>
                </table>
                <table class="vas-labels">
                    <tr>
                        <td style="text-align: left; color: #28a745; font-weight: bold;">No Pain (0)</td>
                        <td style="text-align: right; color: #dc3545; font-weight: bold;">Severe Pain (10)</td>
                    </tr>
                </table>

                <div class="section-title" style="margin-top: 8px;">&#128203; Dx (Diagnosis):</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>

                <div class="section-title">Advice:</div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>
                <div class="dotted-line"></div>
            </td>

            {{-- Right Column --}}
            <td class="col-right">
                <div class="section-title" style="font-size: 13px; margin-top: 0;">
                    <span style="font-family: serif; font-size: 17px; font-weight: bold;">&#8478;</span> PT Rx (Physiotherapy Treatment):
                </div>
                @for($i = 0; $i < 17; $i++)
                    <div class="dotted-line"></div>
                @endfor

                <div class="section-title" style="margin-top: 15px;">Medication / Other Support:</div>
                @for($i = 0; $i < 6; $i++)
                    <div class="dotted-line"></div>
                @endfor

                {{-- Doctor Signature --}}
                <div class="signature-box">
                    <div class="signature-line">
                        Doctor's Signature
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- Footer Bar --}}
    <div class="footer-bar">
        <div>
            Address: {{ !empty($data['hospital_address']) ? $data['hospital_address'] : 'House No: 13, Road No: 03, Rupnagar Housing Society, Mohammadpur, Dhaka' }}
        </div>
        <div>
            Mobile: {{ !empty($data['hospital_phone']) ? $data['hospital_phone'] : '+8801712-194950, +8801732-821813' }} |
            Email: {{ !empty($data['hospital_email']) ? $data['hospital_email'] : 'Surokkhaphyz@gmail.com' }}
        </div>
    </div>
</body>
</html>

