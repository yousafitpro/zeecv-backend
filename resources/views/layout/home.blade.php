<!DOCTYPE html>
<html lang="en">
<head>
    @php
    $plus_jakarta_sans_path = asset('fonts/Plus_Jakarta_Sans/static/');
    @endphp
  <style>
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
  </style>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @yield('meta_tags')
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
  <title>ZeeCV · AI CV Builder</title>
  <!-- Font Awesome (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  @include('home.css.style')
@include("layout.includes.css")
<!-- Google tag (gtag.js) -->
@include('home.google-tag')
</head>
<body>
<div style="height: 100px"></div>
<div class="container">

@include('layout.includes.navbar')

@yield('content')



<!-- end container -->
</div>
</body>
</html>