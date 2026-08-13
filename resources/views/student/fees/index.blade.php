@extends('layouts.student')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4 fees-page">

        {{-- Page Heading --}}
        <div class="page-heading" id="feesPrintArea">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-cash-coin"></i></span>
                <div>
                    <p class="eyebrow mb-1">My Fees</p>
                    <h1 class="h4 mb-0">Financial Status</h1>
                    <p class="text-muted mb-0 small">View your current financial status and payment history.</p>
                </div>
            </div>

            <div class="heading-actions d-print-none">
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Statement
                </button>
            </div>
        </div>

        {{-- Print-only identity header — only visible when printed --}}
        <div class="d-none d-print-block print-student-header">
            <div><strong>Student:</strong> {{ $student->name }}</div>
            <div><strong>Student ID:</strong> {{ $student->user?->registration_id ?? '—' }}</div>
            <div><strong>Statement Date:</strong> {{ now()->format('M d, Y') }}</div>
        </div>

        {{-- Summary Metrics --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Total Fees</span>
                        <span class="metric-icon"><i class="bi bi-receipt"></i></span>
                    </div>
                    <div class="metric-value">${{ number_format($totalAssigned, 2) }}</div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="metric-card metric-success">
                    <div class="metric-top">
                        <span class="metric-label">Amount Paid</span>
                        <span class="metric-icon"><i class="bi bi-check-circle"></i></span>
                    </div>
                    <div class="metric-value">${{ number_format($totalPaid, 2) }}</div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="metric-card {{ $balance > 0 ? 'metric-danger' : 'metric-success' }}">
                    <div class="metric-top">
                        <span class="metric-label">Balance Due</span>
                        <span class="metric-icon"><i class="bi bi-wallet2"></i></span>
                    </div>
                    <div class="metric-value">${{ number_format($balance, 2) }}</div>
                </div>
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="panel mb-4">
            <div class="panel-header">
                <h2 class="h6 mb-0">Payment Status</h2>
                <span
                    class="badge text-bg-{{ $overallStatus === 'paid' ? 'success' : ($overallStatus === 'partial' ? 'warning' : ($overallStatus === 'pending' ? 'info' : 'secondary')) }}">
                    {{ $overallStatus === 'no_fees' ? 'No Fees' : ucfirst($overallStatus) }}
                </span>
            </div>

            <p class="text-muted small mb-3">
                @if ($overallStatus === 'no_fees')
                    No fees have been assigned to your account yet.
                @elseif ($overallStatus === 'paid')
                    Your account is fully paid thank you!
                @else
                    Your account has an outstanding balance of ${{ number_format($balance, 2) }}.
                @endif
            </p>

            <div class="progress" role="progressbar" aria-valuenow="{{ $percentPaid }}" aria-valuemin="0"
                aria-valuemax="100">
                <div class="progress-bar bg-{{ $overallStatus === 'paid' ? 'success' : 'primary' }}"
                    style="width: {{ $percentPaid }}%">
                    {{ $percentPaid }}% Paid
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">

            {{-- Current Enrollment --}}
            <div class="col-12 col-lg-5">
                <div class="panel h-100">
                    <div class="panel-header">
                        <h2 class="h6 mb-0"><i class="bi bi-mortarboard me-2"></i>Current Enrollment</h2>
                    </div>

                    @if ($activeEnrollment)
                        <div class="info-list">
                            <div>
                                <span>Course</span>
                                <strong>{{ $activeEnrollment->course->title ?? '—' }}</strong>
                            </div>
                            <div>
                                <span>Cohort</span>
                                <strong>{{ $activeEnrollment->cohort->name ?? '—' }}</strong>
                            </div>
                            <div>
                                <span>Status</span>
                                <strong>{{ ucfirst(str_replace('_', ' ', $activeEnrollment->status)) }}</strong>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">No active enrollment on record.</p>
                    @endif
                </div>
            </div>

            {{-- Need Help — WhatsApp contact button --}}
            <div class="col-12 col-lg-7 d-print-none">
                <a href="https://wa.me/231XXXXXXXXX?text={{ urlencode('Hello, I need help with my fees. Student ID: ' . ($student->user?->registration_id ?? '')) }}"
                    target="_blank" rel="noopener"
                    class="panel h-100 d-flex flex-column align-items-center justify-content-center text-center text-decoration-none whatsapp-help-card">
                    <span class="whatsapp-icon"><i class="bi bi-whatsapp"></i></span>
                    <p class="fw-bold mb-1 mt-2">Need help with your fees?</p>
                    <p class="text-muted small mb-0">Chat with the LIPA Finance Office on WhatsApp</p>
                </a>
            </div>

        </div>

        {{-- Fee Breakdown --}}
        <div class="panel mb-4">
            <div class="panel-header">
                <h2 class="h6 mb-0"><i class="bi bi-list-check me-2"></i>Fee Breakdown</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Fee Category</th>
                            <th>Cohort</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Balance</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assignments as $assignment)
                            @php
                                $rowPaid = $assignment->payments->sum('amount_paid');
                                $rowBalance = $assignment->balance();
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $assignment->feeCategory->name }}</div>
                                    @if ($assignment->installment_number)
                                        <div class="text-muted small">{{ $assignment->installment_number }}</div>
                                    @endif
                                </td>
                                <td>{{ $assignment->enrollment->cohort->name ?? '—' }}</td>
                                <td class="text-end">${{ number_format($assignment->amount, 2) }}</td>
                                <td class="text-end">${{ number_format($rowPaid, 2) }}</td>
                                <td class="text-end">${{ number_format($rowBalance, 2) }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge text-bg-{{ $assignment->status === 'paid' ? 'success' : ($assignment->status === 'overdue' ? 'danger' : ($assignment->status === 'partial' ? 'info' : 'warning')) }}">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No fees assigned yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payment History --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="h6 mb-0"><i class="bi bi-clock-history me-2"></i>Payment History</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Fee Category</th>
                            <th class="text-end">Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td class="font-monospace">{{ $payment->receipt_number }}</td>
                                <td>{{ $payment->feeAssignment->feeCategory->name ?? '—' }}</td>
                                <td class="text-end fw-semibold">${{ number_format($payment->amount_paid, 2) }}</td>
                                <td>{{ $payment->payment_method }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No payments recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        .fees-page .metric-card {
            min-height: auto;
            padding: 0.95rem 1.1rem;
        }

        .fees-page .metric-value {
            margin-top: 0.6rem;
            font-size: 1.5rem;
        }

        .fees-page .metric-icon {
            width: 34px;
            height: 34px;
        }

        .whatsapp-help-card {
            color: inherit;
            cursor: pointer;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .whatsapp-help-card:hover {
            border-color: #25D366;
            box-shadow: var(--admin-shadow-lg);
            transform: translateY(-3px);
        }

        .whatsapp-icon {
            width: 48px;
            height: 48px;
            display: inline-grid;
            place-items: center;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.14);
            color: #25D366;
            font-size: 1.4rem;
        }

        .print-student-header {
            display: none;
        }

        @media print {

            .admin-sidebar,
            .admin-navbar,
            .admin-footer,
            .sidebar-backdrop,
            .d-print-none {
                display: none !important;
            }

            .admin-main {
                margin-left: 0 !important;
            }

            body {
                background: #fff !important;
            }

            .metric-card,
            .panel {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                break-inside: avoid;
            }

            .print-student-header {
                display: block !important;
                margin-bottom: 1rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid #ddd;
                font-size: 0.9rem;
            }

            .whatsapp-help-card {
                display: none !important;
            }
        }
    </style>
@endsection
