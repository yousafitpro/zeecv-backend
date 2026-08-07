@include('layout.includes.css')
@include('layout.includes.js')
<style>
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        .headerColumn {
            text-align: center;
        }
    }
    @yield('style')
</style>
@include('notes.loader')
@include('notes.SubscribeWaitingBox')

<script src="{{config('myconfig.Converge.script_url')}}"></script>
{{--    <script src="https://api.convergepay.com/hosted-payments/Checkout.js"></script>--}}

<script type="text/javascript" src="https://js.verygoodvault.com/vgs-collect/2.17.0/vgs-collect.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@if(!isset($header))

    <div class="row" style="padding: 0;  margin: 0; background-color: white; min-height: 70px; padding-top:10px;border-bottom: solid 1px lightgrey;">
        <div class="col-md-2 myFlex" style="padding: 0;  margin: 0" >
            <a href="https://zpayd.com/"><img  src="{{$business->headerLogo()}}" style="width: 50px; "></a>
        </div>
        <div class="col-md-2 headerColumn" style="padding: 0; margin: 0; border-left: solid 1px lightgrey; padding-left: 5px" >
            <span style="font-size: 20px">@yield('title1')</span>
        </div>
        <div class="col-md-8 headerColumn" style="padding: 0; margin: 0;border-left: solid 1px lightgrey; padding-left: 5px">
            <span style="font-size: 20px">@yield('title2')</span>
        </div>
    </div>
@endif
@include('scripts.security')
@yield('content')
