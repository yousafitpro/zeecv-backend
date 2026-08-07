@extends('auth.layout')

@section('content')
<body class="landing-page">
    <div class="container py-5">

        {{-- Company Branding --}}
        <div class="text-center mb-4">
            <img src="{{ asset('app-icons/logo.png') }}" alt="Company Logo" style="width: 100px;">
            <h2 class="mt-3">{{ config('app.name') }}</h2>
            <p class="text-muted">Empowering Merchants & Marketers through seamless affiliate collaboration.</p>
        </div>

        {{-- Features Section --}}
        <div class="row text-center mb-5">
            <div class="col-md-6">
                <div class="card shadow p-4 h-100">
                    <h4>For Merchants</h4>
                    <p>Register as a merchant to list your products and grow your reach through affiliate marketers.</p>
                    <a href="{{ url('signup?type=merchant') }}" class="btn btn-outline-primary mt-2">Join as Merchant</a>
                </div>
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card shadow p-4 h-100">
                    <h4>For Marketers</h4>
                    <p>Sign up as a marketer to create and share affiliate links for merchant products and earn commissions.</p>
                    <a href="{{ url('signup?type=marketer') }}" class="btn btn-outline-success mt-2">Join as Marketer</a>
                </div>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="text-center">
            <a href="{{ url('login') }}" class="btn btn-primary btn-lg px-5">Login</a>
        </div>

    </div>
</body>
@stop
