@extends('templates.admin')

@push('style')
    <style>
        .text-dark-green {
            color: var(--dark-green);
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.5rem;
        }

        .object-fit-cover {
            object-fit: cover;
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
                            <i class="bi bi-trash me-2"></i>Quiz Trash
                        </h2>
                        <p class="text-muted mb-0">Data quiz yang telah dihapus (soft delete)</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Quizzes
                        </a>
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

                @if ($quizzes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Quiz</th>
                                    <th class="border-0">Deskripsi</th>
                                    <th class="border-0">Pertanyaan</th>
                                    <th class="border-0">Reward</th>
                                    <th class="border-0">Dihapus Pada</th>
                                    <th class="border-0 text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes as $quiz)
                                    <tr class="align-middle">
                                        <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <!-- Thumbnail -->
                                                <div class="avatar-sm me-3 position-relative">
                                                    <img src="{{ $quiz->thumbnail ? asset('storage/' . $quiz->thumbnail) : asset('images/default-quiz-thumbnail.jpg') }}"
                                                        class="rounded-circle object-fit-cover"
                                                        style="width: 40px; height: 40px;" alt="{{ $quiz->title }}">
                                                    <div
                                                        class="position-absolute top-0 start-100 translate-middle badge border border-white rounded-circle bg-secondary p-1">
                                                        <i class="bi bi-question text-white" style="font-size: 0.6rem;"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-dark-green fw-semibold">{{ $quiz->title }}</h6>
                                                    <small class="text-muted">ID: {{ $quiz->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ Str::limit($quiz->description, 50) }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $quiz->questions_count }} Soal</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-star me-1"></i>{{ $quiz->point_reward }} Point
                                            </span>
                                        </td>
                                        <td class="text-muted">
                                            {{ $quiz->deleted_at->format('d/m/Y') }}
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.quizzes.restore', $quiz->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success"
                                                        onclick="return confirm('Pulihkan quiz ini?')"
                                                        data-bs-toggle="tooltip" title="Restore Quiz">
                                                        <i class="bi bi-arrow-clockwise"></i> Restore
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.quizzes.force-delete', $quiz->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Hapus permanen quiz ini? Tindakan ini tidak dapat dibatalkan!')"
                                                        data-bs-toggle="tooltip" title="Hapus Permanen">
                                                        <i class="bi bi-trash-fill"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-trash display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Trash kosong</h5>
                        <p class="text-muted">Tidak ada data quiz yang dihapus</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang punya atribut data-bs-toggle="tooltip"
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip']))

        // Aktifkan tooltip Bootstrap untuk setiap elemen yang ditemukan
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        });
    </script>
@endpush
