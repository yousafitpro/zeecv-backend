@extends('layout.home')

@section('meta_tags')
<meta name="description" content="Sign in to your ZeeCV account. Access your AI-powered resume builder and apply to thousands of jobs.">
<title>Sign In | ZeeCV - AI Resume Builder & Job Board</title>
@endsection

@section('content')
<style>
    /* =============================================
       ROOT VARIABLES
    ============================================= */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #dbeafe;
        --primary-gradient: linear-gradient(135deg, #2563eb, #7c3aed);
        --bg-dark: #0f172a;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --border-light: #e2e8f0;
        --shadow-card: 0 20px 60px rgba(15, 23, 42, 0.12);
        --radius-card: 24px;
        --radius-input: 12px;
        --radius-btn: 40px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* =============================================
       PAGE WRAPPER
    ============================================= */
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* =============================================
       MAIN CARD
    ============================================= */
    .login-card {
        display: flex;
        max-width: 1100px;
        width: 100%;
        background: #ffffff;
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        min-height: 560px;
    }

    /* =============================================
       LEFT PANEL - BRANDING
    ============================================= */
    .login-brand {
        flex: 0 0 42%;
        background: var(--bg-dark);
        padding: 48px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .login-brand::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-brand .brand-header {
        position: relative;
        z-index: 1;
    }

    .login-brand .brand-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
    }

    .login-brand .brand-logo img {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px;
    }

    .login-brand .brand-logo span {
        color: #ffffff;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .login-brand .brand-logo span.highlight {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .login-brand .brand-tagline {
        position: relative;
        z-index: 1;
    }

    .login-brand .brand-tagline h2 {
        color: #ffffff;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .login-brand .brand-tagline p {
        color: #94a3b8;
        font-size: 15px;
        line-height: 1.7;
        max-width: 320px;
    }

    .login-brand .brand-features {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: 10px;
    }

    .login-brand .brand-features .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #e2e8f0;
        font-size: 14px;
    }

    .login-brand .brand-features .feature-item i {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.2);
        border-radius: 8px;
        color: #60a5fa;
        font-size: 13px;
        flex-shrink: 0;
    }

    .login-brand .brand-footer {
        position: relative;
        z-index: 1;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .login-brand .brand-footer .quote {
        color: #94a3b8;
        font-size: 13px;
        line-height: 1.6;
        font-style: italic;
    }

    .login-brand .brand-footer .quote strong {
        color: #ffffff;
        font-style: normal;
    }

    /* =============================================
       RIGHT PANEL - FORM
    ============================================= */
    .login-form-panel {
        flex: 1;
        padding: 48px 48px 40px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .login-form-panel .form-header {
        margin-bottom: 28px;
    }

    .login-form-panel .form-header h3 {
        font-size: 26px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .login-form-panel .form-header p {
        color: var(--text-muted);
        font-size: 14px;
        margin: 0;
    }

    .login-form-panel .form-header p a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .login-form-panel .form-header p a:hover {
        text-decoration: underline;
    }

    /* =============================================
       FORM ELEMENTS
    ============================================= */
    .login-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex: 1;
    }

    .form-group {
        position: relative;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }

    .form-group .input-icon {
        position: absolute;
        left: 30px;
        top: 45%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
        pointer-events: none;
        transition: var(--transition);
        z-index: 2;
    }

    .form-group .form-control {
        width: 100%;
        padding: 14px 16px 14px 44px;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-input);
        font-size: 14px;
        color: var(--text-dark);
        background: #fafbfc;
        transition: var(--transition);
        outline: none;
        font-family: inherit;
    }

    .form-group .form-control:focus {
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
    }

    .form-group .form-control::placeholder {
        color: #94a3b8;
        font-size: 14px;
    }

    .form-group .form-control.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-group .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
        display: none;
    }

    .form-group .error-message.show {
        display: block;
    }

    /* Password toggle */
    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 16px;
        padding: 4px;
        transition: var(--transition);
        z-index: 2;
    }

    .password-toggle:hover {
        color: var(--text-dark);
    }

    /* =============================================
       FORM OPTIONS
    ============================================= */
    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 2px 0 4px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .form-options .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 13px;
        color: var(--text-muted);
    }

    .form-options .custom-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
        cursor: pointer;
        border-radius: 4px;
        border: 2px solid var(--border-light);
    }

    .form-options .forgot-link {
        color: var(--primary);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
    }

    .form-options .forgot-link:hover {
        text-decoration: underline;
        color: var(--primary-dark);
    }

    /* =============================================
       SUBMIT BUTTON
    ============================================= */
    .btn-submit {
        width: 100%;
        padding: 14px 24px;
        background: var(--primary-gradient);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-btn);
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 4px;
        font-family: inherit;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.35);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-submit .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    .btn-submit.loading .spinner {
        display: inline-block;
    }

    .btn-submit.loading .btn-text {
        display: none;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* =============================================
       DIVIDER
    ============================================= */
    .divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 6px 0 4px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border-light);
    }

    .divider span {
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    /* =============================================
       SOCIAL BUTTONS
    ============================================= */
    .social-login {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-google {
        width: 100%;
        padding: 12px;
        background: #ffffff;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-input);
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-family: inherit;
    }

    .btn-google:hover {
        border-color: var(--primary);
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
    }

    .btn-google img {
        width: 20px;
        height: 20px;
    }

    /* Google Sign-In override */
    #g_id_onload,
    .g_id_signin {
        /* width: 100% !important; */
    }

    .g_id_signin > div {
        /* width: 100% !important; */
    }

    /* =============================================
       SIGN UP LINK
    ============================================= */
    .signup-link {
        text-align: center;
        margin-top: 4px;
    }

    .signup-link p {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0;
    }

    .signup-link p a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .signup-link p a:hover {
        text-decoration: underline;
    }

    /* =============================================
       ALERT / ERROR MESSAGES
    ============================================= */
    .alert {
        padding: 12px 16px;
        border-radius: var(--radius-input);
        font-size: 13px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 4px;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
    }

    .alert-danger i {
        margin-top: 2px;
        flex-shrink: 0;
    }

    .alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .alert ul li {
        margin-bottom: 2px;
    }

    /* =============================================
       RESPONSIVE
    ============================================= */
    @media (max-width: 991.98px) {
        .login-card {
            flex-direction: column;
            max-width: 480px;
            border-radius: 20px;
        }

        .login-brand {
            flex: 1;
            padding: 32px 28px;
            min-height: 200px;
        }

        .login-brand .brand-tagline h2 {
            font-size: 22px;
        }

        .login-brand .brand-features .feature-item {
            font-size: 13px;
        }

        .login-brand .brand-footer {
            display: none;
        }

        .login-form-panel {
            padding: 32px 24px 28px;
        }

        .login-form-panel .form-header h3 {
            font-size: 22px;
        }

        .login-brand .brand-logo span {
            font-size: 20px;
        }
    }

    @media (max-width: 480px) {
        .login-page {
            padding: 0px;
        }

        .login-brand {
            padding: 24px 20px;
            min-height: 160px;
        }

        .login-brand .brand-tagline h2 {
            font-size: 18px;
        }

        .login-brand .brand-features .feature-item {
            font-size: 12px;
        }

        .login-brand .brand-features .feature-item i {
            width: 24px;
            height: 24px;
            font-size: 11px;
        }

        .login-form-panel {
            padding: 24px 16px 20px;
        }

        .form-group .form-control {
            padding: 12px 14px 12px 38px;
            font-size: 13px;
        }

        .btn-submit {
            font-size: 14px;
            padding: 12px 20px;
        }

        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
        .login-card{
            border-radius: 0px;
        }
    }

    /* =============================================
       UTILITY
    ============================================= */
    .text-center { text-align: center; }
    .mt-1 { margin-top: 4px; }
    .mt-2 { margin-top: 8px; }
    .mb-1 { margin-bottom: 4px; }
    .gap-1 { gap: 4px; }


    /* Google Sign-In Wrapper */
.g_id_signin-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.g_id_signin-wrapper > div {
    /* width: 100% !important; */
    max-width: 400px;
}

.g_id_signin iframe {
    width: 100% !important;
    min-width: 100% !important;
}
</style>

<div class="login-page">
    <div class="login-card">

        <!-- =========================================
             LEFT PANEL - BRANDING
        ========================================== -->
        <div class="login-brand">
            <div class="brand-header">
                <div class="brand-logo">
                    <img src="{{ asset('app-icons/logo.png') }}" alt="ZeeCV">
                    <span>Zee<span class="highlight">CV</span></span>
                </div>
                <div class="brand-tagline">
                    <h2>Welcome back!</h2>
                    <p>Sign in to access your AI-powered resume builder and find your dream job.</p>
                </div>
            </div>

            <div class="brand-features">
                <div class="feature-item">
                    <i class="fas fa-robot"></i>
                    <span>AI-powered resume builder</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-briefcase"></i>
                    <span>8,000+ active job listings</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>96% interview success rate</span>
                </div>
            </div>

            <div class="brand-footer">
                <div class="quote">
                    "ZeeCV helped me land my dream job in just 2 weeks. The AI suggestions were spot on!"
                    <br><strong>— Sarah Mitchell, Product Manager</strong>
                </div>
            </div>
        </div>

        <!-- =========================================
             RIGHT PANEL - FORM
        ========================================== -->
        <div class="login-form-panel">

            <div class="form-header">
                <h3>Sign in to your account</h3>
                <p>Don't have an account? <a href="{{ route('signup') }}">Create one for free</a></p>
            </div>

            <form action="{{ url('login') }}" method="post" class="login-form" id="loginForm" novalidate>
                @csrf

                <!-- Form Errors -->
                @include('includes.form-errors')

                <!-- Email / Username -->
                <div class="form-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control"
                        placeholder="Email Address"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                    >
                    <div class="error-message" id="emailError">Please enter a valid email address</div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="error-message" id="passwordError">Please enter your password</div>
                </div>

                <!-- Form Options -->
                <div class="form-options">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="rememberme">
                        <span>Remember Me</span>
                    </label>
                    <a href="{{ route('webAuth.resetEmail') }}" class="forgot-link">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <i class="fas fa-arrow-right"></i> Sign In
                    </span>
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span>or continue with</span>
                </div>

                <!-- Google Sign-In -->
                <div class="social-login">
                    <div id="g_id_onload"
                        data-client_id="{{ config('services.google.client_id') }}"
                        data-callback="handleGoogleResponse">
                    </div>
                    <div class="g_id_signin-wrapper">
                        <div class="g_id_signin"
                            data-type="standard"
                            data-size="large"
                            data-theme="outline"
                            data-text="signin_with"
                            data-shape="rectangular"
                            data-logo_alignment="left"
                            data-width="100%">
                        </div>
                    </div>
                </div>

                <!-- Sign Up Link (mobile friendly) -->
                <div class="signup-link">
                    <p>New to ZeeCV? <a href="{{ route('signup') }}">Create an account</a></p>
                </div>

            </form>
        </div>

    </div>
</div>

<!-- =============================================
     SCRIPTS
============================================= -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
    (function() {
        'use strict';

        // =============================================
        // PASSWORD TOGGLE
        // =============================================
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        // =============================================
        // FORM VALIDATION
        // =============================================
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        if (form) {
            form.addEventListener('submit', function(e) {
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                let isValid = true;

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
                    email.classList.add('error');
                    document.getElementById('emailError').classList.add('show');
                    isValid = false;
                } else {
                    email.classList.remove('error');
                    document.getElementById('emailError').classList.remove('show');
                }

                // Password validation
                if (!password.value || password.value.length < 1) {
                    password.classList.add('error');
                    document.getElementById('passwordError').classList.add('show');
                    isValid = false;
                } else {
                    password.classList.remove('error');
                    document.getElementById('passwordError').classList.remove('show');
                }

                if (!isValid) {
                    e.preventDefault();
                    submitBtn.classList.remove('loading');
                } else {
                    submitBtn.classList.add('loading');
                }
            });
        }

        // =============================================
        // CLEAR ERRORS ON INPUT
        // =============================================
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorId = this.id + 'Error';
                const errorEl = document.getElementById(errorId);
                if (errorEl) {
                    errorEl.classList.remove('show');
                }
            });
        });

        // =============================================
        // GOOGLE LOGIN
        // =============================================
        window.handleGoogleResponse = function(response) {
            fetch("{{ route('auth.google') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    credential: response.credential
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Google login failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Google login error:', error);
                alert('Google login failed. Please try again.');
            });
        };

    })();
</script>

@stop