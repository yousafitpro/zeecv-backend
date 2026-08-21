@extends('layout.home')

@section('meta_tags')

    @php
        $jobTitle = trim($job->title ?? 'Job Opportunity');

        $company = trim($job->company_name ?? '');

        $location = trim($job->location ?? '');

        $description = strip_tags(
            $job->description
            ?? 'Find the latest job opportunity on ZeeCV.'
        );

        $description = \Illuminate\Support\Str::limit(
            preg_replace('/\s+/', ' ', $description),
            155,
            '...'
        );

        $jobUrl = url()->current();



        $publishedDate = !empty($job->job_created_at)
            ? \Carbon\Carbon::parse($job->job_created_at)
                ->toIso8601String()
            : null;
    @endphp


    <!-- =====================================================
         BASIC SEO
    ====================================================== -->

    <title>
        {{ $jobTitle }}
        @if($company)
            at {{ $company }}
        @endif
        | ZeeCV Jobs
    </title>

    <meta name="description"
          content="{{ $description }}">

    <meta name="robots"
          content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="googlebot"
          content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">


    <!-- =====================================================
         CANONICAL
    ====================================================== -->

    <link rel="canonical"
          href="{{ $jobUrl }}">


    <!-- =====================================================
         OPEN GRAPH
    ====================================================== -->

    <meta property="og:type"
          content="website">

    <meta property="og:title"
          content="{{ $jobTitle }}@if($company) at {{ $company }}@endif | ZeeCV Jobs">

    <meta property="og:description"
          content="{{ $description }}">

    <meta property="og:url"
          content="{{ $jobUrl }}">

    <meta property="og:site_name"
          content="ZeeCV">

    <meta property="og:locale"
          content="en_US">



    <meta property="og:image:alt"
          content="{{ $jobTitle }} - ZeeCV Jobs">

    <meta property="og:image:width"
          content="1200">

    <meta property="og:image:height"
          content="630">


    <!-- =====================================================
         ARTICLE / JOB DATE
    ====================================================== -->

    @if($publishedDate)

        <meta property="article:published_time"
              content="{{ $publishedDate }}">

        <meta property="article:modified_time"
              content="{{ $publishedDate }}">

    @endif


    <!-- =====================================================
         TWITTER / X
    ====================================================== -->

    <meta name="twitter:card"
          content="summary_large_image">

    <meta name="twitter:title"
          content="{{ $jobTitle }}@if($company) at {{ $company }}@endif | ZeeCV Jobs">

    <meta name="twitter:description"
          content="{{ $description }}">



    <meta name="twitter:image:alt"
          content="{{ $jobTitle }} - ZeeCV Jobs">


    <!-- =====================================================
         JOB POSTING STRUCTURED DATA
    ====================================================== -->

