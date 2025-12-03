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
                            <i class="bi bi-graph-up me-2"></i>Progress Quiz
                        </h2>
                        <p class="text-muted mb-0">Kelola dan pantau progress user dalam mengerjakan quiz</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.progress.statistics') }}" class="btn btn-info btn-sm">
                                <i class="bi bi-bar-chart me-1"></i> Statistik
                            </a>
                            <a href="{{ route('admin.progress.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Progress
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.progress.index') }}" method="GET" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-dark-green fw-semibold">Filter User</label>
                            <select class="form-select" name="user_id"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark-green fw-semibold">Filter Quiz</label>
                            <select class="form-select" name="quiz_id"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Quiz</option>
                                @foreach ($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}"
                                        {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                        {{ $quiz->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark-green fw-semibold">Status</label>
                            <select class="form-select" name="status"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="incomplete" {{ request('status') == 'incomplete' ? 'selected' : '' }}>
                                    Incomplete</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($progresses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">User</th>
                                    <th class="border-0">Quiz</th>
                                    <th class="border-0 text-center">Score</th>
                                    <th class="border-0 text-center">Correct</th>
                                    <th class="border-0 text-center">Waktu</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-center">Selesai</th>
                                    <th class="border-0 text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progresses as $progress)
                                    <tr class="align-middle">
                                        <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
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
                                        <td>
                                            <h6 class="mb-0 text-dark-green">{{ $progress->quiz->title }}</h6>
                                            <small class="text-muted">{{ $progress->quiz->questions_count }} soal</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $progress->score }}/100</span>
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
                                            <span class="badge bg-{{ $progress->completed_at ? 'success' : 'warning' }}">
                                                {{ $progress->completed_at ? 'Completed' : 'In Progress' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($progress->completed_at)
                                                <small
                                                    class="text-muted">{{ $progress->completed_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
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
                                                <form action="{{ route('admin.progress.destroy', $progress->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Hapus progress ini?')"
                                                        data-bs-toggle="tooltip" title="Hapus Progress">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
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
                        <i class="bi bi-graph-up display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Belum ada data progress</h5>
                        <p class="text-muted">Mulai dengan menambahkan progress baru</p>
                        <a href="{{ route('admin.progress.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Progress
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Ambil semua elemen yang memiliki atribut data-bs-toggle="tooltip" ---
            // Elemen-elemen ini adalah tombol-tombol aksi (detail, edit, hapus) yang akan menampilkan tooltip saat dihover.
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

            // --- Inisialisasi Tooltip Bootstrap untuk setiap elemen tersebut ---
            // Fungsi map() digunakan untuk membuat instance Tooltip baru di setiap elemen tombol.
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                // bootstrap.Tooltip() adalah class dari Bootstrap untuk mengaktifkan tooltip interaktif
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
