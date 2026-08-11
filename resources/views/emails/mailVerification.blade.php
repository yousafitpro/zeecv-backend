@extends('emails.master')

@section('content')
<style>
    /* Inline styles are best for email, but some clients support style blocks */
    .email-container {
        max-width: 600px;
        margin: 0 auto;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #334155;
        line-height: 1.6;
    }
    .header {
        padding: 30px 0;
        text-align: center;
    }
    .card {
        background: #ffffff;
        padding: 40px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        display: inline-block;
        padding: 14px 30px;
        background-color: #2563eb; /* ZeeCV Brand Blue */
        color: #ffffff !important;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        margin: 25px 0;
    }
    .footer {
        padding: 20px;
        text-align: center;
        font-size: 12px;
        color: #94a3b8;
    }
    .link-alt {
        word-break: break-all;
        font-size: 13px;
        color: #64748b;
    }
</style>

<div class="email-container">
    <!-- Header/Logo Area -->
    <div class="header">
        <h2 style="margin:0; color: #1e293b;">Zee<span style="color: #2563eb;">CV</span></h2>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <h3 style="margin-top: 0; color: #1e293b; font-size: 20px;">Hi {{ $user->name }},</h3>
        
        <p>Welcome to <strong>{{ config('app.name2', 'ZeeCV') }}</strong>! We're excited to help you build your professional future.</p>
        
        <p>To get started and access all our premium CV features, please verify your email address by clicking the button below:</p>

        <div style="text-align: center;">
            <a href="{{ route('webAuth.verifyEmailAddressView', $user->token) }}" class="btn-primary">
                Verify Account
            </a>
        </div>

        <p style="font-size: 14px; color: #64748b;">
            <strong>Note:</strong> This verification link will expire in 24 hours for your security.
        </p>

        <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">

        <p style="font-size: 12px; color: #94a3b8;">
            If the button above doesn't work, copy and paste this URL into your browser: <br>
            <span class="link-alt">{{ route('webAuth.verifyEmailAddressView', $user->token) }}</span>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} ZeeCV. All rights reserved.</p>
        <p>If you did not create an account, no further action is required.</p>
    </div>
</div>
@stop