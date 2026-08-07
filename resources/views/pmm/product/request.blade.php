@extends('layout.master')
@section('title',"Request Campaign")
@section('content')
<style>
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




        <div class="card">
            <!-- /.box-header -->
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    @php
                             if(!empty(request('back_url')))
                                {
                               $back_url= request('back_url');
                                }else {
                                    $back_url= route('sp.tickets.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right">Request Campaign</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">

   <form method="post" action="{{route('pmm.products.request')}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf

   <div class="container form-container">


   <div class="row g-4">
        <div class="col-md-12">
            <label for="fiscalCode" class="form-label">Product link</label>
            <input  type="text" name="link" required class="form-control" id="fiscalCode">
        </div>
         <div class="col-md-12">
            <label for="fiscalCode" class="form-label">Payout expectation</label>
            <input  type="text" name="payout" required class="form-control" id="fiscalCode">
        </div>

         <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Destination country</label>
            <input  type="text" name="country" required class="form-control" id="fiscalCode">
        </div>

        <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Expected Traffic</label>
            <input  type="text" name="trafic" required class="form-control" id="fiscalCode">
        </div>



    </div>

    <div class="row">
                <div class="col-md-12">
            <label for="fiscalCode" class="form-label">Product details</label>
          <textarea class="form-control" name="detail" style="height: 200px" required></textarea>
        </div>
    </div>
       </div>

                <br>
                <br>


            <div class="row gap-1">

        <div class="col-md-8"></div>
        <div class="col-md-4">
         <button class="btn btn-primary btn-sm form-control" id="btn_submit" style="border-radius: 5px;" onclick="$('#projectForm').submit()">
            Create & Continue
         </button>
        </div>

      </div>


         </form>


            </div>


            </div>

        </div>
        </div>


      </div>
      <br>



    </div>


<script>


    $(document).ready(function(){


    })

$("#payment_method").on('change', function() {
   if($(this).val()=='Paypal')
   {
    $("#payment_iban").text("Email Paypal")
   }
     if($(this).val()=='Bank')
   {
    $("#payment_iban").text("IBAN")
   }
});

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
             $("#btn_submit").prop("disabled", true);
             $("#btn_submit").text("Saving...");
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#create_sprint_form")[0].reset();
                        window.location.href=response.url

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
@stop

