@extends('templates.admin')

@push('style')
<style>
    .form-control {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.1);
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .btn {
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .card {
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="fw-bold text-dark mb-2">Buat Artikel Baru</h4>
            <p class="text-muted mb-0">Tambahkan konten edukasi tentang pengelolaan sampah</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 py-4">
            <h5 class="card-title mb-0 fw-bold">
                <i class="bi bi-pencil-square me-3 text-primary"></i>Form Artikel Baru
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.articles.store') }}" method="POST" id="articleForm">
                @csrf

                <!-- Judul Section -->
                <div class="mb-5">
                    <label for="title" class="form-label fw-semibold mb-3">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           placeholder="Contoh: Cara Memilah Sampah yang Benar"
                           required
                           maxlength="200">
                    <div class="form-text text-muted mt-2">
                        <span id="titleCount">0</span>/200 karakter
                    </div>
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konten Section -->
                <div class="mb-5">
                    <label for="content" class="form-label fw-semibold mb-3">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="content"
                              id="content"
                              rows="15"
                              class="form-control @error('content') is-invalid @enderror"
                              placeholder="Tulis konten artikel Anda di sini..."
                              required>{{ old('content') }}</textarea>
                    <div class="form-text text-muted mt-2">
                        Minimal 100 karakter untuk konten yang berkualitas
                    </div>
                    @error('content')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between pt-4 border-top">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i> Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 🔹 Mengatur judul halaman dan breadcrumb ketika halaman selesai dimuat
        updatePageTitle('Buat Artikel Baru', 'Articles');

        // 🔹 Mengatur menu sidebar yang sedang aktif
        setActiveMenu('articles');

        // === Fitur Penghitung Karakter untuk Input Judul ===
        const titleInput = document.getElementById('title');
        const titleCount = document.getElementById('titleCount');

        if (titleInput && titleCount) {
            // Saat pengguna mengetik di kolom judul
            titleInput.addEventListener('input', function() {
                // Menampilkan jumlah karakter yang sudah diketik
                titleCount.textContent = this.value.length;

                // Jika karakter > 180, ubah warna jadi kuning sebagai peringatan
                if (this.value.length > 180) {
                    titleCount.classList.add('text-warning');
                } else {
                    titleCount.classList.remove('text-warning');
                }
            });

            // Menampilkan jumlah karakter saat pertama kali halaman dibuka
            titleCount.textContent = titleInput.value.length;
        }

        // === Validasi Form Saat Disubmit ===
        const articleForm = document.getElementById('articleForm');
        if (articleForm) {
            articleForm.addEventListener('submit', function(e) {
                const content = document.getElementById('content').value;

                // Pastikan konten artikel minimal 100 karakter
                if (content.length < 100) {
                    e.preventDefault(); // Mencegah form terkirim
                    alert('Konten artikel harus minimal 100 karakter untuk memastikan kualitas konten.');
                    return false;
                }
            });
        }
    });

    // buat update judul halaman dan breadcrumb
    function updatePageTitle(title, breadcrumb) {
        document.getElementById('pageTitle').textContent = title;
        document.getElementById('pageBreadcrumb').innerHTML = `
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
            <li class="breadcrumb-item active">${breadcrumb}</li>
        `;
    }

    // Fungsi untuk menandai menu yang sedang aktif di sidebar
    function setActiveMenu(menu) {
        // Hapus kelas 'active' dari semua menu
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active');
        });

        // Tambahkan kelas 'active' ke menu yang cocok dengan parameter
        const currentMenu = document.querySelector(`.menu-item[href*="${menu}"]`);
        if (currentMenu) {
            currentMenu.classList.add('active');
        }
    }
</script>
@endpush
