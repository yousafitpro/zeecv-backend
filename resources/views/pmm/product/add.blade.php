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
<style>
.select2-selection--multiple
{
height: 15px;
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
                                    $back_url= route('pmm.products.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right"> Add Campaign</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">

   <form method="post" action="{{route('pmm.products.addPost')}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf

     <div class="row">
        <div class="col-md-8">
                           <div class="row">
                    <div class="col-md-6 ">
                        <label>Name</label>
                        <input  class="form-control"  required  name="name">
                    </div>
                    <div class=" col-md-6">
                                <label><strong>Campaign Type</strong></label>
                                <select name="type" class="form-control">
                                    <option value="public" >Public</option>
                                    <option value="private" >Private</option>
                                </select>
                            </div>
                    <div class=" col-md-6 ">
                                <label><strong>Marketers (only when type is private)</strong></label>
                          <select name="marketers[]" class="form-control select2" style="height: 30px !important" placeholder="Search for marketers" multiple>
                            @foreach ($marketers as $mk)
                                <option value="{{ $mk->user->id }}">
                                    {{ $mk->user->name }}
                                </option>
                            @endforeach
                        </select>
                            </div>
                               <div class="col-md-6 ">
                    <label>Commission  Type</label>
                    <select class="form-control" name="commission_type" required>
                        <option value="Percentage">Percentage</option>
                        <option value="Flat">Flat</option>
                    </select>
                </div>
                     <div class="col-md-4 ">
                        <label>Status</label>
                        <select name="status" class="form-control" >
                        <option value="active" >Active</option>
                        <option value="inactive" >In Active</option>

                        </select>
                      </div>
                <div class="col-md-4 ">
                    <label>Price</label>
                    <input  class="form-control" type="number" min="1" step="0.01"   required  name="price">
                </div>
                 <div class="col-md-4 ">
                    <label>Commission </label>
                    <input  class="form-control" type="number" min="0"  max="100" step="0.01"  required  name="commission">
                </div>


                </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <label>Select GLS Profile</label>
                    <select class="form-control" name="sender_pro_id">
                        <option value="">-- Select Address --</option>
                       @foreach ($profils as $profil)
                            <option value="{{$profil->id}}">{{$profil->name}}</option>
                       @endforeach
                       
                    </select>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Short Description</label>
                        <textarea style="width: 100%;height:140px" class="form-control" name="description" ></textarea>
                    </div>
                </div>







            <div class="row gap-1">



      </div>
        </div>
        <div class="col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center">
                            <label for="attachment" style="cursor: pointer;">
                                <img  for="#attachment" id="attachment-preview" src="{{asset('app-icons/avatar.jpg')}}" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                            </label>

                               </div>

                        </div>
                          <div class="row">
                    <div class="col-md-12">
             <input type="file"
               name="attachment"
               id="attachment"
               class="form-control form-control-sm ps-5"
               style="height: 42px;">
                    </div>
                </div>
                    </div>
     </div>
                               <div class="row">
                    <div class="col-md-12">
                        <label>Long Description</label>
                        <textarea style="width: 100%;height:200px" class="form-control" id="page_content" name="long_description" ></textarea>
                    </div>
                </div>
     <hr>
     <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
         <button class="btn btn-primary btn-sm form-control" style="border-radius: 5px;" onclick="$('#projectForm').submit()">
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




    </div>


<script>


    $(document).ready(function(){
document.getElementById('attachment').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('attachment-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = ""; // clear if no file selected
    }
});

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
             $("#mainLoader1").modal('show')
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    $("#mainLoader1").modal('hide')
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
                     $("#mainLoader1").modal('hide')
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

