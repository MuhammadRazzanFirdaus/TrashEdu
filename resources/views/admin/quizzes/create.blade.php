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

        .question-card {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: #f8f9fa;
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
                            <i class="bi bi-plus-circle me-2"></i>Buat Quiz Baru
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}"
                                        class="text-decoration-none">Quizzes</a></li>
                                <li class="breadcrumb-item active">Buat Quiz</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.quizzes.store') }}" method="POST" id="quizForm"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column - Form Fields -->
                        <div class="col-md-8">
                            <!-- Informasi Quiz -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark-green mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Quiz
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title" class="form-label text-dark-green fw-semibold">Judul
                                                    Quiz <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                                    name="title" value="{{ old('title') }}"
                                                    placeholder="Masukkan judul quiz" required>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="point_reward"
                                                    class="form-label text-dark-green fw-semibold">Point Reward <span
                                                        class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('point_reward') is-invalid @enderror"
                                                    id="point_reward" name="point_reward"
                                                    value="{{ old('point_reward', 10) }}" min="1" required>
                                                @error('point_reward')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label text-dark-green fw-semibold">Deskripsi
                                            Quiz</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="Masukkan deskripsi quiz">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" checked>
                                        <label class="form-check-label text-dark-green fw-semibold" for="is_active">Aktifkan
                                            Quiz</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Pertanyaan -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="text-dark-green mb-0"><i
                                                class="bi bi-question-circle me-2"></i>Pertanyaan</h5>
                                        <button type="button" class="btn btn-success btn-sm" id="addQuestion">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Pertanyaan
                                        </button>
                                    </div>

                                    <div id="questions-container">
                                        <!-- Pertanyaan akan ditambahkan di sini oleh JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Thumbnail Upload -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light-green text-white">
                                    <h6 class="mb-0">
                                        <i class="bi bi-image me-2"></i>Thumbnail Quiz
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <!-- Preview Image -->
                                    <div class="mb-3">
                                        <img id="thumbnailPreview" src="{{ asset('images/default-quiz-thumbnail.jpg') }}"
                                            class="img-thumbnail rounded"
                                            style="max-height: 200px; width: auto; object-fit: cover;"
                                            alt="Preview Thumbnail">
                                    </div>

                                    <!-- Upload Input -->
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label text-dark-green fw-semibold">
                                            Upload Thumbnail
                                        </label>
                                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" name="thumbnail" accept="image/*">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Format: JPG, PNG, GIF. Maksimal: 2MB
                                        </div>
                                    </div>
                                </div>
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
                                <i class="bi bi-check-circle me-1"></i> Simpan Quiz
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
            // Inisialisasi variabel untuk menghitung jumlah pertanyaan
            let questionCount = 0;

            // Ambil elemen utama yang digunakan untuk menampung pertanyaan
            const questionsContainer = document.getElementById('questions-container');

            // Ambil elemen input file dan preview thumbnail
            const thumbnailInput = document.getElementById('thumbnail');
            const thumbnailPreview = document.getElementById('thumbnailPreview');

            // === Preview gambar thumbnail saat file dipilih ===
            thumbnailInput.addEventListener('change', function() {
                const file = this.files[0]; // Ambil file yang diupload
                if (file) {
                    const reader = new FileReader(); // Buat pembaca file
                    reader.onload = function(e) {
                        // Tampilkan hasil baca file ke elemen <img>
                        thumbnailPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file); // Baca file dalam format base64
                }
            });

            // === Template HTML untuk setiap pertanyaan baru ===
            function createQuestionTemplate(index) {
                return `
        <div class="question-card" data-index="${index}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-dark-green mb-0">Pertanyaan #${index + 1}</h6>
                <!-- Tombol hapus pertanyaan (tidak aktif di pertanyaan pertama) -->
                <button type="button" class="btn btn-outline-danger btn-sm remove-question" ${index === 0 ? 'disabled' : ''}>
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <!-- Input pertanyaan -->
            <div class="mb-3">
                <label class="form-label text-dark-green fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                <textarea class="form-control" name="questions[${index}][question]" rows="2" placeholder="Masukkan pertanyaan" required></textarea>
            </div>

            <!-- Input opsi A & B -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Opsi A <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${index}][option_a]" placeholder="Jawaban A" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Opsi B <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${index}][option_b]" placeholder="Jawaban B" required>
                </div>
            </div>

            <!-- Input opsi C & D -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Opsi C <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${index}][option_c]" placeholder="Jawaban C" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Opsi D <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${index}][option_d]" placeholder="Jawaban D" required>
                </div>
            </div>

            <!-- Pilih jawaban benar dan nilai point -->
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Jawaban Benar <span class="text-danger">*</span></label>
                    <select class="form-select" name="questions[${index}][correct_answer]" required>
                        <option value="">Pilih Jawaban Benar</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark-green fw-semibold">Point <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="questions[${index}][point]" value="5" min="1" required>
                </div>
            </div>
        </div>
        `;
            }

            // === Fungsi untuk menambah pertanyaan baru ===
            document.getElementById('addQuestion').addEventListener('click', function() {
                // Buat elemen HTML pertanyaan baru berdasarkan template
                const questionHtml = createQuestionTemplate(questionCount);
                // Tambahkan ke dalam container pertanyaan
                questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
                // Tambah jumlah total pertanyaan
                questionCount++;
            });

            // === Fungsi untuk menghapus pertanyaan ===
            questionsContainer.addEventListener('click', function(e) {
                // Cek jika tombol hapus diklik
                if (e.target.closest('.remove-question')) {
                    const questionCard = e.target.closest('.question-card');
                    const index = parseInt(questionCard.dataset.index);

                    // Cegah penghapusan pertanyaan pertama (index 0)
                    if (index > 0) {
                        questionCard.remove();
                        // Perbarui nomor dan nama input pertanyaan setelah dihapus
                        updateQuestionNumbers();
                    }
                }
            });

            // === Update ulang urutan dan nama input pertanyaan ===
            function updateQuestionNumbers() {
                const questionCards = questionsContainer.querySelectorAll('.question-card');
                questionCards.forEach((card, index) => {
                    // Update nomor urutan di judul pertanyaan
                    const title = card.querySelector('h6');
                    title.textContent = `Pertanyaan #${index + 1}`;
                    card.dataset.index = index;

                    // Update atribut "name" untuk semua input dan select
                    const inputs = card.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            // Ganti indeks lama dengan indeks baru
                            const newName = name.replace(/questions\[\d+\]/, `questions[${index}]`);
                            input.setAttribute('name', newName);
                        }
                    });
                });

                // Update jumlah pertanyaan yang tersisa
                questionCount = questionCards.length;
            }

            // === Tambahkan pertanyaan pertama secara otomatis saat halaman dimuat ===
            document.getElementById('addQuestion').click();
        });
    </script>
@endpush
