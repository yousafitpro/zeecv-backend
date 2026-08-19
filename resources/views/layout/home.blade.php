<!DOCTYPE html>
<html lang="en">
<head>
    @php
    $plus_jakarta_sans_path = asset('fonts/Plus_Jakarta_Sans/static/');
    @endphp
    @include("layout.includes.css")

  <style>
    :root{
        --primary:#111827 !important
    }
    .job_container__jobs_type_tag{
        border:solid 2px var(--primary);
        font-weight: bold;
        padding: 5px 15px !important;
        border-radius: 10px;
    }
      /* Regular */
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url("{{ asset($plus_jakarta_sans_path.'PlusJakartaSans-Regular.ttf') }}") format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    /* Medium */
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url("{{ asset($plus_jakarta_sans_path.'PlusJakartaSans-Medium.ttf') }}") format('truetype');
        font-weight: 500;
        font-style: normal;
    }

    /* SemiBold */
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url("{{ asset($plus_jakarta_sans_path.'PlusJakartaSans-SemiBold.ttf') }}") format('truetype');
        font-weight: 600;
        font-style: normal;
    }

    /* Bold */
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url("{{ asset($plus_jakarta_sans_path.'PlusJakartaSans-Bold.ttf') }}") format('truetype');
        font-weight: 700;
        font-style: normal;
    }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    @media (max-width: 767px) {
    #main_content_container {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}
  </style>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @yield('meta_tags')
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
<link rel="manifest" href="{{asset('assets/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{asset('assets/favicon/ms-icon-144x144.png')}}">
<meta name="theme-color" content="#ffffff">



  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
  
  <!-- Font Awesome (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  @include('home.css.style')

<!-- Google tag (gtag.js) -->
@include('home.google-tag')
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5874917464902670"
     crossorigin="anonymous"></script>


</script>
</head>
<body>
<div style="height: 100px"></div>
<div class="container" id="main_content_container">

@include('layout.includes.navbar')

<div>
@yield('content')
</div>
@include('home.footer')

@include('layout.includes.js')
<!-- end container -->
</div>
</body>
</html>