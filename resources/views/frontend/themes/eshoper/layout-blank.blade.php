<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('app-icons/favicon_io/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('app-icons/favicon_io/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('app-icons/favicon_io/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('app-icons/favicon_io/site.webmanifest')}}">
    <title>@yield('title','Blank')</title>
    <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
            <script src="{{asset('theme/js/core/jquery.3.2.1.min.js')}}"></script>
<script src="{{asset('theme/js/core/popper.min.js')}}"></script>
<script src="{{asset('theme/js/core/bootstrap.min.js')}}"></script>
<style>
                :root{
        --primary:#28a5ab !important;
        --blue:#28a5ab !important;
        --link-color:rgb(0, 120, 212) !important;
    }
</style>
</head>
<body>
@include('loaders.index')
@yield('content')
</body>
</html>
