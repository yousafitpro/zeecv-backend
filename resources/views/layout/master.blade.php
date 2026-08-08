<!DOCTYPE html>
<html lang="en" class="{{$user_settings->sidebar_status=='closed'?'sidebar_minimize':''}}">
<head>
    @include('layout.includes.css')
    <!-- Chart JS -->
    <script src="{{asset('theme/js/plugin/chart.js/chart.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('css')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link rel="stylesheet" href="{{asset('appstyle.css')}}">
<style>

       table thead th {
       background: rgba(40,165,171,255) !important;
        color: #ffffff !important; /* White text */
    }
    .card {
         margin-bottom: 10px !important;
    }
</style>
</head>

<body>
@include('app.widgets.userModal')
        <audio id="alert-sound" src="{{asset('app-data/sounds/alert-sound.mp3')}}" preload="auto"></audio>
<!-- Chart Circle -->
<script src="{{asset('theme/js/plugin/chart-circle/circles.min.js')}}"></script>
<div class="wrapper">
   @include("layout.navbar")
    @include("layout.sidebar")
    <div class="main-panel">
        <div class="content">
            <div class="page-inner" style="background: linear-gradient(
                                                            135deg, 
                                                            #fff1ec 0%, 
                                                            #f3e7e9 25%, 
                                                            #e3eeff 60%, 
                                                            #e0f2fe 100%
                                                            );min-height:600px">
             @include('loaders.index')
             @include('app-notification.text-box')
       @yield('content')
            </div>
        </div>
    </div>

    @include('layout.includes.js')
    @include('scripts.security')
    @include('alert.subscription')
@yield('script')
<script>
    function appSidebarToggler()
    {

        currentState = localStorage.getItem('topbar_toggle');
            if (currentState === 'open') {
                localStorage.setItem('topbar_toggle', 'closed');
            } else {
                localStorage.setItem('topbar_toggle', 'open');
            }
             submitSettingForm()
            setSidebar()
    }
  function f4()
  {

  }
      function submitSettingForm()
    {
        currentState = localStorage.getItem('topbar_toggle');
            $.ajax({
                url:"{{route('user.settings.update')}}",
                type:'post',
                data: {'sidebar_status':currentState,'_token':'{{csrf_token()}}'},
                success: function(response) {
                },
                error: function(xhr) {

                }
            });
    }
    function setSidebar()
    {
        var minibutton = $('.btn-minimize');
        if(localStorage.getItem('topbar_toggle')==null)
        {
           localStorage.setItem('topbar_toggle', 'open');
        }
         currentState = localStorage.getItem('topbar_toggle');
            if (currentState === 'open') {
			   $('html').removeClass('sidebar_minimize');
				mini_sidebar = 0;
            }else{
                $('html').addClass('sidebar_minimize');
				mini_sidebar = 1;
            }
    }
    $(document).ready(function () {

     setSidebar()


    });
</script>

<script src="{{asset('appscript.js')}}"></script>
</div>
</body>
</html>
