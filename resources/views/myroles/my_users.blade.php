@extends('layout.master')
@section('title',"Users")
@section('content')
<style>
    .btn-primary-new{
        background-color: var(--primary);
    }
    .bill_role_buttons{
        outline: none;
        border: solid 0.001cm var(--primary);
        height: 40px;
        width:90px;
        background-color: white;
        color: solid 2px var(--primary);
        border-radius:40px;
        margin-right: 10px;
    }
    .btn-primary-new{
        background-color: var(--primary);
        color: white;
    }
    .btn-primary-new:active{
        background-color: var(--primary);
        color: white;
    }
    .btn-primary-new:focus{
        background-color: var(--primary);
        color: white;
    }
    .btn-primary-new:visited{
        background-color: var(--primary);
        color: white;
    }
    </style>
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2">
                                @include('components.panelBackbutton',['backUrl'=>'/dashboard'])
                            </div>
                            <div class="col-md-8">
                                <br>
                                <h3>Users</h3>
                            </div>


                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm form-control" data-toggle="modal" data-target="#create_query2"> <i class="ti-eye" style="color: var(--primary)" ></i> Show Credentials</button>

                            </div>
                            <div class="col-md-2">

                            <button class="btn btn-primary btn-sm form-control" data-toggle="modal" data-target="#create_query"> <i class="ti-plus" style="color: var(--primary)" ></i> Add New</button>


                            </div>
                        </div>
                    </div>


            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-sm table-bordered table-hover display  margin-top-10 w-p100">
                        <thead>
                        <tr>
                            {{-- <th>User</th> --}}
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Slug</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($list as $item)
                        <div class="modal fade" id="update_bill_pay_user{{$item->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Update User Details</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>



                           </div>
                       </div>
                   </div>
                        <div class="modal fade" id="update_modal{{$item->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('roles.users.update',$item->id)}}" >
                           @csrf
                           <div class="modal-body">

                               <div class="row">
                                   <div class="col-md-6">
                                       <label>Name</label>
                                       <input class="form-control" required value="{{$item->name}}" name="name">
                                   </div>
                                   <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" required name="status">
                                        <option {{$item->status=='active'?'selected':''}} value="active">Active</option>
                                        <option {{$item->status=='inactive'?'selected':''}} value="inactive">Inactive</option>
                                    </select>
                                </div>
                               </div>
                               @if(is_admin())
                               <div class="row">
                                <div class="col-md-12">
                                    <label>Type</label>
                                    <select class="form-control" required name="type">
                                        <option {{$item->type=='Company'?'selected':''}} value="Company">Company</option>
                                        <option {{$item->type=='User'?'selected':''}} value="User">User</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                               <div class="row">
                                <div class="col-md-12">
                                    <label>Email</label>
                                    <input disabled class="form-control" required value="{{$item->email}}" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Password (optional)</label>
                                    <input class="form-control"  name="password">
                                </div>
                            </div>
                           </div>
                           <div class="modal-footer text-center">
                               <button type="button" class="btn btn-secondary"
                                       data-dismiss="modal"> Cancel
                               </button>
                               <button href="#"
                                  class="btn btn-primary"> Update
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
                   </div>
                            <tr>
                                {{-- <td>
                                  @if($item->created_by)
                                      <label>{{$item->created_by->name}}</label><br>
                                        <small>{{$item->created_by->email}}</small>
                                    @endif
                                </td> --}}
                                <td>
                                    {{$item->name}}
                                    @if(!empty($item->signup_type))
                                    <br>
                                    <div class="badge badge-info">{{ $item->signup_type }}</div>
                                    @endif
                                    @if(!empty($item->resume))
                                    <br>
                                    <div class="badge badge-info">Resume</div>
                                    @endif
                                    @if(!empty($item->contact))
                                    <br>
                                    <div class="badge badge-info">{{$item->contact->desired_job_title}}</div>
                                    @endif
                                </td>
                                <td>
                                    #{{unique_encrypt($item->id)}}
                                </td>
                                <td>
                                    {{$item->email}}
                                </td>
                                <td>
                                    {{$item->created_at}}
                                </td>

                                <td>
                                    <div class="dropdown pull-right">

                                        <a style="font-size: 15px; margin-right: 20px"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="fas fa-caret-down pull-left"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" >

                                            @if(is_has_permission('roles.users.manage_roles'))
                                            <a class="dropdown-item" style="cursor: pointer" href="{{route('roles.users.roles',$item->id)}}"  >Roles</a>
                                            @endif
                                            @if(is_has_permission('api.keys.view'))
                                            <a class="dropdown-item" style="cursor: pointer" href="{{route('api.keys.view',$item->id)}}"  >API Keys</a>
                                            @endif
                                            @if(is_has_permission('roles.users.direct_permissions'))
                                            <a class="dropdown-item" style="cursor: pointer" href="{{route('roles.users.direct_permissions',$item->id)}}"  >Direct Permissions</a>
                                            @endif
                                            {{-- @if(is_has_permission('roles.users.remove'))
                                            <a class="dropdown-item" style="cursor: pointer" onclick="return confirm('Are you sure?')" href="{{route('roles.users.delete',$item->id)}}"  ><i class="fas fa-trash"></i> Remove</a>
                                            @endif --}}
                                            @if(is_has_permission('roles.users.edit'))
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#update_modal{{$item->id}}" href="#"  >Edit</a>
                                             @endif




                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="modal fade" id="create_query" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

        <form method="post" action="{{route('roles.users.add')}}" id="addIp">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input required class="form-control" name="name">
                    </div>
                       <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" required name="status">
                                        <option  value="active">Active</option>
                                        <option  value="inactive">Inactive</option>
                                    </select>
                                </div>
                </div>
                @if(is_admin())
                <div class="row">
                    <div class="col-md-12">
                        <label>Type</label>
                        <select class="form-control" required name="type">
                            <option value="Company">Company</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label>Email</label>
                        <input required class="form-control" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Password</label>
                        <input required class="form-control" name="password">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"> Cancel
                </button>
                <a onclick="createQuery()" href="#"
                   class="btn btn-primary"> Add
                </a>
            </div>
        </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="create_query2" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Active API Key Credentials</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

        <form method="post" action="{{route('api.keys.refresh',root_user_id())}}" id="addIp">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label>Client ID</label>
                        <input value="{{$client_id}}" class="form-control" name="name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>API-Key</label>
                        <input value="{{$api_key}}"  class="form-control" >
                    </div>
                </div>

            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"> Cancel
                </button>
                <a onclick="createQuery()" href="#"
                   class="btn btn-primary"> Refresh
                </a>
            </div>
        </form>

            </div>
        </div>
    </div>
<script>

    function createQuery(form_id="addIp")
    {


        swal({
            title: "Confirmation!",
            text: "Are you sure you want to proceed ?",
            icon: "success",
            buttons: ["No", "Yes"],
            dangerMode:false,
        })
            .then((res) => {
                if (res) {
                    $("#"+form_id).submit()
                } else {

                }
            });

    }
</script>
@stop

