@extends('layout.master')
@section('title',"Links")
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

                  <form id="saearchForm" action="{{route('pmm.merchants.search')}}" method="post"onsubmit="submitSearchForm(event, this)">
                                @csrf
                    <div class="row no-gutters page-header-outer"   >
                        <div class="col-md-6">
                               <div class="page-header">
                                <h4 class="page-title">Merchants</h4>
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
                                        <a href="{{route('pmm.merchants.view')}}">Merchants</a>
                                    </li>

                                </ul>

                            </div>
                                    </div>


                                    <div class="col-md-6 filter-icon">

                                        <a href="javascript:none" id="menu-toggle"  style="font-size:16px"  class=" pull-right ">
                                       <i class="fas fa-sliders-h"></i>

                                    </a>

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
                                        <a  class="btn  btn-sm form-control" style="border-radius: 0px" href="{{route('pmm.merchants.view')}}">Reset</a>
                                    </div>


                                </div>
                                <br>
                                </div>
                            </form>

{{-- asdadd --}}
                <div id="list_outer" style="margin-top:0px;">
                    @include('pmm.merchant.ajax.main_list')
                </div>
            </div>
            <!-- /.box-body -->
        </div>


<script>
    function copyAffiliateLink(id) {
        const linkInput = document.getElementById(id);
        if (!linkInput) return;

        // Use Clipboard API (recommended and works with hidden fields)
        navigator.clipboard.writeText(linkInput.value).then(() => {
            // Optional: show a success message
            alert('Link copied to clipboard!');
        }).catch(() => {
            alert('Failed to copy the link. Please try again.');
        });
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

