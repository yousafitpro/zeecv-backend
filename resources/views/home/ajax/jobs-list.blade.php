     <!-- Apply Confirmation Modal -->
<div class="modal fade" id="applyConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-question-circle fs-1 text-warning mb-3 d-block"></i>
                <h6>Have you successfully applied for this job?</h6>
                <p class="text-muted small">This will mark the job as applied in your profile.</p>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                <button type="button" onclick="applyJob(this)" class="btn btn-success" id="confirmApplyYes">
                    Yes, I applied
                </button>
            </div>
        </div>
    </div>
</div>
     <!-- Job Detail Modal -->
<div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobDetailModalLabel">Job Details</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="jobDetailModalBody">
                <!-- Content will be loaded here -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading job details…</p>
                </div>
            </div>
        </div>
    </div>
</div>
                @forelse($list as $job)


                        <article class="job_container_outer_card">


                            {{-- Card Top --}}

                            <div class="job_container_outer_card_top">


                                <div class="job_container_outer_logo">
                                @if (!empty($job->user))
                                <img src="{{$job->user->avatar()}}" style="width: 100%">
                                @else
                                {{ strtoupper(
                                        substr(
                                            $job->company ?? $job->title ?? 'J',
                                            0,
                                            1
                                        )
                                    ) }}
                                @endif
                                    

                                </div>


                                <div class="job_container_outer_main">


                                    <h3 class="job_container_outer_title">

                                        @if (auth()->check())
                                            <a
                                            href="{{ route('home.jobs.single' , $job->slug) }}"
                                            class="job_container_outer_title_link"
                                        >

                                            {{ $job->title }}

                                        </a>
                                        @else
                                        <a
                                            href="javascrip:void" data-toggle="modal" data-target="#loginRegModal"
                                            class="job_container_outer_title_link"
                                        >

                                            {{ $job->title }}

                                        </a>
                                        @endif

                                    </h3>


                                    @if(!empty($job->company_name) && $job->company_name!='name')

                                        <div class="job_container_outer_company">

                                            <i class="bi bi-building"></i>

                                            {{ $job->company_name }}

                                        </div>

                                    @endif


                                </div>

                            </div>


                            {{-- Metadata --}}

                            <div class="job_container_outer_meta">


                                @if(!empty($job->location))

                                    <span class="job_container_outer_meta_item">

                                        <i class="bi bi-geo-alt"></i>

                                        {{ $job->location }}

                                    </span>

                                @endif


                                @if(!empty($job->job_created_at))

                                    <span class="job_container_outer_meta_item">

                                        <i class="bi bi-clock"></i>

                                      {{ \Carbon\Carbon::parse(
                                            $job->job_created_at
                                        )->format('M d, Y') }}

                                    </span>

                                @endif


                            @if(!empty($job->job_types))
                                <span class="job_container_outer_meta_item job_container__jobs_type_tag">
                                    <i class="bi bi-briefcase"></i>

                                    {{ str_replace(',', ', ', $job->job_types) }}
                                </span>
                            @endif


                            </div>


                            {{-- Description --}}

                            @if(!empty($job->description))

                                <div class="job_container_outer_description">

                                    {{ \Illuminate\Support\Str::limit(
                                        strip_tags(html_entity_decode($job->description)),
                                        260
                                    ) }}

                                </div>

                            @endif


                            {{-- Tags --}}

                            @if(!empty($job->tags))

                                @php

                                    $tags = is_array($job->tags)
                                        ? $job->tags
                                        : explode(',', $job->tags);

                                @endphp


                                <div class="job_container_outer_tags">

                                    @foreach(array_slice($tags, 0, 6) as $tag)

                                        @if(trim($tag) !== '')

                                            <span class="job_container_outer_tag">

                                                {{ trim($tag) }}

                                            </span>

                                        @endif

                                    @endforeach

                                </div>

                            @endif


                            {{-- Footer --}}

                            <div class="job_container_outer_footer">


                                <span class="job_container_outer_status">

                                    <i class="bi bi-check-circle"></i>
                                      @if(!empty($job->appliedjob))
                                      Applied
                                      @else
                                    Open Position
                                    @endif

                                </span>


                                <div>
                                    @if(empty($job->appliedjob))
                                     @if (auth()->check())
                                         <a
                                    data-job-id="{{ $job->slug }}"
                                    onclick="saveJob(this)"
                                    href="javascript:void"
                                    class="job_container_outer_button mt-1"
                                >
                                    @if(!empty($job->savedjob))
                                    Saved
                                    @else
                                    save
                                    @endif


                                    <i class="bi bi-arrow-right"></i>

                                </a>
                                <a href="javascript:void(0)"
                                    data-url="{{ route('home.jobs.single.shot', $job->slug) }}"
                                    class="job_container_outer_button btn-applied view-job-modal mt-1">
                                       Quick Apply
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                     @else
                                      <a href="javascrip:void" data-toggle="modal" data-target="#loginRegModal"
                                        class="job_container_outer_button mt-1"
                                        >
                                            save

                                        </a>
                                         <a href="javascrip:void" data-toggle="modal" data-target="#loginRegModal"
                                    class="job_container_outer_button  mt-1">
                                       Quick Apply
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                     @endif

                                      
                                  
                                    @endif
                                                                
                                </div>


                            </div>


                        </article>


                    @empty


                        <div class="job_container_outer_empty">


                            <div class="job_container_outer_empty_icon">

                                <i class="bi bi-briefcase"></i>

                            </div>


                            <h3 class="job_container_outer_empty_title">

                                No jobs found

                            </h3>


                            <div class="job_container_outer_empty" style="border: none;padding:30px 30px !important;">
    <p class="job_container_outer_empty_description">
        Please edit your resume first to get personalised job opportunities here.
    </p>

