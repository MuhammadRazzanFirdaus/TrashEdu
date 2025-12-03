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
        <!-- Header Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="h4 mb-2 text-dark-green fw-bold">
                            <i class="bi bi-question-circle me-2"></i>Quiz Management
                        </h2>
                        <p class="text-muted mb-0">Kelola semua kuis dan pertanyaan di sistem TrashEdu</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <!-- Export Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Export Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.quizzes.export') }}?type=all">
                                            <i class="bi bi-question-circle me-2"></i> Semua Quiz (.xlxx)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.quizzes.export') }}?type=trash">
                                            <i class="bi bi-trash me-2"></i> Quiz di Trash (.xlxx)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.quizzes.export.pdf') }}?type=all">
                                            <i class="bi bi-question-circle me-2"></i> Semua Quiz (.pdf)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.quizzes.export.pdf') }}?type=trash">
                                            <i class="bi bi-trash me-2"></i> Quiz di Trash (.pdf)
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="{{ route('admin.quizzes.trash') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-trash me-1"></i> Trash
                            </a>
                            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Buat Quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
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

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4">#</th>
                                <th class="border-0">Quiz</th>
                                <th class="border-0">Deskripsi</th>
                                <th class="border-0">Pertanyaan</th>
                                <th class="border-0">Reward</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quizzes as $quiz)
                                <tr class="align-middle">
                                    <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- Thumbnail -->
                                            <div class="avatar-sm me-3 position-relative">
                                                <img src="{{ $quiz->thumbnail ? asset('storage/' . $quiz->thumbnail) : asset('images/default-quiz-thumbnail.jpg') }}"
                                                    class="rounded-circle object-fit-cover"
                                                    style="width: 40px; height: 40px;" alt="{{ $quiz->title }}">
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark-green fw-semibold">{{ $quiz->title }}</h6>
                                                <small class="text-muted">ID: {{ $quiz->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark-green">{{ Str::limit($quiz->description, 50) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $quiz->questions_count }} Soal</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star me-1"></i>{{ $quiz->point_reward }} Point
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $quiz->is_active ? 'success' : 'secondary' }}">
                                            {{ $quiz->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                                class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Edit Quiz">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Hapus quiz ini?')" data-bs-toggle="tooltip"
                                                    title="Hapus Quiz">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <i class="bi bi-question-circle display-1 text-muted"></i>
                                            <h5 class="text-muted mt-3">Belum ada data quiz</h5>
                                            <p class="text-muted">Mulai dengan membuat quiz baru</p>
                                            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-success">
                                                <i class="bi bi-plus-circle me-1"></i> Buat Quiz
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Jalankan kode setelah halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang punya atribut data-bs-toggle="tooltip"
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

            // Aktifkan tooltip Bootstrap untuk setiap elemen
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
