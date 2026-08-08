@extends('layout.home')
@section('content')
<div style="width: 100%;min-height:700px">
   <div class="col-md-12">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 p-md-5">

                    <!-- Icon -->
                    <div class="mb-4">
                        <div class="verification-icon mx-auto">
                           <img src="{{asset('app-icons/logo.png')}}" style="width: 80px" alt="">
                        </div>
                    </div>

                    <!-- Heading -->
                    <h2 class="fw-bold mb-3">
                        Please Verify Your Account
                    </h2>

                    <p class="text-muted mb-4">
                        We've sent a verification email to your email address.
                        Please check your inbox and click the verification link
                        to activate your ZeeCV account.
                    </p>

                    <!-- Notice -->
                    <div class="alert alert-light border rounded-3 text-start mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle text-primary me-2 mt-1"></i>
                            <div>
                                <strong>Didn't receive the email?</strong>
                                <p class="mb-0 text-muted small">
                                    Check your spam or junk folder. You can also
                                    request a new verification email below.
                                </p>
                            </div>
                        </div>
                    </div>

               

                    <!-- Back to login -->
                    <div class="mt-4">
                        <a href="{{ route('login') }}"
                           class="text-decoration-none text-muted">
                            <i class="bi bi-arrow-left me-1"></i>
                            Back to Login
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .verification-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #eef4ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
    }

    .card {
        background: #fff;
    }

    .btn-primary {
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
    }
</style> 
</div>
@endsection