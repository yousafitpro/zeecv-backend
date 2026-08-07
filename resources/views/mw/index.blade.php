@extends('layout.master')
@section('title',"MW")
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
                            <div class="col-md-1">
                                @include('components.panelBackbutton',['backUrl'=>'/dashboard'])
                            </div>
                            <div class="col-md-9">
                                <br>
                                <h3><i class="fas fa-stream"></i> Middleware</h3>
                            </div>


                            <div class="col-md-2">

                            <button class="btn btn-primary btn-sm form-control" data-toggle="modal" data-target="#create_query"> <i class="ti-plus" style="color: var(--primary)" ></i> Add</button>


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
                            <th>Identitifier</th>
                            <th>Originator</th>
                            <th>User ID</th>
                            <th>status</th>

                            <th>LE Time</th>
                            <th>Created At</th>
                            <th>Emails</th>
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
                                   <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-stream"></i> Middleware</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('mw.update',$item->id)}}" >
                           @csrf
                           <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Identitifier</label>
                                    <input class="form-control" required value="{{$item->identitifier}}" name="identitifier">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>User</label>
                                   <select class="form-control" name="user_id" required>
                                   @foreach ($users as $user)
                                   <option value="{{$user->id}}" {{$item->user_id==$user->id?'selected':''}}>{{$user->email}}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Originator</label>
                                <select class="form-control" name="originator" required>
                                @foreach ($originators as $or)
                                <option value="{{$or}}" {{$or==$item->originator?'selected':''}}>{{$or}}</option>
                                @endforeach
                                </select>
                                </div>
                            </div>

                               <div class="row">
                                <div class="col-md-4">
                                    <label>Status</label>
                                   <select class="form-control" name="status" required>
                                    <option {{$item->status=='active'?'selected':''}} value="active">Active</option>
                                    <option {{$item->status=='inactive'?'selected':''}} value="inactive">Inactive</option>
                                   </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Enable Endpoints</label>
                                <select class="form-control" name="enable_endpoints" required>
                                    <option {{$item->enable_endpoints=='no'?'selected':''}} value="no">No</option>
                                    <option {{$item->enable_endpoints=='yes'?'selected':''}} value="yes">Yes</option>
                                </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Allow Wildcard</label>
                                <select class="form-control" name="allow_wildcard" required>
                                    <option {{$item->allow_wildcard=='yes'?'selected':''}} value="yes">Yes</option>
                                    <option {{$item->allow_wildcard=='no'?'selected':''}} value="no">No</option>
                                </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Enable Logging</label>
                                <select class="form-control" name="logging" required>
                                    <option {{$item->logging=='no'?'selected':''}} value="no">No</option>
                                    <option {{$item->logging=='yes'?'selected':''}} value="yes">Yes</option>

                                </select>
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
                    <div class="modal fade" id="duplicate{{$item->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-stream"></i> Middleware</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('mw.duplicate',$item->id)}}" >
                           @csrf
                           <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Identitifier</label>
                                    <input class="form-control" required value="{{$item->identitifier}}" name="identitifier">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>User</label>
                                   <select class="form-control" name="user_id" required>
                                   @foreach ($users as $user)
                                   <option value="{{$user->id}}" {{$item->user_id==$user->id?'selected':''}}>{{$user->email}}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Duplicate
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
                   </div>
         <div class="modal fade" id="create_query2{{$item->id}}" tabindex="-1" role="dialog"
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


                      @csrf
                      <div class="modal-body">

                          <div class="row">
                              <div class="col-md-12">
                                  <label>Client ID</label>
                                  <input value="{{$item->client_id}}" class="form-control" name="name">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <label>API-Key</label>
                                  {{-- <input value="{{$item->api_key}}"  class="form-control" > --}}
                                  <div class="input-group">
                                    <input id="secretapikey{{$item->id}}"  class="form-control" required value="{{$item->api_key }}" type="password">
                                    <span class="input-group-text" onclick="see_key('apikey{{$item->id}}')" style="cursor: pointer;">
                                     <i  class="fa fa-eye" id="secretToggleBtnapikey{{$item->id}}" ></i>
                                    </span>
                                    </div>
                              </div>
                          </div>

                      </div>


                      </div>
                  </div>
              </div>
                            <tr>
                                <td>
                                    {{$item->identitifier}}
                                </td>
                                <td>
                                    {{$item->originator}}
                                </td>
                                <td>
                                    {{$item->user->email}}
                                    <br>
                                    <small>Client ID:<small style="color: darkred;font-weight:bold">{{$item->client_id}}</small></small>
                                </td>
                                <td>
                                    <div class="badge badge-default">{{$item->status}}</div>
                                </td>
                                <td>
                                    {{$item->updated_at}}
                                </td>
                                <td>
                                    {{$item->created_at}}
                                </td>
                                <td>
                                    @php
                                    $listners_emails = explode(',', $item->listners_emails);
                                @endphp

                                @foreach ($listners_emails as $email)
                                <div class="badge badge-info badge-sm">{{ trim($email) }}</div><br>
                                @endforeach

                                </td>

                                <td>
                                    <div class="dropdown pull-right">

                                        <a style="font-size: 15px; margin-right: 20px"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="fas fa-caret-down pull-left"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" >

                                            <a class="dropdown-item" style="cursor: pointer" onclick="return confirm('Are you sure?')" href="{{route('mw.delete',$item->id)}}"  ><i class="fas fa-trash"></i> Remove</a>

                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#update_modal{{$item->id}}" href="#"  ><i class="fas fa-edit"></i>Edit</a>
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#create_query2{{$item->id}}" href="#"  ><i class="fas fa-key"></i> API Credentials</a>
                                            <a class="dropdown-item" style="cursor: pointer" href="{{route('mw.paths.view',$item->id)}}"  ><i class="fas fa-route"></i> Paths</a>
                                            <a class="dropdown-item" style="cursor: pointer" href="{{route('mw.logs.view',$item->id)}}"  ><i class="fas fa-history"></i> Logs</a>
                                            <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#duplicate{{$item->id}}" href="#"   ><i class="fas fa-copy"></i> Duplicate</a>






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
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-stream"></i> Middleware</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

        <form method="post" action="{{route('mw.add')}}" id="addIp">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Identitifier</label>
                        <input class="form-control" required  name="identitifier">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>User</label>
                       <select class="form-control" name="user_id" required>
                       @foreach ($users as $user)
                       <option value="{{$user->id}}">{{$user->email}}</option>
                       @endforeach
                       </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Originator</label>
                    <select class="form-control" name="originator" required>
                    @foreach ($originators as $or)
                    <option value="{{$or}}">{{$or}}</option>
                    @endforeach
                    </select>
                    </div>
                </div>
                {{-- <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Data (Json)</label>
                   <textarea style="width: 100%; min-height:100px" name="mw_data"></textarea>
                    </div>
                </div> --}}
                <br>

                <div class="row">
                    <div class="col-md-3">
                        <label>Status</label>
                       <select class="form-control" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                       </select>
                    </div>
                    <div class="col-md-3">
                        <label>Enable Endpoints</label>
                       <select class="form-control" name="enable_endpoints" required>
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                       </select>
                    </div>
                    <div class="col-md-3">
                        <label>Allow Wildcard</label>
                       <select class="form-control" name="allow_wildcard" required>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                       </select>
                    </div>
                      <div class="col-md-3">
                        <label>Enable Logging</label>
                       <select class="form-control" name="logging" required>
                         <option value="no">No</option>
                        <option value="yes">Yes</option>

                       </select>
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

