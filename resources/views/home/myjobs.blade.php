@extends('layout.home')

@section('meta_tags')

    <!-- =====================================================
         BASIC SEO
    ====================================================== -->

    <title>Latest Jobs - Find Your Next Career Opportunity | ZeeCV   </title>

    <meta name="description"
          content="Explore the latest job opportunities from trusted companies and job sources. Find jobs that match your skills, experience, location, and career goals with ZeeCV.">

    <meta name="keywords"
          content="latest jobs, jobs, job search, job opportunities, careers, employment, remote jobs, full time jobs, part time jobs, software jobs, jobs in Pakistan, international jobs, ZeeCV">

    <meta name="robots"
          content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="googlebot"
          content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="bingbot"
          content="index, follow">

    <meta name="author"
          content="ZeeCV">

    <meta name="publisher"
          content="ZeeCV">

    <meta name="language"
          content="English">

    <meta name="revisit-after"
          content="1 day">



    <!-- =====================================================
         OPEN GRAPH / FACEBOOK / LINKEDIN
    ====================================================== -->

    <meta property="og:type"
          content="website">

    <meta property="og:title"
          content="Latest Jobs - Find Your Next Career Opportunity | ZeeCV">

    <meta property="og:description"
          content="Explore the latest job opportunities from trusted companies and job sources. Find your next career opportunity with ZeeCV.">

    <meta property="og:url"
          content="{{ url()->current() }}">

    <meta property="og:site_name"
          content="ZeeCV">

    <meta property="og:locale"
          content="en_US">

    {{-- <meta property="og:image"
          content="{{ asset('zeecv-job-share.jpg') }}"> --}}

    <meta property="og:image:width"
          content="1200">

    <meta property="og:image:height"
          content="630">

    <meta property="og:image:alt"
          content="Latest Jobs - ZeeCV">


    <!-- =====================================================
         TWITTER / X
    ====================================================== -->

    <meta name="twitter:card"
          content="summary_large_image">

    <meta name="twitter:title"
          content="Latest Jobs - Find Your Next Career Opportunity | ZeeCV">

    <meta name="twitter:description"
          content="Discover the latest job opportunities and find your next career move with ZeeCV.">

    <meta name="twitter:image"
          content="{{ asset('images/zeecv-job-share.jpg') }}">

    <meta name="twitter:image:alt"
          content="Latest Jobs - ZeeCV">


    <!-- =====================================================
         MOBILE / BROWSER
    ====================================================== -->

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="theme-color"
          content="#ffffff">

    <meta name="format-detection"
          content="telephone=no">


    <!-- =====================================================
         FAVICON
    ====================================================== -->

    <link rel="icon"
          type="image/png"
          href="{{ asset('favicon.png') }}">

    <link rel="apple-touch-icon"
          href="{{ asset('favicon.png') }}">


    <!-- =====================================================
         STRUCTURED DATA - WEBSITE
    ====================================================== -->

