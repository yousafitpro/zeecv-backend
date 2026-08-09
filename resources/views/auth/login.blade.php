@extends('auth.layout')
@section('content')
<style>
    .container-login2{
        width: 500px !important;

    }
      @media (max-width: 991.98px) {
        .container-login2{
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
    <body class="login">
    <div class="wrapper wrapper-login">
        <form action="{{url('login')}}" method="post" class="web-form">
            @csrf
            @include('includes.form-errors')
        <div class="container container-login container-login2 animated fadeIn">
            <div style="width: 100%" class="myFlex">
                <img src="{{asset('app-icons/logo.png')}}" style="width: 80px" alt="">
            </div>
<br><br>
{{--            <h3 class="text-center" style="margin-top: 6px">{{config('app.name')}}</h3>--}}
            <div class="login-form">
                <div class="form-group form-floating-label">
                    <input id="username" name="email" type="text" class="form-control input-border-bottom" required>
                    <label for="username" class="placeholder">Username</label>
                </div>
                <div class="form-group form-floating-label">
                    <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                    <label for="password" class="placeholder">Password</label>
                    <div class="show-password">
                        <i class="flaticon-interface"></i>
                    </div>
                </div>
                <div class="row form-sub m-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="rememberme">
                        <label class="custom-control-label" for="rememberme">Remember Me</label>
                    </div>

                    <a href="{{route('webAuth.resetEmail') }}" class="link float-right">Forget Password ?</a>
                </div>
                <div class="form-action mb-3">
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
                </div>
               <div class="login-account">
                   <span class="msg">Don't have an account yet ?</span>
                   <a href="{{route('signup')}}" class="link">Sign Up</a>
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

@stop
