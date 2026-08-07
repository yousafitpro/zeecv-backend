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
              <a href="{{ $back_url ?? route('pmm.withdrawal.view') }}" >
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <br>
            <br>
            <form method="POST" action="{{ route('pmm.withdrawal.updatePost', $item->id) }}" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
  <div class="row g-4">
        <div class="col-md-6">
            <label for="legalEntity" class="form-label">Payment Method</label>
            <select  name="payment_profile_id" disabled required class="form-control">
                @foreach ($methods as $method)
                     <option value="{{$method->id}}" {{$method->id==$item->payment_profile_id?'selected':''}}>{{$method->business_name}} ({{$method->payment_method}})</option>
                @endforeach


            </select>
        </div>

        <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Amount</label>
<input  value="{{$item->amount}}$" required readonly name="amount" class="form-control" id="fiscalCode">
        </div>


    </div>
     @if(is_has_permission('pmm.withdrawal.update'))
      <div class="row g-4">
          <div class="col-md-6 div-sm">
                        <label>Status</label>
                        <select name="status" class="form-control" >
                        <option value="Pending" {{$item->status=='Pending'?'selected':''}} >Pending</option>
                        <option value="Approved" {{$item->status=='Approved'?'selected':''}} >Approved</option>
                        <option value="Rejected" {{$item->status=='Rejected'?'selected':''}} >Rejected</option>

                        </select>

                        <br>
                        <div style="border: dotted 2px gray;padding:5px">
                            <h4>Banking Details</h4>
                        <h5>Payment Method : {{$item->method->payment_method}}</h5>
                        <h5>Transfer ID / IBAN : {{$item->method->payment_iban}}</h5>
                        </div>
                      </div>
           <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Note</label>
            <textarea class="form-control" name="note" style="height: 200px;">{{$item->note}}</textarea>
        </div>
      </div>
      @endif

       </div>
           <div class="row g-4">
        <div class="col-md-6">
            <div class="container-fluid file-upload-container">

                <h6 class="form-section-title">Invoice DOCUMENT (MAX 5MB)*</h6>
                <small>If multiple zip documents first</small>

                <div class="upload-area">
                    <input type="file"  name="invoice"  id="fileUploadInput">
                </div>

            </div>
        </div>
        @if(is_has_permission('pmm.withdrawal.update'))
         <div class="col-md-5">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center">
                                {{-- <h6 class="mb-3">Product Image</h6> --}}
                                <img src="{{ !empty($item->user)?$item->user->avatar():''}}" id="attachment" >
                                <hr>
                                <h5 class="text-primary">{{ $item->user->name }}</h5>
                                <p class="text-muted">{{ $item->user->email }}</p>

                            </div>
                        </div>
                    </div>
            @endif
       </div>

                <br>
                <br>

                <!-- Submit -->
                @if(is_has_permission('pmm.withdrawal.update'))
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
