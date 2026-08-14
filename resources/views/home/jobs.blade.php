@extends('layout.home')

@section('meta_tags')

    <title>Latest Jobs - Find Your Next Career Opportunity | ZeeCV</title>

    <meta name="description"
          content="Explore the latest job opportunities from trusted sources. Find jobs that match your skills and career goals with ZeeCV.">

    <meta name="robots" content="index, follow">

@endsection


@section('content')

<style>
    .job_container_outer_pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 35px;
        padding: 20px 0;
        border-top: 1px solid #e5e7eb;
    }

    .job_container_outer_pagination_info {
        font-size: 14px;
        color: #6b7280;
    }

    .job_container_outer_pagination_links {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .job_container_outer_page {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all .2s ease;
    }

    .job_container_outer_page:hover {
        border-color: #111827;
        color: #111827;
        background: #f9fafb;
    }

    .job_container_outer_page.active {
        background: #111827;
        border-color: #111827;
        color: #fff;
    }

    .job_container_outer_page.disabled {
        opacity: .4;
        cursor: not-allowed;
        pointer-events: none;
    }

    @media (max-width: 600px) {

        .job_container_outer_pagination {
            flex-direction: column;
            align-items: center;
        }

        .job_container_outer_pagination_links {
            width: 100%;
            justify-content: center;
        }
    }
        /* =========================================
        MAIN CONTAINER
        ========================================= */

        .job_container_outer {
            background: #f7f8fa;
            min-height: 100vh;
        }


        /* =========================================
        HERO
        ========================================= */

        .job_container_outer_hero {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 65px 0 60px;
        }

        .job_container_outer_hero_content {
            max-width: 760px;
        }

        .job_container_outer_eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 7px 13px;

            background: #f0fdf4;
            border: 1px solid #dcfce7;
            border-radius: 50px;

            color: #15803d;

            font-size: 13px;
            font-weight: 600;

            margin-bottom: 18px;
        }

        .job_container_outer_hero_title {
            margin: 0 0 15px;

            color: #111827;

            font-size: 44px;
            line-height: 1.15;
            font-weight: 750;

            letter-spacing: -1px;
        }

        .job_container_outer_hero_description {
            margin: 0;

            color: #64748b;

            font-size: 17px;
            line-height: 1.7;
        }


        /* =========================================
        SECTION
        ========================================= */

        .job_container_outer_section {
            padding: 45px 0 80px;
        }


        /* =========================================
        HEADER
        ========================================= */

        .job_container_outer_header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 25px;
        }

        .job_container_outer_header_title {
            margin: 0 0 5px;

            color: #111827;

            font-size: 24px;
            line-height: 1.3;
            font-weight: 700;
        }

        .job_container_outer_header_count {
            margin: 0;

            color: #64748b;

            font-size: 14px;
        }


        /* =========================================
        LAYOUT
        ========================================= */

        .job_container_outer_layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 290px;

            gap: 25px;

            align-items: start;
        }


        /* =========================================
        JOB LIST
        ========================================= */

        .job_container_outer_list {
            min-width: 0;
        }


        /* =========================================
        JOB CARD
        ========================================= */

        .job_container_outer_card {
            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-radius: 14px;

            padding: 25px;

            margin-bottom: 16px;

            transition: all .2s ease;
        }

        .job_container_outer_card:hover {
            border-color: #cbd5e1;

            box-shadow: 0 8px 25px rgba(15, 23, 42, .06);

            transform: translateY(-1px);
        }


        /* =========================================
        CARD TOP
        ========================================= */

        .job_container_outer_card_top {
            display: flex;
            align-items: flex-start;

            gap: 15px;
        }


        /* =========================================
        COMPANY LOGO
        ========================================= */

        .job_container_outer_logo {
            width: 52px;
            height: 52px;

            min-width: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #f1f5f9;

            color: #334155;

            font-size: 19px;
            font-weight: 700;
        }


        /* =========================================
        JOB MAIN
        ========================================= */

        .job_container_outer_main {
            min-width: 0;
        }


        .job_container_outer_title {
            margin: 2px 0 7px;

            font-size: 19px;
            line-height: 1.4;

            font-weight: 700;
        }


        .job_container_outer_title_link {
            color: #111827;

            text-decoration: none;

            transition: color .2s ease;
        }


        .job_container_outer_title_link:hover {
            color: #16a34a;
        }


        /* =========================================
        COMPANY
        ========================================= */

        .job_container_outer_company {
            display: flex;
            align-items: center;

            gap: 6px;

            color: #64748b;

            font-size: 14px;
        }


        /* =========================================
        META
        ========================================= */

        .job_container_outer_meta {
            display: flex;
            flex-wrap: wrap;

            gap: 17px;

            margin-top: 19px;

            padding: 13px 0;

            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }


        .job_container_outer_meta_item {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            color: #64748b;

            font-size: 13px;
        }


        .job_container_outer_meta_item i {
            color: #94a3b8;
        }


        /* =========================================
        DESCRIPTION
        ========================================= */

        .job_container_outer_description {
            margin-top: 17px;

            color: #64748b;

            font-size: 14px;
            line-height: 1.7;
        }


        /* =========================================
        TAGS
        ========================================= */

        .job_container_outer_tags {
            display: flex;
            flex-wrap: wrap;

            gap: 7px;

            margin-top: 17px;
        }


        .job_container_outer_tag {
            background: #f8fafc;

            border: 1px solid #e2e8f0;

            color: #475569;

            padding: 5px 10px;

            border-radius: 6px;

            font-size: 12px;
            font-weight: 500;
        }


        /* =========================================
        CARD FOOTER
        ========================================= */

        .job_container_outer_footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-top: 22px;
        }


        .job_container_outer_status {
            display: flex;
            align-items: center;

            gap: 6px;

            color: #16a34a;

            font-size: 13px;
            font-weight: 600;
        }


        .job_container_outer_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 10px 16px;

            border-radius: 8px;

            background: #111827;

            color: #ffffff !important;

            font-size: 13px;
            font-weight: 600;

            text-decoration: none;

            transition: all .2s ease;
        }


        .job_container_outer_button:hover {
            background: #16a34a;

            color: #ffffff !important;
        }


        /* =========================================
        SIDEBAR
        ========================================= */

        .job_container_outer_sidebar {
            position: sticky;
            top: 25px;
        }


        .job_container_outer_sidebar_card {
            background: #111827;

            color: #ffffff;

            border-radius: 16px;

            padding: 25px;
        }


        .job_container_outer_sidebar_icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 18px;

            border-radius: 10px;

            background: rgba(255,255,255,.1);

            color: #ffffff;

            font-size: 18px;
        }


        .job_container_outer_sidebar_title {
            margin: 0 0 10px;

            color: #ffffff;

            font-size: 20px;
            line-height: 1.4;

            font-weight: 700;
        }


        .job_container_outer_sidebar_description {
            margin: 0 0 20px;

            color: #cbd5e1;

            font-size: 13px;
            line-height: 1.7;
        }


        .job_container_outer_sidebar_button {
            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 11px 15px;

            background: #ffffff;

            color: #111827;

            border-radius: 8px;

            font-size: 13px;
            font-weight: 700;

            text-decoration: none;

            transition: all .2s ease;
        }


        .job_container_outer_sidebar_button:hover {
            background: #f0fdf4;

            color: #15803d;
        }


        /* =========================================
        SIDEBAR INFO
        ========================================= */

        .job_container_outer_sidebar_info {
            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 22px;

            margin-top: 15px;
        }


        .job_container_outer_sidebar_info_title {
            margin: 0 0 8px;

            color: #111827;

            font-size: 15px;
            font-weight: 700;
        }


        .job_container_outer_sidebar_info_description {
            margin: 0;

            color: #64748b;

            font-size: 13px;
            line-height: 1.7;
        }


        /* =========================================
        EMPTY
        ========================================= */

        .job_container_outer_empty {
            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 70px 30px;

            text-align: center;
        }


        .job_container_outer_empty_icon {
            width: 60px;
            height: 60px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #f1f5f9;

            color: #64748b;

            font-size: 22px;
        }


        .job_container_outer_empty_title {
            margin: 0 0 7px;

            color: #111827;

            font-size: 19px;
            font-weight: 700;
        }


        .job_container_outer_empty_description {
            margin: 0;

            color: #64748b;

            font-size: 14px;
        }


        /* =========================================
        PAGINATION
        ========================================= */

        .job_container_outer_pagination {
            display: flex;
            justify-content: center;

            margin-top: 30px;
        }


        .job_container_outer_pagination nav {
            display: flex;
            justify-content: center;
        }


        .job_container_outer_pagination .pagination {
            display: flex;
            align-items: center;

            gap: 6px;

            margin: 0;
            padding: 0;

            list-style: none;
        }


        .job_container_outer_pagination .page-item {
            list-style: none;
        }


        .job_container_outer_pagination .page-link {
            min-width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 12px;

            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-radius: 8px;

            color: #475569;

            font-size: 13px;
            font-weight: 600;

            text-decoration: none;

            transition: all .2s ease;
        }


        .job_container_outer_pagination .page-link:hover {
            border-color: #111827;

            color: #111827;
        }


        .job_container_outer_pagination .page-item.active .page-link {
            background: #111827;

            border-color: #111827;

            color: #ffffff;
        }


        .job_container_outer_pagination .page-item.disabled .page-link {
            background: #f8fafc;

            color: #cbd5e1;

            cursor: not-allowed;
        }


        /* =========================================
        RESPONSIVE
        ========================================= */

        @media (max-width: 991px) {

            .job_container_outer_layout {
                grid-template-columns: 1fr;
            }

            .job_container_outer_sidebar {
                display: none;
            }

        }


        @media (max-width: 576px) {

            .job_container_outer_hero {
                padding: 45px 0;
            }

            .job_container_outer_hero_title {
                font-size: 32px;
            }

            .job_container_outer_hero_description {
                font-size: 15px;
            }

            .job_container_outer_section {
                padding: 30px 0 60px;
            }

            .job_container_outer_header_title {
                font-size: 21px;
            }

            .job_container_outer_card {
                padding: 18px;
            }

            .job_container_outer_title {
                font-size: 17px;
            }

            .job_container_outer_meta {
                gap: 10px 15px;
            }

            .job_container_outer_footer {
                flex-direction: column;
                align-items: stretch;
            }

            .job_container_outer_button {
                width: 100%;
            }

        }

