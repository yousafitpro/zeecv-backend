
@foreach ($comments as $comment)
    <div class="row gap-1" id="comment-{{ $comment->id }}">
        <div class="col-md-12">

            <hr class="my-4">
            <i class="fas fa-reply  top-0 end-0 me-1 mt-1 text-primary"
                  style="cursor: pointer;float:right"
                   title="Reply"
                   data-message="{{app_limit_str($comment->comment,50)}}"
                   data-comment-id="{{$comment->id}}"
                   onclick="replyToComment(this)"
                   ></i>
            <div class="d-flex align-items-start position-relative">

                <img src="{{ $comment->user->avatar() ?? asset('app-icons/avatar.jpg') }}"
                     data-user-id="{{ $comment->user->id }}"
                     onclick="hr_show_employee_card(this)"
                     style="width: 40px;cursor: pointer;height:40px;margin:5px !important"
                     alt="User Avatar"
                     class="rounded-circle me-3">

                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark">
                        {{ $comment->user->name }}
                    </h6>

                    {{-- If the comment is a reply to another comment --}}
                  @if ($comment->tagged_comment)
    <div class="tagged-comment-preview mb-3" onclick="goToComment('{{ $comment->tagged_comment->id }}')">
        <div class="d-flex align-items-start">
            <i class="bi bi-chat-left-quote-fill text-secondary me-2 fs-5"></i>
            <div class="flex-grow-1">
                <div class="fw-semibold text-dark">
                    {{ $comment->tagged_comment->user->name }}
                </div>
                <p class="text-muted small">
                    {{ \Illuminate\Support\Str::limit($comment->tagged_comment->comment, 100) }}
                </p>
            </div>
        </div>
    </div>
@endif


                    {{-- Attachment --}}
                    @if (!empty($comment->attachment))
                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                            $extension = strtolower(pathinfo($comment->attachment->original_name, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($extension, $imageExtensions))
                            <div class="mt-2">
                                <a href="{{ $comment->attachment->file_url }}" target="_blank">
                                    <img src="{{ $comment->attachment->file_url }}"
                                         alt="{{ $comment->attachment->original_name }}"
                                         class="img-thumbnail"
                                         style="max-height: 200px; max-width: 100%; object-fit: cover;">
                                </a>
                            </div>
                        @else
                            <div class="mt-2 p-2 bg-light border rounded d-inline-flex align-items-center gap-2" style="max-width: 100%;">
                                <i class="bi bi-paperclip text-primary"></i>
                                <a href="{{ $comment->attachment->file_url }}"
                                   target="_blank"
                                   class="text-decoration-none text-dark fw-medium"
                                   download>
                                    {{ $comment->attachment->original_name }}
                                </a>
                            </div>
                        @endif
                    @endif

                   <pre style="font-family: inherit; background: none; padding: 0; margin: 0; border: none; white-space: pre-wrap; word-wrap: break-word;" class="comment-inner-box">{{ $comment->comment }}
                    </pre>

                    <div style="text-align: right">
                        <small>{{ date_time_readable($comment->created_at) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
