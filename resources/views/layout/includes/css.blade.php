
 <link rel="canonical"
          href="{{ url()->current() }}">
<link rel="apple-touch-icon" sizes="57x57" href={{asset('assets/favicon/apple-icon-57x57.png')}}">
<link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/favicon/apple-icon-60x60.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/favicon/apple-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/favicon/apple-icon-76x76.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/favicon/apple-icon-114x114.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/favicon/apple-icon-120x120.png')}}">
<link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/favicon/apple-icon-144x144.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/favicon/apple-icon-152x152.png')}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-icon-180x180.png')}}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{asset('assets/favicon/android-icon-192x192.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/favicon/favicon-96x96.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('assets/favicon/manifest.json')}}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{asset('assets/favicon/ms-icon-144x144.png')}}">
<meta name="theme-color" content="#ffffff">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/css/azzara.min.css')}}">
<link rel="stylesheet" href="{{asset('css/mystyle.css')}}">
<link rel="stylesheet" href="{{asset('v4-css/ui-v4.css')}}">





<script src="{{asset('theme/js/plugin/webfont/webfont.min.js')}}"></script>
<script src="{{asset('qrcodejs/qrcode.js')}}"></script>
<script src="{{asset('html2canvas/html2canvas.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://maps.googleapis.com/maps/api/js?key={{config('myconfig.google.key')}}" async defer></script>
<!-- jQuery 3 -->
<script src="{{asset('/')}}assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js"></script>

{{--<script src="https://maps.googleapis.com/maps/api/js?key={{config('myconfig.google.key')}}" async defer></script>--}}
<script>
    WebFont.load({
        google: {"families":["Open+Sans:300,400,600,700"]},
        custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ["{{asset('theme/css/fonts.css')}}"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<!-- CSS Just for demo purpose, don't include it in your project -->
<link  href="{{asset('theme/css/demo.css')}}">
@include('notes.loader')
@include('notes.SubscribeWaitingBox')
<link rel="stylesheet" href="{{asset('line-control-master/editor.css')}}">
