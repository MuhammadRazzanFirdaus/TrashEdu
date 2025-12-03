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

    .badge {
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="fw-bold text-dark mb-2">Edit Artikel</h4>
            <p class="text-muted mb-0">Edit "{{ Str::limit($article->title, 50) }}"</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- Article Info -->
    <div class="card border-0 bg-light bg-opacity-50 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-4 text-muted">
                        <span><i class="bi bi-calendar me-2"></i> Dibuat: {{ $article->created_at->format('d M Y') }}</span>
                        <span><i class="bi bi-arrow-clockwise me-2"></i> Diupdate: {{ $article->updated_at->format('d M Y') }}</span>
                        <span><i class="bi bi-hash me-2"></i> ID: ART{{ str_pad($article->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i> Active
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 py-4">
            <h5 class="card-title mb-0 fw-bold">
                <i class="bi bi-pencil-square me-3 text-primary"></i>Form Edit Artikel
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" id="articleForm">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="mb-5">
                    <label for="title" class="form-label fw-semibold mb-3">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $article->title) }}"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           placeholder="Masukkan judul artikel"
                           required
                           maxlength="200">
                    <div class="form-text text-muted mt-2">
                        <span id="titleCount">{{ strlen($article->title) }}</span>/200 karakter
                    </div>
                    @error('title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konten -->
                <div class="mb-5">
                    <label for="content" class="form-label fw-semibold mb-3">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="content"
                              id="content"
                              rows="15"
                              class="form-control @error('content') is-invalid @enderror"
                              placeholder="Tulis konten artikel di sini..."
                              required>{{ old('content', $article->content) }}</textarea>
                    <div class="form-text text-muted mt-2">
                        Panjang konten saat ini: <span id="contentCount">{{ strlen($article->content) }}</span> karakter
                    </div>
                    @error('content')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-between pt-4 border-top">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i> Update Artikel
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
        // 🔹 Set judul halaman dan breadcrumb saat halaman dimuat
        updatePageTitle('Edit Artikel', 'Articles');

        // 🔹 Tandai menu navigasi "articles" sebagai aktif di sidebar
        setActiveMenu('articles');

        // 🔹 Ambil elemen input judul dan hitung jumlah karakternya
        const titleInput = document.getElementById('title');
        const titleCount = document.getElementById('titleCount');

        // 🔹 Ambil elemen textarea konten dan hitung jumlah karakternya
        const contentTextarea = document.getElementById('content');
        const contentCount = document.getElementById('contentCount');

        // 🔹 Saat pengguna mengetik di input judul, tampilkan jumlah karakter secara real-time
        if (titleInput && titleCount) {
            titleInput.addEventListener('input', function() {
                titleCount.textContent = this.value.length;
            });
        }

        // 🔹 Saat pengguna mengetik di textarea konten, tampilkan jumlah karakter secara real-time
        if (contentTextarea && contentCount) {
            contentTextarea.addEventListener('input', function() {
                contentCount.textContent = this.value.length;
            });
        }
    });

    /**
     * 🔸 updatePageTitle()
     * Fungsi ini mengganti teks judul halaman dan breadcrumb sesuai halaman aktif.
     *
     * @param {string} title - Judul halaman yang akan ditampilkan di header
     * @param {string} breadcrumb - Nama breadcrumb terakhir
     */
    function updatePageTitle(title, breadcrumb) {
        // Ganti teks judul halaman di elemen dengan ID 'pageTitle'
        document.getElementById('pageTitle').textContent = title;

        // Ganti breadcrumb di elemen dengan ID 'pageBreadcrumb'
        document.getElementById('pageBreadcrumb').innerHTML = `
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
            <li class="breadcrumb-item active">${breadcrumb}</li>
        `;
    }

    /**
     * 🔸 setActiveMenu()
     * Fungsi ini digunakan untuk menandai menu yang sedang aktif di sidebar.
     *
     * @param {string} menu - Nama bagian menu (misalnya: 'articles', 'dashboard')
     */
    function setActiveMenu(menu) {
        // Hapus class 'active' dari semua item menu
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active');
        });

        // Cari menu yang mengandung nama bagian yang diberikan dan beri class 'active'
        const currentMenu = document.querySelector(`.menu-item[href*="${menu}"]`);
        if (currentMenu) {
            currentMenu.classList.add('active');
        }
    }
</script>
@endpush