</style>


<div class="job_container_outer" style="background: transparent">




    {{-- =========================================
         JOBS
    ========================================== --}}

    <section class="job_container_outer_section" style="background: transparent">
        <form action="{{ route('home.jobs') }}" method="post">
            @csrf
                    <div class="row">
                    <div class="col-md-9">
                        <input class="form-control" value="{{ $input['search']??'' }}" name="search" placeholder="Search here...">
                     
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label>Location</label><br>
                                <select class="form-control select2" name="location">
                                    <option value="">--All--</option>
                                    @foreach ($locations as $lo)
                                      
                                      <option value="{{ $lo }}" {{ $lo == ($input['location'] ?? '') ? 'selected' : '' }}>
                                            {{ $lo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block" style="background:var(--primary) !important" type="submit">Search</button>
                    </div>
                   </div>
                </form>
        <div class="container" style="padding-left:0px;padding-right:0px;">


            {{-- Header --}}

            <div class="job_container_outer_header">

                <div>

                   


                    <p class="job_container_outer_header_count">

                        Showing
                        {{ $list->firstItem() ?? 0 }}
                        -
                        {{ $list->lastItem() ?? 0 }}
                        of
                        {{ $list->total() }}
                        jobs

                    </p>

                </div>

            </div>


            {{-- Main Layout --}}

            <div class="job_container_outer_layout">


                {{-- =====================================
                     JOB LIST
                ====================================== --}}

                <div class="job_container_outer_list">


                    @forelse($list as $job)


                        <article class="job_container_outer_card">


                            {{-- Card Top --}}

                            <div class="job_container_outer_card_top">


                                <div class="job_container_outer_logo">

                                    {{ strtoupper(
                                        substr(
                                            $job->company ?? $job->title ?? 'J',
                                            0,
                                            1
                                        )
                                    ) }}

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


                                    @if(!empty($job->company))

                                        <div class="job_container_outer_company">

                                            <i class="bi bi-building"></i>

                                            {{ $job->company }}

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
                                        )->diffForHumans() }}

                                    </span>

                                @endif


                            @if(!empty($job->job_types))
                                <span class="job_container_outer_meta_item">
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


                                <a
                                    href="{{ route('home.jobs.single',$job->slug) }}"
                                    class="job_container_outer_button"
                                >

                                    View Job

                                    <i class="bi bi-arrow-right"></i>

                                </a>


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