<br>
<a href="{{ route('resume.create') }}" class="btn btn-primary" style="background: var(--primary) !important">
    Edit Resume
</a>


</div>



                        </div>


                    @endforelse


                    {{-- =================================
                         PAGINATION
                    ================================== --}}

                    {{-- @if($list->hasPages())
                        <div class="job_container_outer_pagination"> --}}

                            {{-- <div class="job_container_outer_pagination_info">
                                Showing {{ $list->firstItem() }}–{{ $list->lastItem() }}
                                of {{ $list->total() }} jobs
                            </div> --}}

                            {{-- <div class="job_container_outer_pagination_links"> --}}

                                {{-- Previous --}}
                                {{-- @if($list->onFirstPage())
                                    <span class="job_container_outer_page disabled" >
                                        ‹
                                    </span>
                                @else
                                    <a href="{{ $list->previousPageUrl() }}" class="job_container_outer_page">
                                        ‹
                                    </a>
                                @endif --}}

                                {{-- Pages --}}
                                {{-- @foreach($list->getUrlRange(
                                    max(1, $list->currentPage() - 2),
                                    min($list->lastPage(), $list->currentPage() + 2)
                                ) as $page => $url)

                                    @if($page == $list->currentPage())
                                        <span class="job_container_outer_page active">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="job_container_outer_page">
                                            {{ $page }}
                                        </a>
                                    @endif

                                @endforeach --}}

                                {{-- Next --}}
                                {{-- @if($list->hasMorePages())
                                    <a href="{{ $list->nextPageUrl() }}" class="job_container_outer_page">
                                        ›
                                    </a>
                                @else
                                    <span class="job_container_outer_page disabled">
                                        ›
                                    </span>
                                @endif

                            </div>

                        </div>
                    @endif --}}


<script>
    
function applyJob(el){
        var modal = $('#applyConfirmModal');
        var jobId = modal.data('job-id');

        if (!jobId) {
            alert('Job ID not found.');
            return;
        }
        $(el).html('Wait...');
        $.ajax({
            url: "{{ route('home.jobs.apply.ajax') }}",
            method: 'get',
            data: {
                job_id: jobId,
            },
            success: function(response) {
                modal.modal('hide');
                $('[data-job-id="' + jobId + '"]').closest('.job_container_outer_card')
                    .find('.job_container_outer_status')
                    .html('<i class="bi bi-check-circle-fill text-success"></i> Applied');
                $('[data-job-id="' + jobId + '"]').closest('.job_container_outer_card')
                    .find('.btn-applied')
                    .html('Applied');
               
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Failed to save application status. Please try again.');
            },
            complete: function() {
                // Re-enable button
                $('#confirmApplyYes').prop('disabled', false).text('Yes, I applied');
            }
        });
    }
function saveJob(el) {
    const jobId = el.getAttribute('data-job-id');
    if (!jobId) {
        alert('Job ID not found.');
        return;
    }

    // Determine current state (true = saved, false = not saved)
    const isSaved = el.getAttribute('data-saved') === 'true';
    const action = isSaved ? 'unsave' : 'save';

    // Store original text for error recovery
    const originalText = el.innerText;
    el.innerText = 'Saving…';
    el.disabled = true;

    const url = "{{ route('home.jobs.save') }}";

    $.ajax({
        url: url,
        method: 'get',
        data: {
            job_id: jobId,
            action: action,
        },
        success: function(response) {
            // Toggle the visual state
            if (action === 'save') {
                el.innerText = 'Saved';
                el.setAttribute('data-saved', 'true');
                el.classList.add('saved');
            } else {
                el.innerText = 'Save';
                el.setAttribute('data-saved', 'false');
                el.classList.remove('saved');
            }
            el.disabled = false;
        },
        error: function(xhr) {
            // Revert to original text and re-enable
            el.innerText = originalText;
            el.disabled = false;
            console.error('Error:', xhr.responseText);
            alert('Action failed. Please try again.');
        }
    });
}
$(document).ready(function() {
    // At the very top of your script (before any AJAX)
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
});
    // Handle View Job modal
    $(document).on('click', '.view-job-modal', function(e) {
        e.preventDefault();

        var url = $(this).data('url');
        var modal = $('#jobDetailModal');
        var modalBody = $('#jobDetailModalBody');

        // Show loading state
        modalBody.html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading job details…</p>
            </div>
        `);

        // Open modal (it will show the loading spinner)
        modal.modal('show');

        // Fetch the job detail page
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $("#jobDetailModalBody").html(response)

                // Re-initialize any scripts inside the loaded content if needed
                // e.g., if you have Bootstrap tooltips, datepickers, etc.
            },
            error: function(xhr, status, error) {
                modalBody.html(`
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Failed to load job details. Please try again.
                    </div>
                `);
                console.error('AJAX Error:', error);
            }
        });
    });

    // Optional: clear modal content on hide to avoid stale data
    $('#jobDetailModal').on('hidden.bs.modal', function() {
        $('#jobDetailModalBody').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading job details…</p>
            </div>
        `);
    });
});
$(document).ready(function() {

    // Handle "Yes, I applied" click


    // Optional: Clear data when modal is closed
    $('#applyConfirmModal').on('hidden.modal', function() {
        $(this).data('job-id', null);
        $('#confirmApplyYes').prop('disabled', false).text('Yes, I applied');
    });

});
</script>
