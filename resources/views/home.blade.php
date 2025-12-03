@extends('templates.app')

@push('style')
<style>
    :root {
        --primary-green: #2e7d32;
        --light-green: #66bb6a;
        --pale-green: #e8f5e9;
        --soft-green: #c8e6c9;
        --dark-green: #1b5e20;
    }

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Alert Positioning */
    .alert-container {
        position: absolute;
        top: 120px; /* Sesuaikan dengan tinggi navbar */
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 0 15px;
    }

    .custom-alert {
        border-radius: 12px !important;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        max-width: 600px;
        margin: 0 auto;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.95) !important;
        color: white;
        border-left: 4px solid #16a34a;
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.95) !important;
        color: white;
        border-left: 4px solid #d97706;
    }

    /* Hero Section */
    .hero-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .hero-bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .hero-content {
        max-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: 80px; /* Space for alert */
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: white;
    }

    .hero-description {
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        max-width: 500px;
        color: white;
    }

    .stats-container {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        justify-items: center;
        align-items: start;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100%;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #22c55e;
        display: block;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
        line-height: 1.3;
        display: block;
        color: white;
    }

    .counting {
        transition: all 0.5s ease-out;
    }

    /* Welcome Section */
    .welcome-section {
        padding: 5rem 0;
    }

    /* Feature Cards */
    .feature-section {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border-radius: 20px;
        padding: 3rem 0;
        margin: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .feature-card {
        background: linear-gradient(135deg, #7ec8a3, #5fa87b);
        border: none;
        border-radius: 16px;
        padding: 2rem;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* Image Section */
    .image-section {
        padding: 5rem 0;
    }

    /* Article Section */
    .article-section {
        padding: 5rem 0;
    }

    .article-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    /* NEW Testimonial Section */
    .testimonial-section {
        background: linear-gradient(135deg, #f8fdf8 0%, #e8f5e9 100%);
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }

    .testimonial-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232e7d32' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .testimonial-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(46, 125, 50, 0.1);
        padding: 2.5rem;
        border: none;
        height: 100%;
        position: relative;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(46, 125, 50, 0.15);
    }

    .testimonial-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--light-green));
    }

    .quote-icon {
        font-size: 3rem;
        color: var(--light-green);
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }

    .testimonial-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
        margin-bottom: 2rem;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--pale-green);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover .author-avatar {
        transform: scale(1.1);
        border-color: var(--light-green);
    }

    .author-name {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    .author-position {
        color: var(--light-green);
        font-size: 0.9rem;
    }

    /* Carousel Controls */
    .carousel-container {
        position: relative;
        padding: 0 60px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 60px;
        height: 60px;
        background: var(--primary-green);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.9;
        transition: all 0.4s ease;
        border: 3px solid white;
        box-shadow: 0 5px 25px rgba(46, 125, 50, 0.3);
    }

    .carousel-control-prev {
        left: -30px;
    }

    .carousel-control-next {
        right: -30px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        transform: translateY(-50%) scale(1.1);
        background: var(--dark-green);
        box-shadow: 0 8px 30px rgba(46, 125, 50, 0.4);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        top: 100%;
        width: 25px;
        height: 25px;
    }

    /* Dots Indicator */
    .slider-dots {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin: 3rem 0 1rem 0;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--soft-green);
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .dot::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, var(--primary-green), var(--light-green));
        transition: left 0.4s ease;
    }

    .dot.active {
        transform: scale(1.3);
    }

    .dot.active::before {
        left: 0;
    }

    .dot:hover::before {
        left: 0;
    }

    /* FAQ Section */
    .faq-section {
        background: #f8f9fa;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }

    /* Alert styling */
    .alert {
        margin-bottom: 0 !important;
        border-radius: 0 !important;
    }

     .btn-selengkapnya {
            background: rgba(46, 125, 50, 0.15);
            border: 2px solid rgba(46, 125, 50, 0.3);
            color: #2e7d32;
            border-radius: 25px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            display: inline-flex;
            align-items: center;
            float: right;
            gap: 0.5rem;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn-selengkapnya:hover {
            background: rgba(46, 125, 50, 0.25);
            border-color: rgba(46, 125, 50, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.25);
            color: #1b5e20;
            gap: 0.7rem;
        }

        .btn-selengkapnya i {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-selengkapnya:hover i {
            transform: translateX(3px);
        }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .carousel-control-prev {
            left: -20px;
        }

        .carousel-control-next {
            right: -20px;
        }
    }

    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.2rem;
        }

        .carousel-container {
            padding: 0 40px;
        }

        .carousel-control-prev {
            left: -15px;
        }

        .carousel-control-next {
            right: -15px;
        }

        .stats-grid {
            gap: 1.5rem;
        }

        .alert-container {
            top: 100px;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .stat-number {
            font-size: 1.75rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .carousel-container {
            padding: 0 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }

        .testimonial-card {
            padding: 2rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
            background-size: 20px 20px;
        }

        .alert-container {
            top: 90px;
            padding: 0 10px;
        }

        .custom-alert {
            max-width: 95%;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.75rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 45px;
            height: 45px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 18px;
            height: 18px;
            background-size: 18px 18px;
        }

        .testimonial-card {
            padding: 1.5rem;
        }

        .stats-grid {
            gap: 1rem;
        }

        .stat-number {
            font-size: 1.75rem;
        }

        .hero-content {
            margin-top: 60px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section position-relative overflow-hidden bg-dark">
        <!-- Alert Container -->
        <div class="alert-container">
            @if (Session::get('success'))
                <div class="alert alert-success custom-alert w-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->name }}</b>
                        </div>
                    </div>
                </div>
            @endif
            @if (Session::get('logout'))
                <div class="alert alert-warning custom-alert w-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>{{ Session::get('logout') }}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('danger'))
                <div class="alert alert-warning custom-alert w-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>{{ Session::get('danger') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2073&q=80"
                 alt="Environmental Background"
                 class="w-100 h-100 object-fit-cover">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.5;"></div>
        </div>

        <div class="container position-relative text-white h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">
                            Kelola Sampah dengan<br>
                            <span class="text-success">Bijak</span>
                        </h1>

                        <p class="hero-description">
                            Solusi lengkap pengelolaan sampah berkelanjutan.
                            Edukasi, pengumpulan, hingga daur ulang dalam satu platform.
                        </p>

                        <div class="stats-container">
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <span class="stat-number counting" data-target="50">0</span>
                                    <span class="stat-label">Klien</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number counting" data-target="100">0</span>
                                    <span class="stat-label">Kota</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number counting" data-target="999">0</span>
                                    <span class="stat-label">Sampah Terkelola</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Space for background image -->
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="fw-bold mb-4">Selamat datang <span class="d-block">di <span class="text-success">TrashEdu</span></span></h1>
                </div>
                <div class="col-lg-5">
                    <p class="lead text-muted" style="text-align: justify;">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Earum similique eligendi dicta a provident asperiores dolorem dignissimos, accusantium eveniet doloremque?
                    </p>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="feature-section">
                <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0;">
                    <div class="rounded-circle bg-success opacity-25 position-absolute"
                        style="width:300px; height:300px; top:-100px; left:-100px;"></div>
                    <div class="rounded-circle bg-warning opacity-25 position-absolute"
                        style="width:200px; height:200px; bottom:-50px; right:-80px;"></div>
                </div>

                <div class="container position-relative">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-card">
                                <div class="position-absolute rounded-circle"
                                    style="width: 150px; height: 150px; background: rgba(255,255,255,0.15); top: -40px; right: -40px;"></div>
                                <div class="position-absolute rounded-circle"
                                    style="width: 100px; height: 100px; background: rgba(255,255,255,0.1); bottom: -30px; left: -30px;"></div>
                                <div class="card-body text-white text-center position-relative">
                                    <i class="fas fa-recycle fa-3x mb-3"></i>
                                    <h5 class="fw-bold">Sampahmu, Hadiahmu!</h5>
                                    <p class="mb-3">Kumpulkan sampah yang kamu miliki, tukarkan jadi poin, dan raih berbagai hadiah menarik sambil jaga lingkungan.</p>
                                    <a href="{{ route('exchange') }}" class="btn btn-light btn-rounded">
                                        Pelajari lebih lanjut
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature-card" style="background: linear-gradient(135deg, #a8cfc4, #7aa89f);">
                                <div class="position-absolute rounded-circle"
                                    style="width: 180px; height: 180px; background: rgba(255,255,255,0.15); top: -40px; right: -40px; z-index:0;"></div>
                                <div class="position-absolute rounded-circle"
                                    style="width: 120px; height: 120px; background: rgba(255,255,255,0.1); bottom: -30px; left: -30px; z-index:0;"></div>
                                <div class="card-body text-white text-center position-relative" style="z-index:1;">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5 class="fw-bold">Komunitas & Aksi</h5>
                                    <p class="mb-3">Ikuti challenge ramah lingkungan, diskusi, dan kegiatan komunitas untuk jaga bumi bersama-sama.</p>
                                    <a href="#Lanjut" class="btn btn-light btn-rounded px-4">
                                        Pelajari Lebih Lanjut
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Section -->
    <section class="image-section" id="Lanjut">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 position-relative text-center">
                    <div class="position-absolute top-50 start-50 translate-middle"
                        style="width:450px; height:450px; background:rgba(13,202,240,0.15); border-radius:50% 35% 60% 40%; z-index:0;"></div>
                    <img src="{{ asset('images/contoh.webp') }}"
                        class="shadow-lg position-relative w-100"
                        style="border-radius:60px 120px 40px 100px; z-index:1; max-width:600px; height:auto;" alt="Foto Laut">
                    <div class="d-flex justify-content-center gap-3 bg-white shadow rounded-pill px-4 py-2 position-absolute"
                        style="bottom: 50px; left:90%; transform:translateX(-70%); z-index:2;">
                        <img src="{{ asset('images/logo2.png') }}" style="height:24px;" alt="Logo1">
                        <img src="{{ asset('images/logo2.png') }}" style="height:24px;" alt="Logo2">
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width:50px; height:3px; background:#0dcaf0;" class="me-2"></div>
                        <span class="fw-semibold text-uppercase small" style="letter-spacing:.1em;">Lorem ipsum dolor sit amet.</span>
                    </div>
                    <h2 class="fw-bold mb-4" style="font-size:2.4rem; line-height:1.3;">
                        Lorem ipsum dolor sit. <br>
                        Lorem, ipsum dolor.
                    </h2>
                    <p class="text-muted mb-4 fs-5">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio nisi hic non fugiat?
                    </p>
                    <a href="#" class="btn btn-outline-info px-5 py-2 rounded-pill">Lorem, ipsum.</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Section -->
    <section class="article-section my-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="article-card border-0 shadow h-100">
                        <img src="{{ asset('images/contoh.webp') }}" class="w-100" alt="Reduce Waste"
                            style="height:250px; object-fit:cover;">
                        <div style="background:#fff; padding:20px; position: relative; top:-40px; margin:0 15px; border-radius:8px;">
                            <p class="text-uppercase small text-muted mb-1">Lorem, ipsum dolor.</p>
                            <h5 class="fw-bold">Lorem ipsum dolor sit amet.</h5>
                            <p class="text-muted" style="font-size:15px;">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quam officia deserunt, debitis dolorum vero iure veniam illo assumenda harum.
                            </p>
                            <a href="#" class="fw-bold text-primary text-decoration-none">
                                Lorem, ipsum. <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="article-card border-0 shadow h-100">
                        <img src="{{ asset('images/contoh.webp') }}" class="w-100" alt="Residential"
                            style="height:250px; object-fit:cover;">
                        <div style="background:#fff; padding:20px; position: relative; top:-40px; margin:0 15px; border-radius:8px;">
                            <p class="text-uppercase small text-muted mb-1">Lorem, ipsum dolor.</p>
                            <h5 class="fw-bold">Lorem ipsum dolor sit.</h5>
                            <p class="text-muted" style="font-size:15px;">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia non dolorum voluptatum repellendus cupiditate quos, animi ullam culpa libero tempora.
                            </p>
                            <a href="#" class="fw-bold text-primary text-decoration-none">
                                Lorem, ipsum. <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="article-card border-0 shadow h-100">
                        <img src="{{ asset('images/contoh.webp') }}" class="w-100" alt="Community"
                            style="height:250px; object-fit:cover;">
                        <div style="background:#fff; padding:20px; position: relative; top:-40px; margin:0 15px; border-radius:8px;">
                            <p class="text-uppercase small text-muted mb-1">Lorem, ipsum dolor.</p>
                            <h5 class="fw-bold">Lorem ipsum dolor sit.</h5>
                            <p class="text-muted" style="font-size:15px;">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, magni. Nobis laborum est natus obcaecati optio non, quae facilis omnis.
                            </p>
                            <a href="#" class="fw-bold text-primary text-decoration-none">
                                Lorem, ipsum. <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                <a href="#" class="mt-4 btn-selengkapnya">
        Lihat Selengkapnya
        <i class="bi bi-arrow-right"></i>
    </a>
        </div>
    </section>

    <!-- NEW Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold text-success mb-3">Apa Kata Mereka</h2>
                    <p class="lead text-muted">Testimoni dari klien dan pelanggan yang telah merasakan manfaat layanan kami</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="carousel-container">
                        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Testimonial 1 -->
                                <div class="carousel-item active">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 col-lg-10">
                                            <div class="testimonial-card">
                                                <div class="quote-icon">❝</div>
                                                <p class="testimonial-text">
                                                    "Saya sangat terkesan dengan kualitas layanan yang diberikan. Tim profesional dan responsif, hasilnya melebihi ekspektasi saya. Sangat direkomendasikan!"
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Avatar" class="author-avatar me-3">
                                                    <div>
                                                        <div class="author-name">Sarah Johnson</div>
                                                        <div class="author-position">CEO, TechSolutions</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimonial 2 -->
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 col-lg-10">
                                            <div class="testimonial-card">
                                                <div class="quote-icon">❝</div>
                                                <p class="testimonial-text">
                                                    "Proses kerja sama yang sangat smooth dan hasil yang memuaskan. Mereka benar-benar memahami kebutuhan bisnis saya dan memberikan solusi yang tepat."
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Avatar" class="author-avatar me-3">
                                                    <div>
                                                        <div class="author-name">Michael Chen</div>
                                                        <div class="author-position">Marketing Director, GlobalCorp</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimonial 3 -->
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 col-lg-10">
                                            <div class="testimonial-card">
                                                <div class="quote-icon">❝</div>
                                                <p class="testimonial-text">
                                                    "Pelayanan yang luar biasa! Tim sangat komunikatif dan detail-oriented. Hasil akhirnya sesuai dengan yang diharapkan bahkan lebih baik. Terima kasih!"
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Avatar" class="author-avatar me-3">
                                                    <div>
                                                        <div class="author-name">Lisa Rodriguez</div>
                                                        <div class="author-position">Founder, CreativeMinds</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimonial 4 -->
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 col-lg-10">
                                            <div class="testimonial-card">
                                                <div class="quote-icon">❝</div>
                                                <p class="testimonial-text">
                                                    "Saya sudah bekerja sama dengan banyak vendor, tapi pengalaman dengan tim ini yang terbaik. Mereka memberikan value yang luar biasa untuk bisnis saya."
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Avatar" class="author-avatar me-3">
                                                    <div>
                                                        <div class="author-name">David Wilson</div>
                                                        <div class="author-position">Product Manager, InnovateCo</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimonial 5 -->
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 col-lg-10">
                                            <div class="testimonial-card">
                                                <div class="quote-icon">❝</div>
                                                <p class="testimonial-text">
                                                    "Transformasi digital yang dilakukan tim ini benar-benar mengubah cara bisnis kami beroperasi. Efisiensi meningkat 40% dalam waktu 3 bulan pertama!"
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/women/26.jpg" alt="Avatar" class="author-avatar me-3">
                                                    <div>
                                                        <div class="author-name">Amanda Lee</div>
                                                        <div class="author-position">Operations Director, GrowthLabs</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <button style="margin-left: -33px" class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                                <span style="margin-bottom: 20px" class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button style="margin-right: -33px" class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                                <span style="margin-bottom: 20px;" class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>

                        <!-- Dots Indicator -->
                        <div class="slider-dots">
                            <div class="dot active" data-bs-target="#testimonialCarousel" data-bs-slide-to="0"></div>
                            <div class="dot" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></div>
                            <div class="dot" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"></div>
                            <div class="dot" data-bs-target="#testimonialCarousel" data-bs-slide-to="3"></div>
                            <div class="dot" data-bs-target="#testimonialCarousel" data-bs-slide-to="4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="position-absolute top-0 start-0" style="z-index:0; pointer-events:none;">
            <div class="bg-success rounded-circle"
                style="width:120px; height:120px; opacity:0.08; transform:translate(-40%,-40%);"></div>
        </div>
        <div class="position-absolute top-0 end-0" style="z-index:0; pointer-events:none;">
            <div class="bg-primary rounded-circle"
                style="width:90px; height:90px; opacity:0.08; transform:translate(40%,-40%);"></div>
        </div>
        <div class="position-absolute bottom-0 start-0" style="z-index:0; pointer-events:none;">
            <div class="bg-warning"
                style="width:100px; height:100px; opacity:0.07; transform:rotate(25deg) translate(-30%,30%);">
            </div>
        </div>
        <div class="position-absolute bottom-0 end-0" style="z-index:0; pointer-events:none;">
            <i class="fas fa-leaf text-success"
                style="font-size:110px; opacity:0.06; transform:translate(40%,40%);"></i>
        </div>

        <div class="container position-relative" style="z-index:1;">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold text-success mb-3">
                    <i class="fas fa-question-circle me-3"></i>
                    Pertanyaan Umum
                </h2>
                <p class="lead text-muted col-lg-8 mx-auto">
                    Temukan jawaban atas pertanyaan yang sering diajukan tentang TrashEdu dan program-programnya
                </p>
            </div>

            <!-- FAQ Content (same as original) -->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ items tetap sama -->
<div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                            <h2 class="accordion-header"> <button
                                    class="accordion-button collapsed bg-light fw-semibold text-dark rounded-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center w-100"> <span class="badge bg-success me-3">
                                            <i class="fas fa-user-plus"></i>
                                        </span> <span class="flex-grow-1">Bagaimana cara bergabung dengan
                                            TrashEdu?</span> </div>
                                </button> </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <p class="text-muted mb-3">Anda bisa bergabung dengan mudah melalui
                                                website kami atau aplikasi TrashEdu. Cukup daftar dengan email dan
                                                mulai ikuti program-program yang tersedia secara gratis.</p>
                                            <div class="d-flex flex-wrap gap-2 mb-3"> <span
                                                    class="badge bg-success-subtle text-success"> <i
                                                        class="fas fa-check me-1"></i>Gratis </span> <span
                                                    class="badge bg-info-subtle text-info"> <i
                                                        class="fas fa-clock me-1"></i>5 Menit </span> <span
                                                    class="badge bg-primary-subtle text-primary"> <i
                                                        class="fas fa-mobile-alt me-1"></i>Website & App </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- FAQ Item 2 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                            <h2 class="accordion-header"> <button
                                    class="accordion-button collapsed bg-light fw-semibold text-dark rounded-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <div class="d-flex align-items-center w-100"> <span class="badge bg-warning me-3">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span> <span class="flex-grow-1">Apakah semua program TrashEdu
                                            gratis?</span> </div>
                                </button> </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    <div class="alert alert-success d-flex align-items-center mb-3" role="alert"> <i
                                            class="fas fa-check-circle me-2"></i>
                                        <div><strong>Ya!</strong> Semua program edukasi dasar TrashEdu adalah 100%
                                            gratis </div>
                                    </div>
                                    <p class="text-muted mb-3">Untuk workshop khusus atau sertifikasi resmi,
                                        mungkin ada biaya nominal untuk operasional dan penerbitan sertifikat.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card border-success h-100">
                                                <div class="card-header bg-success text-white"> <i
                                                        class="fas fa-gift me-2"></i>Program Gratis </div>
                                                <div class="card-body">
                                                    <ul class="list-unstyled mb-0">
                                                        <li><i class="fas fa-check text-success me-2"></i>Kursus
                                                            Online Dasar</li>
                                                        <li><i class="fas fa-check text-success me-2"></i>Webinar
                                                            Rutin </li>
                                                        <li><i class="fas fa-check text-success me-2"></i>Komunitas
                                                            Forum </li>
                                                        <li><i class="fas fa-check text-success me-2"></i>Materi
                                                            Pembelajaran</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-warning h-100">
                                                <div class="card-header bg-warning text-dark"> <i
                                                        class="fas fa-star me-2"></i>Program Premium </div>
                                                <div class="card-body">
                                                    <ul class="list-unstyled mb-0">
                                                        <li><i class="fas fa-certificate text-warning me-2"></i>Sertifikasi
                                                            Resmi</li>
                                                        <li><i class="fas fa-users text-warning me-2"></i>Workshop
                                                            Eksklusif</li>
                                                        <li><i class="fas fa-headset text-warning me-2"></i>Mentoring
                                                            1-on-1</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- FAQ Item 3 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                            <h2 class="accordion-header"> <button
                                    class="accordion-button collapsed bg-light fw-semibold text-dark rounded-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <div class="d-flex align-items-center w-100"> <span class="badge bg-info me-3"> <i
                                                class="fas fa-calendar-alt"></i>
                                        </span> <span class="flex-grow-1">Bagaimana cara mengorganisir event di
                                            komunitas saya?</span> </div>
                                </button> </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    <p class="text-muted mb-4">Tim TrashEdu siap membantu Anda mengorganisir event
                                        di komunitas. Hubungi kami melalui kontak yang tersedia dan kami akan
                                        memberikan panduan lengkap serta dukungan yang diperlukan.</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-primary mb-3"> <i
                                                    class="fas fa-list-ol me-2"></i>Langkah-langkah: </h6>
                                            <div class="timeline">
                                                <div class="d-flex mb-3"> <span
                                                        class="badge bg-primary rounded-circle me-3">1</span>
                                                    <span>Hubungi tim TrashEdu melalui form kontak</span>
                                                </div>
                                                <div class="d-flex mb-3"> <span
                                                        class="badge bg-primary rounded-circle me-3">2</span>
                                                    <span>Diskusikan konsep dan tujuan event</span>
                                                </div>
                                                <div class="d-flex mb-3"> <span
                                                        class="badge bg-primary rounded-circle me-3">3</span>
                                                    <span>Terima panduan & materi edukasi</span>
                                                </div>
                                                <div class="d-flex mb-3"> <span
                                                        class="badge bg-primary rounded-circle me-3">4</span>
                                                    <span>Eksekusi event dengan dukungan tim</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-success mb-3"> <i
                                                    class="fas fa-hands-helping me-2"></i>Dukungan tersedia: </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"> <i class="fas fa-check text-success me-2"></i>
                                                    Materi edukasi lengkap </li>
                                                <li class="mb-2"> <i class="fas fa-check text-success me-2"></i>
                                                    Panduan pelaksanaan event </li>
                                                <li class="mb-2"> <i class="fas fa-check text-success me-2"></i>
                                                    Sertifikat untuk peserta </li>
                                                <li class="mb-2"> <i class="fas fa-check text-success me-2"></i>
                                                    Dokumentasi & laporan </li>
                                                <li class="mb-2"> <i class="fas fa-check text-success me-2"></i>
                                                    Konsultasi via WhatsApp </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- FAQ Item 4 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                            <h2 class="accordion-header"> <button
                                    class="accordion-button collapsed bg-light fw-semibold text-dark rounded-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <div class="d-flex align-items-center w-100"> <span class="badge bg-secondary me-3">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span> <span class="flex-grow-1">Apakah TrashEdu tersedia di seluruh
                                            Indonesia?</span> </div>
                                </button> </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2"> <span
                                                class="text-muted">Jangkauan saat ini:</span> <span
                                                class="fw-bold text-success">75% Indonesia</span> </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-4">Saat ini TrashEdu aktif di kota-kota besar Indonesia
                                        dan terus berkembang. Kami berkomitmen untuk menjangkau seluruh nusantara
                                        dalam waktu dekat.</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card border-success h-100">
                                                <div class="card-header bg-success text-white d-flex align-items-center">
                                                    <i class="fas fa-check-circle me-2"></i> <span>Tersedia
                                                        Sekarang</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6"> <small
                                                                class="text-muted d-block">Jakarta</small> <small
                                                                class="text-muted d-block">Surabaya</small> <small
                                                                class="text-muted d-block">Bandung</small> </div>
                                                        <div class="col-6"> <small
                                                                class="text-muted d-block">Medan</small> <small
                                                                class="text-muted d-block">Yogyakarta</small>
                                                            <small class="text-muted d-block">Makassar</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-warning h-100">
                                                <div class="card-header bg-warning text-dark d-flex align-items-center">
                                                    <i class="fas fa-clock me-2"></i> <span>Segera Hadir</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6"> <small
                                                                class="text-muted d-block">Semarang</small> <small
                                                                class="text-muted d-block">Palembang</small> <small
                                                                class="text-muted d-block">Denpasar</small> </div>
                                                        <div class="col-6"> <small
                                                                class="text-muted d-block">Balikpapan</small>
                                                            <small class="text-muted d-block">Malang</small> <small
                                                                class="text-muted d-block">Manado</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- FAQ Item 5 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                            <h2 class="accordion-header"> <button
                                    class="accordion-button collapsed bg-light fw-semibold text-dark rounded-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <div class="d-flex align-items-center w-100"> <span class="badge bg-primary me-3">
                                            <i class="fas fa-chart-line"></i>
                                        </span> <span class="flex-grow-1">Bagaimana cara melacak progress saya di
                                            TrashEdu?</span> </div>
                                </button> </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    <p class="text-muted mb-4">Setiap anggota memiliki dashboard personal yang
                                        menampilkan progress pembelajaran, pencapaian, badge yang diperoleh, dan
                                        kontribusi terhadap lingkungan.</p>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-3 col-6">
                                            <div class="text-center p-3 bg-primary bg-opacity-10 rounded-3">
                                                <div class="text-primary fs-3 mb-2"> <i class="fas fa-tasks"></i>
                                                </div>
                                                <h6 class="fw-bold">Progress</h6> <small class="text-muted">Lacak
                                                    kemajuan kursus Anda</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center p-3 bg-warning bg-opacity-10 rounded-3">
                                                <div class="text-warning fs-3 mb-2"> <i class="fas fa-medal"></i>
                                                </div>
                                                <h6 class="fw-bold">Point</h6> <small class="text-muted">Kumpulkan
                                                    point</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center p-3 bg-success bg-opacity-10 rounded-3">
                                                <div class="text-success fs-3 mb-2"> <i class="fas fa-leaf"></i>
                                                </div>
                                                <h6 class="fw-bold">Kontribusi</h6> <small class="text-muted">Dampak
                                                    positif lingkungan</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center p-3 bg-info bg-opacity-10 rounded-3">
                                                <div class="text-info fs-3 mb-2"> <i class="fas fa-certificate"></i>
                                                </div>
                                                <h6 class="fw-bold">Sertifikat</h6> <small class="text-muted">Bukti
                                                    kompetensi</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info" role="alert"> <i class="fas fa-lightbulb me-2"></i>
                                        <strong>Tips:</strong> Login setiap
                                        hari untuk mendapatkan streak bonus dan mendapatkan point!
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
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize carousel
        const carousel = new bootstrap.Carousel('#testimonialCarousel', {
            interval: 3000,
            wrap: true,
            touch: true,
            pause: 'hover'
        });

        // Enhanced dots indicator functionality
        const dots = document.querySelectorAll('.dot');
        const carouselElement = document.getElementById('testimonialCarousel');

        carouselElement.addEventListener('slid.bs.carousel', function(event) {
            const activeIndex = event.to;

            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === activeIndex);
            });
        });

        // Dot click navigation with smooth transition
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                const slideTo = parseInt(this.getAttribute('data-bs-slide-to'));
                carousel.to(slideTo);
            });
        });

        // Enhanced counter animation
        function animateCounter(element, target, duration = 1500) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = formatNumber(target);
                    clearInterval(timer);
                } else {
                    element.textContent = formatNumber(Math.floor(start));
                }
            }, 16);
        }

        function formatNumber(num) {
            if (num >= 999) {
                return (num / 999).toFixed(0) + 'k+';
            }
            return num + '+';
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.counting');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-target'));
                        animateCounter(counter, target);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        // Observe stats section
        const statsSection = document.querySelector('.stats-container');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.custom-alert');
            alerts.forEach(alert => {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    });
</script>
@endpush
