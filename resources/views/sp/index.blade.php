@extends('layout.master')
@section('title', "Support Center")
@section('content')

<style>
    .hero-box {
        background: linear-gradient(90deg, #2D9CDB, #56CCF2);
        border-radius: 10px;
        padding: 40px 20px;
        color: #fff;
        text-align: center;
        margin-bottom: 30px;
    }
    .search-box {
        max-width: 500px;
        margin: 0 auto;
    }
    .card-box {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 20px;
    }
    .support-icon {
        font-size: 24px;
        margin-right: 10px;
    }
    .card-box a {
        font-weight: 600;
        text-decoration: none;
    }
    .profile-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<div class="container py-4">

    <!-- Header Section -->
    <div class="hero-box">
        <h2 class="fw-bold">Service Center</h2>
        <div class="search-box mt-3">
            {{-- <input type="text" class="form-control form-control-lg" placeholder="Enter your question here"> --}}
        </div>
    </div>

    <!-- Main Section -->
    <div class="row g-4">

        <!-- Left Section -->
        <div class="col-md-6">
    {{-- <div class="text-end mt-3">
        <a href="{{route('sp.tickets.view')}}" class="text-primary fw-semibold">Support center <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <br> --}}
            <div class="card-box">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{asset('app-icons/logo.png')}}" alt="Logo" style="height: 40px;">
                    <span class="ms-2 fw-bold text-muted">Scalifypro</span>
                </div>
                <p class="mb-3">As a member of the scalifypro you have access to:</p>
                <div class="row">
                    <div class="col-6">
                        <a href="{{route('sp.tickets.add')}}">
                            <div class="border rounded p-3 h-100">
                            <div class="mb-2 text-primary">
                                <i class="fas fa-comments support-icon"></i>
                                <strong>Start a support chat</strong>
                            </div>
                            <div class="text-muted small">Support Team 24/7</div>
                        </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 h-100 border-warning">
                            <div class="mb-2 text-warning">
                                <i class="fas fa-users support-icon"></i>
                                <strong>Scalifypro Facebook Group</strong>
                            </div>
                            <div class="text-muted small">Here you can discuss your issues with other members</div>
                        </div>
                    </div>
                     <div class="col-6 mb-2 mt-2">

                        <a href="{{route('sp.tickets.view')}}">
                            <div class="border rounded p-3 h-100">
                            <div class="mb-2 text-primary">
                                <i class="fas fa-users support-icon"></i>
                                <strong>Support Center</strong>
                            </div>
                            <div class="text-muted small">All Tickets</div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="col-md-6">
            <div class="card-box d-flex">
                <img src="{{ !empty($setting->actordp)?$setting->actordp->file_url:''}}" alt="Ornella Scafarella" class="profile-img me-3">
                <div class="ml-2">
                    <h5 class="mb-1">{{$setting->support_actor_name}}</h5>
                    <div class="mb-2 small">
                        <div><i class="fas fa-envelope"></i> {{$setting->support_actor_email}}</div>
                        <div><i class="fab fa-skype"></i> {{$setting->support_actor_skype}}</div>
                        <div><i class="fab fa-telegram"></i> {{$setting->support_actor_telegram}}</div>
                    </div>
                    <p class="mb-0 small text-muted">
                       {{$setting->support_actor_description}}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .faq-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .faq-card h6 {
        font-weight: bold;
        font-size: 14px;
        color: #3366cc;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .faq-card .question {
        font-size: 14px;
        padding: 8px 0;
        cursor: pointer;
        color: #333;
        transition: all 0.2s;
        border-bottom: 1px solid #f0f0f0;
    }

    .faq-card .question:hover {
        color: #2D9CDB;
    }

    .faq-answer {
        font-size: 13px;
        color: #555;
        padding: 5px 0 10px 20px;
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .faq-answer.show {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container">
    <div class="row g-4">

        <!-- My Account -->
        <div class="col-md-6">
            <div class="faq-card">
                <h6><i class="fas fa-user me-2"></i> My Account</h6>
                @foreach ($myaccount as $acc)
                <div class="question" onclick="toggleAnswer(this)">{{$acc->title}}</div>
                <div class="faq-answer">{{$acc->description}}</div>

                @endforeach

            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-6">
            <div class="faq-card">
                <h6><i class="fas fa-euro-sign me-2"></i> Payments</h6>

          @foreach ($payments as $acc)
                <div class="question" onclick="toggleAnswer(this)">{{$acc->title}}</div>
                <div class="faq-answer">{{$acc->description}}</div>

                @endforeach
            </div>
        </div>
    </div>


</div>
<br>
<script>
    function toggleAnswer(el) {
        const answer = el.nextElementSibling;
        const isShown = answer.classList.contains('show');

        // hide all
        document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('show'));

        if (!isShown) {
            answer.classList.add('show');
        }
    }
</script>


@endsection