@if($list->hasPages())
    <div class="job_container_outer_pagination">

        <div class="job_container_outer_pagination_info">
            Showing {{ $list->firstItem() }}–{{ $list->lastItem() }}
            of {{ $list->total() }} jobs
        </div>

        <div class="job_container_outer_pagination_links">

            {{-- Previous --}}
            @if($list->onFirstPage())
                <span class="job_container_outer_page disabled">
                    ‹
                </span>
            @else
                <a href="{{ $list->previousPageUrl() }}" class="job_container_outer_page">
                    ‹
                </a>
            @endif

            {{-- Pages --}}
            @foreach($list->getUrlRange(
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

            @endforeach

            {{-- Next --}}
            @if($list->hasMorePages())
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
@endif


                </div>


                {{-- =====================================
                     SIDEBAR
                ====================================== --}}

                <aside class="job_container_outer_sidebar">


                    <div class="job_container_outer_sidebar_card">


                        <span class="job_container_outer_sidebar_icon">

                            <i class="bi bi-stars"></i>

                        </span>


                        <h3 class="job_container_outer_sidebar_title">

                            Create a Better Resume

                        </h3>


                        <p class="job_container_outer_sidebar_description">

                            Stand out from other candidates with a
                            professional, ATS-friendly resume created
                            with ZeeCV.

                        </p>


                        <a
                            href="{{ url('/signup') }}"
                            class="job_container_outer_sidebar_button"
                        >

                            Create My Resume

                            <i class="bi bi-arrow-right"></i>

                        </a>


                    </div>


                    <div class="job_container_outer_sidebar_info">

                        <h4 class="job_container_outer_sidebar_info_title">

                            Looking for a job?

                        </h4>


                        <p class="job_container_outer_sidebar_info_description">

                            Make sure your resume highlights the skills,
                            experience, and achievements employers are
                            looking for.

                        </p>

                    </div>


                </aside>


            </div>

        </div>

    </section>


</div>
<script>
    $(document).ready(function() {
  
     $('.select2').select2();
  
});
</script>
@endsection