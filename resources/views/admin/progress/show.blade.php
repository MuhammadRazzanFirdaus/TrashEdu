@extends('templates.admin')

@push('style')
    <style>
        .text-dark-green {
            color: var(--dark-green);
        }

        .bg-light-green {
            background-color: var(--light-green);
        }

        .avatar-lg {
            width: 80px;
            height: 80px;
            font-size: 2rem;
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
                            <i class="bi bi-eye me-2"></i>Detail Progress
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.index') }}"
                                        class="text-decoration-none">Progress</a></li>
                                <li class="breadcrumb-item active">Detail Progress</li>
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

        <div class="row">
            <!-- User & Quiz Info -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light-green text-white">
                        <h6 class="mb-0"><i class="bi bi-person me-2"></i>Informasi User</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div
                                class="avatar-lg bg-light-green rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <span class="text-white fw-bold fs-4">{{ substr($progress->user->name, 0, 1) }}</span>
                            </div>
                            <h5 class="text-dark-green fw-bold">{{ $progress->user->name }}</h5>
                            <p class="text-muted mb-0">{{ $progress->user->email }}</p>
                        </div>
                        <a href="{{ route('admin.progress.user.history', $progress->user->id) }}"
                            class="btn btn-outline-primary w-100">
                            <i class="bi bi-clock-history me-1"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-question-circle me-2"></i>Informasi Quiz</h6>
                    </div>
                    <div class="card-body">
                        <h6 class="text-dark-green fw-bold">{{ $progress->quiz->title }}</h6>
                        <p class="text-muted small">{{ $progress->quiz->description }}</p>
                        <div class="row text-center">
                            <div class="col-6">
                                <small class="text-muted">Total Soal</small>
                                <h6 class="text-dark-green fw-bold">{{ $progress->quiz->questions_count }}</h6>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Reward</small>
                                <h6 class="text-warning fw-bold">{{ $progress->quiz->point_reward }} pts</h6>
                            </div>
                        </div>
                        <a href="{{ route('admin.progress.quiz.leaderboard', $progress->quiz->id) }}"
                            class="btn btn-outline-info w-100 mt-2">
                            <i class="bi bi-trophy me-1"></i> Lihat Leaderboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Details -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Detail Progress</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-4">
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary fw-bold">{{ $progress->score }}/100</h3>
                                    <small class="text-muted">Score</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-success fw-bold">
                                        {{ $progress->correct_answers }}/{{ $progress->total_questions }}</h3>
                                    <small class="text-muted">Jawaban Benar</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-info fw-bold">{{ $progress->percentage }}%</h3>
                                    <small class="text-muted">Persentase</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-warning fw-bold">{{ $progress->formatted_time }}</h3>
                                    <small class="text-muted">Waktu</small>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-dark-green fw-semibold">Progress Pengerjaan</span>
                                <span class="text-muted">{{ $progress->percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $progress->percentage }}%"
                                    aria-valuenow="{{ $progress->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <td class="border-0 text-muted">Status:</td>
                                        <td class="border-0">
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 text-muted">Selesai Pada:</td>
                                        <td class="border-0">{{ $progress->completed_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <td class="border-0 text-muted">Dibuat:</td>
                                        <td class="border-0">{{ $progress->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 text-muted">Diupdate:</td>
                                        <td class="border-0">{{ $progress->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('admin.progress.edit', $progress->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i> Edit Progress
                            </a>
                            <form action="{{ route('admin.progress.destroy', $progress->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Hapus progress ini?')">
                                    <i class="bi bi-trash me-1"></i> Hapus Progress
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
