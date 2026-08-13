
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
    {{-- Header Image --}}
    {{-- ============================= --}}

    @if(!empty($blog->headerimg))

        <section class="py-4 py-lg-5">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10">

                        <div class="overflow-hidden rounded-4 shadow-sm">

                            <img
                                src="{{ asset($blog->headerimg->file_url) }}"
                                alt="{{ $blog->title }}"
                                class="w-100"
                                style="
                                    max-height: 520px;
                                    object-fit: cover;
                                "
                            >

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- ============================= --}}
    {{-- Blog Content --}}
    {{-- ============================= --}}

    <section class="pb-5">

        <div class="container">

            <div class="row justify-content-center">

                {{-- Main Article --}}
                <div class="col-lg-8">

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


    {{-- ============================= --}}
    {{-- CTA --}}
    {{-- ============================= --}}

    <section class="py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9">

                    <div class="bg-primary text-white rounded-4 p-4 p-lg-5 text-center shadow-sm">

                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3">
                            Build Your Resume with ZeeCV
                        </span>

                        <h2 class="fw-bold mb-3">
                            Ready to Create a Better Resume?
                        </h2>

                        <p class="mb-4 opacity-75 fs-5">

                            Build an ATS-friendly resume, optimize it with AI,
                            and make your next opportunity count.

                        </p>

                        <a href="{{ url('/') }}"
                           class="btn btn-light btn-lg px-4 fw-semibold">

                            Create Your Resume

                            <i class="bi bi-arrow-right ms-2"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================= --}}
    {{-- Related Blogs --}}
    {{-- ============================= --}}

    @if(isset($relatedBlogs) && $relatedBlogs->count())

        <section class="py-5 bg-light">

            <div class="container">

                <div class="text-center mb-5">

                    <span class="text-primary fw-semibold">
                        ZeeCV Blog
                    </span>

                    <h2 class="fw-bold mt-2">
                        You May Also Like
                    </h2>

                    <p class="text-muted">
                        More career and resume insights from ZeeCV.
                    </p>

                </div>


                <div class="row g-4">

                    @foreach($relatedBlogs as $related)

                        <div class="col-lg-4 col-md-6">

                            <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                                {{-- Image --}}
                                @if(!empty($related->thumbnail))

                                    <a href="{{ url('/blog/' . $related->slug) }}">

                                        <img
                                            src="{{ asset($related->thumbnail->file_url) }}"
                                            class="card-img-top"
                                            alt="{{ $related->title }}"
                                            loading="lazy"
                                            style="
                                                height: 210px;
                                                object-fit: cover;
                                            "
                                        >

                                    </a>

                                @endif


                                <div class="card-body p-4 d-flex flex-column">

                                    @if(!empty($related->category))

                                        <span class="small text-primary fw-semibold mb-2">

                                            {{ $related->category->name }}

                                        </span>

                                    @endif


                                    <h3 class="h5 fw-bold mb-3">

                                        <a
                                            href="{{ url('/blog/' . $related->slug) }}"
                                            class="text-dark text-decoration-none"
                                        >

                                            {{ $related->title }}

                                        </a>

                                    </h3>


                                    <p class="text-muted mb-4">

                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags($related->description ?? $related->metadata ?? ''),
                                            120
                                        ) }}

                                    </p>


                                    <div class="mt-auto">

                                        <a
                                            href="{{ url('/blog/' . $related->slug) }}"
                                            class="text-primary fw-semibold text-decoration-none"
                                        >

                                            Read More

                                            <i class="bi bi-arrow-right ms-1"></i>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>


{{-- ============================= --}}
{{-- Blog Content Styling --}}
{{-- ============================= --}}

<style>

    .zeecv-blog-detail {
        background: #ffffff;
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
