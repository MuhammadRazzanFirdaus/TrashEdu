@extends('templates.admin')

@push('style')
    <style>
        .text-dark-green {
            color: var(--dark-green);
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
                            <i class="bi bi-plus-circle me-2"></i>Tambah Progress Baru
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.progress.index') }}"
                                        class="text-decoration-none">Progress</a></li>
                                <li class="breadcrumb-item active">Tambah Progress</li>
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

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.progress.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label text-dark-green fw-semibold">User <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" required>
                                    <option value="">Pilih User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quiz_id" class="form-label text-dark-green fw-semibold">Quiz <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('quiz_id') is-invalid @enderror" id="quiz_id"
                                    name="quiz_id" required>
                                    <option value="">Pilih Quiz</option>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}"
                                            {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                            {{ $quiz->title }} ({{ $quiz->questions_count }} soal)
                                        </option>
                                    @endforeach
                                </select>
                                @error('quiz_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="score" class="form-label text-dark-green fw-semibold">Score <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('score') is-invalid @enderror"
                                    id="score" name="score" value="{{ old('score', 0) }}" min="0"
                                    max="100" required>
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
                                    id="correct_answers" name="correct_answers" value="{{ old('correct_answers', 0) }}"
                                    min="0" required>
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
                                    id="total_questions" name="total_questions" value="{{ old('total_questions', 1) }}"
                                    min="1" required>
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
                                    id="time_spent" name="time_spent" value="{{ old('time_spent', 0) }}" min="1"
                                    required>
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
                                    name="completed_at" value="{{ old('completed_at', now()->format('Y-m-d\TH:i')) }}"
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
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Simpan Progress
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
            // 🔹 Ambil elemen input yang dibutuhkan dari form
            const correctAnswersInput = document.getElementById('correct_answers'); // Input jumlah jawaban benar
            const totalQuestionsInput = document.getElementById('total_questions'); // Input jumlah total soal
            const scoreInput = document.getElementById('score'); // Input skor (akan dihitung otomatis)

            /**
             * 🔸 Fungsi calculateScore()
             * Fungsi ini otomatis menghitung skor berdasarkan jumlah jawaban benar dan total soal.
             * Rumus: (jawaban_benar / total_soal) * 100, lalu dibulatkan dengan Math.round().
             */
            function calculateScore() {
                // Ambil nilai input 'jawaban benar', jika kosong maka gunakan 0
                const correct = parseInt(correctAnswersInput.value) || 0;

                // Ambil nilai input 'total soal', jika kosong maka gunakan 1 agar tidak membagi 0
                const total = parseInt(totalQuestionsInput.value) || 1;

                // Hitung skor dalam bentuk persen
                const score = Math.round((correct / total) * 100);

                // Tampilkan hasil perhitungan skor ke input 'score'
                scoreInput.value = score;
            }

            // 🔹 Tambahkan event listener agar setiap perubahan di input langsung menghitung ulang skor
            correctAnswersInput.addEventListener('input', calculateScore); // Saat jumlah jawaban benar berubah
            totalQuestionsInput.addEventListener('input', calculateScore); // Saat total soal berubah
        });
    </script>
@endpush
