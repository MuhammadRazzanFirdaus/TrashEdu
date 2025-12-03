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

    .trash-item {
        transition: background-color 0.2s ease;
    }

    .trash-item:hover {
        background-color: #fffbf0;
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="fw-bold text-dark mb-2">Trash Artikel</h4>
            <p class="text-muted mb-0">Kelola artikel yang telah dihapus sementara</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Artikel
        </a>
    </div>

    <!-- Stats -->
    <div class="row mb-5">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted small">Total di Trash</span>
                            <h3 class="mb-0 fw-bold text-warning">{{ $articles->total() }}</h3>
                        </div>
                        <div class="icon-shape bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-trash text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted small">Dapat Dipulihkan</span>
                            <h3 class="mb-0 fw-bold text-success">{{ $articles->total() }}</h3>
                        </div>
                        <div class="icon-shape bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-arrow-clockwise text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted small">Akan Dihapus</span>
                            <h3 class="mb-0 fw-bold text-danger">0</h3>
                        </div>
                        <div class="icon-shape bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
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

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 py-4">
            <h5 class="card-title mb-0 fw-bold text-warning">
                <i class="bi bi-trash me-3"></i>Daftar Artikel di Trash
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-warning">
                        <tr>
                            <th width="80" class="ps-4 text-muted fw-semibold">#</th>
                            <th class="text-muted fw-semibold">Judul Artikel</th>
                            <th width="35%" class="text-muted fw-semibold">Konten</th>
                            <th width="180" class="text-muted fw-semibold">Dihapus Pada</th>
                            <th width="200" class="text-center text-muted fw-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                            <tr class="trash-item">
                                <td class="ps-4">
                                    <span class="text-muted fw-semibold">
                                        {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-3">
                                                <i class="bi bi-trash text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold text-dark">{{ $article->title }}</h6>
                                            <small class="text-muted">ID: ART{{ str_pad($article->id, 4, '0', STR_PAD_LEFT) }}</small>
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
                                        <div class="fw-medium">{{ $article->deleted_at->format('d M Y') }}</div>
                                        <small>{{ $article->deleted_at->format('H:i') }} WIB</small>
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-clock-history me-1"></i>
                                            {{ $article->deleted_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.articles.restore', $article->id) }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-success px-3"
                                                    data-bs-toggle="tooltip"
                                                    title="Pulihkan Artikel">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Pulihkan
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.articles.force-delete', $article->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger px-3"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus Permanen"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus PERMANEN artikel ini? Tindakan ini tidak dapat dibatalkan!')">
                                                <i class="bi bi-trash-fill me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-trash display-4 d-block mb-3 opacity-50"></i>
                                        <h5 class="fw-semibold mb-2">Trash Kosong</h5>
                                        <p class="mb-4">Tidak ada artikel yang dihapus sementara</p>
                                        <a href="{{ route('admin.articles.index') }}" class="btn btn-primary px-4">
                                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Artikel
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
        @if($articles->hasPages())
            <div class="card-footer bg-transparent border-0 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan <strong>{{ $articles->firstItem() ?? 0 }}</strong> - <strong>{{ $articles->lastItem() ?? 0 }}</strong>
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
    // Jalankan script setelah seluruh elemen DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Ubah judul halaman dan breadcrumb sesuai halaman aktif
        updatePageTitle('Trash Artikel', 'Articles');

        // Tandai menu 'articles' sebagai menu aktif di sidebar
        setActiveMenu('articles');

        // Inisialisasi semua elemen dengan atribut data-bs-toggle="tooltip" agar Bootstrap tooltip aktif
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    /**
     * Fungsi untuk memperbarui judul halaman dan breadcrumb.
     * @param {string} title - Judul halaman yang akan ditampilkan di elemen #pageTitle
     * @param {string} breadcrumb - Nama breadcrumb terakhir yang menunjukkan posisi halaman aktif
     */
    function updatePageTitle(title, breadcrumb) {
        // Ubah teks judul halaman
        document.getElementById('pageTitle').textContent = title;

        // Ganti isi breadcrumb agar sesuai dengan posisi halaman saat ini
        document.getElementById('pageBreadcrumb').innerHTML = `
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
            <li class="breadcrumb-item active">${breadcrumb}</li>
        `;
    }

    /**
     * Fungsi untuk menandai menu yang sedang aktif di sidebar.
     * @param {string} menu - Nama menu (dari URL) yang ingin dijadikan aktif.
     */
    function setActiveMenu(menu) {
        // Hapus class 'active' dari semua item menu
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active');
        });

        // Temukan menu yang URL-nya mengandung nama yang diberikan
        const currentMenu = document.querySelector(`.menu-item[href*="${menu}"]`);

        // Jika ditemukan, tambahkan class 'active' agar menu tersebut terlihat aktif
        if (currentMenu) {
            currentMenu.classList.add('active');
        }
    }
</script>
@endpush
