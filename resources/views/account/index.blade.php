@extends('layout.home')

@section('content')
@php
    $activeTab = request('tab', 'invoices');
@endphp

{{-- WRAPPER CLASS to scope custom styles --}}
<div class="account-dashboard">
    <div class="container py-5">
        <div class="row g-4">
            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden sticky-sidebar">
                    {{-- Gradient header with avatar --}}
                    <div class="card-header bg-gradient-primary text-white border-0 py-3">
                        <div class="d-flex align-items-center gap-3">
                            {{-- <div class="avatar-circle bg-white text-primary d-flex align-items-center justify-content-center">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div> --}}
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: black">{{ auth()->user()->name ?? 'User' }}</h6>
                                <small class="text-white-50" style="color: black">{{ auth()->user()->email ?? '' }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <nav class="nav nav-pills flex-column gap-2">
                            <a href="{{ route('account.index') }}?tab=invoices" 
                               class="nav-link d-flex align-items-center gap-3 rounded-3 px-3 py-2 {{ $activeTab == 'invoices' ? 'active' : '' }}">
                                <i class="fas fa-file-invoice fa-fw"></i> Invoices
                            </a>
                            <a href="{{ route('account.index') }}?tab=subscription" 
                               class="nav-link d-flex align-items-center gap-3 rounded-3 px-3 py-2 {{ $activeTab == 'subscription' ? 'active' : '' }}">
                                <i class="fas fa-crown fa-fw"></i> Subscription
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden content-card">
                    <div class="card-body p-4 p-xl-5">
                        @if($activeTab == 'invoices')
                            {{-- INVOICES TAB --}}
                            <div class="section-header d-flex align-items-center gap-3 mb-4">
                                <div class="icon-box bg-soft-primary p-3 rounded-3">
                                    <i class="fas fa-file-invoice text-primary" style="font-size: 1.75rem;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0">Your Invoices</h4>
                                    <p class="text-muted small mb-0">View and download your past invoices</p>
                                </div>
                            </div>

                            @if(empty($invoices))
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                        <i class="fas fa-receipt text-muted" style="font-size: 36px;"></i>
                                    </div>
                                    <h5 class="fw-bold">No invoices yet</h5>
                                    <p class="text-muted">Your transactions will appear here once you make a purchase.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border rounded-3 overflow-hidden">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Invoice #</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoices as $invoice)
                                                <tr>
                                                    <td><span class="fw-semibold">#{{ unique_encrypt($invoice->id) }}</span></td>
                                                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                                    <td>
                                                        @if($invoice->status == 'completed')
                                                            <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill">
                                                                <i class="fas fa-check-circle me-1"></i> Paid
                                                            </span>
                                                        @elseif($invoice->status == 'pending')
                                                            <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill">
                                                                <i class="fas fa-clock me-1"></i> Pending
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill">
                                                                <i class="fas fa-times-circle me-1"></i> {{ ucfirst($invoice->status) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <a target="_blank" href="{{ route('account.invoice.pdf', unique_encrypt($invoice->id)) }}" 
                                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 action-btn" 
                                                           title="Download PDF">
                                                            <i class="fas fa-download me-1"></i> PDF
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        @elseif($activeTab == 'subscription')
                            {{-- SUBSCRIPTION TAB --}}
                            <div class="section-header d-flex align-items-center gap-3 mb-4">
                                <div class="icon-box bg-soft-primary p-3 rounded-3">
                                    <i class="fas fa-crown text-primary" style="font-size: 1.75rem;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0">Your Subscription</h4>
                                    <p class="text-muted small mb-0">Manage your plan and billing details</p>
                                </div>
                            </div>

                            @if($subscription && !$is_expired)
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="subscription-card card h-100 border-0 shadow-sm rounded-4 p-4">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="plan-icon bg-soft-primary p-2 rounded-3">
                                                    <i class="fas fa-box text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <span class="badge bg-success rounded-pill px-3 py-2 mb-2">
                                                        @if($subscription->status == 'active')
                                                            <i class="fas fa-check-circle me-1"></i> Active
                                                        @elseif($subscription->status == 'pending_cancellation')
                                                            <i class="fas fa-clock me-1"></i> Cancelling
                                                        @else
                                                            {{ ucfirst($subscription->status) }}
                                                        @endif
                                                    </span>
                                                    <h3 class="fw-bold mb-1">{{ $subscription->package->title ?? 'Premium' }}</h3>
                                                    <p class="text-muted mb-2">
                                                        ${{ number_format($subscription->package->amount ?? 0, 2) }} 
                                                        / {{ $subscription->package->billing_cycle ?? 'month' }}
                                                    </p>
                                                    <div class="d-flex flex-wrap gap-3 small">
                                                        <span class="text-muted">
                                                            <i class="far fa-calendar-alt me-1"></i> 
                                                            Next billing: {{ $subscription?->expire_at ?? 'N/A' }}
                                                        </span>
                                                        <span class="text-muted">
                                                            <i class="far fa-clock me-1"></i> 
                                                            Started: {{ $subscription->created_at ? $subscription->created_at->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($subscription && $subscription->status == 'active')
                                    <div class="col-md-6">
                                        <div class="cancel-card card h-100 border-0 shadow-sm rounded-4 p-4 d-flex flex-column align-items-center justify-content-center text-center">
                                            <div class="mb-3 text-warning">
                                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem;"></i>
                                            </div>
                                            <p class="text-muted small">Cancel your subscription anytime. You'll retain access until the end of the current billing period.</p>
                                            <form action="{{ route('packages.unsubscribe') }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to cancel your subscription? You will lose access after the current billing period.');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="payment_id" value="{{ $subscription->payment_id }}">
                                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2 cancel-btn">
                                                    <i class="fas fa-times-circle me-2"></i>Cancel Subscription
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                        <i class="fas fa-crown text-muted" style="font-size: 36px;"></i>
                                    </div>
                                    <h5 class="fw-bold">No active subscription</h5>
                                    <p class="text-muted">You're on the free plan. Upgrade to unlock premium features.</p>
                                    <a href="{{ route('packages.subscribe') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                        <i class="fas fa-rocket me-2"></i>View Plans
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* ------------------------------
       SCOPED CUSTOM CSS (wrapper: .account-dashboard)
       --------------------------------- */
    .account-dashboard {
        /* base font & smoothness */
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* ---- Sidebar ---- */
    .account-dashboard .sticky-sidebar {
        position: sticky;
        top: 2rem;
        z-index: 1020;
        transition: transform 0.2s ease;
    }
    .account-dashboard .sticky-sidebar:hover {
        transform: translateY(-2px);
    }

    .account-dashboard .bg-gradient-primary {
        background: linear-gradient(145deg, #0d6efd, #084298);
    }

    .account-dashboard .avatar-circle {
        width: 56px;
        height: 56px;
        font-size: 28px;
        font-weight: 700;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        flex-shrink: 0;
    }

    .account-dashboard .nav-pills .nav-link {
        color: #495057;
        font-weight: 500;
        transition: all 0.25s ease;
        border-radius: 0.75rem !important;
    }
    .account-dashboard .nav-pills .nav-link:hover:not(.active) {
        background-color: rgba(13, 110, 253, 0.06);
        transform: translateX(6px);
    }
    .account-dashboard .nav-pills .nav-link.active {
        background: linear-gradient(145deg, #0d6efd, #0a58ca);
        color: #fff;
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.35);
    }
    .account-dashboard .nav-pills .nav-link i {
        width: 1.25rem;
        text-align: center;
    }

    /* ---- Content cards ---- */
    .account-dashboard .content-card {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .account-dashboard .section-header .icon-box {
        background: rgba(13, 110, 253, 0.08);
        transition: background 0.2s;
    }

    /* ---- Table ---- */
    .account-dashboard .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .account-dashboard .table tbody tr {
        transition: background-color 0.2s ease, transform 0.15s ease;
    }
    .account-dashboard .table tbody tr:hover {
        background-color: #f8faff;
        transform: scale(1.005);
    }

    /* Soft badge variants (scoped) */
    .account-dashboard .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.12);
    }
    .account-dashboard .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.15);
    }
    .account-dashboard .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.12);
    }
    .account-dashboard .badge {
        font-weight: 500;
        letter-spacing: 0.02em;
    }

    .account-dashboard .action-btn {
        border-width: 2px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .account-dashboard .action-btn:hover {
        transform: scale(1.05);
        background-color: #0d6efd;
        color: #fff;
    }

    /* ---- Subscription cards ---- */
    .account-dashboard .subscription-card,
    .account-dashboard .cancel-card {
        background: #f8faff;
        transition: all 0.25s ease;
    }
    .account-dashboard .subscription-card:hover,
    .account-dashboard .cancel-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.06) !important;
    }

    .account-dashboard .plan-icon {
        background: rgba(13, 110, 253, 0.08);
    }

    .account-dashboard .cancel-btn {
        border-width: 2px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .account-dashboard .cancel-btn:hover {
        transform: scale(1.04);
        background-color: #dc3545;
        color: #fff;
    }

    /* ---- Empty state ---- */
    .account-dashboard .empty-icon {
        width: 80px;
        height: 80px;
    }

    /* ---- Animations ---- */
    .account-dashboard .card-body {
        animation: fadeSlideUp 0.45s ease forwards;
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ---- Responsive tweaks ---- */
    @media (max-width: 991.98px) {
        .account-dashboard .sticky-sidebar {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush