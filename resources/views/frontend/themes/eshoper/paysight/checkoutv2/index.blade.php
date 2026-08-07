@extends('frontend.themes.eshoper.paysight.checkoutv2.layout')
@section('title', 'Checkout')
@section('content')

@php
  $selected_country='';
  $countries=json_decode($product->countries);
  if(count($countries)>=1)
  {
    $selected_country=$countries[0];
  }
  if(!empty(request('en')))
  {
    $selected_country=request('en');
  }
 $selected_country = strtoupper($selected_country);
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css">

@php
if (!empty(request('en'))) {
    fun_set_locale(request('en'));
} elseif (!empty(Session::get('locale'))) {
    fun_set_locale(Session::get('locale'));
} else {
    fun_set_locale(config('app.locale'));
}
@endphp
@include('loaders.index')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<style>
    .country-select .country-list .country-name {
  display: none !important;
}
.country-select .selected-flag {
  width: 40px; /* adjust flag size */
}

        .myFlex{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
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
    /* #card-element {
    background: #f8f9fa;
    padding: 14px 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
} */

.StripeElement--focus {
    border-color: #4A90E2;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
    background-color: #ffffff;
}

.StripeElement--invalid {
    border-color: #e3342f;
    background-color: #fff0f0;
    color: #e3342f;
}

@media (max-width: 600px) {

.checkout-container {
      padding: 10px;
      border-radius: 10px;
      box-shadow: none;
    }
}

  </style>

<div class="container my-5">
  <div class="row">
    <!-- Left Column -->
  <div class="col-md-7 order-2 order-md-1">

        <div class="checkout-container ">
            <form action="{{route('frontend.product.paysight.checkout',request('id'))}}" id="create_sprint_form" method="post" onsubmit="submitForm(event, this)">
                @csrf
            <h5>{{__('checkout.contact')}}</h5>
            <div class="mb-3">
            <input type="email" class="form-control" value="{{$ref_trans?$ref_trans->email:''}}" placeholder="{{__('checkout.email_address')}}" required name="email">
            </div>
            <div class="form-check mb-4">
            <input class="form-check-input"  type="checkbox" id="orderUpdates" checked>
            <label class="form-check-label" for="orderUpdates">
                {{__('checkout.email_me_with_order_updates')}}
            </label>
            </div>
           @if(!empty($product->countries))
            <h5>{{__('checkout.delivery')}}</h5>
            <div class="mb-3">
            <label class="form-label">{{__('checkout.country_region')}}</label>
            <select class="form-select" name="country" id="country_name">
                @foreach (json_decode($product->countries) as $c)
                   <option
                    {{ (request()->has('en') && strcasecmp($c, request('en')) === 0) ? 'selected' : '' }}
                    value="{{$c}}">{{$c}}</option>
                @endforeach
            </select>
            </div>
            @endif

            <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" value="{{$ref_trans?$ref_trans->name:''}}" placeholder="{{__('checkout.full_name')}}" required name="name">
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group mb-3">
            <input id="order_quantity" type="number" min="1" {{$product->quantity!='0'?'readonly':''}} value="{{ $ref_trans->quantity ?? ($product->quantity != '0' ? $product->quantity : 1) }}" onchange="calculate_total(this)" name="quantity" required class="form-control" placeholder="Quantity">
            <button type="button" class="btn btn-default apply-btn">{{__('checkout.quantity')}}</button>
            </div>
            </div>
            </div>

            <div class="mb-3">
            <input type="text" class="form-control" value="{{$ref_trans?$ref_trans->address:''}}" name="address" placeholder="{{__('checkout.street_address')}}" required>
            </div>

            <div class="mb-3">
            <a href="#" class="text-success small">{{__('checkout.give_us_more_information')}}</a>
            </div>

            <div class="row">


            <div class="col-md-6 mb-3">
              <label>{{__('checkout.city')}}</label>
                <input type="text" class="form-control" value="{{$ref_trans?$ref_trans->city:''}}" placeholder="{{__('checkout.city')}}" name="city" required>
            </div>
            <div class="col-md-6 mb-3">
              @if ($selected_country == "US" )
              <label>{{ __('checkout.checkout_state')}}</label>
             <select name="state" class="select2 form-control">
              @foreach ($us_states as $code => $state)
                    <option value="{{ $code }}">{{ $state }}</option>
                @endforeach
             </select>
             @endif
                

            </div>
            <div class="col-md-6 mb-3">
              <label>{{ $selected_country == "US" ? __('checkout.checkout_zip') : __('checkout.postal_code') }}</label>
              <input type="text" class="form-control" placeholder="{{ $selected_country == "US" ? __('checkout.checkout_zip') : __('checkout.postal_code') }}" value="{{$ref_trans?$ref_trans->city:''}}" name="postal_code"  required>
            
            </div>
            <div class="col-md-6 mb-3">
              <br>
              <section id="payment_section" style="margin-top: 5px;">
  <div >


<div class="input-group">

  <span class="input-group-text p-2">
    <span class="fi fi-{{ strtolower($locale) }}"></span> <!-- 🇮🇹 Italian flag -->
  </span>
  <input type="text"
         class="form-control"
         placeholder="{{__('checkout.phone_like')}}"
         value="{{$ref_trans?$ref_trans->phone:''}}"
         name="phone" required>
</div>


            </div>
</section>
            </div>
            </div>


            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="saveInfo" checked>
            <label class="form-check-label" for="saveInfo">
                {{__('checkout.save_this_informaton_for_next_time')}}
            </label>
            </div>
            <br>
            <div id="error_box" style="color: red">
            </div>
        {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="g-recaptcha" data-sitekey="{{config('myconfig.Recap.site_key')}}" data-callback="recaptcha_successfull_response" data-error-callback="data_error_callback" data-expired-callback="recaptcha_expired_callback"></div>

                        </div>
                    </div> --}}
                    <br>
        <div class="row">
        <div class="col-md-12">
            <button  type="submit" id="form_continue_btn" class="form-control btn btn-success">{{$product->payment_method=='COD'?__('checkout.confirm_&_order'):__('checkout.confirm_&_pay')}}</button>
            </div>
        </div>
        </form>
            <br>


            <form id="payment-form"  class="d-none">

                <div class="trusted-icons text-center mb-3">
                <img src="https://img.icons8.com/ios-filled/24/000000/lock-2.png" title="Secure Checkout" alt="Secure" />
                <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" />
                <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="MasterCard" />
                <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex" />
                <img src="https://img.icons8.com/color/48/000000/secured-letter.png" title="SSL Secured" alt="SSL Secured" />
                </div>

     <div style="text-align: center">Secure payments + 30 day money back guarantee</div>
                <br>

                        <div id="card-element"><!-- Stripe Card Element will be inserted here --></div>

                        <br>
                 
                        <div id="payment-message" style="color: red"></div>

                </form>

                </div>
    </div>

    <!-- Right Column -->
    <div class="col-md-5 order-1 order-md-2">
      <div class="card-summary p-4">
        <div class="d-flex mb-4">
          <img src="{{ !empty($link->attachment)?$link->attachment->file_url:$product->attachment->file_url}}" class="product-img me-3" alt="Product">
          <div class="pl-2">
            <strong>{{ !empty($link->product_name)?$link->product_name:$product->name }}</strong><br>
            <small>{{ __('checkout.in_stock') }}</small><br>
            <strong>{{ $symbol }} {{ number_format($unit_price_amount, 2, '.', '') }}</strong>
          </div>
        </div>



        <div class="card card-body">
            <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between">
            <span>{{__('checkout.subtotal')}}</span>
           <span id="checkout_subtotal"> {{ number_format($unit_price_amount, 2, '.', '') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>{{__('checkout.shipping')}}</span>
            <span class="text-success">{{__('checkout.free_shipping')}}</span>
          </li>

          <li class="list-group-item d-flex justify-content-between summary-total">
            <span>{{__('checkout.total')}}</span>
            <span id="checkout_total">${{$product->price}}</span>
          </li>
        </ul>
        </div>

      </div>
         <h4 class="mt-2">{{__('checkout.more_about_product')}}</h4>
        <div class="mb-2">
            @php
                $product_description=!empty($link->product_description)?nl2br(e($link->product_description)):nl2br(e($product->description));
            @endphp
         {!! \Illuminate\Support\Str::limit($product_description, 1125) !!}

        </div>
    </div>
  </div>

</div>

{!! $link->on_click !!}
<script src="https://payment.paysight.io/widget-sdk.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    </script>
    <script>
    $(document).ready(function () {
        
    $("#country_name").on('change',function(){
        window.location.href="{{route('pmm.product.purchase',request('id'))}}?en="+$("#country_name").val().toLowerCase();
    })
    // Trigger 'change' manually on page load
    $('#order_quantity').trigger('change');
    });
   function recaptcha_successfull_response(data)
    {

    }
    function recaptcha_expired_callback()
    {



    }
    function reset_recaptcha() {
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset();
        }
    }
    function data_error_callback(error)
    {
      console.log(error);

    }
   function initAppleAndGooglePay(success_url)
   {


   }
   function parseName(fullName) {
    if (!fullName || typeof fullName !== 'string') {
        return { firstName: '', lastName: '' };
    }
    
    const trimmedName = fullName.trim();
    if (trimmedName === '') {
        return { firstName: '', lastName: '' };
    }
    
    const nameParts = trimmedName.split(/\s+/).filter(part => part.length > 0);
    
    if (nameParts.length === 1) {
        return { firstName: nameParts[0], lastName: '' };
    }
    
    return {
        firstName: nameParts[0],
        lastName: nameParts[nameParts.length - 1]
    };
}
   function initCard(new_payment_id,payment,success_url,title,product_id,currency='usd',country='US')
   {

            var name = parseName(payment.name);
            var first_name = name.firstName;
            var last_name = name.lastName;
            let customer = {
              email: payment.email,
              firstName: first_name,
              lastName: last_name,
              country: payment.country,
              zip:payment.postalcode,
              phone:payment.phone,
              address:payment.address,
              city:payment.city
            };

            if (payment.country === "US") {
              customer.state = payment.state;
            }
            console.log(customer);
     const widget = PaySightSDK.createWidget({
          targetId: 'card-element',
          config: {
            productId: product_id, 
            sessionId: 'payment-'+payment.id,
            environment: '{{ $p_env }}',
            amount: payment.amount,
            customer: customer,
            threeDSRequired: false,
            failOnThreeDSChallenge: false,
            cancelOnThreeDSFailure: false,
            currency: 'USD',
            locale: 'en-US'
          },
          onReady: () => {
            console.log('Widget is ready');
          },
          onError: (error) => {
            const errorElement = document.getElementById('error-message');
            errorElement.textContent = error.message;
            errorElement.style.display = 'block';
            console.error('Widget error:', error);
            setTimeout(function(){
              errorElement.style.display = 'none';
            },4000)
          },
          onMessage: (message) => {
            if (message.type === 'PAYMENT_SUCCESS') {
              var r_payload=message.payload;
              console.log('Payment successful:', message.payload);
                $.ajax({
                url:"{{ url('paysight/checkout/save-after-info') }}/"+new_payment_id,
                type: "post",
                data: {_token: @json(csrf_token()),transactionId:r_payload.transactionId,paysightSession:r_payload.paysightSession},
                success: function(response) {
                    if (response.code == 1) {
                     window.location.href=success_url
                    }else
                    {
                      swal("Error!","Payment failed", "error");
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
             $("#btncheckout").text("Submit & Continue")
                }
            });
              //  window.location.href=success_url
            }
          }
        });
   }


    function submitForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    formData = new FormData(formElement);
    var nameValue = formData.get('name');
    console.log(nameValue);
    var name = parseName(formData.get('name'));
            var first_name = name.firstName;
            var last_name = name.lastName;
            if (!first_name.trim() || !last_name.trim()) {
    alert("Please enter your full name properly (First and Last name)");
    return; // Stop execution
}
    formData.set('en', $("#country_name").val().toLowerCase());
             $("#form_continue_btn").prop('disabled',true)
             $("#form_continue_btn").text("{{__('checkout.saving')}}")
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {

                        // $("#create_sprint_form")[0].reset();
                        $("#create_sprint_form :input").prop("disabled", true);
                        $("#form_continue_btn").addClass('d-none')
                       if('{{$product->payment_method=="COD"}}')
                        {
                            window.location.href=response.success_url;
                            return;
                        }
                        $("#payment-form").removeClass('d-none')
                          document.getElementById('payment_section').scrollIntoView({
                            behavior: 'smooth'
                        });
                    initCard(response.new_payment_id,response.payment,response.success_url,response.product_name,response.product_id,response.currency,response.country)
                    } else if (response.code == 0) {

                        // grecaptcha.reset();
                            $("#form_continue_btn").prop('disabled',false)
                            $("#form_continue_btn").html("{{$product->payment_method=='COD'?__('checkout.confirm_&_order'):__('checkout.confirm_&_pay')}}")
                            $("#error_box").html(response.message)
                           setTimeout(() => {
                            $("#error_box").fadeOut(500, function () {
                                $(this).html('').show(); // clear and reset display for future use
                            });
                            }, 3000);

                    } else {
                        // grecaptcha.reset();
                        $("#form_continue_btn").prop('disabled',false)
                            $("#form_continue_btn").html("{{$product->payment_method=='COD'?__('checkout.confirm_&_order'):__('checkout.confirm_&_pay')}}")
                             $("#error_box").html('Sorry! Unexpected response')
                            setTimeout(() => {
                            $("#error_box").fadeOut(500, function () {
                                $(this).html('').show(); // clear and reset display for future use
                            });
                            }, 3000);
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
let unitPrice = parseFloat("{{ $unit_price_amount }}");
      let qty = parseInt($(element).val()) || 0;
      let subtotal = (qty * unitPrice).toFixed(2);

      // Update Subtotal and Total fields
      $('#checkout_subtotal').text('{{ $symbol }} ' + subtotal);
      $('#checkout_total').text('{{ $symbol }} ' + subtotal);

 }

    // $(document).ready(function(){
    //     $("#mainLoader1").modal('show')
    //     setTimeout(() => {
    //       $("#mainLoader1").modal('hide')
    //     }, 1000);
    // })
</script>
<script>
  // $("#country_selector").countrySelect({
  //   defaultCountry: "it",   // Italy 🇮🇹
  //   preferredCountries: ['it', 'us', 'pk']
  // });
</script>

<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection
