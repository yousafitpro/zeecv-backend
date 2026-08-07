@extends('layout.master')
@section('title', "Product Details")

@section('content')
<script src="https://cdn.tiny.cloud/1/842w9cxxv1dvk2ckkhu8kav5civsf7g3jlijnox9pkl4wer0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>


   $(document).ready(function(){
         tinymce.init({
        selector: '#page_content',
        height: 500,
        plugins: 'advlist autolink lists link image charmap preview anchor ' +
                 'searchreplace visualblocks code fullscreen ' +
                 'insertdatetime media table code help wordcount',
        toolbar: 'undo redo | formatselect | ' +
                 'bold italic underline strikethrough | link image media | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | removeformat | help',
        menubar: 'file edit view insert format tools table help',
        branding: false // Hide "Powered by TinyMCE"
    });
    })


</script>
@php

    $can_edit=is_has_permission('pmm.products.update');
@endphp
<style>
    .select2-selection--multiple
{
height: 30px;
}
        .badge-sm {
        font-size: 0.75rem;
        padding: 0.4em 0.6em;
        color: white
    }
.form-control:disabled,
.form-control[readonly] {
    background-color: white !important;  /* soft light-gray background */
    color: #6c757d !important;            /* muted text color */
    border-color: #ced4da !important;     /* light border */
    /* cursor: not-allowed; */
    box-shadow: none !important;
    opacity: 1;                           /* override Bootstrap's default reduced opacity */
}

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
                    <div class="col-md-8">

                        <div class="row">
                        <div class="col-md-12">
                            <label for="productLink"><strong>Checkout Link <i class="fas fa-link"></i></strong></label>
                            <div class="input-group">
                            <input type="text"
                                id="productLink"
                                class="form-control"
                                value="{{ (!empty($domain->domain) && $domain->order_checkout == 'true')
                                            ? $domain->domain.'/sell/'.product_encrypt($link->id)
                                            : affiliate_link(auth()->user()->id, $item->id) }}"
                                readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#productLink')">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                  @if ($can_edit)
                         <div class="row">
                        <div class="col-md-12">
                            <label><strong>Product Name </strong></label>
                            <input type="text" name="name" class="form-control" {{$can_edit?'':'readonly'}} value="{{$item->name }}" required>
                        </div>
                        </div>
                         @if(is_has_permission('pmm.products.update'))
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><strong>Campaign Type</strong></label>
                                <select name="type" class="form-control">
                                    <option value="public" {{ $item->type == 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="private" {{ $item->type == 'private' ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Marketers (only when type is private)</strong></label>
                          <select name="marketers[]" class="form-control select2" multiple>
                            @foreach ($marketers as $mk)
                                <option value="{{ $mk->user->id }}"
                                    {{ in_array($mk->user->id, json_decode($item->marketers) ?? []) ? 'selected' : '' }}>
                                    {{ $mk->user->name }}
                                </option>
                            @endforeach
                        </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label><strong>Status</strong></label>
                                <select name="status" class="form-control" {{$can_edit?'':'readonly'}}>
                                    <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label><strong>Price</strong></label>
                                <input type="number" name="price" class="form-control" step="0.01" {{$can_edit?'':'readonly'}} min="1" value="{{ $item->price }}" required>
                            </div>
                             <div class="form-group col-md-4">
                            <label>Currency Checkout</label>
                            <select class="form-control" name="crouncy" >
                                <option value="USD" {{$item->crouncy=='USD'?'selected':''}}> USD  ($)</option>
                                <option value="EUR"{{$item->crouncy=='EUR'?'selected':''}}> Euro (€)</option>
                                <option value="PKR" {{$item->crouncy=='PKR'?'selected':''}}> PKR  (Rs)</option>
                            </select>
                        </div>
                        </div>
                       <div class="row">
                        <div class="col-md-6 ">
                            <label>Commission  Type</label>
                            <select class="form-control" name="commission_type" required {{$can_edit?'':'readonly'}}>
                                <option value="Percentage" {{$item->commission_type=='Percentage'?'selected':''}}>Percentage</option>
                                <option value="Flat" {{$item->commission_type=='Flat'?'selected':''}}>Flat</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Commission </strong></label>
                            <input type="number" name="commission" class="form-control" {{$can_edit?'':'readonly'}} step="0.01" min="0.1" max="100" value="{{ $item->commission }}" required>
                        </div>
                       </div>
                         <div class="row">
                            <div class="col-md-6">
                                <label>GLS Profile</label>
                                <select class="form-control" name="sender_pro_id">
                                    <option value="">-- Select Address --</option>
                                    @foreach ($profils as $profil)
                                        <option value="{{ $profil->id }}" 
                                            {{ $item->gls_profile_id == $profil->id ? 'selected' : '' }}>
                                            {{ $profil->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                       
                       </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Description </strong></label>
                            <textarea name="description" class="form-control" {{$can_edit?'':'readonly'}} rows="6">{{ $item->description }}</textarea>
                        </div>

                        </div>




                  @else
               <div class="row">
                <div class="col-md-12">
                    {!! nl2br(e($item->description)) !!}
                </div>
            </div>

                  @endif

                    </div>

                    <!-- Product Preview -->
                    <div class="col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center">
                                    <span class="badge bg-{{ app_getStatusColor($item->status) }} badge-sm" style="position: absolute;top:30px;right:30px">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                <img src="{{ !empty($item->attachment)?$item->attachment->file_url:''}}" id="attachment" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                                <hr>

                                <h5 class="text-primary">{{ $item->name }}</h5>
                                <p class="text-muted">{{ $item->description ? Str::limit($item->description, 100) : 'No description.' }}</p>
                                <p class="mb-0"><strong>Price:</strong> {{ number_format($item->price, 2) }} {{$item->crouncy}}</p>
                                <p><strong>Commission:</strong>        {{$item->commission}} {{$item->commission_type=='Flat'?$item->crouncy:'%'}}</p>
                            </div>
                        </div>
                           @if(is_has_permission('pmm.products.update'))
                        <div class="row">
                        <div class="col-md-12">
                            <label><strong>Product Thumbnail</strong></label>
                            <input type="file" name="attachment" class="form-control">
                        </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 ">
                            <label>Payment Method</label>
                            <select class="form-control" name="payment_method" required {{$can_edit?'':'readonly'}}>
                                <option value="Card" {{$item->payment_method=='Card'?'selected':''}}>Card</option>
                                <option value="COD" {{$item->payment_method=='COD'?'selected':''}}>Cash On Delivery</option>
                            </select>
                        </div>
                         
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                            <label>Countries</label>
                            <select class="form-control select2" name="countries[]" multiple required {{$can_edit?'':'readonly'}}>
                                <option value="US" {{ in_array('US', json_decode($item->countries) ?? []) ? 'selected' : '' }}>US</option>
                                <option value="IT" {{ in_array('IT', json_decode($item->countries) ?? []) ? 'selected' : '' }}>Italy</option>
                            </select>
                        </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 ">
                            <label>Fixed Quantity</label> <small>(enter 0 if not fixed)</small>
                             <input class="form-control" value="{{$item->quantity}}" min="0" value="0" name="quantity">
                        </div>
                        </div>
                       <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('upp.sell',$item->id)}}" class="btn btn-primary w-100">Up Sell</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                 @if(is_has_permission('pmm.products.update'))
         <div class="row">
                        <div class="col-md-12">
                            <label><strong>Long Description </strong></label>
                            <textarea id="page_content" name="long_description" class="form-control" {{$can_edit?'':'readonly'}} rows="10">{{ $item->long_description }}</textarea>
                        </div>
                        </div>
                        @endif

                <!-- Submit -->
                @if(is_has_permission('pmm.products.update'))
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
                @endif
            </form>
           @include('pmm.product.includes.product-bottom',['domain'=>$domain])
        </div>
    </div>
</div>
<script>

function copyToClipboard(selector) {
    const input = document.querySelector(selector);
    if (!input) return;

    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices

    try {
        const successful = document.execCommand('copy');
        if (successful) {

        } else {

        }
    } catch (err) {
        swal("Error", "Clipboard copy failed", "error");
    }
}



function submitForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            $("#mainLoader1").modal('show')
            formData = new FormData(formElement);
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data: formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    $("#mainLoader1").modal('hide')
                    $("#mainLoader1").modal('hide')
                    if (response.code == 1) {
                        $("#attachment").prop('src',response.item_url)
                        swal("Success!", response.message, "success");
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                     $("#mainLoader1").modal('hide')
                     $("#mainLoader1").modal('hide')
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }
    });
}

</script>
@endsection
