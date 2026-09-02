@extends('layout.home')

@section('content')
<style>
    /* ─── Reset & Base ─── */
    .dashboard-wrapper {
        background: #ffffff;
        padding: 1.5rem 1rem;
        border-radius: 0;
    }

    /* ─── Stat Cards ─── */
    .stat-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        padding: 1.5rem 1.8rem;
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(0, 0, 0, 0.02);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        opacity: 0.4;
        transition: opacity 0.3s, height 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    }
    .stat-card:hover::after {
        opacity: 1;
        height: 6px;
    }
    .stat-card .stat-icon {
        font-size: 2.6rem;
        opacity: 0.12;
        position: absolute;
        right: 1.2rem;
        bottom: 0.8rem;
        transition: all 0.4s;
    }
    .stat-card:hover .stat-icon {
        opacity: 0.25;
        transform: scale(1.1) rotate(-2deg);
    }
    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .stat-number {
        font-size: 2.4rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
    }
    .stat-sub {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }
    /* color overrides */
    .stat-card.google .stat-number { color: #1cc88a; }
    .stat-card.custom .stat-number { color: #f6c23e; }
    .stat-card.applications .stat-number { color: #e74a3b; }
    .stat-card.saved .stat-number { color: #36b9cc; }

    /* ─── Filter Form ─── */
    .filter-glass {
        background: #f9fafb;
        border-radius: 18px;
        padding: 1.2rem 1.8rem;
        border: 1px solid #f3f4f6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        margin-bottom: 2rem;
    }
    .filter-glass .form-control {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        transition: all 0.2s;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
    .filter-glass .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        background: #fff;
    }
    .filter-glass .btn-primary {
        border-radius: 50px;
        padding: 0.6rem 2rem;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        font-weight: 600;
        letter-spacing: 0.03em;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.25);
    }
    .filter-glass .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(78, 115, 223, 0.35);
    }
    .filter-glass .btn-outline-secondary {
        border-radius: 50px;
        border-color: #d1d5db;
        color: #4b5563;
        transition: all 0.3s;
    }
    .filter-glass .btn-outline-secondary:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
        transform: translateY(-2px);
    }

    /* ─── Chart Card ─── */
    .chart-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        height: 100%;
        transition: box-shadow 0.3s;
    }
    .chart-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }
    .chart-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #111827;
        font-size: 1rem;
    }
    .chart-card .card-body {
        padding: 1rem 1.5rem 1.5rem;
    }

    /* ─── Table Card ─── */
    .table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: box-shadow 0.3s;
    }
    .table-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }
    .table-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    .table-card .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .table-card .table th {
        border-top: 0;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        padding: 0.8rem 1rem;
    }
    .table-card .table td {
        padding: 0.8rem 1rem;
        vertical-align: middle;
        border-color: #f3f4f6;
    }
    .badge-apply {
        background: #1cc88a;
        color: white;
        padding: 0.3rem 1.2rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.7rem;
        letter-spacing: 0.03em;
    }

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
        .stat-number { font-size: 1.8rem; }
        .filter-glass { padding: 1rem; }
        .stat-card { padding: 1.2rem; }
    }

    /* ─── Counter animation (smooth) ─── */
    .counter {
        display: inline-block;
        transition: all 0.1s;
    }
</style>

