@extends('layout.home')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            {{-- Processing Card --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Decorative top bar --}}
                <div class="bg-warning" style="height: 6px;"></div>

                <div class="card-body p-5 text-center">

                    {{-- Spinner Icon --}}
                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle" 
                         style="width: 90px; height: 90px;">
                        <i class="fas fa-spinner fa-spin text-warning" style="font-size: 42px;"></i>
                    </div>

                    {{-- Titles --}}
                    <h1 class="display-6 fw-bold mb-2">Processing Your Payment</h1>
                    <p class="lead text-muted">Please wait while we confirm your subscription.</p>

                    {{-- Divider --}}
                    <hr class="my-4">

                

                    {{-- Status Tip --}}
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <p class="text-muted small mb-0">
                            <i class="fas fa-clock me-1"></i> 
                            You will be redirected automatically once confirmed, or you can check manually below.
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <a href="{{ route('account.index') }}?tab=subscription" class="btn btn-primary btn-lg px-5 w-100 w-sm-auto">
                        <i class="fas fa-arrow-right me-2"></i> Check Status Now
                    </a>

                    {{-- Optional: Auto-redirect countdown --}}
                    <p class="text-muted small mt-3 mb-0">
                        <i class="fas fa-redo-alt me-1"></i> 
                        Redirecting automatically in <span id="countdown" class="fw-bold">8</span> seconds...
                    </p>

                </div>
            </div>

            {{-- Support Line --}}
            <p class="text-center text-muted small mt-4">
                <i class="fas fa-lock me-1"></i> Secure payment processed via Stripe. 
                Need help? <a href="#" class="text-decoration-none">Contact Support</a>
            </p>

        </div>
    </div>
</div>
@endsection

{{-- Optional: FontAwesome + Auto-Redirect Script --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Subtle pulse animation for the spinner container */
    .bg-warning.bg-opacity-10 {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }

    /* Countdown styling */
    #countdown {
        color: #0d6efd;
        min-width: 24px;
        display: inline-block;
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        // Auto-redirect countdown (optional)
        let seconds = 8;
        const countdownEl = document.getElementById('countdown');
        const redirectUrl = "{{ route('account.index') }}";

        const interval = setInterval(() => {
            seconds--;
            if (countdownEl) {
                countdownEl.textContent = seconds;
            }

            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = redirectUrl;
            }
        }, 1000);
    })();
</script>
@endpush