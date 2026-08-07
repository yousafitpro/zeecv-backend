@extends('layout.master')
@section('title', "Settings")

@section('content')
<style>
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d; /* Optional: gray text for inactive tabs */
        border-bottom: 2px solid transparent;
    }

    .nav-tabs .nav-link:hover {
        border-bottom: 2px solid #ccc; /* Optional hover effect */
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #007bff; /* Active text color */
        border-bottom: 2px solid #007bff;
        font-weight: bold;
        background-color: transparent;
    }
</style>
<div class="container-fluid">
    <div class="card shadow-sm">


        <div class="card-body">
              <a href="{{ $back_url ?? route('pmm.products.view') }}" >
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <br>
            <br>
            <form method="POST" action="{{ route('system.setting.app.update.support.actor', $item->id) }}" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
                <div class="row">
                    <!-- Product Info -->
                    <div class="col-md-8">


                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Name </strong></label>
                            <input type="text" name="support_actor_name" class="form-control" value="{{$item->support_actor_name }}" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Email </strong></label>
                            <input type="text" name="support_actor_email" class="form-control" value="{{$item->support_actor_email }}" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Skype </strong></label>
                            <input type="text" name="support_actor_skype" class="form-control" value="{{$item->support_actor_skype }}" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Telegram </strong></label>
                            <input type="text" name="support_actor_telegram" class="form-control" value="{{$item->support_actor_telegram }}" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Description </strong></label>
                            <input type="text" name="support_actor_description" class="form-control" value="{{$item->support_actor_description }}" required>
                        </div>
                        </div>
                        @if(is_has_permission('pmm.products.update'))
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Support Actor Profile Image</strong></label>
                            <input type="file" name="support_actor_image" class="form-control">
                        </div>
                        </div>
                        @endif
                        <br>

                    </div>

                    <!-- Product Preview -->
                    <div class="col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center">
                                <img src="{{ !empty($item->actordp)?$item->actordp->file_url:''}}" id="attachment" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                                <hr>
                                <h5 class="text-primary">{{ $item->name }}</h5>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Paysigh Product ID</strong></label>
                            <input type="text" name="paysigh_product_id" class="form-control" value="{{$item->paysigh_product_id }}" required>
                        </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Paysigh Test Product ID</strong></label>
                            <input type="text" name="paysigh_test_product_id" class="form-control" value="{{$item->paysigh_test_product_id }}" required>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                @if(is_has_permission('pmm.products.update'))
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Now
                    </button>
                </div>
                @endif
            </form>

        </div>
    </div>
</div>
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
            formData = new FormData(formElement);
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data: formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#attachment").prop('src',response.item_url)
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
@endsection
