<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">

<link rel="apple-touch-icon" sizes="180x180" href="{{asset('app-icons/favicon_io/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('app-icons/favicon_io/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('app-icons/favicon_io/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('app-icons/favicon_io/site.webmanifest')}}">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
        <script src="{{asset('theme/js/core/jquery.3.2.1.min.js')}}"></script>
<script src="{{asset('theme/js/core/popper.min.js')}}"></script>
<script src="{{asset('theme/js/core/bootstrap.min.js')}}"></script>
    @yield('content')

</body>
</html>
