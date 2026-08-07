@extends('layout.master')
@section('title', "Orders")
@section('content')
<style>
.filter-icon {
    text-align: right;
}
#menu-content {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
        height: 180px;

}

#menu-content .btn-sm {
    padding: 6px 12px;
    font-size: 13px;
}
.tow_buttons{
    float:right;
}
.btn-success.btn-sm {
    background-color: white !important;
    color: #0069d9 !important; 
    border: 1px solid #0069d9;
}

.btn-success.btn-sm:hover,
.btn-success.btn-sm:focus {
    background-color: #e6e6e6 !important; 
    color: #0069d9 !important;
}
</style>
@php
    $from_date = now()->subDays(30)->format('Y-m-d');
    $to_date = now()->format('Y-m-d');
@endphp
<div class="card">
    <div class="card-body">

        {{-- 🔹 Header + Filter Icon --}}
        <div class="row no-gutters page-header-outer mb-3">
            <div class="col-md-6">
                <div class="page-header">
                    <h4 class="page-title">Order Information</h4>
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
                            <a href="{{route('system.CallCenter.orders')}}">Order Information</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 filter-icon">
             <button type="button" id="menu-toggle" style="font-size:18px; background:none; border:none;">
    <i class="fas fa-sliders-h"></i>
</button>
            </div>
        </div>
<div id="menu-content" class="mt-2 " >
    <form id="searchForm" action="{{ route('system.CallCenter.orders.search') }}" method="post">
    @csrf
    <input type="hidden" name="export" id="export" value="0">

    <div class="row">
        <div class="col-md-3">
            <label>Name</label>
            <input type="text" name="name" placeholder="Name" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Payment Status</label>
            <select class="form-control" name="status">
                <option value="">--Select Status--</option>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" name="from_date"  value="{{ $from_date }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to_date" value="{{ $to_date }}" class="form-control">
        </div>
    </div>

    <div class="row mt-3">
         <div class="col-md-3">
            <label>Type</label>
            <select class="form-control" name="payment_method">
               
                <option value="COD">COD</option>
                <option value="Card">Card</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Order Status</label>
            <select class="form-control" name="order_status">
                <option value="">--Select Status--</option>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>

            </select>
        </div>
        <div class="col-md-3">
            <label>CC Status</label>
            <select class="form-control" name="cc_status">
                    <option value="">--Select Status--</option>
                    <option value="Try Call 1" >Try Call 1</option>
                    <option value="Try Call 2">Try Call 2</option>
                    <option value="Try Call 3">Try Call 3</option>
                    <option value="Pending">Pending</option>
                    {{-- <option value="Shipping" >Accepted</option> --}}
                    <option value="Fake" >Fake</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Trash" >Trash</option>
                    <option value="Non-existent data">Non-existent data</option>
                    <option value="Suspended" >Suspended</option>
                                    <option value="Accepted">Accepted</option>
                <option value="Accepted + Up Sell">Accepted + Up Sell</option>
            </select>
        </div>

        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-primary btn-sm me-1" onclick="submitSearchForm(event, this.form)">
                <i class="fa fa-search"></i> Search
            </button>
            @if(is_has_permission('pmm.cc.order.report.download'))
        <button type="button"
        class="btn btn-success btn-sm" 
        onclick="downloadReport(this)"
        style="color:#0069d9; background-color:white;">
    <i class="fa fa-download"></i> Download
        </button>
            @endif
        </div>
    </div>
    
</form>

</div>


        {{-- 🔽 AJAX Result List --}}
        <div id="list_outer" style="margin-top:15px;">
            @include('pmm.callcenter.ajax.main_list')
        </div>

    </div>
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
// function submitOrderDetailsForm(event, formElement) {
//         event.preventDefault(); // Always pass event explicitly
//        formData = new FormData(formElement);
//             $.ajax({
//                 url: $(formElement).attr('action'),
//                 type: $(formElement).attr('method'),
//                 data:formData,
//                 contentType: false,         // Required for FormData
//                 processData: false,
//                 success: function(response) {
//                     if (response.code == 1) {
//                         $("#"+$(formElement).attr('form-id')).modal('hide')
//                           $("#saearchForm").submit()

//                         swal("Success!", response.message, "success");

//                     } else if (response.code == 0) {
//                         swal("Sorry!", response.message, "error");
//                     } else {
//                         swal("Sorry!", "Unexpected response", "error");
//                     }
//                 },
//                 error: function(xhr) {
//                     let errorMessage = "Something went wrong.";
//                     if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
//                         errorMessage = xhr.e.responseJSON.message;
//                     }
//                     swal("Error!", errorMessage, "error");
//                 }
//             });
// }
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
    if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMessage = xhr.responseJSON.message;
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
function compeltepayment(url) {

    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            $("#mainLoader1").modal('show')
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
                },
                complete:function(){
                    $("#mainLoader1").modal('hide')
                }
            });
        }
    });
}

function downloadReport(event) {
 
var form = $("#searchForm")[0];   // get native form element
let formData = new FormData(form);
    // Get date fields
    let from_date = document.querySelector('input[name="from_date"]').value;
    let to_date = document.querySelector('input[name="to_date"]').value;

    if (from_date && to_date) {
        let from = new Date(from_date);
        let to = new Date(to_date);
        let diffDays = Math.floor((to - from) / (1000 * 60 * 60 * 24));

        // ✅ If more than 30 days difference, show alert
        if (diffDays > 30) {
            swal({
                title: "Invalid Date Range!",
                text: "You can only download reports for a maximum of 30 days range.",
                icon: "error",
                button: "OK",
            });
            return false;
        }
    }

    // ✅ Create a hidden form for POST request
    let downloadForm = document.createElement('form');
    downloadForm.method = 'POST';
    downloadForm.action = "{{ route('system.CallCenter.orders.downloadReport') }}";

    // Add CSRF token
    let csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    downloadForm.appendChild(csrf);

    // Copy all fields from searchForm
  
    for (let [key, value] of formData.entries()) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        downloadForm.appendChild(input);
    }

    // Submit the form
    document.body.appendChild(downloadForm);
    downloadForm.submit();
    document.body.removeChild(downloadForm);
}

</script>

@stop

