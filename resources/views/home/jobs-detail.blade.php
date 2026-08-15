@extends('layout.home')

@section('meta_tags')

    <title>{{ $job->title }} | ZeeCV Jobs</title>

    <meta name="description"
          content="ZeeCV Job - Details {{ \Illuminate\Support\Str::limit(strip_tags($job->description ?? 'Find the latest job opportunity on ZeeCV.'), 155) }}">

    <meta name="robots" content="index, follow">

    @if(!empty($job->job_created_at))
        <meta property="article:published_time"
              content="{{ \Carbon\Carbon::parse($job->job_created_at)->toIso8601String() }}">
    @endif

@endsection


@section('content')

<style>
    /* =========================================
   RANDOM JOBS
========================================= */

.job_container_outer_random_jobs {
    margin-top: 35px;
}

.job_container_outer_random_jobs_header {
    margin-bottom: 18px;
}

.job_container_outer_random_jobs_title {
    margin: 0 0 5px;
    color: #111827;
    font-size: 22px;
    font-weight: 700;
}

.job_container_outer_random_jobs_subtitle {
    margin: 0;
    color: #94a3b8;
    font-size: 13px;
}

.job_container_outer_random_jobs_grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.job_container_outer_random_job_card {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 20px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    text-decoration: none;
    transition: all .2s ease;
}

.job_container_outer_random_job_card:hover {
    border-color: #cbd5e1;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(15, 23, 42, .07);
}

.job_container_outer_random_job_top {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 15px;
}

.job_container_outer_random_job_logo {
    width: 45px;
    height: 45px;
    min-width: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    color: #334155;
    font-size: 17px;
    font-weight: 700;
}

.job_container_outer_random_job_content {
    min-width: 0;
}

.job_container_outer_random_job_title {
    margin: 0;
    color: #111827;
    font-size: 15px;
    line-height: 1.4;
    font-weight: 700;
}

.job_container_outer_random_job_company {
    margin-top: 5px;
    color: #64748b;
    font-size: 12px;
}

.job_container_outer_random_job_meta {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: auto;
    padding-top: 15px;
}

.job_container_outer_random_job_meta_item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #64748b;
    font-size: 11px;
}

.job_container_outer_random_job_meta_item i {
    font-size: 11px;
}

.job_container_outer_random_job_arrow {
    margin-top: 15px;
    padding-top: 13px;
    border-top: 1px solid #f1f5f9;
    color: #16a34a;
    font-size: 12px;
    font-weight: 600;
}

@media (max-width: 991px) {
    .job_container_outer_random_jobs_grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .job_container_outer_random_jobs_grid {
        grid-template-columns: 1fr;
    }

    .job_container_outer_random_jobs_title {
        font-size: 20px;
    }
}

    /* =========================================
       MAIN
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
        padding: 55px 0;
    }

    .job_container_outer_hero_inner {
        max-width: 900px;
    }


    /* =========================================
       BREADCRUMB
    ========================================= */

    .job_container_outer_breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;

        margin-bottom: 25px;

        color: #94a3b8;

        font-size: 13px;
    }

    .job_container_outer_breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }

    .job_container_outer_breadcrumb a:hover {
        color: #16a34a;
    }


    .job_container_outer_breadcrumb_separator {
        color: #cbd5e1;
    }


    /* =========================================
       HERO JOB
    ========================================= */

    .job_container_outer_hero_job {
        display: flex;
        align-items: flex-start;

        gap: 20px;
    }


    .job_container_outer_logo {
        width: 68px;
        height: 68px;

        min-width: 68px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #f1f5f9;

        border: 1px solid #e2e8f0;
        border-radius: 14px;

        color: #334155;

        font-size: 25px;
        font-weight: 700;
    }


    .job_container_outer_hero_content {
        min-width: 0;
    }


    .job_container_outer_title {
        margin: 0 0 9px;

        color: #111827;

        font-size: 34px;
        line-height: 1.25;

        font-weight: 750;

        letter-spacing: -.6px;
    }


    .job_container_outer_company {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 15px;

        color: #64748b;

        font-size: 14px;
    }


    .job_container_outer_company_item {
        display: inline-flex;
        align-items: center;

        gap: 6px;
    }


    .job_container_outer_company_item i {
        color: #94a3b8;
    }


    /* =========================================
       TAGS
    ========================================= */

    .job_container_outer_tags {
        display: flex;
        flex-wrap: wrap;

        gap: 8px;

        margin-top: 22px;
    }


    .job_container_outer_tag {
        padding: 6px 11px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;
        border-radius: 6px;

        color: #475569;

        font-size: 12px;
        font-weight: 500;
    }


    /* =========================================
       MAIN SECTION
    ========================================= */

    .job_container_outer_section {
        padding: 35px 0 80px;
    }


    .job_container_outer_layout {
        display: grid;

        grid-template-columns: minmax(0, 1fr) 310px;

        gap: 25px;

        align-items: start;
    }


    /* =========================================
       CONTENT CARD
    ========================================= */

    .job_container_outer_content {
        background: #ffffff;

        border: 1px solid #e5e7eb;
        border-radius: 14px;

        overflow: hidden;
    }


    .job_container_outer_content_header {
        padding: 22px 25px;

        border-bottom: 1px solid #f1f5f9;
    }


    .job_container_outer_content_header_title {
        margin: 0;

        color: #111827;

        font-size: 19px;
        font-weight: 700;
    }


    .job_container_outer_description {
        padding: 25px;

        color: #475569;

        font-size: 14px;
        line-height: 1.8;
    }


    /* =========================================
       DESCRIPTION HTML
    ========================================= */

    .job_container_outer_description h1,
    .job_container_outer_description h2,
    .job_container_outer_description h3,
    .job_container_outer_description h4 {
        color: #111827;

        line-height: 1.4;

        margin-top: 28px;
        margin-bottom: 12px;
    }


    .job_container_outer_description h1 {
        font-size: 24px;
    }


    .job_container_outer_description h2 {
        font-size: 21px;
    }


    .job_container_outer_description h3 {
        font-size: 18px;
    }


    .job_container_outer_description h4 {
        font-size: 16px;
    }


    .job_container_outer_description h1:first-child,
    .job_container_outer_description h2:first-child,
    .job_container_outer_description h3:first-child {
        margin-top: 0;
    }


    .job_container_outer_description p {
        margin: 0 0 16px;
    }


    .job_container_outer_description ul,
    .job_container_outer_description ol {
        margin: 0 0 20px;

        padding-left: 22px;
    }


    .job_container_outer_description li {
        margin-bottom: 8px;
    }


    .job_container_outer_description a {
        color: #16a34a;

        text-decoration: underline;
    }


    .job_container_outer_description strong,
    .job_container_outer_description b {
        color: #334155;
        font-weight: 700;
    }


    /* =========================================
       SIDEBAR
    ========================================= */

    .job_container_outer_sidebar {
        position: sticky;
        top: 25px;
    }


    /* =========================================
       APPLY CARD
    ========================================= */

    .job_container_outer_apply {
        background: #ffffff;

        border: 1px solid #e5e7eb;
        border-radius: 14px;

        padding: 22px;
    }


    .job_container_outer_apply_button {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 13px 18px;

        background: #111827;

        border-radius: 8px;

        color: #ffffff !important;

        font-size: 14px;
        font-weight: 700;

        text-decoration: none;

        transition: all .2s ease;
    }


    .job_container_outer_apply_button:hover {
        background: #16a34a;

        color: #ffffff !important;
    }


    .job_container_outer_apply_note {
        margin: 12px 0 0;

        color: #94a3b8;

        font-size: 12px;

        line-height: 1.6;

        text-align: center;
    }


    /* =========================================
       JOB INFORMATION
    ========================================= */

    .job_container_outer_info {
        margin-top: 15px;

        background: #ffffff;

        border: 1px solid #e5e7eb;
        border-radius: 14px;

        padding: 22px;
    }


    .job_container_outer_info_title {
        margin: 0 0 18px;

        color: #111827;

        font-size: 16px;

        font-weight: 700;
    }


    .job_container_outer_info_item {
        display: flex;

        gap: 12px;

        padding: 13px 0;

        border-bottom: 1px solid #f1f5f9;
    }


    .job_container_outer_info_item:last-child {
        border-bottom: 0;

        padding-bottom: 0;
    }


    .job_container_outer_info_icon {
        width: 34px;
        height: 34px;

        min-width: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #f8fafc;

        border-radius: 8px;

        color: #64748b;

        font-size: 14px;
    }


    .job_container_outer_info_content {
        min-width: 0;
    }


    .job_container_outer_info_label {
        display: block;

        margin-bottom: 3px;

        color: #94a3b8;

        font-size: 11px;

        font-weight: 600;

        text-transform: uppercase;

        letter-spacing: .3px;
    }


    .job_container_outer_info_value {
        display: block;

        color: #334155;

        font-size: 13px;

        line-height: 1.5;
    }


    /* =========================================
       RESUME CTA
    ========================================= */

    .job_container_outer_resume {
        margin-top: 15px;

        padding: 22px;

        background: #111827;

        border-radius: 14px;

        color: #ffffff;
    }


    .job_container_outer_resume_icon {
        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 9px;

        background: rgba(255,255,255,.1);

        font-size: 17px;
    }


    .job_container_outer_resume_title {
        margin: 0 0 8px;

        color: #ffffff;

        font-size: 17px;

        font-weight: 700;
    }


    .job_container_outer_resume_description {
        margin: 0 0 17px;

        color: #cbd5e1;

        font-size: 12px;

        line-height: 1.7;
    }


    .job_container_outer_resume_button {
        display: flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        padding: 10px 14px;

        background: #ffffff;

        border-radius: 8px;

        color: #111827;

        font-size: 12px;

        font-weight: 700;

        text-decoration: none;
    }


    .job_container_outer_resume_button:hover {
        color: #16a34a;
    }


    /* =========================================
       SOURCE
    ========================================= */

    .job_container_outer_source {
        margin-top: 20px;

        padding-top: 18px;

        border-top: 1px solid #f1f5f9;

        color: #94a3b8;

        font-size: 12px;

        line-height: 1.6;
    }


    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 991px) {

        .job_container_outer_layout {
            grid-template-columns: 1fr;
        }

        .job_container_outer_sidebar {
            position: static;
        }

    }


    @media (max-width: 576px) {

        .job_container_outer_hero {
            padding: 35px 0;
        }

        .job_container_outer_hero_job {
            gap: 13px;
        }

        .job_container_outer_logo {
            width: 50px;
            height: 50px;

            min-width: 50px;

            border-radius: 10px;

            font-size: 19px;
        }

        .job_container_outer_title {
            font-size: 25px;
        }

        .job_container_outer_company {
            gap: 9px;

            font-size: 13px;
        }

        .job_container_outer_section {
            padding: 25px 0 60px;
        }

        .job_container_outer_description {
            padding: 20px;

            font-size: 14px;
        }

        .job_container_outer_content_header {
            padding: 18px 20px;
        }

    }

