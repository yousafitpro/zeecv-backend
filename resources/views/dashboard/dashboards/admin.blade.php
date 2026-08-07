      @php

      @endphp

      <style>

        .chart-box {
            margin-bottom: 10px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
            max-height: 300px !important;
            padding-bottom: 40px !important;
        }
        h3 {
            margin-bottom: 20px;
        }
    </style>

<div class="row">
    <div class="col-md-6 order-2 order-md-1">
        @if (is_admin() || is_has_role('Merchant'))
        <div class="chart-box">
            <div class="row">
                <div class="col-md-6">
                     <h3>Campaigns Created</h3>
                </div>
                <div class="col-md-6 div-sm">
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

                @endif
        <div class="chart-box">
            <div class="row">
                <div class="col-md-6">
                     <h3>Clicks & Leads</h3>
                </div>
                <div class="col-md-6 div-sm">
                <select id="fun_clicks_and_leads_select" onchange="fun_clicks_and_leads()" class="form-control" style="float: right">
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

            <canvas id="clicks_leads_Chart" height="100"></canvas>
        </div>



    </div>
    <div class="col-md-6 order-1 order-md-2">
       <div class="card" style="border-radius: 10px;padding-bottom:0px">
        <div class="card-header bg-primary text-white" style="border-top-right-radius: 10px;border-top-left-radius: 10px;">
            <h5 class="card-title mb-0" style="color: white">🆕 New Orders</h5>
        </div>
        <div class="card-body" style="max-height: 450px; overflow-y: auto;">
            @if (count($orders)>0)
                            <ul class="list-group list-group-flush">
                 @foreach ($orders as $o)
                <!-- Product Item -->
                <li class="list-group-item d-flex align-items-center" style="cursor: pointer" onclick="redirect_to_product('{{route('pmm.transactions.detail',unique_encrypt($o->id)). '?back_url=' . route('pmm.transactions.view') }}')">
                    @if ($o->link->product->attachment)
                            <img src="{{$o->link->product->attachment->file_url}}" class="rounded mr-3" style="width: 50px; height: 50px; object-fit: cover;">

                    @endif
                    <div>
                        <strong>{{$o->link->product->name}}</strong><br>
                        <small class="text-muted">
                          Order ID : #{{unique_encrypt($o->id)}}
                        </small>

                    </div>
                    <span class="badge badge-success mt-1" style="float: right">${{$o->amount}}</span>
                </li>
                @endforeach
            </ul>
            <br>
            <h5 style="text-align: center"><a href="{{route('pmm.transactions.view')}}">see all</a></h5>
            @else
            <h3 style="text-align: center;color:gray"> No Orders </h3>
            @endif


        </div>
    </div>
    <div class="card" style="border-radius: 10px">
        <div class="card-header bg-primary text-white" style="border-top-right-radius: 10px;border-top-left-radius: 10px;">
            <h5 class="card-title mb-0" style="color: white">🆕 Newly Added Campaigns</h5>
        </div>
        <div class="card-body" style="max-height: 450px; overflow-y: auto;">
            <ul class="list-group list-group-flush">
                 @foreach ($products as $pd)
                <!-- Product Item -->
                <li class="list-group-item d-flex align-items-center" style="cursor: pointer" onclick="redirect_to_product('{{route('pmm.products.update',product_encrypt($pd->id))}}')">
                    @if ($pd->attachment)
                            <img src="{{$pd->attachment->file_url}}" class="rounded mr-3" style="width: 50px; height: 50px; object-fit: cover;">

                    @endif
                    <div>
                        <strong>{{$pd->name}}</strong><br>
                        <small class="text-muted">
                          @if (!empty($pd->created_at))
                                     {{ $pd->created_at->format('d M Y, h:i A') }}
                                    @endif
                        </small>

                    </div>
                    <span class="badge badge-success mt-1" style="float: right">${{$pd->price}}</span>
                </li>
                @endforeach





            </ul>

        </div>
          <a href="{{route('pmm.products.view')}}" class="text-muted" style="text-align: center">
                        See all
          </a>
                    <br>
    </div>


    </div>
</div>



<script>
let productChartInstance = null;
let clickChartInstance = null;
let transactionChartInstance = null;
let clickLeadsChartInstance = null;
    $(document).ready(function(){
        @if (is_admin() || is_has_role('Merchant'))
        monthly_product_states()
        @endif
        fun_clicks_and_leads()


    })


function monthly_product_states() {
    $.ajax({
        url: "{{ route('dashboard.monthly_product_states') }}",
        type: 'POST',
        data: { "_token": "{{ csrf_token() }}" ,"filter":$("#monthly_campaigns_created").val()},
        success: function (response) {
            const labels = response.labels;
            const productData = response.data;

            const ctx = document.getElementById('productsChart').getContext('2d');
           if (productChartInstance) {
                productChartInstance.destroy();
            }
            productChartInstance=new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Campaigns Created',
                        data: productData,
                        borderColor: '#36a2eb',
                        backgroundColor: '#36a2eb33',
                        fill: true,
                        borderWidth: 2,
                        tension: 0.3,
                        pointRadius: 2,
                        pointHoverRadius: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        },
        error: function (xhr) {
            let errorMessage = "Something went wrong.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            swal("Error!", errorMessage, "error");
        }
    });
}

function fun_clicks_and_leads() {
    $.ajax({
        url: "{{ route('dashboard.clicks_and_leads') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "filter": $("#fun_clicks_and_leads_select").val()
        },
        success: function(response) {
            const labels = response.labels;
            const orders = response.orders;
            const clicks = response.clicks;

            const ctx = document.getElementById('clicks_leads_Chart').getContext('2d');
            if (clickLeadsChartInstance) {
                clickLeadsChartInstance.destroy();
            }

            clickLeadsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Leads',
                            data: orders,
                            fill: false,
                            borderColor: '#42a5f5',
                            borderWidth: 1.5,
                            backgroundColor: '#42a5f5',
                            tension: 0,
                            pointRadius: 1
                        },
                        {
                            label: 'Clicks',
                            data: clicks,
                            fill: false,
                            borderWidth: 1.5,
                            borderColor: '#66bb6a',
                            backgroundColor: '#66bb6a',
                            tension: 0,
                            pointRadius: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(xhr) {
            let errorMessage = "Something went wrong.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            swal("Error!", errorMessage, "error");
        }
    });
}


    function redirect_to_product(url)
    {
        window.location.href=url;
    }
</script>
