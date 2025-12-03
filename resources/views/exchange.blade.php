@extends('templates.app')

@section('content')
    <section class="position-relative overflow-hidden" style="min-height: 100vh;">
        <!-- Background shapes -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0; pointer-events:none;">
            <div class="position-absolute rounded-circle"
                style="
          width: 300px;
          height: 300px;
          top: -80px;
          left: -80px;
          background: rgba(25, 135, 84, 0.15);
        ">
            </div>
            <div class="position-absolute rounded-circle"
                style="
          width: 180px;
          height: 180px;
          top: 20%;
          right: 10%;
          background: rgba(255, 193, 7, 0.2);
        ">
            </div>
            <div class="position-absolute rounded-circle"
                style="
          width: 150px;
          height: 150px;
          bottom: 25%;
          left: 12%;
          background: rgba(13, 202, 240, 0.2);
        ">
            </div>
            <div class="position-absolute rounded-circle"
                style="
          width: 220px;
          height: 220px;
          bottom: -60px;
          right: -60px;
          background: rgba(220, 53, 69, 0.18);
        ">
            </div>
        </div>

        <div class="container py-5 position-relative d-flex align-items-center" style="z-index:1; min-height: 100vh;">
            <div class="row align-items-center w-100">
                <!-- Left Side - Enhanced Text with Details -->
                <div class="col-md-6 mb-4 mb-lg-0 pt-5">
                    <div class="position-relative">
                        <h1 class="display-3 fw-bold text-success mb-4">
                            Ubah Sampah Jadi <span class="text-warning">Reward</span>
                        </h1>
                    </div>

                    <p class="lead text-dark fs-5 mb-4">Setiap sampah yang kamu kumpulkan adalah langkah kecil menuju bumi
                        yang lebih bersih!</p>

                    <!-- Stats Inline -->
                    <div class="d-flex gap-4 mb-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-people-fill text-success fs-4"></i>
                            </div>
                            <div class="fw-bold text-success">500+</div>
                            <small class="text-muted">Pengguna</small>
                        </div>
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-coin text-warning fs-4"></i>
                            </div>
                            <div class="fw-bold text-warning">2.5K</div>
                            <small class="text-muted">Poin Diberikan</small>
                        </div>
                        <div class="text-center">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-award text-info fs-4"></i>
                            </div>
                            <div class="fw-bold text-info">150+</div>
                            <small class="text-muted">Hadiah Ditukar</small>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Enhanced Cards -->
                <div class="col-6">
                    <div class="row g-4">
                        <!-- Card 1 - Stats Card with Floating Elements -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-lg rounded-4 h-100 position-relative"
                                style="background: linear-gradient(135deg, #198754, #20c997);">
                                <!-- Floating Icon -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                                        <i class="bi bi-trophy text-white"></i>
                                    </div>
                                </div>

                                <div class="card-body text-white p-4">
                                    <div class="text-center mb-3">
                                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-recycle fs-1"></i>
                                        </div>
                                        <h3 class="mb-0 fw-bold">1.2K+</h3>
                                    </div>
                                    <p class="mb-0 fw-medium text-center">Sampah Didaur Ulang</p>
                                    <div class="progress mt-3 bg-white bg-opacity-25"
                                        style="height: 8px; border-radius: 10px;">
                                        <div class="progress-bar bg-white" style="width: 85%"></div>
                                    </div>

                                    <!-- Mini Progress Label -->
                                    <div class="d-flex justify-content-between mt-2 small">
                                        <span>Progress</span>
                                        <span>85%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 - Featured Reward with Rating -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-lg rounded-4 h-100 position-relative"
                                style="background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">🔥 POPULER</span>

                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center position-relative"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-gift-fill text-success fs-2"></i>
                                            <!-- Ribbon Effect -->
                                            <div class="position-absolute top-0 start-0 bg-danger text-white small px-2 rounded-end"
                                                style="font-size: 10px;">
                                                NEW
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="card-title text-success fw-bold mb-2 text-center">Tote Bag Eco</h5>

                                    <!-- Rating Stars -->
                                    <div class="text-center mb-2">
                                        <small class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </small>
                                        <small class="text-muted">(24 reviews)</small>
                                    </div>

                                    <p class="text-muted small mb-3 text-center">Tas ramah lingkungan berkualitas tinggi</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="h5 text-success fw-bold mb-0">100 Poin</span>
                                            <div class="text-muted small">Stok: 12 left</div>
                                        </div>
                                        <button
                                            class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center gap-1">
                                            <i class="bi bi-arrow-right"></i>
                                            Tukar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Edukasi & Fakta Unik Section -->
    <section class="container py-5" style="position: relative; z-index: 2;">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold mb-3 text-success">Lebih dari Sekadar Daur Ulang</h2>
            <p class="lead text-muted mx-auto" style="max-width: 720px; font-style: italic;">
                Di mana sampah berubah jadi keajaiban, dan setiap penukaran punya cerita hijau
            </p>
        </div>

        <div class="row g-0 position-relative">
            <!-- Elemen Mengambang -->
            <div class="position-absolute top-0 start-0" style="z-index: -1;">
                <div class="bg-success bg-opacity-10 rounded-circle"
                    style="width: 120px; height: 120px; transform: translate(-30px, -20px);"></div>
            </div>
            <div class="position-absolute bottom-0 end-0" style="z-index: -1;">
                <div class="bg-warning bg-opacity-10 rounded-circle"
                    style="width: 80px; height: 80px; transform: translate(20px, 30px);"></div>
            </div>

            <!-- Konten Utama Card -->
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-transparent">
                    <div class="row g-0">
                        <!-- Sisi Kiri - Visual Impact -->
                        <div class="col-md-6 position-relative" style="background-color:#20c997;">
                            <div class="p-5 text-white d-flex flex-column justify-content-center h-100">
                                <div class="mb-4 text-center">
                                    <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 100px; height: 100px;">
                                        <i class="bi bi-arrow-repeat text-white" style="font-size: 3rem;"></i>
                                    </div>
                                    <h3 class="fw-bold mb-3">Revolusi Sirkular</h3>
                                    <p class="mb-0 fs-5">
                                        Sampahmu bukan limbah—melainkan harta masa depan. Setiap penukaran menutup
                                        lingkaran.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Sisi Kanan - Fakta Interaktif -->
                        <div class="col-md-6 bg-light">
                            <div class="p-5">
                                <div class="row g-4">
                                    <!-- Fakta 1 -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white shadow-sm">
                                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-tree text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">17 Pohon Terselamatkan</h6>
                                                <p class="mb-0 small text-muted">Per ton kertas yang didaur ulang</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fakta 2 -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white shadow-sm">
                                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-droplet text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">95% Energi Tersimpan</h6>
                                                <p class="mb-0 small text-muted">Daur ulang aluminium dibanding produksi
                                                    baru</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fakta 3 -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white shadow-sm">
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-people text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">500+ Pejuang Lingkungan</h6>
                                                <p class="mb-0 small text-muted">Sudah berkontribusi nyata</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exchange Options -->
    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Pilih Jenis Sampah</h2>
            <p class="lead text-muted">Setiap jenis sampah memiliki nilai poin yang berbeda</p>
        </div>

        <div class="row g-4 justify-content-center text-center">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 p-4 d-flex flex-column align-items-center"
                    style="background: #e6f4ea;">
                    <div class="mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 90px; height: 90px; background-color: #28a745;">
                        <i class="fa-solid fa-bottle-water fs-1 text-white"></i>
                    </div>
                    <h4 class="fw-bold text-success mb-2">Kumpulkan Plastik</h4>
                    <p class="text-muted mb-3 px-3">Botol, kemasan, dan plastik bekas yang bisa didaur ulang.</p>
                    <span class="badge bg-success rounded-pill px-4 py-2 fs-6 fw-semibold">Dapatkan 50 poin per kg</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 p-4 d-flex flex-column align-items-center"
                    style="background: #e7e9fc;">
                    <div class="mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 90px; height: 90px; background-color: #0d6efd;">
                        <i class="bi bi-journal-text fs-1 text-white"></i>
                    </div>
                    <h4 class="fw-bold text-primary mb-2">Kumpulkan Kertas</h4>
                    <p class="text-muted mb-3 px-3">Koran, majalah, kardus, dan kertas bekas lainnya.</p>
                    <span class="badge bg-primary rounded-pill px-4 py-2 fs-6 fw-semibold">Dapatkan 30 poin per kg</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 p-4 d-flex flex-column align-items-center"
                    style="background: #d9f0f7;">
                    <div class="mb-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 90px; height: 90px; background-color: #17a2b8;">
                        <i class="fa-solid fa-wine-bottle fs-1 text-white"></i>
                    </div>
                    <h4 class="fw-bold text-info mb-2">Kumpulkan Kaca & Kaleng</h4>
                    <p class="text-muted mb-3 px-3">Botol kaca, kaleng aluminium, dan logam lainnya.</p>
                    <span class="badge bg-info rounded-pill px-4 py-2 fs-6 fw-semibold">Dapatkan 70 poin per kg</span>
                </div>
            </div>
        </div>

    </section>

    <!-- Exchange Form -->
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3">Form Penukaran</h2>
                    <p class="lead text-muted">Isi data dengan lengkap untuk memproses penukaran sampah Anda</p>
                </div>

                <div class="card border-0 shadow-5"
                    style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">
                    <div class="card-body p-5">
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" id="name"
                                            class="form-control form-control-lg rounded-pill"
                                            style="background: rgba(248, 249, 250, 0.8);" />
                                        <label class="form-label fw-bold" for="name">
                                            <i class="fas fa-user me-2 text-success"></i>Nama Lengkap
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="number" id="weight"
                                            class="form-control form-control-lg rounded-pill"
                                            style="background: rgba(248, 249, 250, 0.8);" step="0.1"
                                            min="0.1" />
                                        <label class="form-label fw-bold" for="weight">
                                            <i class="fas fa-weight me-2 text-primary"></i>Berat Sampah (kg)
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select form-select-lg rounded-pill shadow-2"
                                        style="background: rgba(248, 249, 250, 0.8); border: 1px solid rgba(0,0,0,0.125);">
                                        <option selected disabled>
                                            <i class="fas fa-recycle"></i> Pilih Jenis Sampah
                                        </option>
                                        <option value="plastik">🍼 Plastik (50 poin/kg)</option>
                                        <option value="kertas">📰 Kertas (30 poin/kg)</option>
                                        <option value="kaca">🍾 Kaca & Kaleng (70 poin/kg)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input type="text" id="location"
                                            class="form-control form-control-lg rounded-pill"
                                            style="background: rgba(248, 249, 250, 0.8);" />
                                        <label class="form-label fw-bold" for="location">
                                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>Lokasi Penyerahan
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-outline" data-mdb-input-init>
                                        <textarea class="form-control rounded-4" id="notes" rows="3"
                                            style="background: rgba(248, 249, 250, 0.8);"></textarea>
                                        <label class="form-label fw-bold" for="notes">
                                            <i class="fas fa-sticky-note me-2 text-warning"></i>Catatan Tambahan (Opsional)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit"
                                    class="btn btn-success btn-lg rounded-pill px-5 py-3 shadow-4 fw-bold"
                                    style="background: linear-gradient(135deg, #28a745, #20c997); border: none; transition: all 0.3s ease;">
                                    <i class="fas fa-exchange-alt me-2"></i>Tukar Sekarang
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reward Section -->
    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Reward yang Bisa Kamu Dapatkan</h2>
            <p class="lead text-muted">Tukarkan poin dengan berbagai reward menarik</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background-color: #6f4e37;">
                    </div>
                    <div class="card-body text-center p-4 d-flex flex-column align-items-center">
                        <div class="mb-4 rounded-4 d-inline-flex align-items-center justify-content-center shadow"
                            style="width: 100px; height: 100px; background-color: #6f4e37;">
                            <i class="bi bi-cup-hot text-white fs-1"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Voucher Kopi Premium</h4>
                        <p class="card-text text-muted mb-4">Nikmati kopi berkualitas tinggi dari kedai partner kami</p>
                        <span
                            class="badge bg-light text-dark rounded-pill px-4 py-2 fs-5 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi bi-coin text-warning fs-4"></i>300 poin
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background-color: #fd7e14;">
                    </div>
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-warning rounded-pill shadow-sm">Trending</span>
                    </div>
                    <div class="card-body text-center p-4 d-flex flex-column align-items-center">
                        <div class="mb-4 rounded-4 d-inline-flex align-items-center justify-content-center shadow"
                            style="width: 100px; height: 100px; background-color: #fd7e14;">
                            <i class="bi bi-bag-fill text-white fs-1"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Voucher Belanja</h4>
                        <p class="card-text text-muted mb-4">Berbelanja kebutuhan sehari-hari di marketplace partner</p>
                        <span
                            class="badge bg-light text-dark rounded-pill px-4 py-2 fs-5 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi bi-coin text-warning fs-4"></i>500 poin
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background-color: #dc3545;">
                    </div>
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger rounded-pill shadow-sm">Exclusive</span>
                    </div>
                    <div class="card-body text-center p-4 d-flex flex-column align-items-center">
                        <div class="mb-4 rounded-4 d-inline-flex align-items-center justify-content-center shadow"
                            style="width: 100px; height: 100px; background-color: #dc3545;">
                            <i class="bi bi-gift-fill text-white fs-1"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Merchandise Eksklusif</h4>
                        <p class="card-text text-muted mb-4">Koleksi terbatas tas ramah lingkungan dan aksesoris eco</p>
                        <span
                            class="badge bg-light text-dark rounded-pill px-4 py-2 fs-5 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi bi-coin text-warning fs-4"></i>800 poin
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Riwayat Penukaran Terbaru</h2>
            <p class="lead text-muted">Lihat aktivitas penukaran sampah dari komunitas kami</p>
        </div>

        <div class="card border-0 shadow rounded-4 bg-white">
            <div class="card-header border-0 py-4 bg-light">
                <h5 class="mb-0 fw-bold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-clock-history text-success fs-4"></i>
                    Riwayat Aktivitas
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-4 fw-semibold" style="min-width: 180px;">
                                    <i class="bi bi-person-fill text-primary me-2"></i>Nama
                                </th>
                                <th class="py-3 fw-semibold" style="min-width: 140px;">
                                    <i class="bi bi-recycle text-success me-2"></i>Jenis Sampah
                                </th>
                                <th class="py-3 fw-semibold" style="min-width: 100px;">
                                    <i class="fa-solid fa-scale-balanced text-warning me-2"></i>Berat (kg)
                                </th>
                                <th class="py-3 fw-semibold" style="min-width: 120px;">
                                    <i class="bi bi-coin text-info me-2"></i>Poin
                                </th>
                                <th class="py-3 pe-4 fw-semibold" style="min-width: 140px;">
                                    <i class="bi bi-calendar-event text-danger me-2"></i>Tanggal
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle" style="cursor: default;">
                                <td class="py-3 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 44px; height: 44px; background-color: #28a745; color: white; font-weight: 700; font-size: 1rem;">
                                            MR
                                        </div>
                                        <span class="fw-semibold fs-6">M. Razzan</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-success rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="fa-solid fa-bottle-water"></i> Plastik
                                    </span>
                                </td>
                                <td class="py-3 fw-semibold fs-6">2.0 Kg</td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="bi bi-coin me-1"></i> 100 poin
                                    </span>
                                </td>
                                <td class="py-3 pe-4 text-muted fs-6">30 Agustus 2025</td>
                            </tr>

                            <tr class="align-middle" style="cursor: default;">
                                <td class="py-3 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 44px; height: 44px; background-color: #0d6efd; color: white; font-weight: 700; font-size: 1rem;">
                                            A
                                        </div>
                                        <span class="fw-semibold fs-6">Ayu</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-primary rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="bi bi-journal-text me-1"></i> Kertas
                                    </span>
                                </td>
                                <td class="py-3 fw-semibold fs-6">3.0 Kg</td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="bi bi-coin me-1"></i> 90 poin
                                    </span>
                                </td>
                                <td class="py-3 pe-4 text-muted fs-6">28 Agustus 2025</td>
                            </tr>

                            <tr class="align-middle" style="cursor: default;">
                                <td class="py-3 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 44px; height: 44px; background-color: #17a2b8; color: white; font-weight: 700; font-size: 1rem;">
                                            B
                                        </div>
                                        <span class="fw-semibold fs-6">Budi</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-info rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="bi bi-cup-straw me-1"></i> Kaca & Kaleng
                                    </span>
                                </td>
                                <td class="py-3 fw-semibold fs-6">1.5 Kg</td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 fs-6">
                                        <i class="bi bi-coin me-1"></i> 105 poin
                                    </span>
                                </td>
                                <td class="py-3 pe-4 text-muted fs-6">27 Agustus 2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
