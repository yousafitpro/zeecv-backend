@extends('layout.home')

@section('content')
<div class="container py-5 pricing-page">
    <div class="text-center mb-5">
        <span class="pricing-eyebrow">Pricing</span>
        <h1 class="fw-bold mb-2">Choose Your Plan</h1>
        <p class="text-muted mb-0">Simple pricing, no surprises. Pick the plan that fits you best.</p>
    </div>

    @if($packages->isEmpty())
        <div class="alert alert-info text-center rounded-4 border-0 shadow-sm">No packages available at the moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center align-items-stretch">
            @foreach($packages as $package)
                <div class="col">
                    <div class="card pricing-card h-100 border-0">
                        <div class="card-body text-center d-flex flex-column p-4 p-lg-4">
                            <h3 class="pricing-title mb-2">{{ $package->title }}</h3>
                            <p class="pricing-desc text-muted mb-2">{{ $package->description ?? 'No description' }} <br>
                           20,000+ Real Jobs Added Daily
                            </p>
                            <p class="pricing-desc text-muted mb-3" style="font-weight: bold">Cancel Your Subscription Anytime</p>

                            <div class="pricing-amount mb-4">
                                <span class="currency">$</span>{{ number_format($package->amount, 2) }}
                                @if($package->billing_cycle)
                                    <span class="pricing-cycle">/ {{ $package->days }}</span>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('packages.pay', unique_encrypt($package->id)) }}" class="btn btn-primary btn-lg w-100 rounded-pill pricing-btn">
                                    Subscribe Now <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .pricing-page .pricing-eyebrow {
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 12.5px;
        font-weight: 600;
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.1);
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .pricing-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 4px 18px rgba(17, 24, 39, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .pricing-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #6ea8fe);
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .pricing-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 32px rgba(17, 24, 39, 0.12);
    }

    .pricing-card:hover::before {
        opacity: 1;
    }

    .pricing-title {
        font-size: 20px;
        font-weight: 700;
        color: #212529;
    }

    .pricing-desc {
        font-size: 14.5px;
        min-height: 44px;
    }

    .pricing-amount {
        font-size: 42px;
        font-weight: 800;
        color: #0d6efd;
        line-height: 1;
    }

    .pricing-amount .currency {
        font-size: 22px;
        font-weight: 700;
        vertical-align: top;
        margin-right: 2px;
        position: relative;
        top: 6px;
    }

    .pricing-amount .pricing-cycle {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #6c757d;
        margin-top: 4px;
    }

    .pricing-btn {
        font-weight: 600;
        padding: 12px 20px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.25);
    }

    .pricing-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(13, 110, 253, 0.32);
    }
</style>
@endpush
