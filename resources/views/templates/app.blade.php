<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon"
        href="https://play-lh.googleusercontent.com/FcRZx_UEXN2uc7uKM5EKGn7Jmb65c8VVELlmligxdfUcjKKIpzFX0SHXFePllD2g4ik"
        type="image/x-icon">
    <title>TrashEdu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/47.1.0/ckeditor5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <style>
        /* ===== NAVBAR BASE STYLES ===== */
        .navbar-custom {
            background: white !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        /* ===== BRAND STYLES ===== */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a3c2a !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            color: #22c55e !important;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
            border-radius: 8px;
            padding: 2px;
            background: rgba(34, 197, 94, 0.1);
            height: 35px;
        }

        .navbar-brand:hover img {
            transform: rotate(10deg) scale(1.1);
            background: rgba(34, 197, 94, 0.2);
        }

        /* ===== NAV LINK STYLES ===== */
        .nav-link {
            color: #1a3c2a !important;
            font-weight: 600;
            padding: 8px 16px !important;
            margin: 0 2px;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
        }

        .nav-link:hover {
            background: rgba(34, 197, 94, 0.12);
            color: #166534 !important;
            transform: translateY(-1px);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: #22c55e !important;
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.18), rgba(187, 247, 208, 0.15));
            color: #166534 !important;
            font-weight: 700;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .nav-link.active i {
            color: #22c55e !important;
            transform: scale(1.15);
        }

        /* ===== BUTTON STYLES ===== */
        .btn-login {
            background: rgba(34, 197, 94, 0.1);
            border: 2px solid rgba(34, 197, 94, 0.3);
            color: #166534;
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
        }

        .btn-login:hover {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.5);
            transform: translateY(-1px);
            color: #166534;
        }

        .btn-signup {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
        }

        .btn-signup:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            transform: translateY(-1px);
        }

        /* ===== USER INFO STYLES ===== */
        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 200px;
            cursor: pointer;
        }

        .user-info:hover {
            background: rgba(34, 197, 94, 0.18);
            border-color: rgba(34, 197, 94, 0.3);
            transform: translateY(-1px);
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(34, 197, 94, 0.15);
            border-radius: 50%;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .user-avatar i {
            font-size: 1rem;
            color: #1a3c2a;
            transition: all 0.3s ease;
        }

        .user-info:hover .user-avatar {
            background: rgba(34, 197, 94, 0.25);
            transform: scale(1.05);
        }

        .user-info:hover .user-avatar i {
            color: #22c55e;
            transform: scale(1.1);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #1a3c2a;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.3s ease;
        }

        .user-info:hover .user-name {
            color: #166534;
        }

        .user-points {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            color: #166534;
            font-weight: 600;
        }

        .user-points i {
            color: #f59e0b;
            font-size: 0.75rem;
        }

        .user-role {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .role-badge {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        /* POINT BADGE STYLES */
        .point-badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            border: 1px solid rgba(251, 191, 36, 0.3);
            box-shadow: 0 2px 6px rgba(217, 119, 6, 0.3);
            transition: all 0.3s ease;
            margin-right: 8px;
        }

        .point-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(245, 158, 11, 0.4);
        }

        .point-badge i {
            font-size: 0.7rem;
        }

        /* DROPDOWN STYLES */
        .user-dropdown-menu {
            background: white !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 12px !important;
            padding: 6px !important;
            min-width: 180px !important;
            margin-top: 6px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .user-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            color: #1a3c2a !important;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            border: none;
            background: none;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: rgba(34, 197, 94, 0.1) !important;
            color: #166534 !important;
            transform: translateX(4px);
        }

        .user-dropdown-menu .dropdown-item i {
            width: 14px;
            text-align: center;
            color: #22c55e;
            transition: all 0.3s ease;
        }

        .user-dropdown-menu .dropdown-item:hover i {
            color: #16a34a;
            transform: scale(1.1);
        }

        .profile-item:hover {
            border-left: 2px solid #22c55e !important;
        }

        .points-item:hover {
            border-left: 2px solid #fbbf24 !important;
        }

        .points-item:hover i {
            color: #f59e0b !important;
        }

        .logout-item:hover {
            border-left: 2px solid #ef4444 !important;
        }

        .logout-item:hover i {
            color: #ef4444 !important;
        }

        .user-dropdown-menu .dropdown-divider {
            margin: 3px 0 !important;
            background-color: rgba(34, 197, 94, 0.2) !important;
        }

        /* NAVBAR TOGGLER */
        .navbar-toggler {
            border: none;
            padding: 5px 8px;
            border-radius: 10px;
            background: rgba(34, 197, 94, 0.12);
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background: rgba(34, 197, 94, 0.2);
            transform: scale(1.05);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .navbar-toggler i {
            color: #1a3c2a;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                border-radius: 16px;
                margin-top: 12px;
                padding: 16px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            .nav-link {
                margin: 3px 0;
                justify-content: flex-start;
                padding: 10px 16px !important;
            }

            .user-info {
                max-width: none;
                min-width: auto;
                width: 100%;
                justify-content: center;
                margin: 6px 0;
                padding: 10px 16px;
            }

            .user-details {
                justify-content: center;
                text-align: center;
            }

            .point-badge {
                margin-right: 0;
                margin-bottom: 8px;
                justify-content: center;
                width: 100%;
            }

            .navbar-nav .btn-login,
            .navbar-nav .btn-signup {
                justify-content: center;
                margin: 6px 0;
                padding: 10px 16px;
            }
        }

        /* COMPACT LAYOUT */
        @media (max-width: 1200px) {
            .nav-link {
                padding: 6px 12px !important;
                font-size: 0.8rem;
            }

            .nav-link i {
                font-size: 0.8rem;
            }

            .user-info {
                max-width: 180px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.3rem;
            }

            .navbar-brand img {
                height: 30px;
            }

            .point-badge {
                font-size: 0.65rem;
                padding: 3px 8px;
            }
        }

        /* FOOTER STYLES (Tetap sama) */
        .footer-custom {
            background: linear-gradient(135deg, #1a3c2a 0%, #166534 100%);
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: auto;
        }

        .footer-content {
            position: relative;
            z-index: 2;
        }

        .footer-brand {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .footer-brand:hover {
            color: #bbf7d0;
            transform: translateY(-2px);
        }

        .footer-brand img {
            border-radius: 12px;
            padding: 4px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .footer-brand:hover img {
            transform: scale(1.1) rotate(5deg);
            background: rgba(255, 255, 255, 0.2);
        }

        .footer-description {
            color: #bbf7d0;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 300px;
        }

        .footer-heading {
            color: #bbf7d0;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: #22c55e;
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #d1fae5;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            padding: 6px 0;
            border-radius: 8px;
        }

        .footer-links a:hover {
            color: #22c55e;
            transform: translateX(8px);
        }

        .footer-links a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .footer-links a:hover i {
            color: #22c55e;
            transform: scale(1.2);
        }

        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-info li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: #d1fae5;
        }

        .contact-info i {
            color: #22c55e;
            font-size: 1.2rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #22c55e;
            transform: translateY(-3px) scale(1.1);
            color: #bbf7d0;
        }

        .social-link i {
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-link:hover i {
            transform: scale(1.2);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0 1rem;
            margin-top: 3rem;
        }

        .copyright {
            color: #9ca3af;
            font-size: 0.9rem;
            text-align: center;
        }

        .footer-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .footer-badge {
            background: rgba(255, 255, 255, 0.1);
            color: #bbf7d0;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .footer-badge:hover {
            background: rgba(34, 197, 94, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        /* Newsletter Section */
        .newsletter-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .newsletter-input {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 12px 20px;
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .newsletter-input::placeholder {
            color: #9ca3af;
        }

        .newsletter-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: #22c55e;
        }

        .newsletter-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 25px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .newsletter-btn:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
        }

        /* Mobile Responsive Footer */
        @media (max-width: 768px) {
            .footer-brand {
                font-size: 1.6rem;
                justify-content: center;
                text-align: center;
            }

            .footer-description {
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }

            .footer-heading {
                text-align: center;
                display: block;
            }

            .footer-heading::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                justify-content: center;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-btn {
                width: 100%;
            }
        }

        /* MAIN CONTENT PADDING FOR FIXED NAVBAR */
        body {
            padding-top: 70px;
        }
    </style>
    @stack('style')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" height="35" alt="TrashEdu Logo" class="me-2">
                <span class="fw-bold">TrashEdu</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-database me-1"></i>Data Master
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-film me-2"></i>Bioskop</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-video me-2"></i>Film</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i
                                            class="fas fa-users me-2"></i>Pengguna</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::check() && Auth::user()->role == 'staff')
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-calendar-alt me-1"></i>Jadwal Tayang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-tag me-1"></i>Promo
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.quizzes.index') }}">
                                <i class="fa-solid fa-circle-question"></i>Bermain Quiz
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.waste.submit') }}">
                                <i class="fa-solid fa-trash"></i>Tukar Sampah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.rewards.redeem')}}">
                                <i class="fa-solid fa-gift"></i>Tukar Hadiah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.articles.index') }}">
                                <i class="fa-solid fa-newspaper"></i>Baca Article
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="d-flex align-items-center">
                    @if (Auth::check())
                        <div class="dropdown">
                            <div class="user-info d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" id="userDropdown">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="user-details">
                                    <div class="user-name" title="{{ Auth::user()->name }}">
                                        {{ Str::limit(Auth::user()->name, 15) }}
                                    </div>
                                    @if (Auth::user()->role == 'user')
                                        <div class="user-points">
                                            <i class="fas fa-coins"></i>
                                            {{ $userStats['total_points'] ?? 0 }} Points
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu"
                                aria-labelledby="userDropdown">
                                @if (Auth::user()->role == 'user')
                                    <li>
                                        <a class="dropdown-item points-item" href="#">
                                            <i class="fas fa-star me-2"></i>
                                            <span>My Points: {{ $userStats['total_points'] ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        class="dropdown-item logout-item w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login me-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a href="{{ route('signup') }}" class="btn btn-signup">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer-custom pt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Brand & Description -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="footer-brand">
                        <img src="{{ asset('images/logo.png') }}" height="45" alt="TrashEdu Logo">
                        <span>TrashEdu</span>
                    </a>
                    <p class="footer-description">
                        Platform edukasi pengelolaan sampah terdepan di Indonesia. Mari bersama-sama menjaga bumi untuk
                        generasi mendatang.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Menu Utama</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.quizzes.index') }}">
                                <i class="fa-solid fa-circle-question"></i>
                                Bermain Quiz
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-graduation-cap"></i>
                                Edukasi
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-users"></i>
                                Komunitas
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Sumber Belajar</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="#">
                                <i class="fas fa-book"></i>
                                Artikel
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-video"></i>
                                Video Edukasi
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-chart-bar"></i>
                                Statistik Sampah
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-newspaper"></i>
                                Berita Terkini
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">Hubungi Kami</h5>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Lingkungan Hijau No. 123, Jakarta Selatan, Indonesia</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+62 895 3213 84487</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@trashedu.id</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Senin - Jumat: 08.00 - 17.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom mt-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="copyright mb-0">
                            &copy; 2024 TrashEdu. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-badges">
                            <span class="footer-badge">
                                <i class="fas fa-leaf me-1"></i> Ramah Lingkungan
                            </span>
                            <span class="footer-badge">
                                <i class="fas fa-award me-1"></i> Terpercaya
                            </span>
                            <span class="footer-badge">
                                <i class="fas fa-heart me-1"></i> Untuk Negeri
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/47.1.0/ckeditor5.umd.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple active nav detection
            function setActiveNav() {
                const currentPath = window.location.pathname;
                const navLinks = document.querySelectorAll('.nav-link[href]');
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Find the current active link
                navLinks.forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (currentPath === linkHref || (currentPath === "/" && linkHref === "{{ route('home') }}")) {
                        link.classList.add('active');
                    }
                });
            }

            setActiveNav();

            // Newsletter form submission
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('.newsletter-input').value;
                    alert('Terima kasih! Email ' + email + ' berhasil berlangganan newsletter kami.');
                    this.reset();
                });
            }

            // Add padding to body for fixed navbar
            const updateBodyPadding = () => {
                const navbarHeight = document.querySelector('.navbar-custom').offsetHeight;
                document.body.style.paddingTop = navbarHeight + 'px';
            };

            updateBodyPadding();
            window.addEventListener('resize', updateBodyPadding);
        });
    </script>
    @stack('script')
</body>

</html>
