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




  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
  
  <!-- Font Awesome (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  @include('home.css.style')

<!-- Google tag (gtag.js) -->
@include('home.google-tag')
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5874917464902670"
     crossorigin="anonymous"></script>


</script>
<!-- Datatables -->
<script src="{{asset('theme/js/plugin/datatables/datatables.min.js')}}"></script>

</head>
<body>
@if(request('is_app','yes')!='no')
<div style="height: 100px"></div>
@endif
<div class="container" id="main_content_container">

@if(request('is_app','yes')!='no')
@include('layout.includes.navbar')
@endif
<div>
@yield('content')
</div>
@if(session('is_app','no')=='no')
@include('home.footer')
@endif

@include('layout.includes.js')
<!-- end container -->
</div>
<script>
    $(document).ready(function(){
               $('.myTable8').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
    })
    $(document).ready(function(){
        $('#myTable').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable1').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable2').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable3').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable4').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable5').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable6').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });
        $('.myTable7').DataTable({
            "order": [],
            "scrollY": "400px",
            "scrollCollapse": true  
        });

    })
</script>
</body>
</html>