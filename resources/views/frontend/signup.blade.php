@extends('auth.layout')
@section('content')
<style>
    .container-singup2{
        width: 500px !important;

    }
     @media (max-width: 991.98px) {
        .container-singup2{
        width:100% !important;
           min-height: 1000px;
    }
        .wrapper-login{
        display: block !important;
        padding: 0px !important;
        min-height: 1000px;
    }
      }
</style>

<script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
<body class="login">
<div class="wrapper wrapper-login">
    <form action="{{ route('signup.post') }}" method="post" class="web-form">
        @csrf
        @include('includes.form-errors')

        <div class="container container-login container-singup2 animated fadeIn">
            <div style="width: 100%" class="myFlex text-center mb-3">
                <img src="{{ asset('app-icons/logo.png') }}" style="width: 80px" alt="">
            </div>

            <div class="login-form">
                <h3 class="text-center mb-4">Sign Up</h3>

                <div class="form-group form-floating-label">
                    <input id="name" value="{{old('name')}}" name="name" type="text" class="form-control input-border-bottom" required>
                    <label for="name" class="placeholder">Full Name</label>
                </div>

                <div class="form-group form-floating-label">
                    <input id="email" value="{{old('email')}}" name="email" type="email" class="form-control input-border-bottom" required>
                    <label for="email" class="placeholder">Email Address</label>
                </div>

                <div class="form-group form-floating-label">
                    <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                    <label for="password" class="placeholder">Password</label>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="g-recaptcha" data-sitekey="{{config('myconfig.Recap.site_key')}}" data-callback="recaptcha_successfull_response" data-error-callback="data_error_callback" data-expired-callback="recaptcha_expired_callback"></div>

                    </div>
                </div>

                <div class="form-action mb-3">
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">Create Account</button>
                </div>

                <div class="login-account">
                    <span class="msg">Already have an account?</span>
                    <a href="{{ url('login') }}" class="link">Sign In</a>
                </div>
            </div>
             <br>
            <div class="row justify-content-center">
                <a href="{{ url('/') }}">Go To Home</a>
            </div>
        </div>
    </form>
</div>
</body>
<script>

    function recaptcha_successfull_response(data)
    {

    }
    function recaptcha_expired_callback()
    {



    }
    function reset_recaptcha()
    {
        grecaptcha.enterprise.reset();
    }
    function data_error_callback()
    {

    }
</script>
@stop
