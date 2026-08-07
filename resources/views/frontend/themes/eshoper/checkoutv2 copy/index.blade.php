@extends('frontend.themes.eshoper.checkoutv2.layout')
@section('content')
<style>
    body {
      background-color: #f5f5f5;
    }

    .checkout-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.08);
    }

    .form-label {
      font-weight: 500;
    }

    .card-summary {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
    }

    .card-summary .product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 5px;
    }

    .list-group-item {
      background-color: #fff;
      border: none;
      padding: 10px 0;
    }

    .form-check-label {
      font-size: 0.9rem;
    }

    .apply-btn {
      white-space: nowrap;
    }

    .summary-total {
      font-weight: bold;
      font-size: 1.2rem;
    }

    .form-control, .form-select {
      border-radius: 8px;
    }

    a.text-success {
      text-decoration: none;
    }

    a.text-success:hover {
      text-decoration: underline;
    }
  </style>

<div class="container my-5">
  <div class="row">
    <!-- Left Column -->
    <div class="col-md-7">
          <form action="{{route('frontend.product.checkout',request('id'))}}" id="create_sprint_form" method="post" onsubmit="submitForm(event, this)">
            @csrf
      <div class="checkout-container mb-4">
        <h5>Contact</h5>
        <div class="mb-3">
          <input type="email" class="form-control" placeholder="Email Address" required name="email">
        </div>
        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="orderUpdates" checked>
          <label class="form-check-label" for="orderUpdates">
            Email me with order updates
          </label>
        </div>

        <h5>Delivery</h5>
        <div class="mb-3">
          <label class="form-label">Country/Region</label>
          <select class="form-select" name="country">
            <option selected value="US">US</option>
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" placeholder="Full Name" required name="name">
          </div>
          <div class="col-md-6 mb-3">
           <input type="number" min="1" value="1" onchange="calculate_total(this)" name="quantity" required class="form-control" placeholder="Quantity"/>
          </div>
        </div>

        <div class="mb-3">
          <input type="text" class="form-control" name="address" placeholder="Street Address" required>
        </div>

        <div class="mb-3">
          <a href="#" class="text-success small">Give us more information</a>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" placeholder="City" name="city" required>
          </div>
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" placeholder="Postal Code" name="postal_code"  required>
          </div>
        </div>

        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Phone" name="phone" required>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="saveInfo" checked>
          <label class="form-check-label" for="saveInfo">
            Save this information for next time
          </label>
        </div>
        <br>
              <div class="row">
      <div class="col-md-12">
         <button id="btncheckout" type="submit" class="form-control btn btn-success" >
											Confirm
										</button>
      </div>
      </div>
      </div>

          </form>
    </div>

    <!-- Right Column -->
    <div class="col-md-5">
      <div class="card-summary p-4">
        <div class="d-flex mb-4">
          <img src="{{ !empty($link->attachment)?$link->attachment->file_url:$product->attachment->file_url}}" class="product-img me-3" alt="Product">
          <div>
            <strong>{{ !empty($link->product_name)?$link->product_name:$product->name }}</strong><br>
            <small>In Stock</small><br>
            <strong>${{$product->price}}</strong>
          </div>
        </div>

        <div class="input-group mb-3">
          <input disabled type="text" class="form-control" placeholder="Discount code or gift card">
          <button type="button" class="btn btn-success apply-btn">Apply</button>
        </div>

        <div class="card card-body">
            <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between">
            <span>Subtotal</span>
            <span id="checkout_subtotal">${{$product->price}}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Shipping</span>
            <span class="text-success">Free Shipping</span>
          </li>
          <li class="list-group-item d-flex justify-content-between summary-total">
            <span>Total</span>
            <span id="checkout_total">${{$product->price}}</span>
          </li>
        </ul>
        </div>
      </div>
    </div>
  </div>
</div>
{!! $link->on_click !!}
<script>
    function submitForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    formData = new FormData(formElement);
             $("#btncheckout").prop('disabled',true)
             $("#btncheckout").text("Saving...")
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#create_sprint_form")[0].reset();
                    window.top.location.href = response.url;
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                },
                complete:function(){
                                 $("#btncheckout").prop('disabled',false)
             $("#btncheckout").text("Submit & Continue")
                }
            });
}
 function calculate_total(element)
 {
let unitPrice = parseFloat("{{ $product->price }}");
      let qty = parseInt($(element).val()) || 0;
      let subtotal = (qty * unitPrice).toFixed(2);

      // Update Subtotal and Total fields
      $('#checkout_subtotal').text('$' + subtotal);
      $('#checkout_total').text('$' + subtotal);

 }

</script>

@endsection
