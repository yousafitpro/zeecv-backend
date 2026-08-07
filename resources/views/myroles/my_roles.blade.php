@extends('layout.master')
@section('title',"Ips")
@section('content')
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
                                <h3>Roles</h3>
                            </div>


                            <div class="col-md-2">

    <button class="btn btn-outline-primary form-control" data-toggle="modal" data-target="#create_query"> <i class="ti-plus" style="color: var(--primary)" ></i> Add</button>


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
                            <th>User</th>
                            <th>Name</th>
                            <th>Group</th>
                            <th>Tag</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($list as $item)
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

                       <form method="post" action="{{route('roles.roles.update',$item->id)}}" >
                           @csrf
                           <div class="modal-body">

                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Name</label>
                                       <input required class="form-control" value="{{$item->name}}" name="name">
                                   </div>
                               </div>
                               <div class="row">
                                <div class="col-md-12">
                                    <label>Group</label>
                                    <input class="form-control" value="{{$item->group}}" name="group">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>key</label>
                                    <input class="form-control"  name="unique_key" value="{{$item->unique_key}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tag</label>
                                    <input class="form-control"  name="tag" value="{{$item->tag}}">
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
                                <td>
                                  @if($item->user)
                                      <label>{{$item->user->name}}</label><br>
                                        <small>{{$item->user->email}}</small>
                                    @endif
                                </td>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>
                                    {{$item->group}}
                                </td>
                                <td>
                                    {{$item->tag}}
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

                                            <a class="dropdown-item" style="cursor: pointer" onclick="return confirm('Are you sure?')" href="{{route('roles.roles.delete',$item->id)}}"  >Remove</a>
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#update_modal{{$item->id}}" href="#"  >Edit</a>

                                            <a class="dropdown-item" style="cursor: pointer"  href="{{route('roles.roles.permissions',$item->id)}}"  >Permissions</a>





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

        <form method="post" action="{{route('roles.roles.add')}}" id="addIp">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label>Name</label>
                        <input required class="form-control" name="name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Group</label>
                        <input class="form-control" name="group">
                    </div>
                </div>
             <div class="row">
                    <div class="col-md-12">
                        <label>key</label>
                        <input class="form-control"  name="unique_key">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Tag</label>
                        <input class="form-control"  name="tag">
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
<script>
    function createQuery()
    {
       var user_id=$("#queryUser").val()
        swal({
            title: "Confirmation!",
            text: "Are you sure you want to proceed ?",
            icon: "success",
            buttons: ["No", "Yes"],
            dangerMode:false,
        })
            .then((res) => {
                if (res) {
                    $("#addIp").submit()
                } else {

                }
            });

    }
</script>
@stop

