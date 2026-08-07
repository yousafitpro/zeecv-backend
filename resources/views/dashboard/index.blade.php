@extends('layout.master')
@section('title',"Dashboard")
@section('content')
<style>
        .balance-card-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;

        }
        .balance-card {
            padding: 5px;
            border-radius: 10px;
            color: #343a40; /* Dark text color */
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90px !important;
        }
        .card-balance-bg {
            background-color: #e6f6ee; /* Light green */
        }
        .card-pending-bg {
            background-color: #fff9e6; /* Light yellow */
        }
        .balance-value {
            font-size:12px;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        .balance-label {
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }
        .dot-balance {
            background-color: #ff6347; /* Tomato red */
        }
        .dot-pending {
            background-color: #ff6347; /* Tomato red */
        }
</style>
<script>

</script>
<div class="row">

    <div class="col-md-6">
        <h4 class="page-title">Dashboard</h4>
    </div>
    <div class="col-md-6">
       <div class="balance-card-container" style="float: right">

   @include('dashboard.includes.balance')

</div>
    </div>
    {{-- <div class="col-md-2">
            @include('components.time')
    </div> --}}
</div>

<br>
@include('dashboard.dashboards.admin')






</div>


@endsection
