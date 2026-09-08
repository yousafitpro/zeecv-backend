@extends('layout.home')

@section('content')
@php
    $activeTab=request('tab','invoices');
@endphp
<div class="container py-4">
    <div class="row g-4">
        {{-- LEFT SIDEBAR --}}
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3">
                    {{-- User info (optional) --}}
                    <div class="text-center mb-3 pb-2 border-bottom">
                        <div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                             style="width: 64px; height: 64px; font-size: 28px; font-weight: 600;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <h6 class="mb-0">{{ auth()->user()->name ?? 'User' }}</h6>
                        <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                    </div>

                    {{-- Navigation Tabs --}}
                    <nav class="nav nav-pills flex-column gap-1">
                        <a href="{{ route('account.index') }}?tab=invoices" 
                           class="nav-link d-flex align-items-center gap-2 {{ $activeTab == 'invoices' ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i> Invoices
                        </a>
                        <a href="{{ route('account.index') }}?tab=subscription" 
                           class="nav-link d-flex align-items-center gap-2 {{ $activeTab == 'subscription' ? 'active' : '' }}">
                            <i class="fas fa-crown"></i> Subscription
                        </a>
                    </nav>

                  
                </div>
            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div class="col-lg-9 col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    @if($activeTab == 'invoices')
                        {{-- INVOICES TAB --}}
                        <h4 class="fw-bold mb-4"><i class="fas fa-file-invoice text-primary me-2"></i>Your Invoices</h4>

                        @if(empty($invoices))
                            <div class="text-center py-5">
                                <i class="fas fa-receipt text-muted" style="font-size: 48px;"></i>
                                <p class="mt-3 text-muted">You don't have any invoices yet.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
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
                                                <td>
                                                    <strong>#{{ unique_encrypt($invoice->id) }}</strong>
                                                </td>
                                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                                <td>${{  number_format($invoice->amount, 2)  }}</td>
                                                <td>
                                                    @if($invoice->status == 'completed')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($invoice->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ ucfirst($invoice->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                              
                                                    <a target="_blank" href="{{ route('account.invoice.pdf', unique_encrypt($invoice->id)) }}" class="btn btn-sm btn-primary" title="Download">
                                                        <i class="fas fa-download"></i>
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
                        <h4 class="fw-bold mb-4"><i class="fas fa-crown text-primary me-2"></i>Your Subscription</h4>

                        @if($subscription && !$is_expired)
                            <div class="row g-4">
                                {{-- Subscription details --}}
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 h-100">
                                        <h6 class="text-muted small">Current Plan</h6>
                                        <h3 class="fw-bold">{{ $subscription->package->title ?? 'Premium' }}</h3>
                                        <p class="mb-1">
                                            <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                                            @if($subscription->status == 'pending_cancellation')
                                                <span class="badge bg-warning text-dark">Cancels at period end</span>
                                            @endif
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="far fa-calendar-alt me-1"></i> 
                                        Next billing: {{ $subscription?->expire_at ?? 'N/A' }}
                                        </p>
                                        <p class="text-muted">
                                           
                                            ${{ number_format($subscription->package->amount ?? 0, 2) }} / {{ $subscription->package->billing_cycle ?? 'month' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Cancel button --}}
                                @if($subscription && $subscription->status=='active')
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 h-100 d-flex flex-column justify-content-center align-items-center">
                                       
                                            <p class="text-muted text-center">Cancel your subscription anytime. You will continue to have access until the end of the current billing period.</p>
                                            <form action="{{ route('packages.unsubscribe') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription? You will lose access after the current billing period.');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="payment_id" value="{{ $subscription->payment_id }}">
                                                <button type="submit" class="btn btn-outline-danger btn-lg px-4">
                                                    <i class="fas fa-times-circle me-2"></i>Cancel Subscription
                                                </button>
                                            </form>
                                        
                                        
                                    </div>
                                </div>
                                @endif
                            </div>

                            {{-- Subscription history (optional) --}}
                            <div class="mt-4">
                                <p class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Started on {{ $subscription->created_at ? $subscription->created_at->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>

                        @else
                            {{-- No subscription --}}
                            <div class="text-center py-5">
                                <i class="fas fa-crown text-muted" style="font-size: 48px;"></i>
                                <h5 class="mt-3">No active subscription</h5>
                                <p class="text-muted">You are currently on the free plan. Upgrade to access premium features.</p>
                                <a href="{{ route('packages.subscribe') }}" class="btn btn-primary">
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
@endsection

{{-- Optional: Add FontAwesome if not already in your layout --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }
    .nav-pills .nav-link:not(.active):hover {
        background-color: #f0f0f0;
    }
    .avatar {
        background-color: #0d6efd;
    }
    .table > :not(caption) > * > * {
        vertical-align: middle;
    }
    /* optional small fixes */
    .btn-outline-danger {
        transition: all 0.2s;
    }
</style>
@endpush