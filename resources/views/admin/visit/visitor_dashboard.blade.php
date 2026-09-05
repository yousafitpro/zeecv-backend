@extends('layout.home')

@section('content')
<style>
    /* Custom Dashboard Styles */
    .dashboard-stat-card {
        border-radius: 0px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.2s;
        background: #fff;
        border-left: 4px solid #4e73df;
        padding: 10px 20px;
    }
    .dashboard-stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 1rem;
        opacity: 0.3;
        float: right;
    }
    .stat-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .stat-number {
        font-size:12px;
        font-weight: 700;
        color: #2d3748;
    }
    .filter-form {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }
    .filter-form .form-group {
        margin-bottom: 0;
    }
    .filter-form .btn {
        padding: 0.375rem 2rem;
    }
    .card-header-custom {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        font-weight: 600;
    }
    .table-recent td, .table-recent th {
        vertical-align: middle;
    }
    .badge-apply {
        background: #1cc88a;
        color: white;
    }
    .badge-save {
        background: #36b9cc;
        color: white;
    }
</style>

<div class="container-fluid px-4">


    <!-- Filter Form -->
    <form action="{{ route('admin.job.dashboard') }}" method="post">
        @csrf
        <div class="filter-form row align-items-end">
        <div class="col-md-4 col-sm-6 form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $input['start_date'] ?? '' }}">
        </div>
        <div class="col-md-4 col-sm-6 form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $input['end_date'] ?? '' }}">
        </div>
        <div class="col-md-4 col-sm-12 form-group">
            <button type="submit" id="applyFilterBtn" class="btn btn-primary btn-block">
                <i class="fas fa-filter"></i> Apply Filter
            </button>
            <a href="{{ route('admin.job.dashboard') }}" class="btn btn-outline-secondary btn-block mt-1">
                <i class="fas fa-undo"></i> Reset
            </a>
        </div>
    </div>
    </form>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="dashboard-stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Visits</div>
                <div class="stat-number">{{ $total_visit_count }}</div>
            </div>
        </div>
                
    </div>


    <div class="row">
<div class="col-md-6">
       
            <div class="card shadow">
                <div class="card-header card-header-custom">
                    <i class="fas fa-chart-line mr-2"></i> Daily Applied Trend (last 30 days)
                </div>
                <div class="card-body">
                    <canvas id="appliedChart" style="width:100%; height:200px;"></canvas>
                </div>
            </div>
      
       
        </div>
        <div class="col-md-6">
       
            <div class="card shadow">
                <div class="card-header card-header-custom">
                    <i class="fas fa-chart-line mr-2"></i> Daily Sign‑up Trend (last 30 days)
                </div>
                <div class="card-body">
                    <canvas id="trendChart" style="width:100%; height:200px;"></canvas>
                </div>
            </div>
      
        </div>
    </div>



  <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header card-header-custom">
                            <i class="fas fa-clock mr-2"></i> Recently Visits
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="myTable7 table table-hover table-recent">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>IP</th>
                                            <th>URL</th>
                                            <th>Visited At</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_visits as $visit)
                                            <tr>
                                                <td>
                                                    {{ $visit->user->name ?? 'N/A' }}
                                                    <br>
                                                    {{ $visit->user->email ?? 'N/A' }}


                                                </td>
                                                <td>{{ $visit->ip_address ?? 'N/A' }}</td>
                                                <td>{{ $visit->url ?? 'N/A' }}</td>
                                                <td>{{ $visit->created_at->format('M d, Y H:i') }}</td>
                                                <td><span class="badge badge-apply">Saved</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted">No applications yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($trend_labels),
                datasets: [{
                    label: 'New Users',
                    data: @json($trend_data),
                    backgroundColor: 'rgba(78, 115, 223, 0.2)',
                    borderColor: '#4e73df',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#4e73df',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
        const ctx2 = document.getElementById('appliedChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: @json($applied_labels),
                datasets: [{
                    label: 'New Users',
                    data: @json($applied_data),
                    backgroundColor: 'rgba(78, 115, 223, 0.2)',
                    borderColor: '#4e73df',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#4e73df',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
});

</script>


@endsection