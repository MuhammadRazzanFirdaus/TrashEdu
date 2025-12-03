@extends('templates.admin')

@push('style')
    <style>
        .text-dark-green {
            color: var(--dark-green);
        }

        .bg-light-green {
            background-color: var(--light-green);
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="h4 mb-2 text-dark-green fw-bold">
                            <i class="bi bi-bar-chart me-2"></i>Statistik Progress
                        </h2>
                        <p class="text-muted mb-0">Analytics dan insights progress user</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.progress.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Progress
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold">{{ $totalUsers ?? 0 }}</h3>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <i class="bi bi-people fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold">{{ $totalQuizzes ?? 0 }}</h3>
                                <p class="mb-0">Active Quizzes</p>
                            </div>
                            <i class="bi bi-question-circle fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold">{{ $totalAttempts ?? 0 }}</h3>
                                <p class="mb-0">Total Attempts</p>
                            </div>
                            <i class="bi bi-graph-up fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold">{{ $completedAttempts ?? 0 }}</h3>
                                <p class="mb-0">Completed</p>
                            </div>
                            <i class="bi bi-check-circle fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Top Performers -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-trophy me-2"></i>Top Performers</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($topPerformers) && $topPerformers->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($topPerformers as $performer)
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-light-green rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <span class="text-white fw-bold">
                                                    {{ substr($performer->user->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark-green fw-semibold">
                                                    {{ $performer->user->name ?? 'Unknown User' }}</h6>
                                                <small
                                                    class="text-muted">{{ $performer->user->email ?? 'No email' }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary">{{ round($performer->avg_score, 1) }}/100</span>
                                            <small class="text-muted d-block">{{ $performer->quiz_count }} quizzes</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-trophy display-1 text-muted"></i>
                                <p class="text-muted mt-3">Belum ada data performers</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Popular Quizzes -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-fire me-2"></i>Popular Quizzes</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($popularQuizzes) && $popularQuizzes->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($popularQuizzes as $quiz)
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <h6 class="mb-0 text-dark-green fw-semibold">{{ $quiz->title }}</h6>
                                            <small class="text-muted">{{ $quiz->questions_count }} questions •
                                                {{ $quiz->point_reward }} points</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-info">{{ $quiz->attempts_count }} attempts</span>
                                            <small class="text-muted d-block">{{ $quiz->average_score ?? 0 }}/100
                                                avg</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-fire display-1 text-muted"></i>
                                <p class="text-muted mt-3">Belum ada data quiz</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Completion Rate</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h2 class="text-primary fw-bold">{{ $totalAttempts ?? 0 }}</h2>
                                    <small class="text-muted">Total Attempts</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h2 class="text-success fw-bold">{{ $completedAttempts ?? 0 }}</h2>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h2 class="text-info fw-bold">
                                        @php
                                            $total = $totalAttempts ?? 0;
                                            $completed = $completedAttempts ?? 0;
                                            $rate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                                        @endphp
                                        {{ $rate }}%
                                    </h2>
                                    <small class="text-muted">Completion Rate</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
