@extends('layout.master')
@section('title',"Ticket")
@section('content')
<style>
    /* Main comment box */
.comment-div {
    background-color: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease-in-out;
}

/* Avatar */
.comment-div img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 1rem;
}

/* Textarea */
.comment-div textarea {
    resize: none;
    font-size: 15px;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #dee2e6;
    box-shadow: none;
    transition: border-color 0.3s;
}

.comment-div textarea:focus {
    border-color: var(--primary);
    outline: none;
}

/* Tagged comment preview box */
#tagged_comment_preview {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    background-color: #f8f9fa;
    border-left: 4px solid var(--primary);
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    position: relative;
    font-size: 14px;
    color: #333;
}

#tagged_comment_preview .tagged-comment-user {
    font-weight: 600;
    color: var(--primary);
}

#tagged_comment_preview .tagged-comment-text {
    color: #555;
    font-size: 13px;
}

#tagged_comment_preview .btn-close {
    position: absolute;
    top: 8px;
    right: 8px;
    background: none;
    border: none;
    font-size: 1rem;
    opacity: 0.5;
    cursor: pointer;
}

#tagged_comment_preview .btn-close:hover {
    opacity: 1;
}

/* Attachment input */
.comment-div .form-label {
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 6px;
    color: #6c757d;
}

.comment-div input[type="file"] {
    height: 42px;
    padding-left: 2.5rem;
    font-size: 14px;
    border-radius: 0.5rem;
}

/* Upload icon inside input */
.comment-div .position-relative .bi-upload {
    font-size: 16px;
    opacity: 0.6;
}

/* Post Button */
#btn-post-comment {
    padding: 0.5rem 1.25rem;
    border-radius: 0.5rem;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

#btn-post-comment:hover {
    background-color: #0b5ed7;
}

    .tagged-comment-preview {
    background-color: #f8f9fa;
    border-left: 4px solid var(--primary);
    padding: 12px 16px;
    border-radius: 6px;
    transition: background-color 0.2s ease;
    cursor: pointer;
    width: 100%;
}

.tagged-comment-preview:hover {
    background-color: #eef3fb;
}

.task-log-card {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: none;
}

.task-log-card-body {
    padding: 1.5rem;
}

.task-log-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.25rem;
    color: #343a40;
}

.task-log-list {
    margin: 0;
    padding: 0;
}

.task-log-item {
    border-bottom: 1px solid #e9ecef;
    padding: 0.75rem 0;
    transition: background-color 0.2s ease-in-out;
}

.task-log-item:last-child {
    border-bottom: none;
}

.task-log-item:hover {
    background-color: #f8f9fa;
    border-radius: 6px;
}

.task-log-content {
    display: flex;
    flex-direction: column;
}

.task-log-summary {
    margin: 0 0 0.25rem 0;
    font-weight: 500;
    color: #212529;
}

.task-log-timestamp {
    color: #6c757d;
    font-size: 0.875rem;
}

