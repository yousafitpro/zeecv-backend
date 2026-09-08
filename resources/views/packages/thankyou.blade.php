@extends('layout.home')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            {{-- Success Card --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Decorative top bar --}}
                <div class="bg-success" style="height: 8px;"></div>

                <div class="card-body p-5 text-center">

                    {{-- Success Icon --}}
                    {{-- <div class="mx-auto mb-4 d-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle" 
                         style="width: 90px; height: 90px;">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                    </div> --}}

                    {{-- Titles --}}
                    <h1 class="display-5 fw-bold mb-2">Payment Successful! 🎉</h1>
                    <p class="lead text-muted">Thank you for your purchase. Your subscription is now active.</p>

                    {{-- Divider --}}
                 

                

                    {{-- Next Steps / Actions --}}
                    <div class="mt-4 pt-3 border-top">
                        {{-- <p class="text-muted small mb-3">
                            <i class="fas fa-envelope me-1"></i> 
                            A confirmation email has been sent to <strong>{{ auth()->user()->email ?? 'your email' }}</strong>.
                        </p> --}}

                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('home.jobs') }}" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-arrow-right me-2"></i> Brows Jobs
                            </a>
                            <a href="{{ route('account.index') }}?tab=invoices" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-receipt me-2"></i> View Invoices
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Trust / Support Line --}}
            <p class="text-center text-muted small mt-4">
                <i class="fas fa-lock me-1"></i> Secure payment processed via Stripe. 
                Need help? <a href="{{ route('home.contact') }}" class="text-decoration-none">Contact Support</a>
            </p>

        </div>
    </div>
</div>
@endsection

{{-- Optional: Add FontAwesome for icons (if not already in your layout) --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Subtle pulse animation for the checkmark */
    .bg-success.bg-opacity-10 {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endpush