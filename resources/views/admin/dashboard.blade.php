{{-- dashboard.blade.php --}}
@extends('templates.admin')

@push('style')
    <style>
        /* Minimal styles for other components */
        .stats-card {
            transition: all 0.2s ease;
            border: none;
            background: #ffffff;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        .stats-card .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .chart-card {
            border: none;
            background: #ffffff;
        }

        .activity-card {
            border: none;
            background: #ffffff;
        }

        .activity-item {
            transition: all 0.2s ease;
            border: none !important;
        }

        .activity-item:hover {
            background: #f8f9fa !important;
        }

        .quick-action-card {
            border: none;
            background: #ffffff;
        }

        .quick-action-btn {
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
            background: white;
        }

        .quick-action-btn:hover {
            border-color: #2e7d32;
            background: #f8fff9;
        }

        .metric-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-online { background-color: #22c55e; }

        .section-header {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        /* KEEP ALL TIME DISPLAY STYLES */
        .time-display-container {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .time-display-container:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
        }

        .time-main {
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 0.1rem;
            position: relative;
            z-index: 2;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            line-height: 1.2;
        }

        .time-date {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-bottom: 0.3rem;
            position: relative;
            z-index: 2;
            line-height: 1.2;
        }

        .time-zone {
            font-size: 0.65rem;
            opacity: 0.8;
            background: rgba(255,255,255,0.15);
            padding: 0.15rem 0.5rem;
            border-radius: 10px;
            display: inline-block;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(5px);
            font-weight: 500;
        }

        .time-colon {
            animation: blink 2s infinite;
            opacity: 0.9;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.5; }
        }

        /* Keep background animation for time only */
        .time-display-container::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.05), transparent);
            animation: shimmer 8s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        /* Clean scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        ::-webkit-scrollbar-thumb {
            background: #dee2e6;
            border-radius: 2px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Header with Key Metrics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h3 mb-2 fw-bold text-dark">Dashboard Overview</h2>
                            <p class="text-muted mb-0">Real-time insights and platform performance metrics</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex justify-content-md-end align-items-center gap-4">
                                <div class="text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <span class="status-dot status-online"></span>
                                        <small class="text-success fw-semibold">System Online</small>
                                    </div>
                                    <small class="text-muted">All systems operational</small>
                                </div>
                                <div class="vr"></div>
                                <!-- Time Display with Special Effects -->
                                <div class="time-display-container">
                                    <div class="time-main">
                                        <span id="wibHours">--</span>
                                        <span class="time-colon">:</span>
                                        <span id="wibMinutes">--</span>
                                    </div>
                                    <div class="time-date" id="wibDate">Loading...</div>
                                    <div class="time-zone">WIB • Indonesia</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
    <!-- Kiri: 4 Card KPI -->
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="card-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                            <span class="metric-badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrow-up me-1"></i>12.5%
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">12,489</h4>
                        <p class="text-muted mb-0">Total Users</p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>Last 30 days
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="card-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-recycle"></i>
                            </div>
                            <span class="metric-badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrow-up me-1"></i>8.3%
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">38,472</h4>
                        <p class="text-muted mb-0">Recycling Activities</p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-activity me-1"></i>Live tracking
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="card-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <span class="metric-badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrow-up me-1"></i>15.2%
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">1,567</h4>
                        <p class="text-muted mb-0">Articles Published</p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>245K views
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="card-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <span class="metric-badge bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-arrow-down me-1"></i>2.1%
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">892</h4>
                        <p class="text-muted mb-0">User Testimonials</p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-star me-1"></i>4.8 avg rating
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanan: Quick Actions -->
    <div class="col-lg-4">
        <div class="card quick-action-card border-0 shadow-sm mb-3">
            <div class="card-header bg-transparent border-0 py-3">
                <div class="section-header">
                    <h5 class="card-title fw-bold mb-0 text-dark">Quick Actions</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('admin.users.create') }}">
                            <button class="btn quick-action-btn w-100 h-100 p-2 text-start">
                                <div class="text-primary mb-1">
                                    <i class="bi bi-person-plus-fill fs-5"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Add User</h6>
                                <small class="text-muted">Create account</small>
                            </button>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.articles.create') }}">
                            <button class="btn quick-action-btn w-100 h-100 p-2 text-start">
                                <div class="text-success mb-1">
                                    <i class="bi bi-file-earmark-plus-fill fs-5"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">New Article</h6>
                                <small class="text-muted">Publish content</small>
                            </button>
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn quick-action-btn w-100 h-100 p-2 text-start">
                            <div class="text-warning mb-1">
                                <i class="bi bi-graph-up-arrow fs-5"></i>
                            </div>
                            <h6 class="fw-semibold mb-1">Analytics</h6>
                            <small class="text-muted">View reports</small>
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn quick-action-btn w-100 h-100 p-2 text-start">
                            <div class="text-info mb-1">
                                <i class="bi bi-gear-fill fs-5"></i>
                            </div>
                            <h6 class="fw-semibold mb-1">Settings</h6>
                            <small class="text-muted">System config</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // WIB Time Function with smooth animations
    function updateWIBTime() {
        const now = new Date();

        // Convert to WIB (UTC+7)
        const wibOffset = 7 * 60;
        const localOffset = now.getTimezoneOffset();
        const wibTime = new Date(now.getTime() + (localOffset + wibOffset) * 60000);

        // Get time components
        const hours = wibTime.getHours();
        const minutes = wibTime.getMinutes();

        // Format time with leading zeros
        const formattedHours = hours.toString().padStart(2, '0');
        const formattedMinutes = minutes.toString().padStart(2, '0');

        // Format date in Indonesian
        const options = {
            weekday: 'short',
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        };
        const dateString = wibTime.toLocaleDateString('id-ID', options);

        // Update DOM with smooth transitions (only for time)
        const hoursElement = document.getElementById('wibHours');
        const minutesElement = document.getElementById('wibMinutes');
        const dateElement = document.getElementById('wibDate');

        // Add subtle animation when time changes
        if (hoursElement.textContent !== formattedHours) {
            hoursElement.style.transform = 'scale(1.05)';
            setTimeout(() => hoursElement.style.transform = 'scale(1)', 150);
        }
        if (minutesElement.textContent !== formattedMinutes) {
            minutesElement.style.transform = 'scale(1.05)';
            setTimeout(() => minutesElement.style.transform = 'scale(1)', 150);
        }

        hoursElement.textContent = formattedHours;
        minutesElement.textContent = formattedMinutes;
        dateElement.textContent = dateString;
    }

    // Update time every minute
    updateWIBTime();
    setInterval(updateWIBTime, 60000);

    // Initialize Charts
    function initializeCharts() {
        // Main Chart
        const mainCtx = document.getElementById('mainChart').getContext('2d');
        const mainChart = new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [
                    {
                        label: 'User Registrations',
                        data: [1650, 1780, 1900, 2100, 2350, 2680, 3120],
                        borderColor: '#2e7d32',
                        backgroundColor: 'rgba(46, 125, 50, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    },
                    {
                        label: 'Recycling Activities',
                        data: [1280, 1480, 1700, 1950, 2260, 2570, 2890],
                        borderColor: '#66bb6a',
                        backgroundColor: 'rgba(102, 187, 106, 0.05)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Articles', 'Recycling Data', 'Testimonials', 'Users'],
                datasets: [{
                    data: [35, 25, 15, 25],
                    backgroundColor: [
                        '#2e7d32',
                        '#66bb6a',
                        '#a5d6a7',
                        '#e8f5e9'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Interactive elements
    const periodButtons = document.querySelectorAll('.btn-group .btn');
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            periodButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });

    initializeCharts();
});
</script>
@endpush
