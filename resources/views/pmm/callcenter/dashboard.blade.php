@extends('layout.master')
@section('title', "Orders")
@section('content')

<style>
.dashboard-cards .card {
    border: 1px solid #ddd;
    border-radius: 12px;
    text-align: center;
    padding: 20px;
    transition: all 0.3s ease;
}
.dashboard-cards .card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
.dashboard-cards .count {
    font-size: 24px;
    font-weight: bold;
}
.dashboard-cards .label {
    font-size: 14px;
    color: #555;
}
.chart-box {
    margin-bottom: 10px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    max-height: 300px !important;
    padding-bottom: 40px !important;
}
</style>

<div class="card">
    <div class="card-body">

        {{-- ✅ DASHBOARD SUMMARY --}}
        <div class="row dashboard-cards mb-4">
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-primary" id="count_pending">{{ $stats['pending'] ?? 0 }}</div><div class="label">Pending</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-success" id="count_completed">{{ $stats['completed'] ?? 0 }}</div><div class="label">Completed</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-info" id="count_call1">{{ $stats['call1'] ?? 0 }}</div><div class="label">Call 1</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-warning" id="count_call2">{{ $stats['call2'] ?? 0 }}</div><div class="label">Call 2</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-danger" id="count_call3">{{ $stats['call3'] ?? 0 }}</div><div class="label">Call 3</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-dark" id="count_shipping">{{ $stats['shipping'] ?? 0 }}</div><div class="label">Accepted</div></div></div>
            <div class="col-md-2 col-sm-6 mb-2"><div class="card"><div class="count text-muted" id="count_cancelled">{{ $stats['cancelled'] ?? 0 }}</div><div class="label">Cancelled</div></div></div>
        </div>

        {{-- ✅ CHARTS SECTION --}}
        <div class="row mb-4">
            {{-- Chart 1: Completed vs Cancelled --}}
            <div class="col-md-6">
                <div class="chart-box">
                    <div class="row">
                        <div class="col-md-6"><h3>Completed vs Cancelled</h3></div>
                        <div class="col-md-6">
                            <select id="monthly_campaigns_created" onchange="monthly_product_states()" class="form-control" style="float: right">
                                <option value="Today">Today</option>
                                <option value="Yesterday">Yesterday</option>
                                <option value="Previous Month">Previous Month</option>
                                <option value="Monthly">This Month</option>
                                <option value="Previous Year">Previous Year</option>
                                <option value="Yearly">This Year</option>
                                <option value="All">All</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="productsChart" height="100"></canvas>
                </div>
            </div>

          
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let productChartInstance = null;
let clickLeadsChartInstance = null;

$(document).ready(function() {
    monthly_product_states();
    fun_clicks_and_leads();
});

function monthly_product_states() {
    $.ajax({
        url: "{{ route('dashboard.monthly_order_stats') }}",
        type: 'POST',
        data: { "_token": "{{ csrf_token() }}", "filter": $("#monthly_campaigns_created").val() },
        success: function(response) {
            const ctx = document.getElementById('productsChart').getContext('2d');
            if (productChartInstance) productChartInstance.destroy();
            productChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.labels,
                    datasets: [
                        { label: 'Completed Orders', data: response.completed, backgroundColor: '#28a74599', borderColor: '#28a745', borderWidth: 1 },
                        { label: 'Cancelled Orders', data: response.cancelled, backgroundColor: '#dc354599', borderColor: '#dc3545', borderWidth: 1 }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }
    });
}

function fun_clicks_and_leads() {
    $.ajax({
        url: "{{ route('dashboard.pending_completed_stats') }}",
        type: 'POST',
        data: { "_token": "{{ csrf_token() }}", "filter": $("#fun_clicks_and_leads_select").val() },
        success: function(response) {
            const ctx = document.getElementById('clicks_leads_Chart').getContext('2d');
            if (clickLeadsChartInstance) clickLeadsChartInstance.destroy();
            clickLeadsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets: [
                        { label: 'Pending Orders', data: response.pending, borderColor: '#ffc107', backgroundColor: '#ffc10755', fill: true },
                        { label: 'Completed Orders', data: response.completed, borderColor: '#28a745', backgroundColor: '#28a74555', fill: true }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }
    });
}
</script>
@stop
