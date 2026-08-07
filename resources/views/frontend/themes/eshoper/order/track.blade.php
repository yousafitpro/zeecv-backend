@extends('frontend.themes.eshoper.layout-blank')

@section('title', 'Track Order')

@section('content')
<style>
    .track-order-card {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .track-order-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .order-info-box {
        padding: 14px 18px;
        background: linear-gradient(145deg, #f7f8fa, #eaecef);
        border-radius: 10px;
        font-weight: 500;
        color: #212529;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .order-info-icon {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .track-order-heading {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.75rem;
        margin-bottom: 30px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card track-order-card p-4 p-md-5">
                <h3 class="text-center track-order-heading">
                    <i class="bi bi-box-seam me-2"></i> Track Your Order
                </h3>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Order ID</label>
                        <div class="order-info-box">
                            <i class="bi bi-hash order-info-icon"></i>
                            #{{ request('order_id') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Order Status</label>
                        <div class="order-info-box">
                            @if ($order->order_status=="Dispatched")
                                <i class="bi bi-truck order-info-icon"></i>
                            @else
                              <i class="bi bi-info order-info-icon"></i>
                            @endif

                            {{ ucfirst($order->order_status) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Payment Status</label>
                        <div class="order-info-box">
                            <i class="bi bi-credit-card order-info-icon"></i>
                            {{ ucfirst($order->status ?? 'N/A') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
