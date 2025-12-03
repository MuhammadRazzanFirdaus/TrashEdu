@extends('templates.app')

@push('styles')
<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.input-group-text {
    border-right: none;
}

.form-control:focus, .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
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

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
}

.list-group-item {
    background-color: transparent;
}

@media (max-width: 768px) {
    .fixed-bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1030;
    }

    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="container mt-4">
    <!-- Header dengan ikon -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success p-3 rounded-circle me-3">
            <i class="fas fa-recycle text-white fa-2x"></i>
        </div>
        <div>
            <h2 class="mb-1">Setor Sampah</h2>
            <p class="text-muted">Lindungi lingkungan dengan mendaur ulang sampah Anda</p>
        </div>
    </div>

    <div class="row">
        <!-- Form Setor Sampah -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Form Setor Sampah</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.waste.store') }}" method="POST" id="wasteForm">
                        @csrf

                        <!-- Pilih Kategori -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kategori Sampah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-trash-alt text-success"></i></span>
                                <select name="category_id" class="form-select form-select-lg" id="categorySelect" required>
                                    <option value="">-- Pilih Jenis Sampah --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-points="{{ $category->points_per_kg }}">
                                            {{ $category->name }} ({{ $category->points_per_kg }} point/kg)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text">Pilih jenis sampah yang akan Anda setor</div>
                        </div>

                        <!-- Input Berat -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Berat Sampah (kg) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-weight text-success"></i></span>
                                <input type="number" name="weight" class="form-control form-control-lg"
                                       id="weightInput" step="0.1" min="0.1" placeholder="Contoh: 2.5" required>
                                <span class="input-group-text">kg</span>
                            </div>
                            <div class="form-text">Masukkan berat sampah dalam kilogram</div>
                        </div>

                        <!-- Estimasi Poin -->
                        <div class="alert alert-info d-flex align-items-center" id="pointsEstimate" style="display: none!important;">
                            <i class="fas fa-coins fa-2x me-3 text-warning"></i>
                            <div>
                                <h6 class="mb-1">Estimasi Poin yang Didapat:</h6>
                                <h4 class="mb-0"><span id="estimatedPoints">0</span> points</h4>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('user.waste.history') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-history me-2"></i>Lihat History
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="fas fa-paper-plane me-2"></i>Setor Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Informasi -->
        <div class="col-lg-4">
            <!-- Informasi Kategori -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-success"></i>Informasi Kategori</h5>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <div class="list-group-item border-0 px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->description ?? 'Sampah daur ulang' }}</small>
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $category->points_per_kg }} pts/kg</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Panduan Setor -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2 text-warning"></i>Tips Setor Sampah</h5>
                </div>
                <div class="card-body p-3">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pastikan sampah bersih dan kering</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pisahkan sampah berdasarkan kategori</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Gunakan timbangan yang akurat</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Catat berat sebelum disetor</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Simpan bukti setor untuk referensi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Cepat ke History -->
    <div class="fixed-bottom d-lg-none p-3">
        <div class="d-flex justify-content-center">
            <a href="{{ route('user.waste.history') }}" class="btn btn-primary shadow-lg rounded-pill px-4">
                <i class="fas fa-history me-2"></i>History Setoran
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    const weightInput = document.getElementById('weightInput');
    const pointsEstimate = document.getElementById('pointsEstimate');
    const estimatedPoints = document.getElementById('estimatedPoints');

    function calculatePoints() {
        const selectedCategory = categorySelect.options[categorySelect.selectedIndex];
        const pointsPerKg = selectedCategory.getAttribute('data-points');
        const weight = parseFloat(weightInput.value);

        if (pointsPerKg && weight && weight > 0) {
            const points = (parseFloat(pointsPerKg) * weight).toFixed(1);
            estimatedPoints.textContent = points;
            pointsEstimate.style.display = 'flex';
        } else {
            pointsEstimate.style.display = 'none';
        }
    }

    categorySelect.addEventListener('change', calculatePoints);
    weightInput.addEventListener('input', calculatePoints);

    // Validasi form
    document.getElementById('wasteForm').addEventListener('submit', function(e) {
        const weight = parseFloat(weightInput.value);

        if (weight < 0.1) {
            e.preventDefault();
            alert('Berat sampah minimal 0.1 kg');
            weightInput.focus();
            return false;
        }

        if (!categorySelect.value) {
            e.preventDefault();
            alert('Pilih kategori sampah terlebih dahulu');
            categorySelect.focus();
            return false;
        }
    });
});
</script>
@endpush
