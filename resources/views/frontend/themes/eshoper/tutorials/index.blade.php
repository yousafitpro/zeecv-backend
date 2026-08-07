@extends('frontend.themes.eshoper.layout')

@section('content')
<style>
    .hero-box {
        background: linear-gradient(90deg, #2D9CDB, #56CCF2);
        padding: 40px 20px;
        color: #fff;
        text-align: center;
        margin-bottom: 40px;
    }
    .tutorial-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    .tutorial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .tutorial-img {
        height: 180px;
        object-fit: cover;
        width: 100%;
    }
    .tutorial-body {
        padding: 20px;
    }
    .tutorial-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    .tutorial-desc {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
    }
</style>

<div class="hero-box">
    <h2 class="fw-bold">📚 Tutorials</h2>
    <p>Learn step-by-step with our detailed guides</p>
</div>

<div class="container">
    <div class="row g-4">
        @foreach($tutorials as $tutorial)
        <div class="col-md-4 col-sm-6">
            <div class="card tutorial-card">
                <img src="{{$tutorial->attachment->file_url??''}}" class="tutorial-img" alt="{{ $tutorial->title }}">
                <div class="tutorial-body">
                    <h5 class="tutorial-title">{{Str::limit( $tutorial->title, 80) }}</h5>
                    <a href="{{ route('tutorial.show', $tutorial->slug) }}" class="btn btn-primary btn-sm">
                        Read More →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>


</div>
<br>
@endsection