</style>


<div class="job_container_outer" style="background: transparent">


    {{-- =========================================
         HERO
    ========================================== --}}

    <section class="job_container_outer_hero">

        <div class="container">

            <div class="job_container_outer_hero_inner">


                {{-- Breadcrumb --}}

                <div class="job_container_outer_breadcrumb">

                    <a href="{{ route('home.jobs') }}">
                        Jobs
                    </a>

                    <span class="job_container_outer_breadcrumb_separator">
                        /
                    </span>

                    <span>
                        {{ \Illuminate\Support\Str::limit($job->title, 60) }}
                    </span>

                </div>


                {{-- Job Header --}}

                <div class="job_container_outer_hero_job">


                    {{-- Company Logo --}}

                    <div class="job_container_outer_logo">

                        {{ strtoupper(
                            substr(
                                $job->company ?? $job->title ?? 'J',
                                0,
                                1
                            )
                        ) }}

                    </div>


                    <div class="job_container_outer_hero_content">


                        <h1 class="job_container_outer_title">

                            {{ $job->title }}

                        </h1>


                        <div class="job_container_outer_company">


                            @if(!empty($job->company))

                                <span class="job_container_outer_company_item">

                                    <i class="bi bi-building"></i>

                                    {{ $job->company }}

                                </span>

                            @endif


                            @if(!empty($job->location))

                                <span class="job_container_outer_company_item">

                                    <i class="bi bi-geo-alt"></i>

                                    {{ $job->location }}

                                </span>

                            @endif


                            @if(!empty($job->job_created_at))

                                <span class="job_container_outer_company_item">

                                    <i class="bi bi-clock"></i>

                                    {{ \Carbon\Carbon::parse(
                                        $job->job_created_at
                                    )->diffForHumans() }}

                                </span>

                            @endif
                            @if(!empty($job->job_types))
    <span class="job_container_outer_meta_item job_container__jobs_type_tag">
        <i class="bi bi-briefcase"></i>

        {{ str_replace(',', ', ', $job->job_types) }}
    </span>
