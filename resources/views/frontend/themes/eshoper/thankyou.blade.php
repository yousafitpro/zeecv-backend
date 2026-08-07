@extends('frontend.themes.eshoper.layout-blank')
@section('content')
{!! $link->on_sale !!}
    <style>
            .myFlex{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f8;
            margin: 0;
            padding: 0;
        }

        .thank-you-container {
            max-width: 600px;
            margin: 100px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
        }

        .thank-you-container h1 {
            font-size: 32px;
            color: #28a5ab;
            margin-bottom: 20px;
        }

        .thank-you-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #28a5ab;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .checkmark svg {
            width: 40px;
            height: 40px;
            stroke: white;
            stroke-width: 4;
            fill: none;
        }

        .btn-home {
            display: inline-block;
            padding: 12px 30px;
            background-color: #28a5ab;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn-home:hover {
            background-color: #28a5ab;
        }
    </style>



@if(empty($link->thank_page_link))
    @if(empty($link->thank_page_link) && !empty($link->redirect_url))
        <div class="thank-you-container">
            <div class="checkmark">
        <svg width="40" height="40" viewBox="0 0 40 40" stroke="#4A90E2" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="20" cy="20" r="18" stroke-opacity="0.25" stroke-width="4"/>
    <path d="M38 20c0-9.94-8.06-18-18-18" stroke-width="4" stroke-linecap="round">
        <animateTransform attributeName="transform" type="rotate" from="0 20 20" to="360 20 20"
        dur="1s" repeatCount="indefinite" />
    </path>
    </svg>

            </div>
            <h1>Thank You!</h1>
            <p>Order Received, please wait</p>
        </div>
    @else
        <div class="thank-you-container">
            <div class="checkmark">
                <svg viewBox="0 0 52 52">
                    <path d="M14 27l7 7 17-17" />
                </svg>
            </div>
            <h1>Thank You!</h1>
            <p>Your order has been successfully placed. We’ve sent you a confirmation email.</p>
            <a href="{{url('/')}}" class="btn-home">Return to Home</a>
        </div>
    @endif
@else
{!! $link->thank_page_link !!}
@endif






@if(!empty($link->redirect_url))
<script>

   setTimeout(() => {
window.top.location.href = '{{$link->redirect_url}}';
   }, 4000);

</script>
@endif
<script>
        $(document).ready(function(){
        $("#mainLoader1").modal('show')
    })
       setTimeout(() => {

      $("#mainLoader1").modal('hide')
   }, 4000);
</script>
@endsection
