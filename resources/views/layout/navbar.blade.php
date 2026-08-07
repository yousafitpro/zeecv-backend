<style>
   .logo-header{
        background-color: red !important;
    }
   .btn-minimize i{

       color:white !important;
   }
</style>
<div class="main-header" data-background-color="#23395d"  >
    <!-- Logo Header -->

    <div class="logo-header" style="background-color: var(--primary) !important"  >


        <a href="{{url('/')}}" class="logo" >
            <img src="{{asset('app-icons/white-logo.png')}}" alt="navbar brand" class="navbar-brand" style="width:40px;">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" onclick="appSidebarToggler()" style="" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon" >
						<i class="fa fa-bars" ></i>
					</span>
        </button>
        <button class="topbar-toggler more mytopbar-toggler " onclick="appSidebarToggler()"  ><i class="fa fa-ellipsis-v" style="color: white !important"></i></button>
        <div class="navbar-minimize"  onclick="appSidebarToggler()">
            <button class="btn btn-minimize btn-rounded mytopbar-toggler"  >
                <i class="fa fa-bars" id="topbar-toggler" ></i>
            </button>
        </div>

    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg">

        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <h3 style="color: var(--primary); font-weight: bold"></h3>

            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">


                <li class="nav-item dropdown hidden-caret" id="alert_box">

                 @include('alerts.widget')
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic"  data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm myFlex" style="background-color:white;" >
                            <img src="{{auth()->user()->avatar()}}" alt="..." style="border:solid 2px white" class="avatar-img rounded-circle" >
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="{{auth()->user()->avatar()}}" alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <h4>{{auth()->user()->name}}</h4>
                                    <p class="text-muted">{{auth()->user()->email}}</p><a href="{{url('profile')}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('profile')}}">Settings </a>
                           <a class="dropdown-item" href="{{route('pmm.paymentprofile.view')}}">Payment Profiles</a>
{{--                            <a class="dropdown-item" href="#">Inbox</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Account Setting</a>--}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notiTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body myFlex" id="notiBody" style="min-height: 200px">
                ...
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<script>

   function showNoti(title,message)
   {

       $("#exampleModalCenter").modal("show")
       $("#notiTitle").text(title)
       $("#notiBody").text(message)
   }
</script>