@endif


                        </div>


                        {{-- Tags --}}

                        @if(!empty($job->tags))

                            @php

                                $tags = is_array($job->tags)
                                    ? $job->tags
                                    : explode(',', $job->tags);

                            @endphp


                            <div class="job_container_outer_tags">

                                @foreach($tags as $tag)

                                    @if(trim($tag) !== '')

                                        <span class="job_container_outer_tag">

                                            {{ trim($tag) }}

                                        </span>

                                    @endif

                                @endforeach

                            </div>

                        @endif


                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================
         CONTENT
    ========================================== --}}

    <section class="job_container_outer_section">

        <div class="container" style="padding-left: 0px;padding-right: 0px">


            <div class="job_container_outer_layout">


                {{-- =====================================
                     JOB DESCRIPTION
                ====================================== --}}

                <main class="job_container_outer_content">


                    <div class="job_container_outer_content_header">

                        <h2 class="job_container_outer_content_header_title">

                            Job Description

                        </h2>

                    </div>


                    <div class="job_container_outer_description">

                       {!! html_entity_decode($job->description) !!}


                    </div>


                </main>


                {{-- =====================================
                     SIDEBAR
                ====================================== --}}

                <aside class="job_container_outer_sidebar">


                    {{-- Apply --}}

                    <div class="job_container_outer_apply">


                        @if(!empty($job->url))

                            <a
                                href="{{ $job->url }}"
                                target="_blank"
                                rel="nofollow noopener"
                                class="job_container_outer_apply_button"
                            >

                                Apply for this Job

                                <i class="bi bi-box-arrow-up-right"></i>

                            </a>

                        @else

                            <a
                                href="#"
                                class="job_container_outer_apply_button"
                            >

                                Apply for this Job

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        @endif


                        <p class="job_container_outer_apply_note">

                            You will be redirected to the original
                            job posting to apply.

                        </p>


                    </div>


                    {{-- Job Information --}}

                    <div class="job_container_outer_info">


                        <h3 class="job_container_outer_info_title">

                            Job Information

                        </h3>


                        @if(!empty($job->company))

                            <div class="job_container_outer_info_item">

                                <div class="job_container_outer_info_icon">

                                    <i class="bi bi-building"></i>

                                </div>


                                <div class="job_container_outer_info_content">

                                    <span class="job_container_outer_info_label">
                                        Company
                                    </span>

                                    <span class="job_container_outer_info_value">
                                        {{ $job->company }}
                                    </span>

                                </div>

                            </div>

                        @endif


                        @if(!empty($job->location))

                            <div class="job_container_outer_info_item">

                                <div class="job_container_outer_info_icon">

                                    <i class="bi bi-geo-alt"></i>

                                </div>


                                <div class="job_container_outer_info_content">

                                    <span class="job_container_outer_info_label">
                                        Location
                                    </span>

                                    <span class="job_container_outer_info_value">
                                        {{ $job->location }}
                                    </span>

                                </div>

                            </div>

                        @endif


                        @if(!empty($job->job_created_at))

                            <div class="job_container_outer_info_item">

                                <div class="job_container_outer_info_icon">

                                    <i class="bi bi-calendar3"></i>

                                </div>


                                <div class="job_container_outer_info_content">

                                    <span class="job_container_outer_info_label">
                                        Posted
                                    </span>

                                    <span class="job_container_outer_info_value">

                                        {{ \Carbon\Carbon::parse(
                                            $job->job_created_at
                                        )->format('M d, Y') }}

                                    </span>

                                </div>

                            </div>

                        @endif


                        @if(!empty($job->source))

                            <div class="job_container_outer_info_item">

                                <div class="job_container_outer_info_icon">

                                    <i class="bi bi-globe2"></i>

                                </div>


                                <div class="job_container_outer_info_content">

                                    <span class="job_container_outer_info_label">
                                        Source
                                    </span>

                                    <span class="job_container_outer_info_value">

                                        {{ ucfirst($job->source) }}

                                    </span>

                                </div>

                            </div>

                        @endif


                    </div>


                    {{-- Resume CTA --}}

                    <div class="job_container_outer_resume">


                        <div class="job_container_outer_resume_icon">

                            <i class="bi bi-stars"></i>

                        </div>


                        <h3 class="job_container_outer_resume_title">

                            Stand Out From Other Candidates

                        </h3>


                        <p class="job_container_outer_resume_description">

                            Create a professional, ATS-friendly resume
                            that helps you make a stronger impression
                            on employers.

                        </p>


                        <a
                            href="{{ url('/signup') }}"
                            class="job_container_outer_resume_button"
                        >

                            Create Your Resume

                            <i class="bi bi-arrow-right"></i>

                        </a>


                    </div>


                    {{-- Source --}}

                    @if(!empty($job->source))

                        <div class="job_container_outer_source">

                            This job opportunity was sourced from
                            <strong>{{ ucfirst($job->source) }}</strong>.

                        </div>

                    @endif


                </aside>


            </div>

        </div>

    </section>
{{-- =========================================
     RANDOM / RELATED JOBS
========================================== --}}

