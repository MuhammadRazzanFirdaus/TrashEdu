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

        .form-control:focus,
        .form-select:focus {
            border-color: var(--light-green);
            box-shadow: 0 0 0 0.2rem rgba(102, 187, 106, 0.25);
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
                            <i class="bi bi-pencil me-2"></i>Edit Progress
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.index') }}"
                                        class="text-decoration-none">Progress</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.show', $progress->id) }}"
                                        class="text-decoration-none">Detail</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.progress.show', $progress->id) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.progress.update', $progress->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="text-dark-green fw-bold mb-3">Informasi User</h6>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-sm bg-light-green rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <span
                                                class="text-white fw-bold">{{ substr($progress->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark-green fw-semibold">{{ $progress->user->name }}</h6>
                                            <small class="text-muted">{{ $progress->user->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="text-dark-green fw-bold mb-3">Informasi Quiz</h6>
                                    <h6 class="mb-0 text-dark-green">{{ $progress->quiz->title }}</h6>
                                    <small class="text-muted">{{ $progress->quiz->questions_count }} soal •
                                        {{ $progress->quiz->point_reward }} points</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="score" class="form-label text-dark-green fw-semibold">Score <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('score') is-invalid @enderror"
                                    id="score" name="score" value="{{ old('score', $progress->score) }}"
                                    min="0" max="100" required>
                                @error('score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="correct_answers" class="form-label text-dark-green fw-semibold">Jawaban Benar
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('correct_answers') is-invalid @enderror"
                                    id="correct_answers" name="correct_answers"
                                    value="{{ old('correct_answers', $progress->correct_answers) }}" min="0"
                                    required>
                                @error('correct_answers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="total_questions" class="form-label text-dark-green fw-semibold">Total Soal <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_questions') is-invalid @enderror"
                                    id="total_questions" name="total_questions"
                                    value="{{ old('total_questions', $progress->total_questions) }}" min="1"
                                    required>
                                @error('total_questions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="time_spent" class="form-label text-dark-green fw-semibold">Waktu (detik) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('time_spent') is-invalid @enderror"
                                    id="time_spent" name="time_spent"
                                    value="{{ old('time_spent', $progress->time_spent) }}" min="1" required>
                                @error('time_spent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="completed_at" class="form-label text-dark-green fw-semibold">Tanggal Selesai
                                    <span class="text-danger">*</span></label>
                                <input type="datetime-local"
                                    class="form-control @error('completed_at') is-invalid @enderror" id="completed_at"
                                    name="completed_at"
                                    value="{{ old('completed_at', $progress->completed_at->format('Y-m-d\TH:i')) }}"
                                    required>
                                @error('completed_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.progress.show', $progress->id) }}"
                                class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Update Progress
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Ambil elemen input yang diperlukan ---
            // Elemen input untuk jumlah jawaban benar, total soal, dan skor
            const correctAnswersInput = document.getElementById('correct_answers');
            const totalQuestionsInput = document.getElementById('total_questions');
            const scoreInput = document.getElementById('score');

            // --- Fungsi untuk menghitung nilai otomatis ---
            function calculateScore() {
                // Ambil nilai jawaban benar dan total soal
                const correct = parseInt(correctAnswersInput.value) || 0; // jika kosong, dianggap 0
                const total = parseInt(totalQuestionsInput.value) ||
                1; // jika kosong, dianggap 1 agar tidak dibagi 0

                // Rumus: (jawaban benar / total soal) * 100
                const score = Math.round((correct / total) * 100);

                // Masukkan hasil ke input skor
                scoreInput.value = score;
            }

            // --- Event Listener ---
            // Jalankan perhitungan ulang setiap kali user mengubah input jawaban benar atau total soal
            correctAnswersInput.addEventListener('input', calculateScore);
            totalQuestionsInput.addEventListener('input', calculateScore);
        });
    </script>
@endpush
