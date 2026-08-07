@extends('layout.master')
@section('title', "Product Details")

@section('content')
<style>
        .form-container {

        }
        .form-section-title {
            font-size: 0.8rem;
            font-weight: bold;
            color: var(--primary);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 1rem;
        }
        .form-section-title.invoice {
            color: var(--primary);
            padding-top: 2rem;
        }
        .form-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .form-control,
        .form-select {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }
          .file-upload-container {

            max-width: 600px;
        }
        .form-section-title {
            font-size: 0.8rem;
            font-weight: bold;
            color: #007bff;
            padding-bottom: 0.25rem;
        }
        .form-section-subtitle {
            font-size: 0.9rem;
            color: #212529;
            margin-bottom: 1.5rem;
        }
        .upload-area {
            border: 2px dashed #ced4da;
            border-radius: 0.5rem;
            padding: 4rem 1rem;
            text-align: center;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .upload-text {
            color: #212529;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .drag-circle {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #212529;
            margin: 1.5rem 0;
        }
        .btn-choose-file {
            background-color: #4285f4;
            border: none;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .btn-choose-file:hover {
            background-color: #357ae8;
        }
</style>
<div class="container-fluid">
    <div class="card shadow-sm">


        <div class="card-body">
              <a href="{{ $back_url ?? route('pmm.paymentprofile.view') }}" >
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <br>
            <br>
            <form method="POST" action="{{ route('pmm.paymentprofile.updatePost', $item->id) }}" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
 <h6 class="form-section-title ">PERSONAL DATA</h6>

    <div class="row g-4">
        <div class="col-md-6">
            <label for="legalEntity" class="form-label">Legal Entity</label>
            <select name="legal_entity" required class="form-control">
                <option  value="Natural person resident in Italy" {{$item->legal_entity=='Natural person resident in Italy'?'selected':''}}>Natural person resident in Italy</option>
                <option value="Natural person not resident in Italy" {{$item->legal_entity=='Natural person not resident in Italy'?'selected':''}}>Natural person not resident in Italy</option>
                <option value="Italian Company" {{$item->legal_entity=='Italian Company'?'selected':''}}>Italian Company</option>
                <option value="Non-Italian Company" {{$item->legal_entity=='Non-Italian Company'?'selected':''}}>Non-Italian Company</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Fiscal Code</label>
            <input type="text" required value="{{$item->vat}}" name="vat" class="form-control" id="fiscalCode">
        </div>

        <div class="col-md-6">
            <label for="businessName" class="form-label">Business Name</label>
            <input type="text" required name="business_name" value="{{$item->business_name}}" class="form-control" id="businessName">
        </div>
    </div>
  <br>
    <h6 class="form-section-title invoice">INVOICE ADDRESS</h6>

    <div class="row g-4">
        <div class="col-md-6">
            <label for="country" class="form-label">Country</label>


            <div class="input-group">
                <select name="address_country" class="form-control">
                <option value="IT" {{$item->legal_entity==''?'selected':''}}>Italy</option>
                <option value="US" {{$item->legal_entity==''?'selected':''}}>US</option>

            </select>
            </div>
        </div>

        <div class="col-md-6">
            <label for="city" class="form-label">City</label>
            <input type="text" required name="address_city" value="{{$item->address_city}}" class="form-control" id="city">
        </div>

        <div class="col-md-6">
            <label for="province" class="form-label">Province</label>
            <input type="text" required name="address_province" value="{{$item->address_province}}" class="form-control" id="province">
        </div>

        <div class="col-md-6">
            <label for="zipCode" class="form-label">Zip Code</label>
            <input type="text" required name="address_zipcode" value="{{$item->address_zipcode}}" class="form-control" id="zipCode">
        </div>

        <div class="col-12">
            <label for="address_address" class="form-label">Address</label>
            <input type="text" required name="address_address" value="{{$item->address_address}}" class="form-control" id="address_address">
        </div>
    </div>
    <br>
       <h6 class="form-section-title invoice">Payment Details</h6>



         <div class="row g-4">
        <div class="col-md-6">
            <label for="country" class="form-label">Payment Method</label>
           <select name="payment_method" id="payment_method" required class="form-control">
                <option value="Paypal" {{$item->legal_entity==''?'selected':''}}>Paypal</option>
                <option value="Bank" {{$item->legal_entity==''?'selected':''}}>Bank</option>

            </select>
        </div>
         <div class="col-md-6">
            <label for="zipCode" class="form-label" id="payment_iban">Email Paypal</label>
            <input type="text" required name="payment_iban" value="{{$item->payment_iban}}" class="form-control" id="zipCode">
        </div>
    </div>
    <br>
  <div class="row g-4">
        <div class="col-md-6">
            <div class="container-fluid file-upload-container">

                <h6 class="form-section-title">ID DOCUMENT (MAX 5MB)*</h6>
                 <a href="{{$item->profileidentity->file_url}}" download="true">Download</a>


                <p class="form-section-subtitle">Front/Back Identity Card, Passport or Driving License</p>
                <small>If multiple zip documents first</small>

                <div class="upload-area">
                    <input type="file"  name="document_identity"  id="fileUploadInput">
                </div>

            </div>
        </div>
       </div>
       </div>

                <br>
                <br>

                <!-- Submit -->
                @if(is_has_permission('pmm.paymentprofile.update'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right mt-3 mr-2" >
                    <button type="submit" id="btn_submit" style="border-radius: 5px;" class="btn btn-primary">
                        </i> Save Changes
                    </button>
                </div>
                    </div>
                </div>
                @endif
                <br>
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
            $("#btn_submit").prop("disabled", true);
             $("#btn_submit").text("Saving...");
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
                },
                complete:function(){
                    $("#btn_submit").prop("disabled", false);
                $("#btn_submit").text("Create & Continue");
                }
            });
        }
    });
}

</script>
@endsection