.task-log-empty {
    color: #adb5bd;
    font-style: italic;
}
textarea:focus, input[type="file"]:focus {
    box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
    border-color: #80bdff;
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
                <h3 style="text-align: right">ticket</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">
              <div class="row">
            <div class="col-md-12">

            <div class="modal-body">
                <h1>{{$item->subject}}</h1>
                <pre>{{$item->description}}</pre>
<div class="text-center mt-3" id="load-more-wrapper">
    <a class="badge badge-primary" style="cursor: pointer" onclick="loadMoreComments(this)" id="load-more-comments" data-last-id="0">
        Older Comments
    </a>
</div>
         <div id="task_comments_box"></div>
    <div class="row gap-1">
            <div class="col-md-12">
                <hr class="my-4">



<div class="comment-div card border-0 shadow-sm rounded-4 p-3 mb-4" id="comment-div">
    <div class="d-none" id="tagged_comment_preview"></div>
    <div class="d-flex">
        <img src="{{ auth()->user()->avatar() ?? asset('app-icons/avatar.jpg') }}"
             alt="User Avatar"
             class="rounded-circle me-3"
             style="width: 40px; height: 40px; object-fit: cover;margin:5px !important">

        <div class="flex-grow-1">
            <form id="task_comment_form"
                  method="POST"
                  action="{{ route('sp.ticket.chat.comment.add') }}"
                  enctype="multipart/form-data"
                  onsubmit="submitCommentForm(event, this)">


                @csrf
                <input type="hidden" name="tagged_comment_id" id="tagged_comment_id" value="">
                <input type="hidden" name="task_id" value="{{ $item->id }}">
                <input type="hidden" name="project_id" value="{{ $item->project_id }}">
                <input type="hidden" name="mytask_id" value="{{ request('id') }}">

                <div class="mb-2">
                    <textarea name="comment"
                              class="form-control border rounded-3 px-3 py-2"
                              rows="3"
                              placeholder="Leave a thoughtful comment..."
                              style="resize: none; font-size: 15px;"
                              required></textarea>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                <div class="mb-3">
    <label for="attachment" class="form-label fw-medium text-muted d-block mb-1">
        <i class="bi bi-paperclip me-1"></i> Attach a file (optional)
    </label>

    <div class="position-relative">
        <input type="file"
               name="attachment"
               id="attachment"
               class="form-control form-control-sm ps-5"
               style="height: 42px;">

        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted" style="pointer-events: none;">
            <i class="bi bi-upload"></i>
        </span>
    </div>
</div>


                    <button type="submit" class="btn btn-primary btn-sm px-4 " id="btn-post-comment">
                         Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


            </div>


            </div>

        </div>
        </div>


      </div>
      <br>



    </div>


<script>

   window.addEventListener('globalAlert', function(e) {
        if(e.detail.alert.receiver=='{{auth()->user()->id}}')
        {
          if(e.detail.data.ticket_id=='{{$item->id}}' && e.detail.alert.type=='comment_added_on_task')
          {
            getTaskComments('end','',e.detail.data.comment_id)
          }

        }
    });
    $(document).ready(function(){

getTaskComments()
    })
    function loadMoreComments(element)
    {
         last_id=$(element).data("last-id")
         $(element).html("Loading...")
          getTaskComments('start',last_id)
         setTimeout(() => {
           $(element).html("Older Comments")
         }, 2000);
    }
function getTaskComments(append_at='end',last_id='',exact__id='') {

   $.ajax({
                url: "{{route('sp.ticket.chat.comment.view')}}?task_id={{$item->id}}&last_id="+last_id+"&exact__id="+exact__id,
                type: 'post',
                data:{'_token':'{{ csrf_token() }}'} ,
                success: function(response) {
                     if(append_at=='start')
                    {
                        $("#task_comments_box").prepend(response.html)
                    }else
                    {
                         $("#task_comments_box").append(response.html)
                    }
                    if(response.last_id=='NA')
                  {

                  }
                  else if(response.last_id>0)
                  {
                    $("#load-more-comments")
                    .data('last-id', response.last_id)    // update jQuery cache
                    .attr('data-last-id', response.last_id);  // update HTML attribute
                  }else{
                     $("#load-more-comments").addClass('d-none')
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
function replyToComment(element) {
    const message = $(element).data('message');
    const comment_id = $(element).data('comment-id');
  document.getElementById('comment-div').scrollIntoView({ behavior: 'smooth' });
    $("#tagged_comment_id").val(comment_id);

    const previewHTML = `

        <div class="border bg-light rounded-3 p-2 mb-2 position-relative" style="width:100%">
            <i class="fas fa-times" style="float:right;cursor:pointer" onclick="cancelReply()"></i>
            <small class="fw-semibold text-muted">Replying to:</small>
            <div class="text-dark small mb-1">${message}</div>

        </div>
    `;

    $("#tagged_comment_preview").html(previewHTML).removeClass('d-none');
}
function cancelReply() {
    $("#tagged_comment_id").val('');
    $("#tagged_comment_preview").addClass('d-none').empty();
}
function getTaskComments(append_at='end',last_id='',exact__id='') {

   $.ajax({
                url: "{{route('sp.ticket.chat.comment.view')}}?task_id={{$item->id}}&last_id="+last_id+"&exact__id="+exact__id,
                type: 'post',
                data:{'_token':'{{ csrf_token() }}'} ,
                success: function(response) {
                     if(append_at=='start')
                    {
                        $("#task_comments_box").prepend(response.html)
                    }else
                    {
                         $("#task_comments_box").append(response.html)
                    }
                    if(response.last_id=='NA')
                  {

                  }
                  else if(response.last_id>0)
                  {
                    $("#load-more-comments")
                    .data('last-id', response.last_id)    // update jQuery cache
                    .attr('data-last-id', response.last_id);  // update HTML attribute
                  }else{
                     $("#load-more-comments").addClass('d-none')
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
function submitCommentForm(event, formElement) {
    if($("#btn-post-comment").text()=='Posting...')
    {
        return;
    }
    event.preventDefault(); // Always pass event explicitly
     formData = new FormData(formElement);
     $("#btn-post-comment").html("Posting...")
     $("#btn-post-comment").prop('disabled',true)
   $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    $(formElement)[0].reset();
                   if(response.code==1)
                   {
                    getTaskComments('end','',response.item.id)
                     cancelReply()
                   }else if(response.code==0)
                   {
                    swal("Error!", response.message, "error");
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
                    $("#btn-post-comment").html("Post")
                     $("#btn-post-comment").prop('disabled',false)
                }
            });
}
</script>
@stop

