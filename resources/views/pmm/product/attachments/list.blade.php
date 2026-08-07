@foreach ($list as $item)
    <div class="attachment-item">

            <div class="d-flex align-items-center w-100">
                <i class="fas fa-file-alt"></i>
               <a href="{{$item->appfile->file_url}}" download="{{$item->appfile->original_name}}"> <span class="file-name">{{app_limit_str($item->appfile->original_name,20)}}</span></a>
              <div style="margin-left:5px;">
                <small>{{date_time_readable($item->created_at)}}</small>
            </div>
            </div>
             @if(is_has_permission('pm.task.attachments.remove|pm.task.attachments.full_control'))
            @if ($item->user_id==auth_user_id() || is_has_permission('pm.task.attachments.full_control'))
                <div class="attachment-actions ms-3">
                <button class="btn btn-sm btn-outline-danger" style="text-align: center"  data-file-id="{{$item->id}}" onclick="remove_project_attachment(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            @endif

            @endif
        </div>

@endforeach
