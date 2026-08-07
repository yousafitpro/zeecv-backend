@extends('layout.master')
@section('title',"HR | Tutorials")
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
                                    $back_url= route('blog.posts.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right">Tutorial Details</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">
<div class="row">
                        <div class="col-md-12">
                            <label for="productLink"><strong>Page Link <i class="fas fa-link"></i></strong></label>
                            <div class="input-group">
                            <input type="text"
                                id="productLink"
                                class="form-control"
                                value="{{route('tutorial.show',$item->slug)}}"
                                readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#productLink')">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
 <form method="post" action="{{route('blog.posts.updatePost',$item->id)}}" id="create_sprint_form" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
            @csrf

                <div class="row">
                    <div class="col-md-10 div-sm">
                        <label>Title</label>
                        <input  class="form-control" value="{{$item->title}}"  required  name="title">
                    </div>
                     <div class="col-md-2">
                        <img src="{{$item->attachment->file_url??''}}" id="attachment" style="width:100%;border-radius:10px">
                    </div>


                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 div-sm">
                        <label>Placement</label>
                        <select name="placement" class="form-control" >
                        <option value="Website" {{$item->placement=='Website'?'selected':''}}>Website</option>
                        <option value="Support" {{$item->placement=='Support'?'selected':''}}>Support</option>

                        </select>
                    </div>
                    <div class="col-md-3 div-sm">
                        <label>Expiration Date</label>
                        <input class="form-control"
                            value="{{ \Carbon\Carbon::parse($item->exp_date)->format('Y-m-d') }}"
                            type="date"
                            name="exp_date">

                    </div>
                    <div class="col-md-3 div-sm">
                        <label>Status</label>
                        <select name="status" class="form-control" >
                        <option value="active" {{$item->status=='active'?'selected':''}} >Active</option>
                        <option value="inactive" {{$item->status=='inactive'?'selected':''}} >In Active</option>

                        </select>
                    </div>
                <div class="col-md-3 div-sm">
                        <label>Department</label>
                        <select name="department" class="form-control" >
                        @foreach ($departments as $dp)
                            <option value="{{$dp}}" {{$dp==$item->department?'selected':''}} >{{$dp}}</option>
                        @endforeach


                        </select>
                    </div>
                </div>
             <br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea id="page_content" style="width: 100%;height:200px" class="form-control" name="description" >{{$item->description}}</textarea>
                    </div>

                </div>       <br>

                <div class="row">
                    <div class="col-md-12">
             <input type="file"
               name="attachment"
               class="form-control form-control-sm ps-5"
               style="height: 42px;">
                    </div>
                </div>


                <br>


            <div class="row gap-1">

        <div class="col-md-8"></div>
        <div class="col-md-4">
         <button class="btn btn-primary btn-sm form-control" style="border-radius: 5px;" onclick="$('#projectForm').submit()">
            Update
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

function copyToClipboard(selector) {
    const input = document.querySelector(selector);
    if (!input) return;

    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices

    try {
        const successful = document.execCommand('copy');
        if (successful) {

        } else {

        }
    } catch (err) {
        swal("Error", "Clipboard copy failed", "error");
    }
}

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

