@extends('emails.master')

@section('content')

<style>
    .zeecv-email-wrapper {
        width: 100%;
        margin: 0;
        padding: 45px 15px;
        background-color: #eef2ff;
        font-family: Arial, Helvetica, sans-serif;
        color: #172033;
        box-sizing: border-box;
    }

    .zeecv-email-wrapper *,
    .zeecv-email-wrapper *:before,
    .zeecv-email-wrapper *:after {
        box-sizing: border-box;
    }

    .zeecv-email-card {
        width: 100%;
        max-width: 580px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(79, 70, 229, 0.14);
    }

    /* =========================
       COLORFUL HEADER
    ========================== */

    .zeecv-email-header {
        padding: 38px 30px 42px;
        text-align: center;
        background-color: #4f46e5;
        background: linear-gradient(
            135deg,
            #4f46e5 0%,
            #6366f1 45%,
            #3b82f6 100%
        );
        color: #ffffff;
    }

    .zeecv-brand {
        margin: 0;
        font-size: 30px;
        line-height: 1;
        font-weight: 800;
        letter-spacing: -1.2px;
        color: #ffffff;
    }

    .zeecv-brand-accent {
        color: #c4b5fd;
    }

    .zeecv-header-subtitle {
        margin: 12px 0 0;
        color: #e0e7ff;
        font-size: 13px;
        line-height: 1.5;
        letter-spacing: 0.3px;
    }

    /* =========================
       CONTENT
    ========================== */

    .zeecv-email-content {
        padding: 45px 45px 42px;
        text-align: center;
        background-color: #ffffff;
    }

    .zeecv-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 25px;
        border-radius: 50%;
        background-color: #eef2ff;
        border: 5px solid #f5f3ff;
        color: #4f46e5;
        font-size: 27px;
        line-height: 54px;
        font-weight: 700;
    }

    .zeecv-title {
        margin: 0 0 15px;
        color: #111827;
        font-size: 27px;
        line-height: 1.3;
        font-weight: 750;
        letter-spacing: -0.5px;
    }

    .zeecv-greeting {
        margin: 0 0 18px;
        color: #374151;
        font-size: 16px;
        line-height: 1.6;
    }

    .zeecv-description {
        max-width: 455px;
        margin: 0 auto;
        color: #6b7280;
        font-size: 15px;
        line-height: 1.75;
    }

    /* =========================
       COLORFUL BUTTON
    ========================== */

    .zeecv-button-wrapper {
        margin: 34px 0 22px;
    }

    .zeecv-button {
        display: inline-block;
        padding: 16px 38px;
        border-radius: 9px;

        background-color: #4f46e5;
        background: linear-gradient(
            135deg,
            #4f46e5 0%,
            #6366f1 50%,
            #3b82f6 100%
        );

        color: #ffffff !important;
        text-decoration: none !important;

        font-size: 15px;
        line-height: 1;
        font-weight: 700;
        letter-spacing: 0.2px;

        box-shadow:
            0 8px 18px rgba(79, 70, 229, 0.25),
            0 3px 6px rgba(59, 130, 246, 0.12);
    }

    .zeecv-expiry {
        margin: 0;
        color: #9ca3af;
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================
       FALLBACK LINK
    ========================== */

    .zeecv-divider {
        height: 1px;
        margin: 32px 0 25px;
        background-color: #edf0f4;
        border: 0;
    }

    .zeecv-help-text {
        margin: 0 0 10px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.6;
    }

    .zeecv-link-box {
        padding: 12px 14px;
        background-color: #f8faff;
        border: 1px solid #e0e7ff;
        border-radius: 8px;
        text-align: left;
    }

    .zeecv-link {
        color: #4f46e5 !important;
        text-decoration: none !important;
        font-size: 12px;
        line-height: 1.5;
        word-break: break-all;
    }

    /* =========================
       COLORFUL FOOTER
    ========================== */

    .zeecv-email-footer {
        padding: 30px 30px;
        text-align: center;

        background-color: #312e81;
        background: linear-gradient(
            135deg,
            #312e81 0%,
            #3730a3 50%,
            #1e40af 100%
        );
    }

    .zeecv-footer-message {
        margin: 0;
        color: #e0e7ff;
        font-size: 12px;
        line-height: 1.7;
    }

    .zeecv-footer-brand {
        margin-top: 10px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
    }

    .zeecv-footer-copy {
        margin: 6px 0 0;
        color: #a5b4fc;
        font-size: 11px;
    }

    /* =========================
       MOBILE
    ========================== */

    @media only screen and (max-width: 600px) {

        .zeecv-email-wrapper {
            padding: 20px 10px;
        }

        .zeecv-email-header {
            padding: 32px 20px 36px;
        }

        .zeecv-email-content {
            padding: 35px 22px 32px;
        }

        .zeecv-title {
            font-size: 23px;
        }

        .zeecv-description {
            font-size: 14px;
        }

        .zeecv-button {
            display: block;
            width: 100%;
            padding: 17px 20px;
        }

        .zeecv-email-footer {
            padding: 25px 20px;
        }
    }
</style>

<div class="zeecv-email-wrapper">


<div class="zeecv-email-card">

    <!-- =========================
         HEADER
    ========================== -->

    <div class="zeecv-email-header">

        <div class="zeecv-brand">
            Zee<span class="zeecv-brand-accent">CV</span>
        </div>

        <p class="zeecv-header-subtitle">
            Build a resume that gets noticed.
        </p>

    </div>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <div class="zeecv-email-content">

        <div class="zeecv-icon">
            ✓
        </div>

        <h1 class="zeecv-title">
            Verify your email address
        </h1>

        <p class="zeecv-greeting">
            Hi <strong>{{ $user->name }}</strong>,
        </p>

        <p class="zeecv-description">
            Welcome to {{ config('app.name2', 'ZeeCV') }}.
            You're just one step away from activating your account
            and starting your journey toward a better professional resume.
        </p>


        <!-- BUTTON -->

        <div class="zeecv-button-wrapper">

            <a
                href="{{ route('webAuth.verifyEmailAddressView', $user->token) }}"
                class="zeecv-button"
            >
                Verify My Email
            </a>

        </div>


        <p class="zeecv-expiry">
            This verification link will expire in
            <strong>24 hours</strong>.
        </p>


        <!-- FALLBACK LINK -->

        <div class="zeecv-divider"></div>

        <p class="zeecv-help-text">
            Having trouble with the button?
            Copy and paste this link into your browser.
        </p>

        <div class="zeecv-link-box">

            <a
                href="{{ route('webAuth.verifyEmailAddressView', $user->token) }}"
                class="zeecv-link"
            >
                {{ route('webAuth.verifyEmailAddressView', $user->token) }}
            </a>

        </div>

    </div>


    <!-- =========================
         FOOTER
    ========================== -->

    <div class="zeecv-email-footer">

        <p class="zeecv-footer-message">
            If you did not create a {{ config('app.name2', 'ZeeCV') }}
            account, you can safely ignore this email.
        </p>

        <div class="zeecv-footer-brand">
            ZeeCV.com
        </div>

        <p class="zeecv-footer-copy">
            &copy; {{ date('Y') }} ZeeCV. All rights reserved.
        </p>

    </div>

</div>


</div>

@stop
