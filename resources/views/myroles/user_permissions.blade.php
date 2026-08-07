@extends('layout.master')
@section('title',"Ips")
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2">
                                @include('components.panelBackbutton',['backUrl'=>url('roles/myusers')])
                            </div>
                            <div class="col-md-8">
                                <br>
                                <h3>{{$user->email }} | Direct Permissions</h3>
                            </div>


                            <div class="col-md-2">


                            </div>
                        </div>



            </div>
            <!-- /.box-header -->
            <div class="container ">




                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-sm table-bordered table-hover display  margin-top-10 w-p100">
                                <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>User</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Tag</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $item)
                                    <tr>
                                        <td class="MyFlex">
                                            <div id="user_permission_waiter{{$item->id}}" class="d-none" style="width: 20px;height:20px">
                                                <div class="spinner-container">
                                                    <div class="custom-spinner"></div>
                                                  </div>
                                            </div>
                                            <input id="user_permission{{$item->id}}" onclick="add_permission('{{$item->id}}')" type="checkbox"  {{$item->has_permission?'checked':''}} class="permission-checkbox" value="{{ $item->id }}">
                                        </td>
                                        <td>
                                            @if($item->user)
                                                <label>{{ $item->user->name }}</label><br>
                                                <small>{{ $item->user->email }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->group }}</td>
                                        <td>
                                            <div class="badge " style="background-color:{{$item->color?:''}};color:darkbrown;font-weight:bold">
                                                {{$item->tag}}
                                            </div>
                                         </td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <script>
        $(document).ready(function(){
         $('#myTableCustom2').DataTable({
            "order":[],
            "info": false,
            "paging": false, // Disable pagination
            "searching": false
        });
    });
        // Helper function to get selected permissions
        function getSelectedPermissions() {
            let selected = [];
            $('.permission-checkbox:checked').each(function () {
                selected.push($(this).val());
            });
            return selected;
        }

        // Add permissions handler
         function add_permission (id) {

            let roleId = {{ request('id') }}; // Replace with the appropriate role ID
            let permission = id;
            let isChecked = $("#user_permission"+id).prop('checked');


            $("#user_permission"+id).addClass("d-none");
            $("#user_permission_waiter"+id).removeClass("d-none");
            $.ajax({
                url: "{{route('roles.users.direct_permissions.add',request('id'))}}",
                type: 'POST',
                data: {
                    permissions: permission,
                    flag:isChecked,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert_success_message('Sucess!',response.message)
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                },
                complete:function(){
                    $("#user_permission"+id).removeClass("d-none");
                    $("#user_permission_waiter"+id).addClass("d-none")
                }
            });
        };


    </script>
@stop

