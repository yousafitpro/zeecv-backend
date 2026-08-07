@extends('layout.master')
@section('title', "Product Details")

@section('content')
<style>
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d; /* Optional: gray text for inactive tabs */
        border-bottom: 2px solid transparent;
    }

    .nav-tabs .nav-link:hover {
        border-bottom: 2px solid #ccc; /* Optional hover effect */
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #007bff; /* Active text color */
        border-bottom: 2px solid #007bff;
        font-weight: bold;
        background-color: transparent;
    }
</style>

<div class="container-fluid">
    <div class="card shadow-sm">


        <div class="card-body">
            <a href="{{ $back_url ?? route('pmm.products.view') }}" >
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <br>
            <br>
            <form method="POST" action="{{ route('pmm.products.updatePost', $item->id) }}" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
                <div class="row">
                    <!-- Product Info -->
                        <div class="col-md-3">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center">
                                <img src="{{ !empty($item->attachment)?$item->attachment->file_url:''}}" id="attachment" class="img-fluid rounded" style="max-height: 100px; object-fit: contain;">
                                <hr>
                                <h3 class="text-primary">{{ $item->name }}</h5>
                                <p class="mb-0"><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
                                <p><strong>Commission:</strong>        {{$item->commission}} {{$item->commission_type=='Flat'?'$':'%'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                            <div class="row">
                        <div class="col-md-12">
                            <label for="productLink"><strong>Checkout Link <i class="fas fa-link"></i></strong></label>
                            <div class="input-group">
                                <input type="text" id="productLink" class="form-control" value="{{ affiliate_link(auth()->user()->id,$item->id) }}" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#productLink')">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                        <div class="row">
                        <div class="col-md-12">
                            <pre>{{ $item->description }}</pre>
                        </div>
                        </div>


                    </div>

                    <!-- Product Preview -->

                </div>

            </form>
      @include('pmm.product.includes.product-bottom')
        </div>

    </div>

</div>

<script>
function copyToClipboard(selector) {
    var input = document.querySelector(selector);
    if (input) {
        input.select();
        input.setSelectionRange(0, 99999); // For mobile compatibility
        document.execCommand("copy");
    } else {
    }
}
</script>

@endsection
