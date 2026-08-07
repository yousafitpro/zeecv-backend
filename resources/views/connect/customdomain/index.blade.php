@extends('layout.master')
@section('title', "Telegram")
@section('content')
<form method="post" action="{{route('system.connect.customdomain.update')}}" id="customdomain_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Connect your custom domain</h4>
                </div>
                <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-3">
                    <label class="switch">
                        <input type="checkbox" name="order_checkout" {{!empty($domain->order_checkout)?'checked':''}}> Order Checkout
                    </label>
                    </div>
                    <div class="col-md-3">
                    <label class="switch">
                        <input type="checkbox" name="order_tracking" {{!empty($domain->order_tracking)?'checked':''}}> Order Tracking
                    </label>
                    </div>
                    <div class="col-md-3">
                    <label class="switch">
                        <input type="checkbox" name="order_comeback" {{!empty($domain->order_comeback)?'checked':''}}> Order Comeback
                    </label>
                    </div>
                </div>
             <br>
                <div class="row">
                    <div class="col-md-12">
                        <input placeholder="https://yourwebsite.com" value="{{$domain->domain}}" class="form-control" name="domain">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                       <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script>
function submitForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            //  $("#mainLoader1").modal('show')
             formData = new FormData(formElement);
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
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
                    // $("#mainLoader1").modal('hide')
                }
            });
        }
    });
}
</script>
@endsection
