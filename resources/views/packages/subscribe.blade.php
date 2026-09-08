@extends('layout.home')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Choose Your Plan</h1>

    @if($packages->isEmpty())
        <div class="alert alert-info text-center">No packages available at the moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            @foreach($packages as $package)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $package->title }}</h5>
                            <p class="card-text">{{ $package->description ?? 'No description' }}</p>
                            <p class="display-6 fw-bold text-primary">
                                ${{ number_format($package->amount, 2) }}
                                @if($package->billing_cycle)
                                    <small class="text-muted fs-6">/ {{ $package->days }}</small>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-3">
                            <a href="{{ route('packages.pay', unique_encrypt($package->id)) }}" class="btn btn-primary btn-lg w-100">
                                Subscribe Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection