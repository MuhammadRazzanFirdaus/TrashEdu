@extends('templates.admin')

@push('style')
    <style>
        .card-stats {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 12px;
        }

        .card-stats:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .article-item {
            transition: background-color 0.2s ease;
            border-radius: 0;
        }

        .article-item:hover {
            background-color: #f8f9fa;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .icon-shape {
            transition: transform 0.2s ease;
        }

        .card-stats:hover .icon-shape {
            transform: scale(1.05);
        }

        .btn {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .table th {
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: none;
            letter-spacing: 0;
        }

        .alert {
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-6">
            <div>
                <h4 class="fw-bold text-dark mb-2">Manajemen Artikel</h4>
                <p class="text-muted mb-0">Kelola konten artikel edukasi sampah</p>
            </div>
            <div class="d-flex gap-3">
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-file-earmark-excel me-2"></i> Export Data
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.articles.export') }}?type=all">
                                <i class="bi bi-journal-text me-2"></i> Semua Artikel (.xlxx)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.articles.export') }}?type=trash">
                                <i class="bi bi-trash me-2"></i> Artikel di Trash (.xlxx)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.articles.export.pdf') }}?type=all">
                                <i class="bi bi-people me-2"></i> Semua Article (.pdf)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.articles.export.pdf') }}?type=trash">
                                <i class="bi bi-trash me-2"></i> Article di Trash (.pdf)
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('admin.articles.trash') }}" class="btn btn-outline-warning position-relative">
                    <i class="bi bi-trash me-2"></i> Trash
                    @if ($trash_count > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $trash_count }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Artikel
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stats border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted small">Total Artikel</span>
                                <h3 class="mb-0 fw-bold text-primary">{{ $articles->total() }}</h3>
                            </div>
                            <div class="icon-shape bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-journal-text text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stats border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted small">Bulan Ini</span>
                                <h3 class="mb-0 fw-bold text-success">{{ $month_articles }}</h3>
                            </div>
                            <div class="icon-shape bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calendar-month text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stats border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted small">Dalam Trash</span>
                                <h3 class="mb-0 fw-bold text-warning">{{ $trash_count }}</h3>
                            </div>
                            <div class="icon-shape bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-trash text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stats border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted small">Update Terakhir</span>
                                <h5 class="mb-0 fw-bold text-info">
                                    {{ $last_updated ? $last_updated->format('d M Y') : '-' }}
                                </h5>
                            </div>
                            <div class="icon-shape bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-clock-history text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                    <div class="flex-grow-1">
                        <strong class="fw-semibold">Sukses!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill me-3 fs-5"></i>
                    <div class="flex-grow-1">
                        <strong class="fw-semibold">Error!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-list-ul me-3 text-primary"></i>Daftar Artikel
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()" title="Refresh">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <div class="input-group input-group-sm" style="width: 280px;">
                            <span class="input-group-text bg-transparent">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari artikel..."
                                id="searchInput">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="articlesTable">
                        <thead class="table-light">
                            <tr>
                                <th width="80" class="ps-4 text-muted fw-semibold">#</th>
                                <th class="text-muted fw-semibold">Judul Artikel</th>
                                <th width="35%" class="text-muted fw-semibold">Konten</th>
                                <th width="180" class="text-muted fw-semibold">Tanggal Dibuat</th>
                                <th width="150" class="text-center text-muted fw-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr class="article-item">
                                    <td class="ps-4">
                                        <span class="text-muted fw-semibold">
                                            {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold text-dark">{{ $article->title }}</h6>
                                                <small class="text-muted">ID:
                                                    ART{{ str_pad($article->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted line-clamp-2">
                                            {{ Str::limit(strip_tags($article->content), 100) }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <div class="fw-medium">{{ $article->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="tooltip"
                                                title="Edit Artikel">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-3"
                                                    data-bs-toggle="tooltip" title="Hapus Artikel"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-journal-x display-4 d-block mb-3 opacity-50"></i>
                                            <h5 class="fw-semibold mb-2">Belum ada artikel</h5>
                                            <p class="mb-4">Mulai buat artikel pertama Anda</p>
                                            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary px-4">
                                                <i class="bi bi-plus-lg me-2"></i> Buat Artikel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($articles->hasPages())
                <div class="card-footer bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan <strong>{{ $articles->firstItem() ?? 0 }}</strong> -
                            <strong>{{ $articles->lastItem() ?? 0 }}</strong>
                            dari <strong>{{ $articles->total() }}</strong> artikel
                        </div>
                        <div>
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Jalankan kode setelah seluruh halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {

            // 🔹 Atur judul halaman dan breadcrumb sesuai halaman yang sedang dibuka
            updatePageTitle('Manajemen Artikel', 'Articles');

            // 🔹 Tandai menu navigasi 'articles' sebagai aktif di sidebar
            setActiveMenu('articles');

            // 🔹 Inisialisasi semua tooltip Bootstrap pada elemen yang punya atribut data-bs-toggle="tooltip"
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // 🔹 Fitur pencarian artikel di tabel (client-side search)
            const searchInput = document.getElementById('searchInput'); // input pencarian
            const articleRows = document.querySelectorAll('.article-item'); // setiap baris artikel

            // Cek jika input pencarian ada di halaman
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value
                .toLowerCase(); // ubah teks pencarian jadi huruf kecil agar tidak case-sensitive

                    // Loop setiap baris artikel dan sembunyikan yang tidak sesuai dengan kata kunci
                    articleRows.forEach(row => {
                        const text = row.textContent
                    .toLowerCase(); // ambil semua teks dari baris artikel
                        if (text.includes(searchTerm)) {
                            // jika cocok dengan kata kunci pencarian, tampilkan
                            row.style.display = '';
                        } else {
                            // jika tidak cocok, sembunyikan
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });

        /**
         * 🔸 updatePageTitle()
         * Fungsi ini digunakan untuk memperbarui teks judul halaman dan breadcrumb di bagian atas dashboard.
         *
         * @param {string} title - Judul utama halaman yang ingin ditampilkan di header
         * @param {string} breadcrumb - Nama breadcrumb terakhir (posisi halaman saat ini)
         */
        function updatePageTitle(title, breadcrumb) {
            // Ubah teks pada elemen dengan ID 'pageTitle' menjadi judul halaman yang diberikan
            document.getElementById('pageTitle').textContent = title;

            // Ganti isi breadcrumb agar sesuai dengan posisi halaman saat ini
            document.getElementById('pageBreadcrumb').innerHTML = `
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">${breadcrumb}</li>
        `;
        }

        /**
         * 🔸 setActiveMenu()
         * Fungsi ini digunakan untuk menandai menu sidebar mana yang sedang aktif.
         *
         * @param {string} menu - Nama bagian menu yang sedang dibuka (contoh: 'articles', 'dashboard', dll)
         */
        function setActiveMenu(menu) {
            // Hapus class 'active' dari semua item menu agar hanya satu yang aktif
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            // Cari elemen menu berdasarkan nama yang diberikan, lalu tambahkan class 'active'
            const currentMenu = document.querySelector(`.menu-item[href*="${menu}"]`);
            if (currentMenu) {
                currentMenu.classList.add('active');
            }
        }
    </script>
@endpush
