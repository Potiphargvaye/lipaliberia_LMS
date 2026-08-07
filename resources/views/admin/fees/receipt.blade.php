{{--
    Expects $payment (FeePayment) eager-loaded with:
        feeAssignment.enrollment.student.user,
        feeAssignment.enrollment.cohort,
        feeAssignment.feeCategory,
        recordedBy
    and $forPdf (bool).
--}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $payment->receipt_number }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 15px;
            font-size: 13px;
            color: #1e293b;
            position: relative;
        }

        .header,
        .section,
        .footer {
            position: relative;
            z-index: 2;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .logo-cell {
            width: 70px;
        }

        .logo-cell img {
            height: 60px;
            width: 60px;
            object-fit: contain;
        }

        .header-text-cell {
            text-align: center;
            padding-left: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .school-name {
            font-size: 20px;
            font-weight: bold;
            color: #155E8A;
            line-height: 1.3;
        }

        .school-address {
            font-size: 11px;
            margin-top: 2px;
            color: #475569;
        }

        .receipt-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 6px;
            color: #0B3A57;
        }

        .receipt-date {
            font-size: 12px;
            margin-top: 3px;
            color: #475569;
        }

        .divider {
            border-bottom: 3px solid #B91C1C;
            margin-top: 8px;
        }

        .section {
            border: 1px solid #E2E8F0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
            color: #155E8A;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 3px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }

        .detail-group {
            margin-bottom: 4px;
        }

        .detail-label {
            font-weight: bold;
            color: #334155;
        }

        .amount-paid {
            color: #155E8A;
            font-weight: bold;
        }

        .amount-balance {
            color: #B91C1C;
            font-weight: bold;
        }

        .receipt-number-badge {
            display: inline-block;
            background: #155E8A;
            color: #fff;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            color: #334155;
        }

        .signature-line {
            border-top: 1px solid #94A3B8;
            margin-top: 25px;
        }

        .footer-contact {
            margin-top: 16px;
            padding-top: 10px;
            border-top: 1px solid #E2E8F0;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            padding: 0 8px;
            vertical-align: top;
            font-size: 10px;
            color: #475569;
            width: 33.33%;
        }

        .footer-table .footer-label {
            font-weight: bold;
            color: #155E8A;
            font-size: 10.5px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .footer {
            margin-top: 12px;
            font-size: 11px;
            text-align: center;
            color: #64748B;
        }

        .print-toolbar {
            text-align: center;
            margin-bottom: 15px;
        }

        .print-toolbar button {
            background: #155E8A;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        .print-toolbar button:hover {
            background: #0B3A57;
        }

        @media print {
            body {
                margin: 10mm;
            }

            .section {
                page-break-inside: avoid;
            }

            .print-toolbar {
                display: none;
            }
        }
    </style>
</head>

<body>

    @if (!$forPdf)
        <div class="print-toolbar">
            <button onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
        </div>
    @endif

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo">
                </td>
                <td class="header-text-cell">
                    <div class="school-name">Liberia Institute of Public Administration</div>
                    <div class="school-address">Doemah Town, Palm Wine Station, Margibi County, Liberia</div>
                    <div class="receipt-title">OFFICIAL FEE RECEIPT</div>
                    <div class="receipt-date">Date: {{ $payment->payment_date->format('M d, Y') }}</div>
                </td>
                <td class="logo-cell"></td>
            </tr>
        </table>
        <div class="divider"></div>
    </div>

    <div class="section">
        <div class="section-title">
            Receipt <span class="receipt-number-badge">{{ $payment->receipt_number }}</span>
        </div>
        <div class="detail-grid">
            <div class="detail-group"><span class="detail-label">Payment Date:</span>
                {{ $payment->payment_date->format('M d, Y') }}</div>
            <div class="detail-group"><span class="detail-label">Student:</span>
                {{ $payment->feeAssignment->enrollment->student->name }}</div>
            <div class="detail-group"><span class="detail-label">Student ID:</span>
                {{ $payment->feeAssignment->enrollment->student->user?->registration_id ?? '—' }}</div>
            <div class="detail-group"><span class="detail-label">Course:</span>
                {{ $payment->feeAssignment->enrollment->course->title ?? '—' }}</div>
            <div class="detail-group"><span class="detail-label">Cohort:</span>
                {{ $payment->feeAssignment->enrollment->cohort->name ?? '—' }}</div>
            <div class="detail-group"><span class="detail-label">Fee Category:</span>
                {{ $payment->feeAssignment->feeCategory->name }}</div>
            <div class="detail-group"><span class="detail-label">Payment Method:</span> {{ $payment->payment_method }}
            </div>
            <div class="detail-group"><span class="detail-label">Reference Number:</span>
                {{ $payment->reference_number ?: '—' }}</div>
            <div class="detail-group"><span class="detail-label">Amount Paid:</span> <span
                    class="amount-paid">${{ number_format($payment->amount_paid, 2) }}</span></div>
            <div class="detail-group"><span class="detail-label">Remaining Balance:</span> <span
                    class="amount-balance">${{ number_format($payment->feeAssignment->balance(), 2) }}</span></div>
            <div class="detail-group"><span class="detail-label">Recorded By:</span>
                {{ $payment->recordedBy?->name ?? '—' }}</div>
        </div>
        @if ($payment->remarks)
            <div class="detail-group" style="margin-top: 8px;">
                <span class="detail-label">Remarks:</span> {{ $payment->remarks }}
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Authorization</div>
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>Finance Officer
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>Authorized Signature
            </div>
        </div>
    </div>

    <div class="footer-contact">
        <table class="footer-table">
            <tr>
                <td>
                    <span class="footer-label">Our Location</span>
                    Doemah Town, Palm Wine Station<br>
                    Margibi County, Liberia
                </td>
                <td>
                    <span class="footer-label">Call Us</span>
                    +231 775 899 217<br>
                    Mon - Fri, 8:00 AM - 5:00 PM
                </td>
                <td>
                    <span class="footer-label">Email</span>
                    directorate@lipaliberia.com<br>
                    training@lipaliberia.com
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div>Printed on {{ now()->format('M d, Y') }} at {{ now()->format('h:i A') }}</div>
        <div>This document is system-generated and valid without a stamp.</div>
    </div>

</body>

</html>
