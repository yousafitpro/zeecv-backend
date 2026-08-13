@extends('layout.home')

@section('meta_tags')
    <title>Blogs - ZeeCV</title>

    <meta name="description"
          content="Explore ZeeCV's latest articles, resume tips, career advice, job search strategies, ATS optimization tips, and professional development insights.">

    <meta name="keywords"
          content="resume tips, CV tips, ATS resume, career advice, job search, resume builder, ZeeCV">
@endsection

@section('content')
<style>
  @media (max-width: 767.98px) {
    .zeecv-mobile-margin {
        margin-top: 15px;
    }
}
</style>
<div class="container py-5">

    {{-- Header --}}
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">

            <h1 class="fw-bold display-5 mb-3">
                Career & Resume Insights
            </h1>

            <p class="text-muted fs-5 mb-0">
                Discover practical resume tips, career advice, ATS optimization
                strategies, and job search insights to help you stand out.
            </p>

        </div>
    </div>


    {{-- Blog List --}}
    <div class="row g-4">

        @forelse($list as $blog)

            <div class="col-lg-4 col-md-6 zeecv-mobile-margin">

                <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                    {{-- Image --}}
                    @if(!empty($blog->thumbnail))
                        <a href="{{ url('/blogs/' . $blog->slug) }}">
                           <img
                          src="{{ asset($blog->thumbnail->file_url) }}"
                          class="card-img-top"
                          alt="{{ $blog->title }}"
                          loading="lazy"
                          style="height:220px; object-fit:cover;">
                        </a>
                    @else
                        <a href="{{ url('/blog/' . $blog->slug) }}"
                           class="d-flex align-items-center justify-content-center bg-light"
                           style="height:220px;">

                            <span class="text-muted">
                                ZeeCV
                            </span>

                        </a>
                    @endif


                    <div class="card-body p-4 d-flex flex-column">

                        {{-- Category --}}
                        @if(!empty($blog->category))
                            <div class="mb-2">
                                <span class="small text-primary fw-semibold">
                                    {{ $blog->category->name }}
                                </span>
                            </div>
                        @endif


                        {{-- Title --}}
                        <h2 class="h5 fw-bold mb-3">

                            <a
                                href="{{ url('/blogs/' . $blog->slug) }}"
                                class="text-dark text-decoration-none"
                            >
                                {{ $blog->title }}
                            </a>

                        </h2>


                        {{-- Description --}}
                        @if(!empty($blog->description))
                            <p class="text-muted mb-4">
                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 130) }}
                            </p>
                        @elseif(!empty($blog->metadata))
                            <p class="text-muted mb-4">
                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->metadata), 130) }}
                            </p>
                        @endif


                        {{-- Footer --}}
                        <div class="mt-auto d-flex align-items-center justify-content-between">

                            <small class="text-muted">
                                {{ optional($blog->created_at)->format('M d, Y') }}
                            </small>

                            <a
                                href="{{ url('/blogs/' . $blog->slug) }}"
                                class="text-primary fw-semibold text-decoration-none"
                            >
                                Read More
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        </div>

                    </div>

                </article>

            </div>

        @empty

            <div class="col-12">

                <div class="text-center py-5">

                    <div class="mb-3">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>
                    </div>

                    <h3 class="fw-bold">
                        No articles found
                    </h3>

                    <p class="text-muted">
                        Check back soon for new career and resume insights.
                    </p>

                </div>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if($list->hasPages())

        <div class="d-flex justify-content-center mt-5">

            {{ $list->links() }}

        </div>

    @endif

</div>

@endsection