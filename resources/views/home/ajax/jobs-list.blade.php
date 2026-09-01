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

                                        <a
                                            href="{{ route('home.jobs.single' , $job->slug) }}"
                                            class="job_container_outer_title_link"
                                        >

                                            {{ $job->title }}

                                        </a>

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

                                    Open Position

                                </span>


                                <div>
                                     <a
                                    data-job-id="{{ $job->slug }}"
                                    onclick="saveJob(this)"
                                    href="javascript:void"
                                    class="job_container_outer_button"
                                >
                                    @if(!empty($job->savedjob))
                                    Saved
                                    @else
                                    save
                                    @endif

                                    <i class="bi bi-arrow-right"></i>

                                </a>
                                    <a
                                    href="{{ route('home.jobs.single',$job->slug) }}"
                                    
                                    class="job_container_outer_button"
                                    target="_blank"
                                >

                                    View Job

                                    <i class="bi bi-arrow-right"></i>

                                </a>
                               
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


                            <p class="job_container_outer_empty_description">

                                We couldn't find any job opportunities
                                at the moment. Please check again soon.

                            </p>


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
        method: 'POST',
        data: {
            job_id: jobId,
            action: action,
            _token: "{{ csrf_token() }}"
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
</script>