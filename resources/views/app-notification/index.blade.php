@extends('layout.master')
@section('title',"All Offers")
@section('content')
    <div class="page-header">
        <h4 class="page-title">App Notifications</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{url('/dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>



        </ul>
        <div class="btn-group btn-group-page-header ml-auto">
            <button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu">
                <div class="arrow"></div>
                <a class="dropdown-item" href="{{url('App-Notification-System/Add')}}">Add New Notification</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <form action="" method="post" id="filterForm">
                @csrf
                <div class="card-title">
                   Notifications
                </div>
                <div class="btn-group btn-group-page-header ml-auto" style="float: right; min-width: 200px">
                    <select class="form-control" name='status' onchange="$('#filterForm').submit()">
                        <option value="Active" {{session('status','all')=='Active'?'selected':''}}>Active</option>
                        <option value="Expired" {{session('status','all')=='Expired'?'selected':''}}>Expired</option>
                        <option value="Paused" {{session('status','all')=='Paused'?'selected':''}}>Paused</option>
                        <option value="all" {{session('status','all')=='all'?'selected':''}}>All</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="card-body">

            <div class="col-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-sm table-bordered table-hover display  margin-top-10 w-p100">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
{{--                                    <th>Design Type</th>--}}

                                    <th>Place</th>
                                    <th>Status</th>
                                        <th>Actions</th>


                                </tr>

                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>
                                            {{$item->app}}
                                        </td>

                                        <td>
                                            {{$item->type}}
                                        </td>

{{--                                        <td>--}}
{{--                                            {{$item->design_type}}--}}
{{--                                        </td>--}}
                                        <td>
                                            {{$item->place}}
                                        </td>
                                        <td>
{{--                                            @if(strtolower($item->status)=='pending')--}}
{{--                                                <button class="btn btn-sm btn-rounded btn-outline btn-warning">{{$item->status}}</button>--}}
{{--                                            @endif--}}
                                            @if($item->status=='Active')
                                                <button class="btn btn-sm btn-rounded btn-outline btn-success">{{$item->status}}</button>
                                            @endif
                                            @if($item->status=='Expired')
                                                <button class="btn btn-sm btn-rounded btn-outline bg-danger" style="color: white" >{{$item->status}}</button>
                                            @endif
                                            @if($item->status=='Paused')
                                                <button class="btn btn-sm btn-rounded btn-outline bg-warning" style="color: white" >{{$item->status}}</button>
                                            @endif
                                        </td>
                                        @if(auth()->user()->hasRole('admin'))
                                            <td>
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="arrow"></div>
                                                        <a class="dropdown-item" href="#" onclick="redirectUrl('{{url('App-Notification-System/Delete',zpayd_encrypt($item->id))}}')" >Delete</a>
                                                        <a class="dropdown-item" href="{{url('App-Notification-System/Edit',zpayd_encrypt($item->id))}}" >Edit</a>

                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

<script>
    function redirectUrl(url)
    {
        if(confirm("Are you Sure?"))
        {
            window.location.href=url;
        }
    }
</script>
@stop

