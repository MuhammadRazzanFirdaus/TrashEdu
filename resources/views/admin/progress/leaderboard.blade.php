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

        .table> :not(caption)>*>* {
            padding: 1rem 0.5rem;
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
                            <i class="bi bi-trophy me-2"></i>Leaderboard Quiz
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.index') }}"
                                        class="text-decoration-none">Progress</a></li>
                                <li class="breadcrumb-item active">Leaderboard</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.progress.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="text-dark-green fw-bold mb-2">{{ $quiz->title }}</h3>
                        <p class="text-muted mb-3">{{ $quiz->description }}</p>
                        <div class="d-flex gap-4">
                            <span class="text-muted">
                                <i class="bi bi-question-circle me-1"></i>{{ $quiz->questions_count }} Soal
                            </span>
                            <span class="text-muted">
                                <i class="bi bi-star me-1"></i>{{ $quiz->point_reward }} Points
                            </span>
                            <span class="text-muted">
                                <i class="bi bi-people me-1"></i>{{ $leaderboard->total() }} Participants
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <h4 class="text-primary fw-bold mb-1">{{ $quiz->average_score }}/100</h4>
                                <small class="text-muted">Average Score</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if ($leaderboard->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4 text-center">Rank</th>
                                    <th class="border-0">User</th>
                                    <th class="border-0 text-center">Score</th>
                                    <th class="border-0 text-center">Correct</th>
                                    <th class="border-0 text-center">Waktu</th>
                                    <th class="border-0 text-center">Points</th>
                                    <th class="border-0 text-center">Selesai</th>
                                    <th class="border-0 text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaderboard as $progress)
                                    <tr class="align-middle {{ $loop->first ? 'table-success' : '' }}">
                                        <td class="ps-4 text-center">
                                            @if ($loop->first)
                                                <span class="badge bg-warning text-dark fs-6">🥇</span>
                                            @elseif($loop->iteration == 2)
                                                <span class="badge bg-secondary fs-6">🥈</span>
                                            @elseif($loop->iteration == 3)
                                                <span class="badge bg-warning text-dark fs-6">🥉</span>
                                            @else
                                                <span class="fw-semibold text-muted">#{{ $loop->iteration }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-light-green rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <span
                                                        class="text-white fw-bold">{{ substr($progress->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-dark-green fw-semibold">
                                                        {{ $progress->user->name }}</h6>
                                                    <small class="text-muted">{{ $progress->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $progress->score >= 80 ? 'success' : ($progress->score >= 60 ? 'warning' : 'danger') }} fs-6">
                                                {{ $progress->score }}/100
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-dark-green fw-semibold">
                                                {{ $progress->correct_answers }}/{{ $progress->total_questions }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-muted">{{ $progress->formatted_time }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-star me-1"></i>{{ $progress->quiz->point_reward }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <small
                                                class="text-muted">{{ $progress->completed_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.progress.show', $progress->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-body border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-0">Menampilkan {{ $leaderboard->firstItem() }} -
                                {{ $leaderboard->lastItem() }} dari {{ $leaderboard->total() }} participants</p>
                            {{ $leaderboard->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-trophy display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Belum ada participant</h5>
                        <p class="text-muted">Belum ada user yang menyelesaikan quiz ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