@php
    $jobPosting = [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $jobTitle,
        'description' => strip_tags($job->description ?? ''),
        'url' => $jobUrl,

        'identifier' => [
            '@type' => 'PropertyValue',
            'name' => 'ZeeCV',
            'value' => (string) $job->id,
        ],
    ];

    if ($publishedDate) {
        $jobPosting['datePosted'] = $publishedDate;
    }

    if (!empty($job->job_type)) {
        $jobPosting['employmentType'] = $job->job_type;
    }

    if ($company) {
        $jobPosting['hiringOrganization'] = [
            '@type' => 'Organization',
            'name' => $company,
        ];
    }

    if ($location) {
        $jobPosting['jobLocation'] = [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $location,
            ],
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode($jobPosting, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>


    <!-- =====================================================
         BREADCRUMB STRUCTURED DATA
    ====================================================== -->

   <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Jobs',
            'item' => url('/resume-builder/jobs'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $jobTitle,
            'item' => $jobUrl,
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

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
        padding: 55px 0;
        border-left: 5px solid var(--primary)
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
    background: rgba(30, 41, 59, 0.70);
    border: 1px solid #334155;
    color: white;

    padding: 5px 10px;
    border-radius: 20px;

    font-size: 10px;
    font-weight: 500;

    display: inline-block;
    line-height: 1.3;
    transition: all 0.2s ease;
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
        top: 100px;
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
        /* margin-top: 15px; */

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
            border-left: none;
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
            padding: 0px 0 60px;
        }

        .job_container_outer_description {
            padding: 20px;

            font-size: 14px;
        }

        .job_container_outer_content_header {
            padding: 18px 20px;
        }

    }

    /* =========================================
       RESUME TABLE STYLES
    ========================================= */

    .resumes-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: 10px;
    }

    .resumes-table thead th {
        padding: 10px 15px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    .resumes-table tbody td {
        padding: 12px 15px;
        background: white;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .resumes-table tbody tr {
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .resumes-table tbody tr:hover {
        background: #f8fafc;
    }

    .resumes-table tbody tr.selected {
        background: #f0fdf4 !important;
        border-left: 4px solid #22c55e;
    }

    .resumes-table tbody tr.selected td {
        background: #f0fdf4 !important;
    }

    .resume-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .resume-icon img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    .resume-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }

    .resume-id {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .resume-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: #dcfce7;
        color: #166534;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .resume-status-dot {
        width: 6px;
        height: 6px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .resume-date {
        color: #64748b;
        font-size: 13px;
    }

    .resume-date i {
        margin-right: 4px;
        color: #94a3b8;
    }

    .resume-select-radio {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #22c55e;
    }

    .resume-select-label {
        display: inline-block;
        padding: 4px 12px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 12px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .resume-select-label:hover {
        background: #e2e8f0;
    }

    .resume-select-radio:checked + .resume-select-label {
        background: #22c55e;
        color: white;
        border-color: #22c55e;
    }

    .section-divider {
        margin: 25px 0 15px;
        padding: 10px 0;
        /* border-top: 2px solid #e2e8f0;
        border-bottom: 2px solid #e2e8f0;
        background: #f8fafc; */
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }

    .apply_outer_div {
        padding: 30px;
        margin-bottom: 30px;
    }

    .apply_outer_div_header {
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 1px solid #eef0f3;
    }

    .apply_outer_div_header h3 {
        margin: 0 0 6px;
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
    }

    .apply_outer_div_header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .apply_outer_div_group {
        margin-bottom: 20px;
    }

    .apply_outer_div_group label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
    }

    .apply_outer_div_group label span {
        color: #dc3545;
    }

    .apply_outer_div_group .form-control {
        height: 44px;
        border: 1px solid #dce1e7;
        border-radius: 6px;
        font-size: 14px;
        color: #334155;
        box-shadow: none;
        transition: all 0.2s ease;
        width: 100%;
        padding: 0 12px;
    }

    .apply_outer_div_group textarea.form-control {
        height: auto;
        min-height: 150px;
        resize: vertical;
        padding-top: 12px;
    }

    .apply_outer_div_group .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        outline: none;
    }

    .apply_outer_div_submit {
        margin-top: 15px;
    }

    .apply_outer_div_submit .btn {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 12px 30px;
        font-size: 15px;
        font-weight: 600;
        min-width: 180px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .apply_outer_div_submit .btn:hover:not(:disabled) {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(37, 99, 235, 0.18);
    }

    .apply_outer_div_submit .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .apply_outer_div_submit .btn-success {
        background: var(--primary) !important;
    }

    .apply_outer_div_submit .btn-success:hover:not(:disabled) {
        background: var(--primary) !important;
    }

    .selected-resume-label {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background: #f0fdf4;
        border: 1px solid var(--primary);
        border-radius: 6px;
        color: #166534;
        font-size: 13px;
        font-weight: 500;
    }

    .upload-resume-btn {
        padding: 6px 14px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .upload-resume-btn:hover {
        background: #1d4ed8;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 12px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .text-muted {
        color: #94a3b8 !important;
    }

    @media (max-width: 767px) {
        .apply_outer_div {
            padding: 20px 15px;
            margin-top: 15px;
        }

        .apply_outer_div_header h3 {
            font-size: 20px;
        }

        .apply_outer_div_submit .btn {
            width: 100%;
        }

        .resumes-table {
            font-size: 13px;
        }

        .resumes-table thead th,
        .resumes-table tbody td {
            padding: 8px 10px;
        }

        .resume-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .resume-icon img {
            width: 32px;
            height: 32px;
        }
    }
</style>

{{-- <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script> --}}

<div class="job_container_outer" style="background: transparent">

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

                    <div class="apply_outer_div">

                        <div class="apply_outer_div_header">
                            <h3>Apply for this Job</h3>
                            <p>Please complete the form below to submit your application.</p>
                        </div>

                        <form action="{{ route('home.jobs.applyProcess', ['slug' => request('slug')]) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              id="applyForm">

                            @csrf

                            <div class="row">


                                {{-- Cover Letter --}}
                                <div class="col-md-12">
                                    <div class="apply_outer_div_group">
                                        <label for="cover_letter">Cover Letter</label>
                                        <textarea name="cover_letter"
                                                  id="cover_letter"
                                                  rows="7"
                                                  class="form-control"
                                                  placeholder="Write your cover letter..."
                                                  >{{ old('cover_letter') }}</textarea>
                                    </div>
                                </div>

                                {{-- Hidden input for selected resume ID --}}
                                <input type="hidden" name="selected_resume_id" id="selected_resume_id" value="">

                                {{-- Resume Selection --}}
                                <div class="col-md-12">
                                    <div class="apply_outer_div_group">
                                        <label>Select Your Resume <span>*</span></label>
                                        <p class="text-muted" style="font-size: 13px; margin-bottom: 15px;">
                                            Choose one of your saved resumes or upload a new one.
                                        </p>

                                        {{-- Saved Resumes --}}
                                        @if(auth()->user()->resumes->count() > 0)
                                            <div class="section-divider">Resume Builder</div>
                                            <table class="resumes-table">
                                          
                                                <tbody>
                                                    @foreach(auth()->user()->resumes as $resume)
                                                        <tr class="resume-row" data-resume-id="{{ $resume->id }}">
                                                            <td>
                                                                <div class="resume-info">
                                                                    <div class="resume-icon">
                                                                        <img src="{{ auth()->user()->avatar() }}" alt="Profile">
                                                                    </div>
                                                                    <div>
                                                                        <div class="resume-name">
                                                                            {{ $resume->contact->desired_job_title }}
                                                                        </div>
                                                                        <div class="resume-id">
                                                                            Resume #{{ unique_encrypt($resume->id) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="resume-status">
                                                                    <span class="resume-status-dot"></span>
                                                                    Active
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if(isset($resume->created_at))
                                                                    <span class="resume-date">
                                                                        <i class="fa fa-calendar-o"></i>
                                                                        {{ $resume->created_at->format('M d, Y') }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <label class="resume-select-label" for="resume_{{ $resume->id }}">
                                                                    <input type="radio"
                                                                           name="resume_selection"
                                                                           id="resume_{{ $resume->id }}"
                                                                           class="resume-select-radio"
                                                                           value="{{ $resume->id }}">
                                                                    Select
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        {{-- Uploaded Resume --}}
                                        <div class="section-divider" style="margin-top: 20px;">Uploaded Resume</div>
                                        <table class="resumes-table">
                                            <tbody>
                                                <tr class="resume-row" data-resume-id="uploaded">
                                                    <td>
                                                        <div class="resume-info">
                                                            <div class="resume-icon">
                                                                <img src="{{ auth()->user()->avatar() }}" alt="Profile">
                                                            </div>
                                                            <div>
                                                                <div class="resume-name" id="uploaded_resume_name">
                                                                    @if (!empty(auth()->user()->uploadedresume) && !empty(auth()->user()->uploadedresume->attachment))
                                                                        {{ auth()->user()->uploadedresume->attachment->original_name }}
                                                                    @else
                                                                        <span class="text-muted">No uploaded resume</span>
                                                                    @endif
                                                                </div>
                                                                <div class="resume-id">
                                                                    Custom / Uploaded Resume
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="resume-status" id="uploaded_resume_status">
                                                            <span class="resume-status-dot"></span>
                                                            @if (!empty(auth()->user()->uploadedresume))
                                                                Ready
                                                            @else
                                                                Not Uploaded
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary" id="upload_resume_btn">
                                                            <i class="fa fa-upload"></i> Choose File
                                                        </button>
                                                        <input type="file"
                                                               name="resume_file"
                                                               id="resume_file"
                                                               accept=".pdf,.doc,.docx"
                                                               style="display: none;">
                                                        <div id="uploaded_file_name" style="margin-top: 5px; font-size: 12px; color: #64748b;"></div>
                                                    </td>
                                                    <td>
                                                        <label class="resume-select-label" for="resume_uploaded">
                                                            <input type="radio"
                                                                   name="resume_selection"
                                                                   id="resume_uploaded"
                                                                   class="resume-select-radio"
                                                                   value="uploaded"
                                                                   @if(empty(auth()->user()->uploadedresume)) disabled @endif>
                                                            Select
                                                        </label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        {{-- Selected resume display --}}
                                        <div id="selectedResumeDisplay" style="margin-top: 15px;"></div>
                                    </div>
                                </div>

                                {{-- reCAPTCHA --}}
                                {{-- <div class="col-md-12">
                                    <div class="apply_outer_div_group">
                                        <div class="g-recaptcha" 
                                             data-sitekey="{{config('myconfig.Recap.site_key')}}" 
                                             data-callback="recaptcha_successfull_response" 
                                             data-error-callback="data_error_callback" 
                                             data-expired-callback="recaptcha_expired_callback">
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- Submit --}}
                                <div class="col-md-12">
                                    <div class="apply_outer_div_submit">
                                        <button type="submit" class="btn" id="submitBtn" disabled>
                                            Submit Application
                                        </button>
                                        <p class="text-muted small" style="margin-top: 10px;">
                                            <i class="fa fa-info-circle"></i> Please select a resume to enable submission
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>

                </main>

                {{-- =====================================
                     SIDEBAR
                ====================================== --}}
                  @if(session('is_app','no')=='no' || request('is_app','no')=='no')
                <aside class="job_container_outer_sidebar">

                    {{-- Job Information --}}
                    <div class="job_container_outer_info">

                        <h3 class="job_container_outer_info_title" style="margin-bottom:0px;">
                            Job Information
                        </h3>

                        <div class="job_container_outer_info_item">
                            <div class="job_container_outer_info_content">
                                <span class="job_container_outer_info_value">
                                    <a href="{{ route('home.jobs.single',request('slug')) }}" style="color: var(--primary)">
                                        {{ $job->title }}
                                    </a>
                                </span>
                            </div>
                        </div>

                        @if(!empty($job->location))
                            <div class="job_container_outer_info_item">
                                <div class="job_container_outer_info_icon">
                                    <i class="fa fa-location"></i>
                                </div>
                                <div class="job_container_outer_info_content">
                                    <span class="job_container_outer_info_label">Location</span>
                                    <span class="job_container_outer_info_value">{{ $job->location }}</span>
                                </div>
                            </div>
                        @endif

                        @if(!empty($job->job_created_at))
                            <div class="job_container_outer_info_item">
                                <div class="job_container_outer_info_icon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div class="job_container_outer_info_content">
                                    <span class="job_container_outer_info_label">Posted</span>
                                    <span class="job_container_outer_info_value">
                                        {{ \Carbon\Carbon::parse($job->job_created_at)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- Resume CTA --}}
                    <div class="job_container_outer_resume">
                        <div class="job_container_outer_resume_icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <h3 class="job_container_outer_resume_title">Stand Out From Other Candidates</h3>
                        <p class="job_container_outer_resume_description">
                            Create a professional, ATS-friendly resume that helps you make a stronger impression on employers.
                        </p>
                        <a href="{{ url('/signup') }}" class="job_container_outer_resume_button">
                            Create Your Resume
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                </aside>
                @endif

            </div>

        </div>

    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('applyForm');
        const submitBtn = document.getElementById('submitBtn');
        const selectedResumeInput = document.getElementById('selected_resume_id');
        const resumeRadios = document.querySelectorAll('.resume-select-radio');
        const selectedDisplay = document.getElementById('selectedResumeDisplay');
        const uploadBtn = document.getElementById('upload_resume_btn');
        const fileInput = document.getElementById('resume_file');
        const uploadedFileName = document.getElementById('uploaded_file_name');

        // Handle resume selection via radio buttons
        resumeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const resumeId = this.value;
                selectedResumeInput.value = resumeId;
                
                // Update UI
                const row = this.closest('.resume-row');
                document.querySelectorAll('.resume-row').forEach(r => {
                    r.classList.remove('selected');
                });
                if (row) {
                    row.classList.add('selected');
                }

                // Show selected resume info
                let displayText = '';
                if (resumeId === 'uploaded') {
                    const uploadedRow = document.querySelector('.resume-row[data-resume-id="uploaded"]');
                    const nameEl = uploadedRow ? uploadedRow.querySelector('.resume-name') : null;
                    const name = nameEl ? nameEl.textContent.trim() : 'Uploaded Resume';
                    displayText = 'Selected: <strong>' + name + '</strong> (Uploaded Resume)';
                } else {
                    const selectedRow = document.querySelector('.resume-row[data-resume-id="' + resumeId + '"]');
                    const nameEl = selectedRow ? selectedRow.querySelector('.resume-name') : null;
                    const name = nameEl ? nameEl.textContent.trim() : 'Resume #' + resumeId;
                    displayText = 'Selected: <strong>' + name + '</strong> (Saved Resume)';
                }
                selectedDisplay.innerHTML = '<div class="selected-resume-label"><i class="fa fa-check-circle" style="color: #22c55e;"></i> ' + displayText + '</div>';

                // Enable submit button
                submitBtn.disabled = false;
                submitBtn.classList.add('btn-success');
                submitBtn.textContent = 'Submit Application';
            });
        });

        // Handle file upload
        if (uploadBtn && fileInput) {
            uploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fileInput.click();
            });

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    const uploadedRow = document.querySelector('.resume-row[data-resume-id="uploaded"]');
                    const nameEl = document.getElementById('uploaded_resume_name');
                    const statusEl = document.getElementById('uploaded_resume_status');
                    
                    // Update the uploaded resume name
                    if (nameEl) {
                        nameEl.textContent = file.name;
                        nameEl.style.color = '#1e293b';
                    }
                    
                    // Update status
                    if (statusEl) {
                        statusEl.innerHTML = '<span class="resume-status-dot"></span> Ready';
                    }

                    // Show file name below upload button
                    if (uploadedFileName) {
                        uploadedFileName.innerHTML = '<i class="fa fa-file-pdf-o"></i> ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                    }

                    // Enable the radio button for uploaded resume
                    const radio = document.getElementById('resume_uploaded');
                    if (radio) {
                        radio.disabled = false;
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change'));
                    }
                }
            });
        }

        // Form validation before submit
        form.addEventListener('submit', function(e) {
            const selectedId = selectedResumeInput.value;
            
            if (!selectedId) {
                e.preventDefault();
                alert('Please select a resume before submitting your application.');
                return false;
            }

            // If uploaded resume is selected, check if file is uploaded
            if (selectedId === 'uploaded') {
                // Check if file input has a file OR if there's an existing uploaded resume
                const fileInput = document.getElementById('resume_file');
                const hasNewFile = fileInput && fileInput.files.length > 0;
                const hasExistingResume = !document.getElementById('uploaded_resume_name').textContent.includes('No uploaded resume');
                
                if (!hasNewFile && !hasExistingResume) {
                    e.preventDefault();
                    alert('Please upload a resume file before submitting.');
                    return false;
                }
            }

            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
        });

        // reCAPTCHA callbacks
        window.recaptcha_successfull_response = function(data) {
            // reCAPTCHA verified, check if resume is selected
            if (selectedResumeInput.value) {
                submitBtn.disabled = false;
                submitBtn.classList.add('btn-success');
                submitBtn.textContent = 'Submit Application';
            }
        };

        window.recaptcha_expired_callback = function() {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submit Application';
        };

        window.data_error_callback = function() {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submit Application';
        };

        window.reset_recaptcha = function() {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise) {
                grecaptcha.enterprise.reset();
            }
        };
    });
</script>

@endsection