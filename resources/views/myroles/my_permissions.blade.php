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
                                <h3>Permissions</h3>
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
                            <th>Slug</th>
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

                       <form method="post" action="{{route('roles.permissions.update',$item->id)}}" >
                           @csrf
                           <div class="modal-body">

                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Name</label>
                                       <input class="form-control" value="{{$item->name}}" name="name">
                                   </div>
                               </div>
                               <div class="row">
                                <div class="col-md-12">
                                    <label>Slug</label>
                                    <input class="form-control" value="{{$item->slug}}" name="slug">
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
                                    <label>Tag</label>
                                    <input class="form-control" value="{{$item->tag}}" name="tag">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Color</label>
                                    <input class="form-control" value="{{$item->color}}" name="color">
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
                   <div class="modal fade" id="duplicate_modal{{$item->id}}" tabindex="-1" role="dialog"
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

                   <form method="post" action="{{route('roles.permissions.add')}}" >
                       @csrf
                       <div class="modal-body">

                           <div class="row">
                               <div class="col-md-12">
                                   <label>Name</label>
                                   <input class="form-control" value="{{$item->name}}" name="name">
                               </div>
                           </div>
                           <div class="row">
                            <div class="col-md-12">
                                <label>Slug</label>
                                <input class="form-control" value="{{$item->slug}}" name="slug">
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
                                <label>Tag</label>
                                <input class="form-control" value="{{$item->tag}}" name="tag">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Color</label>
                                <input class="form-control" value="{{$item->color}}" name="color">
                            </div>
                        </div>
                       </div>
                       <div class="modal-footer text-center">
                           <button type="button" class="btn btn-secondary"
                                   data-dismiss="modal"> Cancel
                           </button>
                           <button href="#"
                              class="btn btn-primary"> Duplicate
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
                                    <div class="badge " style="background-color:{{$item->color?:''}};color:darkbrown;font-weight:bold">
                                        {{$item->tag}}
                                    </div>
                                </td>
                                <td>
                                    {{$item->slug}}
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

                                            <a class="dropdown-item" style="cursor: pointer" onclick="return confirm('Are you sure?')" href="{{route('roles.permissions.delete',$item->id)}}"  >Remove</a>
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#update_modal{{$item->id}}" href="#"  >Edit</a>
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#duplicate_modal{{$item->id}}" href="#"  >Duplicate</a>





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

        <form method="post" action="{{route('roles.permissions.add')}}" onsubmit="createQuery(this)">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label>Name</label>
                        <input class="form-control" id="item-name" name="name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Slug</label>
                        <input class="form-control" id="item-slug" name="slug">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Group</label>
                        <input class="form-control" id="item-group" required name="group">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Color</label>
                        <input class="form-control" id="item-color" required name="color">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Tag</label>
                        <input class="form-control" id="item-tag" required name="tag">
                    </div>
                </div>
                   <div class="row">
                    <div class="col-md-12">
                        <label>Action</label>
                       <select class="form-control" id="item-action" required name="action">
                        <option value="single">Create Single</option>
                        <option value="all">Create Multiple</option>
                       </select>
                    </div>
                </div>
                     <div class="row d-none">
                    <div class="col-md-12 ">
                        <label>Permissions</label>
                       <select class="form-control select2" style="width: 100%" id="item-permissions"  name="permissions[]" multiple>
                        @foreach ($predefined_permissions as $p)
                          <option value="{{$p}}">{{$p}}</option>
                        @endforeach


                       </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"> Cancel
                </button>
                <button type="submit"
                   class="btn btn-primary"> Add
            </button>
            </div>
        </form>

            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    function toggleFields() {
        const action = $('#item-action').val();

        // Main field rows
        const $nameRow = $('#item-name').closest('.row');
        const $slugRow = $('#item-slug').closest('.row');
        const $groupRow = $('#item-group').closest('.row');
        const $colorRow = $('#item-color').closest('.row');
        const $tagRow = $('#item-tag').closest('.row');
        const $permissionsRow = $('#item-permissions').closest('.row');

        if (action === 'all') {
            $nameRow.hide();
            $slugRow.hide();

            $groupRow.show();
            $tagRow.show();
            $permissionsRow.removeClass('d-none');
        } else {
            $nameRow.show();
            $slugRow.show();
            $groupRow.show();
            $tagRow.show();
            $permissionsRow.addClass('d-none');
        }
    }

    toggleFields(); // on page load
    $('#item-action').on('change', toggleFields); // on change

});

          function createQuery(e)
    {
        const form = event.target;
       e.preventDefault();
        swal({
            title: "Confirmation!",
            text: "Are you sure you want to proceed ?",
            icon: "success",
            buttons: ["No", "Yes"],
            dangerMode:false,
        })
            .then((res) => {
                if (res) {
                    form.submit();
                } else {

                }
            });

    }


</script>
@stop