<div class="dashboard-wrapper container-fluid px-4">



    <!-- Filter Form -->
    <form action="{{ route('admin.job.dashboard') }}" method="post">
        @csrf
         <div class="filter-glass row align-items-end g-3">
        <div class="col-md-3 col-sm-6">
            <label for="start_date" class="form-label small fw-semibold text-secondary">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start_date ?? '' }}">
        </div>
        <div class="col-md-3 col-sm-6">
            <label for="end_date" class="form-label small fw-semibold text-secondary">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end_date ?? '' }}">
        </div>
        <div class="col-md-6 col-sm-12 d-flex gap-2 flex-wrap align-items-center mt-2 mt-sm-0">
            <button type="submit" id="applyFilterBtn" class="btn btn-primary px-4">
                <i class="fas fa-filter me-1"></i> Apply
            </button>
            <a href="{{ route('admin.job.dashboard') }}" class="btn btn-outline-secondary px-4">
                <i class="fas fa-undo me-1"></i> Reset
            </a>
        </div>
    </div> 
    </form>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-number"><span class="counter" data-target="{{ $total_users }}">0</span></div>
                    <div class="stat-sub"><i class="fas fa-arrow-up text-success me-1"></i> +12% this month</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card google">
                <div class="stat-icon"><i class="fab fa-google"></i></div>
                <div>
                    <div class="stat-label">Google Sign-ups</div>
                    <div class="stat-number"><span class="counter" data-target="{{ $google_user_count }}">0</span></div>
                    <div class="stat-sub">via OAuth</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card custom">
                <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
                <div>
                    <div class="stat-label">Custom Sign-ups</div>
                    <div class="stat-number"><span class="counter" data-target="{{ $custom_user_count }}">0</span></div>
                    <div class="stat-sub">email/password</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card applications">
                <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                <div>
                    <div class="stat-label">Applications</div>
                    <div class="stat-number"><span class="counter" data-target="{{ $apply_count }}">0</span></div>
                    <div class="stat-sub">total job applications</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: Saves + Chart -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card saved">
                <div class="stat-icon"><i class="fas fa-heart"></i></div>
                <div>
                    <div class="stat-label">Saved Jobs</div>
                    <div class="stat-number"><span class="counter" data-target="{{ $save_count }}">0</span></div>
                    <div class="stat-sub">total saves</div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6">
            <div class="chart-card">
                <div class="card-header">
                    <i class="fas fa-chart-line mr-2 text-primary"></i> Daily Sign-up Trend (last 30 days)
                </div>
                <div class="card-body">
                    <canvas id="trendChart" style="width:100%; height:200px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <i class="fas fa-clock mr-2 text-primary"></i> Recent Job Applications
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_applies as $apply)
                                    <tr>
                                        <td>{{ $apply->user->name ?? 'N/A' }}</td>
                                        <td>{{ $apply->created_at->format('M d, Y H:i') }}</td>
                                        <td><span class="badge-apply">Applied</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">No applications yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        'use strict';

        // ─── Smooth Animated Counters ───
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'), 10);
            if (isNaN(target) || target === 0) {
                el.textContent = target;
                return;
            }
            let current = 0;
            const duration = 900; // ms
            const stepTime = 16;
            const steps = duration / stepTime;
            const increment = target / steps;
            let timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, stepTime);
        }

        // Observe each counter
        document.querySelectorAll('.counter').forEach(el => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(el);
                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.3 });
            observer.observe(el);
        });

        // ─── Trend Chart ───
        const ctx = document.getElementById('trendChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.25)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($trend_labels),
                datasets: [{
                    label: 'New Users',
                    data: @json($trend_data),
                    backgroundColor: gradient,
                    borderColor: '#4e73df',
                    borderWidth: 3,
                    pointBackgroundColor: '#4e73df',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17,24,39,0.8)',
                        titleColor: '#f3f4f6',
                        bodyColor: '#e5e7eb',
                        cornerRadius: 8,
                        padding: 10,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxTicksLimit: 12, font: { size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { stepSize: 1, font: { size: 10 } }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // ─── Date Filter Logic ───
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');
        const applyBtn = document.getElementById('applyFilterBtn');

        function applyFilter() {
            const start = startInput.value;
            const end = endInput.value;
            let url = "{{ route('admin.job.dashboard') }}";
            const params = new URLSearchParams();
            if (start) params.append('start_date', start);
            if (end) params.append('end_date', end);
            if (params.toString()) {
                url += '?' + params.toString();
            }
            window.location.href = url;
        }

        applyBtn.addEventListener('click', applyFilter);

        // Quick range buttons
        document.querySelectorAll('.quick-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                const now = new Date();
                let start = new Date(now);
                let end = new Date(now);

                switch (range) {
                    case 'today':
                        // already set
                        break;
                    case 'week': {
                        // Monday of this week
                        const day = now.getDay(); // 0=Sunday
                        const diff = now.getDate() - day + (day === 0 ? -6 : 1);
                        start = new Date(now.setDate(diff));
                        end = new Date(start);
                        end.setDate(start.getDate() + 6);
                        break;
                    }
                    case 'month': {
                        start = new Date(now.getFullYear(), now.getMonth(), 1);
                        end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                        break;
                    }
                }

                // Format YYYY-MM-DD
                const format = (d) => d.toISOString().split('T')[0];
                startInput.value = format(start);
                endInput.value = format(end);
                applyFilter();
            });
        });

        // Enter key on inputs
        document.querySelectorAll('#start_date, #end_date').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') applyFilter();
            });
        });

    })();
</script>
@endpush

@endsection