@if(!empty($random_jobs) && count($random_jobs) > 0)

    <section class="job_container_outer_random_jobs">

        <div class="container">

            <div class="job_container_outer_random_jobs_header">

                <h2 class="job_container_outer_random_jobs_title">
                    More Jobs You May Like
                </h2>

                <p class="job_container_outer_random_jobs_subtitle">
                    Explore more opportunities that might be a good fit for you.
                </p>

            </div>


            <div class="job_container_outer_random_jobs_grid">

                @foreach($random_jobs as $random_job)

                    <a
                        href="{{ route('home.jobs.single', $random_job->slug) }}"
                        class="job_container_outer_random_job_card"
                    >

                        <div class="job_container_outer_random_job_top">

                            <div class="job_container_outer_random_job_logo">
                                {{ strtoupper(
                                    substr(
                                        $random_job->company ?? $random_job->title ?? 'J',
                                        0,
                                        1
                                    )
                                ) }}
                            </div>

                            <div class="job_container_outer_random_job_content">

                                <h3 class="job_container_outer_random_job_title">
                                    {{ \Illuminate\Support\Str::limit($random_job->title, 55) }}
                                </h3>

                                @if(!empty($random_job->company))
                                    <div class="job_container_outer_random_job_company">
                                        <i class="bi bi-building"></i>
                                        {{ \Illuminate\Support\Str::limit($random_job->company, 35) }}
                                    </div>
                                @endif

                            </div>

                        </div>


                        <div class="job_container_outer_random_job_meta">

                            @if(!empty($random_job->location))

                                <span class="job_container_outer_random_job_meta_item">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ \Illuminate\Support\Str::limit($random_job->location, 25) }}
                                </span>

                            @endif


                            @if(!empty($random_job->job_types))

                                <span class="job_container_outer_random_job_meta_item">
                                    <i class="bi bi-briefcase"></i>
                                    {{ \Illuminate\Support\Str::limit(str_replace(',', ', ', $random_job->job_types), 25) }}
                                </span>

                            @endif

                        </div>


                        <div class="job_container_outer_random_job_arrow">

                            View Job
                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>

@endif

</div>

@endsection