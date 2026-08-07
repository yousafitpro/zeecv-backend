@extends('layout.single-page',['header'=>'0'])
@section('title1')

@endsection
@section('content')
    <style>
        .topLogin .textMember{
            display: none;
        }
        .toper-icon{
            margin-bottom: 15px;
        }
        .topperBackImageBlack{
            min-height: 800px;
            background-image: url('{{url('images/landing/top-background.png')}}');
            background-repeat: no-repeat;background-size:100% 100%
        }
        .topperBackImageMobile{
            height: 600px;
            background-image: url('{{url('images/landing/top-background-front.png')}}');
            background-repeat: no-repeat;background-size:100% 100%
        }
        .topheading1{
            margin-top: 50px
        }
        .appIcons{
            margin-top: 100px;
        }
        .topLogin{
            width: 100%;
            text-align: right;
            padding-right: 30px;
        }
        @media only screen and (max-width: 600px) {
            .topLogin .textMember{
                display: block;
            }
            .topLogin .btnMember{
                display: none;
            }
            .topperBackImageMobile{
                background-image: url('{{url('images/landing/top-background.png')}}');
                padding: 20px;
            }
            .toper-icon{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
                margin-right: 13px;
                margin-bottom: 0px;
            }
            .appIcons{
                margin-top: 70px;
            }
            .toper-title{
                text-align: center;
            }
            .topheading1{
                margin-top: 5px;
            }
            .paddingleft{
                padding-left: 25px;
            }
        }
    </style>
    <div style="background-color: white; width: 100%; overflow-x: hidden" >
        <div class="row" style="background-color: white; padding-top: 20px">
            <div class="topLogin" style="float: right">
                <a href="{{url('login')}}" class="textMember" >
                    <h4>Login</h4>
                </a>
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-1 toper-icon" >
                <a href="https://zpayd.com/"><img  src="{{$business->headerLogo()}}" style="width: 100px; "></a>
            </div>
            <div class="col-md-5" style="text-align: left">
                <br>
                <h3 class="toper-title">     Unlock New Possibilities.</h3>
            </div>
            <div class="col-md-5">
                <div class="topLogin">
                    <a href="{{url('login')}}" class="btnMember" >
                        <button class="btn btn-primary mt-3">MEMBERS LOGIN HERE</button>
                    </a>

                </div>
            </div>
        </div>

        <div class="topperBackImageBlack">
            <div style="position: relative; width: 100%;" class="topperBackImageMobile" >


                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-4 topheading1" style="color: white; ">
                        <h3>
                            The only Canadian Platform offering 150 000 billers with no sign up requirements

                        </h3>

                        <br>
                        <br>
                        <h2>Key Benefits:
                        </h2>
                        <h4>
                            1. PAY any bill with credit and get points faster (Taxes, Utilities, Student Tuition Fees, Anything)*.<br><br>
                            2. SHARE your monthly bills with anyone without account numbers to remember.<br><br>
                            3. LINK credit cards that you want as a back up in case of fund insufficiency.<br><br>
                            4. REQUEST Funds and Send international payments<br><br>
                            5. LINK your payments to Accounting Platform so year end tax returns are hassle free (no forgotten receipt cases)
                        </h4>
                        <br>

                        <a href="{{url('bill-pay')}}"> <button class="btn " style="background: rgb(250,126,39); color: white">ACCESS BILL PAY LINK</button></a>
                        <br>
                        <br>

                        <br>

                    </div>
                </div>



                <br>
                <br>
                <br>
            </div>
            <br>



            <div class="row appIcons">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="row">

                        <div class="col-md-12">
                            <h4 style="color: white; text-align: center">Or Download the App for Full Benefits</h4>
                        </div>

                    </div>
                    <div class="row" style="padding: 0;">
                        <div class="col-2"></div>
                        <div class="col-4" style="padding: 0;margin: 0">
                            <a href="https://apps.apple.com/pk/app/zpayd/id1631964273" target="_blank">
                                <img src="{{asset('images/landing/download on apple.png')}}" style="width: 100%; max-width: 180px">

                            </a>
                        </div>
                        <div class="col-4" style="padding: 0;margin: 0">
                            <a href="https://play.google.com/store/apps/details?id=com.zpayd.account" target="_blank">
                                <img src="{{asset('images/landing/download on play.png')}}" style="width: 100%; max-width: 180px">
                            </a>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 paddingleft" >
                            <small style="color: white">* Convenience fee applies, see Access Bill Pay Link for details</small>
                        </div>
                    </div>
                    <br>

                </div>
            </div>
        </div>

        <br>
        <br>


        @include('notes.payment-footer')
        <br>
        <br>
        <br>
    </div>
    <script>
        $(".topperBackImageMobile").css('top','250px')

        $(document).ready(function (){
            $(".topperBackImageMobile").animate({top: '0px'});
            // $(".topperBackImageMobile").animate({top: '250px'});
            //   $(".topperBackImageMobile").animate({left: '0px'});
            // setTimeout(function (){
            //     $(".topperBackImageMobile").animate({left: '0px'});
            // },1000)
        })
    </script>
@endsection
