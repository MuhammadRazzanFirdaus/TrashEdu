@extends('templates.app')

@section('content')
<div class="container mt-4">
    <!-- Header dengan ikon -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning p-3 rounded-circle me-3">
                <i class="fas fa-gift text-white fa-2x"></i>
            </div>
            <div>
                <h2 class="mb-1">Penukaran Hadiah</h2>
                <p class="text-muted">Tukarkan poin Anda dengan hadiah menarik</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('user.rewards.history') }}" class="btn btn-primary">
                <i class="fas fa-history me-2"></i>Riwayat Penukaran
            </a>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h5 class="mb-1">Berhasil!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h5 class="mb-1">Gagal!</h5>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Informasi Poin -->
    @auth
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-success p-3 rounded-circle me-3">
                            <i class="fas fa-coins text-white fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Poin Anda Saat Ini</h6>
                            <h3 class="mb-0">{{ Auth::user()->points ?? 0 }} <span class="fs-6 text-muted">points</span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info mb-0">
                        <div class="d-flex">
                            <i class="fas fa-info-circle fa-2x me-3 text-info"></i>
                            <div>
                                <h6 class="mb-1">Cara Menukar Hadiah:</h6>
                                <p class="mb-0 small">Pilih hadiah, klik "Tukar Sekarang", dan tunggu konfirmasi dari admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <div class="row">
        <!-- Daftar Hadiah -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-gifts me-2"></i>Daftar Hadiah Tersedia</h5>
                </div>
                <div class="card-body">
                    @if($rewards->count() > 0)
                        <div class="row">
                            @foreach($rewards as $reward)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm reward-card"
                                     data-reward-id="{{ $reward->id }}"
                                     data-reward-name="{{ $reward->name }}"
                                     data-reward-points="{{ $reward->points_required }}"
                                     data-reward-stock="{{ $reward->stock }}">
                                    @if($reward->image)
                                    <img src="{{ asset('storage/' . $reward->image) }}" class="card-img-top" alt="{{ $reward->name }}" style="height: 180px; object-fit: cover;">
                                    @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                        <i class="fas fa-gift fa-4x text-warning"></i>
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $reward->name }}</h6>
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($reward->description, 80) }}</p>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                                <i class="fas fa-coins me-1"></i>{{ $reward->points_required }} points
                                            </span>
                                            <span class="badge bg-{{ $reward->stock > 0 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                                <i class="fas fa-box me-1"></i>{{ $reward->stock }} tersedia
                                            </span>
                                        </div>

                                        <button type="button" class="btn btn-outline-warning w-100 select-reward-btn"
                                                data-reward-id="{{ $reward->id }}"
                                                {{ $reward->stock < 1 || ($reward->points_required > (Auth::user()->points ?? 0)) ? 'disabled' : '' }}>
                                            <i class="fas fa-exchange-alt me-2"></i>
                                            {{ $reward->stock < 1 ? 'Stok Habis' : (($reward->points_required > (Auth::user()->points ?? 0)) ? 'Poin Kurang' : 'Pilih Hadiah') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-gift fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada hadiah tersedia</h5>
                            <p class="text-muted">Silakan coba lagi nanti.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Penukaran -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Form Penukaran</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.rewards.store') }}" method="POST" id="rewardForm">
                        @csrf

                        <!-- Hadiah Terpilih -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Hadiah yang Dipilih</label>
                            <div class="card border-primary">
                                <div class="card-body" id="selectedRewardInfo">
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-gift fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">Pilih hadiah dari daftar di samping</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="reward_id" id="selectedRewardId" required>
                        </div>

                        <!-- Informasi Poin -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Detail Penukaran</label>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Poin Anda</span>
                                    <span class="fw-bold">{{ Auth::user()->points ?? 0 }} points</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Poin Dibutuhkan</span>
                                    <span class="fw-bold" id="requiredPoints">-</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Sisa Poin</span>
                                    <span class="fw-bold text-success" id="remainingPoints">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn" disabled>
                            <i class="fas fa-exchange-alt me-2"></i>Tukar Sekarang
                        </button>

                    </form>

                    <!-- Tombol History -->
                    <div class="mt-4">
                        <a href="{{ route('user.rewards.history') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-history me-2"></i>Lihat Riwayat Penukaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userPoints = {{ Auth::user()->points ?? 0 }};
    const selectButtons = document.querySelectorAll('.select-reward-btn');
    const selectedRewardInfo = document.getElementById('selectedRewardInfo');
    const selectedRewardId = document.getElementById('selectedRewardId');
    const requiredPointsSpan = document.getElementById('requiredPoints');
    const remainingPointsSpan = document.getElementById('remainingPoints');
    const submitBtn = document.getElementById('submitBtn');
    const agreeTerms = document.getElementById('agreeTerms');

    selectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const rewardCard = this.closest('.reward-card');
            const rewardId = rewardCard.dataset.rewardId;
            const rewardName = rewardCard.dataset.rewardName;
            const rewardPoints = parseInt(rewardCard.dataset.rewardPoints);
            const rewardStock = parseInt(rewardCard.dataset.rewardStock);

            // Update selected reward display
            selectedRewardInfo.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-gift fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold mb-1">${rewardName}</h6>
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <span class="badge bg-warning">
                            <i class="fas fa-coins me-1"></i>${rewardPoints} points
                        </span>
                        <span class="badge bg-${rewardStock > 0 ? 'success' : 'danger'}">
                            <i class="fas fa-box me-1"></i>${rewardStock} tersedia
                        </span>
                    </div>
                    <p class="small text-muted mb-0">Hadiah telah dipilih</p>
                </div>
            `;

            // Update hidden input
            selectedRewardId.value = rewardId;

            // Update points information
            requiredPointsSpan.textContent = `${rewardPoints} points`;

            const remainingPoints = userPoints - rewardPoints;
            remainingPointsSpan.textContent = `${remainingPoints} points`;

            if (remainingPoints < 0) {
                remainingPointsSpan.classList.remove('text-success');
                remainingPointsSpan.classList.add('text-danger');
            } else {
                remainingPointsSpan.classList.remove('text-danger');
                remainingPointsSpan.classList.add('text-success');
            }

            // Enable submit button if points are sufficient and stock is available
            if (rewardPoints <= userPoints && rewardStock > 0) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-secondary');
            }

            // Update button states
            selectButtons.forEach(btn => {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-warning');
                btn.innerHTML = btn.innerHTML.replace('Terpilih', 'Pilih Hadiah');
            });

            this.classList.remove('btn-outline-warning');
            this.classList.add('btn-warning');
            this.innerHTML = this.innerHTML.replace('Pilih Hadiah', '<i class="fas fa-check me-2"></i>Terpilih');
        });
    });

    // Form validation
    agreeTerms.addEventListener('change', function() {
        const isRewardSelected = selectedRewardId.value !== '';
        const isAgreed = this.checked;

        if (isRewardSelected && isAgreed) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    });

    selectedRewardId.addEventListener('change', function() {
        const isAgreed = agreeTerms.checked;
        const isRewardSelected = this.value !== '';

        if (isRewardSelected && isAgreed) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    });

    // Confirm before submitting
    document.getElementById('rewardForm').addEventListener('submit', function(e) {
        if (!selectedRewardId.value) {
            e.preventDefault();
            alert('Silakan pilih hadiah terlebih dahulu');
            return false;
        }

        const rewardPoints = parseInt(document.querySelector(`[data-reward-id="${selectedRewardId.value}"]`)?.dataset.rewardPoints || 0);

        if (rewardPoints > userPoints) {
            e.preventDefault();
            alert('Poin Anda tidak cukup untuk menukar hadiah ini');
            return false;
        }

        const isConfirmed = confirm('Apakah Anda yakin ingin menukar hadiah ini? Poin akan dipotong setelah admin menyetujui.');
        if (!isConfirmed) {
            e.preventDefault();
        }
    });
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

.reward-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.reward-card:hover {
    border-color: #ffc107;
    box-shadow: 0 5px 20px rgba(255, 193, 7, 0.2);
}

.reward-card.selected {
    border-color: #198754;
    background-color: rgba(25, 135, 84, 0.05);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #ffca2c);
    border: none;
    color: #000;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ffca2c, #ffc107);
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0b5ed7, #339af0);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

.sticky-top {
    position: sticky;
    z-index: 10;
}

.badge {
    font-weight: 500;
}

.accordion-button {
    border-radius: 10px !important;
    margin-bottom: 5px;
}

.accordion-button:not(.collapsed) {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.accordion-body {
    background-color: #f8f9fa;
    border-radius: 0 0 10px 10px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sticky-top {
        position: static;
    }

    .reward-card .card-img-top {
        height: 150px !important;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
}
</style>
@endpush
