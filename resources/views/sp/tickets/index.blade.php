@extends('layout.master')
@section('title',"Tickets")
@section('content')
<style>
.task_actions .rounded-circle{
    width: 20px !important;
    height: 20px !important;
}
.task_actions .badge-sm{
/* height: 2px; */
font-size: 8px;
font-weight: bold
/* padding-top: 2px !important */
}
</style>

        <div class="card" >
            <!-- /.box-header -->
            <div class="card-body" >

                  <form id="saearchForm" action="{{route('sp.tickets.search')}}" method="post"onsubmit="submitSearchForm(event, this)">
                                @csrf
                                <div class="row no-gutters page-header-outer"   >
                                    <div class="col-md-6">
                               <div class="page-header">
                                <h4 class="page-title">Tickets</h4>
                                <ul class="breadcrumbs">
                                    <li class="nav-home">
                                        <a href="{{url('/dashboard')}}">
                                            <i class="flaticon-home"></i>
                                        </a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('sp.tickets.view')}}">Tickets</a>
                                    </li>

                                </ul>

                            </div>
                                    </div>


                                    <div class="col-md-6 filter-icon">

                                        <a href="javascript:none" id="menu-toggle"  style="font-size:16px"  class=" pull-right ">
                                       <i class="fas fa-sliders-h"></i>

                                    </a>
                                      @if(is_has_permission('sp.tickets.add|sp.tickets.full_control'))
                                        <a href="{{route('sp.tickets.add')}}"   class="btn btn-sm btn-primary pull-right m-table-header-btn" > Create ticket</a>
                                        @endif

                                    </div>
                                </div>


                            <div id="menu-content"   style="display: none;">
                                <br>
                                <div class="row no-gutters">
                                    <div class="col-md-9">
                                        <input name="name" value="" placeholder="Name" class="form-control sm-input">
                                    </div>
                                     <div class="col-md-3">
                                        <select class="form-control" name="status">
                                            <option value="">--Select Status--</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row no-gutters" >


                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-sm form-control" style="border-radius: 0px">Search</button>
                                    </div>
                                     <div class="col-md-2">
                                        <br>
                                        <a  class="btn  btn-sm form-control" style="border-radius: 0px" href="{{route('sp.tickets.view')}}">Reset</a>
                                    </div>


                                </div>
                                <br>
                                </div>
                            </form>

{{-- asdadd --}}
                <div id="list_outer" style="margin-top:0px;">
                    @include('sp.tickets.ajax.main_list')
                </div>
            </div>
            <!-- /.box-body -->
        </div>
       <div class="modal fade" id="coppy_link_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Affiliation Link</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @csrf
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Link</label>
                        <input id="affiliation_link" class="form-control" readonly>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-primary" onclick="copyAffiliateLink()">Copy Link</button>
                </div>
                <div id="copy_success" class="text-success mt-2" style="display: none;">Link copied to clipboard!</div>
            </div>
        </div>
    </div>
</div>
<script>
    function copyAffiliateLink() {
        const linkInput = document.getElementById("affiliation_link");
        linkInput.select();
        linkInput.setSelectionRange(0, 99999); // For mobile compatibility
        document.execCommand("copy");

        // Show success message
        document.getElementById("copy_success").style.display = "block";

        // Optionally hide it after 2 seconds
        setTimeout(() => {
            document.getElementById("copy_success").style.display = "none";
        }, 2000);
    }
</script>


<script>
function submitSearchForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

   $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data: $(formElement).serialize(),
                success: function(response) {
                    $("#list_outer").empty()
                    $("#list_outer").html(response)
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
}
function generate_link(url) {

    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            $.ajax({
                url:url,
                type: 'post',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(response) {
                    if (response.code == 1) {
                        $("#affiliation_link").val(response.link)
                        $("#coppy_link_modal").modal('show')
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }
    });
}
function removeItem(url) {

    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            $.ajax({
                url:url,
                type: 'get',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(response) {
                    if (response.code == 1) {
                            $("#saearchForm").submit()
                        swal("Success!", response.message, "success");
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }
    });
}
</script>
@stop

