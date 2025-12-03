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
                            <i class="bi bi-clock-history me-2"></i>Riwayat Progress
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.index') }}"
                                        class="text-decoration-none">Progress</a></li>
                                <li class="breadcrumb-item active">Riwayat User</li>
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

        <!-- User Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div
                                class="avatar-lg bg-light-green rounded-circle d-flex align-items-center justify-content-center me-4">
                                <span class="text-white fw-bold fs-4">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-dark-green fw-bold mb-1">{{ $user->name }}</h3>
                                <p class="text-muted mb-2">{{ $user->email }}</p>
                                <div class="d-flex gap-3">
                                    <span class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>Bergabung:
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="text-primary fw-bold">{{ $stats['total_quizzes'] }}</h4>
                                <small class="text-muted">Total Quiz</small>
                            </div>
                            <div class="col-4">
                                <h4 class="text-success fw-bold">{{ $stats['average_score'] }}</h4>
                                <small class="text-muted">Avg Score</small>
                            </div>
                            <div class="col-4">
                                <h4 class="text-warning fw-bold">{{ $stats['total_points'] }}</h4>
                                <small class="text-muted">Total Points</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress History -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if ($progresses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Quiz</th>
                                    <th class="border-0 text-center">Score</th>
                                    <th class="border-0 text-center">Correct</th>
                                    <th class="border-0 text-center">Waktu</th>
                                    <th class="border-0 text-center">Points</th>
                                    <th class="border-0 text-center">Selesai</th>
                                    <th class="border-0 text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progresses as $progress)
                                    <tr class="align-middle">
                                        <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <h6 class="mb-0 text-dark-green">{{ $progress->quiz->title }}</h6>
                                            <small class="text-muted">{{ $progress->quiz->questions_count }} soal</small>
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
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.progress.show', $progress->id) }}"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    title="Detail Progress">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.progress.edit', $progress->id) }}"
                                                    class="btn btn-outline-warning" data-bs-toggle="tooltip"
                                                    title="Edit Progress">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-body border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-0">Menampilkan {{ $progresses->firstItem() }} -
                                {{ $progresses->lastItem() }} dari {{ $progresses->total() }} progress</p>
                            {{ $progresses->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clock-history display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Belum ada riwayat progress</h5>
                        <p class="text-muted">User ini belum mengerjakan quiz apapun</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang memiliki atribut data-bs-toggle="tooltip"
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

            // Looping setiap elemen yang ditemukan dan aktifkan tooltip-nya
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                // Inisialisasi tooltip Bootstrap pada elemen tersebut
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Setelah ini, semua elemen dengan data-bs-toggle="tooltip" akan menampilkan tooltip saat di-hover
        });
    </script>
@endpush
