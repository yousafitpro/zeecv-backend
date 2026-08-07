@extends('layout.master')
@section('title',"Parcels")
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
.switch {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 24px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0;
  right: 0; bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 24px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: var(--primary);
}
input:checked + .slider:before {
  transform: translateX(20px);
}
</style>

        <div class="card" >
            <!-- /.box-header -->
            <div class="card-body" >

                  <form id="saearchForm" action="{{route('pmm.products.search')}}" method="post"onsubmit="submitSearchForm(event, this)">
                                @csrf
                                <div class="row no-gutters page-header-outer"   >
                                    <div class="col-md-6">
                               <div class="page-header">
                                <h4 class="page-title">Parcels</h4>
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
                                        <a href="{{route('pmm.parcel.view')}}">Parcels</a>
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
                                        <a  class="btn  btn-sm form-control" style="border-radius: 0px" href="{{route('pmm.products.view')}}">Reset</a>
                                    </div>


                                </div>
                                <br>
                                </div>
                            </form>

{{-- asdadd --}}
                <div id="list_outer" style="margin-top:0px;">
                    @include('pmm.parcel.ajax.main_list')
                </div>
            </div>
            <!-- /.box-body -->
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
function subscriberProduct(url) {
  $.ajax({
                url:url,
                type: 'post',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(response) {
                    if (response.code == 1) {

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

