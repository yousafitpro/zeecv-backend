@extends('auth.layout')
@section('content')
<br>
<br>
<br>
<br>
    <div class="row">
        <div class="col-md-4 offset-4">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center no-gutters">
                        <div class=" p-30 rounded10 b-2 b-dashed border-info">
                            <div class="content-top-agile p-10">
                               <div class="myFlex" style="width: 100%">
                                   <a href="#" class="aut-logo">
                                       <img src="{{asset('app-icons/logo.png')}}" style="width: 150px" alt="">
                                   </a>
                               </div>
                                <h2 class="text-primary" style="color: gray !important; text-align: center">Phone Verification  </h2>
                                <p class="text-black-50">Verification code has been Sent to Registered Mobile Number</p>
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
                                    resend code
                                </a>
                                <a class="btn btn-link pull-right" href="{{url('logout')}}">
                                    logout
                                </a>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button  class="btn btn-info mt-10 theme-bg" onclick="verifyOtp()">Verify</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function verifyOtp()
        {

            var otpn=$("#otpCode").val()
            if (otpn!='') {

                $.ajax({
                    url: "{{route('security.Verify2FACode')}}",
                    method: 'post',
                    data: {"_token": "{{ csrf_token() }}", otp: '{{$otp}}', 'code': otpn},
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.code == '1') {


                            window.location.href = '{{url('/dashboard')}}'
                        } else if (response.code == '0') {

                            alert(response.message)
                        } else if (response.code == '2') {
                            alert(response.message)
                            setTimeout(function () {
                                window.location.href = '{{url('/login')}}'
                            }, 2000)
                        }
                    }

                })
            }

        }

        function resendCode()
        {
            window.location.reload()
        }
    </script>
@stop
