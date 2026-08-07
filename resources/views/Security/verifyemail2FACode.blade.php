@extends('auth.layout')
@section('content')
<br>
<br>
<br>
<br>
<div style="padding:10px">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form action="{{route('security.VerifyEmail2FACode')}}" method="post" id="myform" class="web-form">
                @csrf
            <div class="card" style="padding-top:20px;padding-bottom:20px">
                <div class="card-body">
                    <div class="row justify-content-center no-gutters">
                        <div class=" p-30 rounded10 b-2 b-dashed border-info">
                            <div class="content-top-agile p-10">
                               <div class="myFlex" style="width: 100%">
                                   <a href="#" class="aut-logo">
                                       <img src="{{asset('app-icons/logo.png')}}" style="width: 150px" alt="">
                                   </a>
                               </div>
                               <br>
                                <h2 class="text-primary" style="color: gray !important; text-align: center">2FA Verification  </h2>
                                <br>
                                <h4 class="text-black-50">Verification code has been Sent to Registered Mail</h4>
                            </div>
                            <div class="">

                                @include('includes.form-errors')


                                <div class="form-group">
                                    <div class="input-group mb-3">

                                        {{--                             <input   value="{{$o_otp}}">--}}
                                        <input  type="text" id="otpCode" class="form-control pl-15 bg-transparent plc-black" style="text-align: center"  placeholder="Code" name="code" autocomplete="false" required>
                                    </div>



                                </div>

                                <a class="btn btn-link" href="#" onclick="resendCode()">
                                    <h3>resend code</h3>
                                </a>
                                <a class="btn btn-link pull-right" href="{{url('logout')}}">
                                   <h3> logout</h3>
                                </a>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button id="btnVerify"  class="btn btn-info mt-10 btn-block" style="font-weight: bold;font-size:20px"">Verify</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $("#myform").on("submit",function(){
        $("#btnVerify").text("Verifying...")
    })
})
</script>
@stop
