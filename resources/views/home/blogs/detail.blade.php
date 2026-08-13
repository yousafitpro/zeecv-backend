
@extends('layout.home')

@section('meta_tags')

    <title>{{ $blog->title }} - ZeeCV</title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->metadata ?? ''), 160) }}">

    <meta name="keywords"
          content="{{ $blog->title }}, resume tips, CV tips, ATS resume, career advice, job search, ZeeCV">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $blog->title }} - ZeeCV">

    <meta property="og:description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->metadata ?? ''), 160) }}">

    @if(!empty($blog->thumbnail))
        <meta property="og:image" content="{{ asset($blog->thumbnail->file_url) }}">
    @endif

    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url('/blog/' . $blog->slug) }}">

@endsection


@section('content')

<div class="zeecv-blog-detail">


{{-- ============================= --}}
    {{-- Full Width Header Image --}}
    {{-- ============================= --}}

    @if(!empty($blog->headerimg))

        <section class="p-0 border-0 overflow-hidden blog-detail-page-header">

            <img
                src="{{ asset($blog->headerimg->file_url) }}"
                alt="{{ $blog->title }}"
                class="w-100"
                style="
                    max-height: 520px;
                    object-fit: cover;
                    display: block; /* Removes tiny space at bottom of image */
                "
            >

        </section>

    @endif
    {{-- ============================= --}}
    {{-- Blog Content --}}
    {{-- ============================= --}}

    <section class="pb-5">

        <div class="container">

            <div class="row">

                {{-- Main Article --}}
                <div class="col-lg-12">

                    <article class="zeecv-blog-content">

                        @if(!empty($blog->content))

                            {!! $blog->content !!}

                        @elseif(!empty($blog->long_description))

                            {!! $blog->long_description !!}

                        @else

                            <p class="text-muted">
                                No content available.
                            </p>

                        @endif

                    </article>

                </div>

            </div>

        </div>

    </section>





</div>


{{-- ============================= --}}
{{-- Blog Content Styling --}}
{{-- ============================= --}}

<style>
  .blog-detail-page-header img{
    border-radius: 10px;
  }
    .zeecv-blog-detail {
        background: transparent;
    }

    .zeecv-blog-content {
        font-size: 1.08rem;
        line-height: 1.9;
        color: #343a40;
    }

    .zeecv-blog-content h2 {
        font-size: 1.9rem;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        color: #212529;
    }

    .zeecv-blog-content h3 {
        font-size: 1.45rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #212529;
    }

    .zeecv-blog-content h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: .75rem;
    }

    .zeecv-blog-content p {
        margin-bottom: 1.25rem;
    }

    .zeecv-blog-content ul,
    .zeecv-blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }

    .zeecv-blog-content li {
        margin-bottom: .6rem;
    }

    .zeecv-blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 1.5rem 0;
    }

    .zeecv-blog-content a {
        color: var(--bs-primary);
        font-weight: 600;
    }

    .zeecv-blog-content blockquote {
        border-left: 4px solid var(--bs-primary);
        padding: 1rem 1.5rem;
        margin: 2rem 0;
        background: #f8f9fa;
        border-radius: 0 10px 10px 0;
        color: #495057;
    }

    .zeecv-blog-content table {
        width: 100%;
        margin: 2rem 0;
        border-collapse: collapse;
    }

    .zeecv-blog-content table th,
    .zeecv-blog-content table td {
        border: 1px solid #dee2e6;
        padding: 10px;
    }

    .zeecv-blog-content table th {
        background: #f8f9fa;
        font-weight: 700;
    }

    @media (max-width: 767px) {

        .zeecv-blog-detail h1 {
            font-size: 2.1rem;
        }

        .zeecv-blog-content {
            font-size: 1rem;
            line-height: 1.8;
        }

        .zeecv-blog-content h2 {
            font-size: 1.6rem;
        }

        .zeecv-blog-content h3 {
            font-size: 1.3rem;
        }

    }

</style>

@endsection
