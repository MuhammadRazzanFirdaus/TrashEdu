@extends('templates.app')

@section('content')
<div class="container mt-4">
    <!-- Header dengan ikon -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary p-3 rounded-circle me-3">
                <i class="fas fa-history text-white fa-2x"></i>
            </div>
            <div>
                <h2 class="mb-1">Riwayat Penukaran Sampah</h2>
                <p class="text-muted">Lacak semua transaksi setor sampah Anda</p>
            </div>
        </div>
        <a href="{{ route('user.waste.submit') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Setor Sampah Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div>
                <h5 class="mb-1">Berhasil!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 bg-primary bg-gradient text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1">Total Setoran</h6>
                            <h3 class="mb-0">{{ $submissions->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 bg-success bg-gradient text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1">Diterima</h6>
                            <h3 class="mb-0">{{ $submissions->where('status', 'approved')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 bg-warning bg-gradient text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1">Menunggu</h6>
                            <h3 class="mb-0">{{ $submissions->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 bg-info bg-gradient text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1">Total Poin</h6>
                            <h3 class="mb-0">{{ $submissions->where('status', 'approved')->sum('points') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0"><i class="fas fa-filter text-primary me-2"></i>Filter Riwayat</h5>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari riwayat..." id="searchInput">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Diterima</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="date" class="form-control" id="dateFilter" placeholder="Filter tanggal">
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="highest">Poin Tertinggi</option>
                        <option value="lowest">Poin Terendah</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-secondary w-100" id="resetFilters">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Daftar Riwayat Setoran</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="historyTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">
                                <i class="fas fa-calendar me-2"></i>Tanggal
                            </th>
                            <th>
                                <i class="fas fa-trash-alt me-2"></i>Kategori
                            </th>
                            <th>
                                <i class="fas fa-weight me-2"></i>Berat
                            </th>
                            <th>
                                <i class="fas fa-tag me-2"></i>Status
                            </th>
                            <th>
                                <i class="fas fa-coins me-2"></i>Poin
                            </th>
                            <th class="text-end pe-4">
                                <i class="fas fa-cogs me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold">{{ $item->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $item->category->color ?? 'primary' }} text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px;">
                                        <i class="{{ $item->category->icon ?? 'fas fa-trash' }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $item->category->name ?? 'Kategori tidak ditemukan' }}</div>
                                        <small class="text-muted">{{ $item->category->points_per_kg }} pts/kg</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-weight text-primary me-2"></i>
                                    <span class="fw-bold">{{ number_format($item->weight, 1) }} kg</span>
                                </div>
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($item->status == 'approved')
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Diterima
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->points)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins text-warning me-2"></i>
                                    <span class="fw-bold fs-5">{{ $item->points }}</span>
                                    <small class="text-muted ms-1">points</small>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </button>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Setoran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted">Tanggal</small>
                                                        <div class="fw-bold">{{ $item->created_at->format('d F Y, H:i') }}</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted">Status</small>
                                                        <div>
                                                            @if($item->status == 'pending')
                                                                <span class="badge bg-warning">Menunggu</span>
                                                            @elseif($item->status == 'approved')
                                                                <span class="badge bg-success">Diterima</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted">Kategori</small>
                                                        <div class="fw-bold">{{ $item->category->name }}</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted">Berat</small>
                                                        <div class="fw-bold">{{ $item->weight }} kg</div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted">Poin per kg</small>
                                                        <div class="fw-bold">{{ $item->category->points_per_kg }} points</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted">Total Poin</small>
                                                        <div class="fw-bold">{{ $item->points ?? '-' }} points</div>
                                                    </div>
                                                </div>
                                                @if($item->note)
                                                <div class="mb-3">
                                                    <small class="text-muted">Catatan</small>
                                                    <div class="alert alert-light">{{ $item->note }}</div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada riwayat setoran</h5>
                                    <p class="text-muted">Mulai setor sampah Anda untuk mendapatkan poin!</p>
                                    <a href="{{ route('user.waste.submit') }}" class="btn btn-success mt-2">
                                        <i class="fas fa-plus-circle me-2"></i>Setor Sampah Pertama
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const sortFilter = document.getElementById('sortFilter');
    const resetFilters = document.getElementById('resetFilters');
    const tableRows = document.querySelectorAll('#historyTable tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;
        const sortValue = sortFilter.value;

        tableRows.forEach(row => {
            if (row.classList.contains('empty-state')) return;

            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.badge');
            const dateText = row.querySelector('td:nth-child(1)').textContent;
            const points = parseInt(row.querySelector('td:nth-child(5) .fw-bold')?.textContent || 0);

            // Filter pencarian
            const matchesSearch = text.includes(searchTerm);

            // Filter status
            const matchesStatus = !statusValue ||
                (statusValue === 'pending' && statusBadge.classList.contains('bg-warning')) ||
                (statusValue === 'approved' && statusBadge.classList.contains('bg-success')) ||
                (statusValue === 'rejected' && statusBadge.classList.contains('bg-danger'));

            // Filter tanggal
            const matchesDate = !dateValue || dateText.includes(dateValue.split('-').reverse().join('/'));

            row.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
        });

        // Sorting (sederhana - di production bisa dilakukan di server)
        sortRows(sortValue);
    }

    function sortRows(sortValue) {
        const tbody = document.querySelector('#historyTable tbody');
        const rows = Array.from(tbody.querySelectorAll('tr:not(.empty-state)')).filter(r => r.style.display !== 'none');

        rows.sort((a, b) => {
            switch(sortValue) {
                case 'oldest':
                    return new Date(a.querySelector('td:nth-child(1)').dataset.date || 0) -
                           new Date(b.querySelector('td:nth-child(1)').dataset.date || 0);
                case 'highest':
                    const pointsA = parseInt(a.querySelector('td:nth-child(5) .fw-bold')?.textContent || 0);
                    const pointsB = parseInt(b.querySelector('td:nth-child(5) .fw-bold')?.textContent || 0);
                    return pointsB - pointsA;
                case 'lowest':
                    const pointsA2 = parseInt(a.querySelector('td:nth-child(5) .fw-bold')?.textContent || 0);
                    const pointsB2 = parseInt(b.querySelector('td:nth-child(5) .fw-bold')?.textContent || 0);
                    return pointsA2 - pointsB2;
                default: // newest
                    return new Date(b.querySelector('td:nth-child(1)').dataset.date || 0) -
                           new Date(a.querySelector('td:nth-child(1)').dataset.date || 0);
            }
        });

        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    dateFilter.addEventListener('change', filterTable);
    sortFilter.addEventListener('change', filterTable);

    resetFilters.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        dateFilter.value = '';
        sortFilter.value = 'newest';
        filterTable();
    });

    // Initialize
    filterTable();
});
</script>
@endpush

@push('styles')
<style>
.card {
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.table th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(25, 135, 84, 0.05);
}

.empty-state {
    padding: 3rem 1rem;
}

.empty-state i {
    opacity: 0.5;
}

.modal-content {
    border-radius: 15px;
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #198754, #2ecc71);
    border: none;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #157347, #27ae60);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
}

.bg-gradient {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-info));
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header h5 {
        font-size: 1.1rem;
    }

    .table-responsive {
        font-size: 0.9rem;
    }

    .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .statistics .card-body {
        padding: 1rem;
    }

    .statistics h3 {
        font-size: 1.5rem;
    }
}
</style>
@endpush
