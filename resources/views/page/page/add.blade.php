@extends('layout.master')
@section('title',"HR | Projects")
@section('content')
<script src="https://cdn.tiny.cloud/1/842w9cxxv1dvk2ckkhu8kav5civsf7g3jlijnox9pkl4wer0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>


   $(document).ready(function(){
         tinymce.init({
        selector: '#page_content',
        height: 500,
        plugins: 'advlist autolink lists link image charmap preview anchor ' +
                 'searchreplace visualblocks code fullscreen ' +
                 'insertdatetime media table code help wordcount',
        toolbar: 'undo redo | formatselect | ' +
                 'bold italic underline strikethrough | link image media | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | removeformat | help',
        menubar: 'file edit view insert format tools table help',
        branding: false // Hide "Powered by TinyMCE"
    });
    })


</script>


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
                                    $back_url= route('pages.page.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right"> Create Page</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">

   <form method="post" action="{{route('pages.page.addPost')}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf
                <div class="row">
                    <div class="col-md-8 div-sm">
                        <label>Title</label>
                        <input  class="form-control"  required  name="title">
                    </div>
    <div class="col-md-4 div-sm">
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
                        <textarea id="page_content" style="width: 100%;height:200px" class="form-control" name="description" ></textarea>
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
                        setTimeout(() => {
                            window.location.href=response.url
                        }, 2000);
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xblog.responseJSON && xblog.responseJSON.message) {
                        errorMessage = xblog.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }
    });
}

</script>

@stop

