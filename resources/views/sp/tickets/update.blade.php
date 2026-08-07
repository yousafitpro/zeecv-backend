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
              <a href="{{ $back_url ?? route('sp.tickets.view') }}" >
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <br>
            <br>
            <form method="POST" action="{{ route('sp.tickets.updatePost', $item->id) }}" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf


      <div class="row g-4">
                <div class="col-md-6">
            <label for="fiscalCode" class="form-label">Subject</label>
<input  type="text" name="subject" value="{{$item->subject}}" required class="form-control" id="fiscalCode">
        </div>
        <div class="col-md-3">
            <label for="legalEntity" class="form-label">Priority</label>
            <select  name="priority" required class="form-control">

                     <option value="Low" {{$item->priority=="Low"?'selected':''}}>Low</option>
                     <option value="Medium" {{$item->priority=="Medium"?'selected':''}}>Medium</option>
                     <option value="Urgent" {{$item->priority=="Urgent"?'selected':''}}>Urgent</option>


            </select>
        </div>
                <div class="col-md-3">
            <label for="legalEntity" class="form-label">Status</label>
            <select  name="status" required class="form-control">

                     <option value="Created" {{$item->status=="Created"?'selected':''}}>Created</option>
                     <option value="Open" {{$item->status=="Open"?'selected':''}}>Open</option>
                     <option value="Closed" {{$item->status=="Closed"?'selected':''}}>Closed</option>


            </select>
        </div>




    </div>

    <div class="row">
                <div class="col-md-12">
            <label for="fiscalCode" class="form-label">Description</label>
          <textarea class="form-control" name="description" style="height: 200px" required>{{$item->description}}</textarea>
        </div>
    </div>

                <br>
                <br>

                <!-- Submit -->
                @if(is_has_permission('sp.tickets.update'))
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