@php
    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'ZeeCV',
        'url' => url('/'),
        'description' => 'Find the latest job opportunities and create professional resumes with ZeeCV.',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/resume-builder/jobs') . '?search={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>


    <!-- =====================================================
         STRUCTURED DATA - JOB LISTING PAGE
    ====================================================== -->

@php
    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Latest Jobs',
        'url' => url()->current(),
        'description' => 'Explore the latest job opportunities from trusted companies and job sources.',
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'ZeeCV',
            'url' => url('/'),
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>


    <!-- =====================================================
         BREADCRUMB
    ====================================================== -->

@php
    $breadcrumbSchema = [
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
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection


@section('content')

<style>
        .job_search_btns button{
            background: white !important;
            outline:none !important;
            border: 2px solid var(--primary) !important;
            color:var(--primary);
            font-weight: bold;
            border-radius: 5px !important;
        }
    .job_search_btns a{
        background: white !important;
        outline: none !important;
        border: 2px solid var(--primary) !important;
        color:var(--primary);
        font-weight: bold;
         border-radius: 5px !important;
    }
    .job_search_btns button:hover{
         background: var(--primary) !important;
         border:none !important;
    }
    .job_search_btns button:active{
         background: var(--primary) !important;
         border:none !important;
    }
    .job_search_btns button:focus{
         background: var(--primary) !important;
         border:none !important;
         color: white !important;
    }
    .job_search_btns a:hover{
         background: var(--primary) !important;
         border:none !important;
    }
    .job_search_btns a:active{
         background: var(--primary) !important;
         border:none !important;
         color: white !important;
    }
    .job_search_btns a:focus{
         background: var(--primary) !important;
         border:none !important;
         color: white !important;
    }
      #job_search_form {
        
        width: 100%;
        box-sizing: border-box;

        padding: 20px;

        background: #ffffff;
        border-left: 5px solid var(--primary);
    }

    #job_search_form label {

    margin-top: 4px;

    font-size: 13px;
    font-weight: 600;

    color: #374151;
    }
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
         #job_search_form{
            border-left: none;
         }
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
            padding: 20px 0 80px;
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
           grid-template-columns: 1fr;

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
            top: 100px;
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
                padding: 0px 0 60px;
                
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
        <form action="{{ route('home.user.myjobs.ajax') }}" id="job_search_form" method="post">
            @csrf
                    <div class="row">
                    <style>
    .search-box-wrapper {
        width: 100%;
    }

    .search-box-wrapper .form-control {
        height: 44px;
    }

    .search_is_remote {
        display: inline-flex;
        align-items: center;
        margin-top: 8px;
        padding: 3px 8px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        color: #475569;
        font-size: 10px !important;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .search_is_remote:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .search_is_remote input {
        display: none;
        margin: 0 7px 0 0;
        cursor: pointer;
        accent-color: #4f46e5;
        width: 0px;
    }

    .search_is_remote:has(input:checked) {
        color: white !important;
        background: var(--primary);
        border-color: #c7d2fe;
    }
</style>

<div class="col-md-8">
    <label>Search</label>

    <div class="search-box-wrapper">

        <input
            class="form-control"
            value="{{ $input['search'] ?? '' }}"
            name="search"
            placeholder="Search jobs, skills, companies..."
        >


    </div>
</div>
                    <div class="col-md-4" >
                                <label>Location</label><br>
                                <select class="form-control select2" name="location" style="max-width: 350px">
                                    <option value="">--All--</option>
                                    @foreach ($locations as $lo)
                                      
                                      <option value="{{ $lo }}" {{ $lo == ($input['location'] ?? '') ? 'selected' : '' }}>
                                            {{ $lo }}
                                        </option>
                                    @endforeach
                                </select>
                         
                    </div>
                   
                   </div>
                   <div class="row mt-2 g-1">
                     <div class="col-md-8" >
                        
                        <label class="search_is_remote" onclick="FunSubmitSearchForm()">
                            <input
                                type="radio"
                                name="jobs_type"
                                value="My Jobs"
                                {{ !empty($input['is_myjobs']) ? 'checked' : '' }}
                            >
                            My Jobs
                        </label>
                        <label class="search_is_remote" onclick="FunSubmitSearchForm()">
                            <input
                                type="radio"
                                name="jobs_type"
                                value="Applied"
                                {{ !empty($input['is_applied']) ? 'checked' : '' }}
                            >
                            Applied
                        </label>
                        <label class="search_is_remote" onclick="FunSubmitSearchForm()">
                            <input
                                 
                                type="radio"
                                name="jobs_type"
                                value="Saved"
                                {{ !empty($input['is_saved']) ? 'checked' : '' }}
                            >
                            Saved
                        </label>
                     </div>
                     <div class=" col-md-3 mt-2 job_search_btns" >
                        <button class="btn btn-primary btn-block btn-sm"  type="submit">Search</button>
                    </div>
                    <div class="col-md-1 mt-2 job_search_btns" >
                        <a href="{{ route('home.user.myjobs') }}" class="btn btn-primary btn-sm btn-block"  type="submit">Reset</a>
                    </div>
                   </div>
                </form>
        <div class="container" style="padding-left:0px;padding-right:0px;">

<br>
            {{-- Header --}}
{{-- 
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

            </div> --}}


            {{-- Main Layout --}}

            <div class="job_container_outer_layout">


                {{-- =====================================
                     JOB LIST
                ====================================== --}}

                <div class="job_container_outer_list" id="job_container_outer_list">


   


                </div>



            </div>

        </div>

    </section>


</div>
<script>
    $(document).ready(function() {
  
     $('.select2').select2();
  
});
</script>
<script>
    function FunSubmitSearchForm(){
        setTimeout(() => {
          $('#job_search_form').submit()  
        }, 100);
    }
$(document).ready(function() {
     let isSubmitting = false;
    // =============================================
    // JOB SEARCH FORM AJAX SUBMISSION
    // =============================================
     
    $('#job_search_form').on('submit', function(e) {
        
        e.preventDefault();
        if (isSubmitting) return;
            isSubmitting = true;
        // Get form data
        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');
        
        // Show loading state
        $('#job_container_outer_list').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Searching for jobs...</p>
            </div>
        `);
        
        // Make AJAX request
        $.ajax({
            url: actionUrl,
            type: 'GET',
            data: formData,
            dataType: 'html',
            success: function(response) {
                // Replace the content with the response
                $('#job_container_outer_list').html(response);
                
                // Scroll to results
                // $('html, body').animate({
                //     scrollTop: $('#job_container_outer_list').offset().top - 100
                // }, 500);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                
                // Show error message
                $('#job_container_outer_list').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Failed to load search results. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            },
            complete: function() {
                isSubmitting = false;
            }
        });
    });
    
    // =============================================
    // FILTER BUTTON CLICK (Alternative)
    // =============================================
    
    $('.filter-btn, .search-btn').on('click', function() {
        $('#job_search_form').submit();
    });
    
    // =============================================
    // AUTO-SUBMIT ON SELECT CHANGE (Optional)
    // =============================================
    
    $('.auto-submit').on('change', function() {
        $('#job_search_form').submit();
    });

     $('#job_search_form').submit()
})

</script>

<style>
/* Loading spinner animation */
.spinner-border {
    display: inline-block;
    width: 3rem;
    height: 3rem;
    vertical-align: text-bottom;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
    to { transform: rotate(360deg); }
}

.text-primary {
    color: #2563eb !important;
}

.visually-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}

/* Alert styles */
.alert {
    position: relative;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.375rem;
}

.alert-danger {
    color: #842029;
    background-color: #f8d7da;
    border-color: #f5c2c7;
}

.alert-dismissible {
    padding-right: 3.75rem;
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    padding: 1.25rem 1rem;
    background: transparent;
    border: 0;
    font-size: 1.5rem;
    line-height: 1;
    cursor: pointer;
}

.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: #000;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: 0.375rem;
    opacity: 0.5;
}

/* Load more loader */
#load-more-loader {
    display: none;
    text-align: center;
    padding: 20px 0;
}

/* Smooth transition for job items */
.job-item {
    transition: opacity 0.3s ease;
}

.job-item.fade-in {
    opacity: 0;
    animation: fadeIn 0.5s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .spinner-border {
        width: 2rem;
        height: 2rem;
    }
}
</style>
@endsection