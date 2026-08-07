@extends('layout.master')
@section('title',"Profiles")
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
                                    $back_url= route('pmm.ledger.balance.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right"> Add Balance</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

<div class="modal-body">

   <form method="post" action="{{route('pmm.ledger.balance.addPost')}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf

   <div class="container form-container">
<br>
<br>

         <div class="row g-4">
        <div class="col-md-6">
            <label for="country" class="form-label">User</label>
           <select name="user_id" required class="select2" style="width: 100%">
                <option value="credit">---Select---</option>
                @foreach ($users as $u)
                    <option value="{{$u->id}}">{{$u->email}} (#{{unique_encrypt($u->id)}})</option>
                @endforeach

            </select>
        </div>
        <div class="col-md-6">
            <label for="created_at" class="form-label">Created At</label>
            <input type="datetime-local" required name="created_at" id="created_at" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="form-control">
        </div>

    </div>
        <br>
    <div class="row">
        <div class="col-md-4">
            <label for="country" class="form-label">Credit/Debit</label>
           <select name="type" required class="form-control">
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>

            </select>
        </div>

         <div class="col-md-4">
            <label for="zipCode" class="form-label" id="payment_iban">Amount</label>
            <input type="number" step="0.01" required name="amount" min="0.01" class="form-control">
        </div>
        <div class="col-md-4">
            <label  class="form-label">Narration</label>
           <select name="narration" required class="form-control">
                <option value="default">Default</option>

            </select>
        </div>
    </div>

     <div class="row">
        <div class="col-md-12">
            <label for="zipCode" class="form-label" id="payment_iban">Message</label>
            <textarea style="height: 80px" name="message"   class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="zipCode" class="form-label" id="payment_iban">Internal Note</label>
            <textarea style="height: 120px" name="internal_note"  required class="form-control"></textarea>
        </div>
    </div>
    <br>

       </div>

                <br>
                <br>


            <div class="row gap-1">

        <div class="col-md-8"></div>
        <div class="col-md-4">
         <button class="btn btn-primary btn-sm form-control" id="btn_submit" style="border-radius: 5px;" onclick="$('#projectForm').submit()">
            Confirm
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
                        swal("Success!", response.message, "success");
                        setTimeout(() => {
                            window.location.href="{{route('pmm.ledger.balance.view')}}"
                        }, 2000);

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

