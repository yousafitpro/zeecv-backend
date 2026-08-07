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
                                <h3>{{$user->email}} | Roles</h3>
                            </div>


                            <div class="col-md-2">


                            </div>
                        </div>
                    </div>


            </div>
            <!-- /.box-header -->
            <div class="container mt-3">



                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="myTableCustom" class="table table-sm table-bordered table-hover display  margin-top-10 w-p100">
                                <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>User</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $item)
                                    <tr>
                                        <td class="MyFlex">

                                            <div id="user_permission_waiter{{$item->id}}" class="d-none" style="width: 20px;height:20px">
                                                <div class="spinner-container">
                                                    <div class="custom-spinner"></div>
                                                  </div>
                                            </div>
                                            <input id="user_permission{{$item->id}}" type="checkbox"  {{$item->has_role?'checked':''}} class="permission-checkbox" value="{{ $item->id }}">
                                        </td>
                                        <td>
                                            @if($item->user)
                                                <label>{{ $item->user->name }}</label><br>
                                                <small>{{ $item->user->email }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
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
        $(document).on('click', '.permission-checkbox', function() {
            const id = $(this).val();
            const isChecked = $(this).prop('checked');
            add_permission(id,isChecked)
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
        function add_permission(permission,isChecked)
            {
                $("#user_permission"+permission).addClass("d-none");
                $("#user_permission_waiter"+permission).removeClass("d-none");
            let roleId = {{ request('id') }};

            $.ajax({
                url: "{{route('roles.users.roles.add',request('id'))}}",
                type: 'POST',
                data: {
                    permission: permission,
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
                    $("#user_permission"+permission).removeClass("d-none");
                    $("#user_permission_waiter"+permission).addClass("d-none")
                }
            });
          };


    </script>
@stop

