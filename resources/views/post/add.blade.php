@extends('layout.master')
@section('title',"HR | Projects")
@section('content')




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
                                    $back_url= route('hr.e.posts.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right"> Create Post</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">

   <form method="post" action="{{route('hr.e.posts.addPost')}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf
                <div class="row">
                    <div class="col-md-12 div-sm">
                        <label>Title</label>
                        <input  class="form-control"  required  name="title">
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 div-sm">
                        <label>Expiration Date</label>
                        <input  class="form-control"  required type="date" name="exp_date">
                    </div>
                    <div class="col-md-6 div-sm">
                        <label>Status</label>
                        <select name="status" class="form-control" >
                        <option value="active" >Active</option>
                        <option value="inactive" >In Active</option>

                        </select>
                    </div>
                </div>
             <br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea style="width: 100%;height:200px" class="form-control" name="description" ></textarea>
                    </div>
                </div>
<br>

                <div class="row">
                    <div class="col-md-12">
             <input type="file"
               name="attachment"
               id="attachment"
               class="form-control form-control-sm ps-5"
               style="height: 42px;">
                    </div>
                </div>

                <br>


            <div class="row gap-1">

        <div class="col-md-8"></div>
        <div class="col-md-4">
         <button class="btn btn-primary btn-sm form-control" style="border-radius: 5px;" onclick="$('#projectForm').submit()">
            Create
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

