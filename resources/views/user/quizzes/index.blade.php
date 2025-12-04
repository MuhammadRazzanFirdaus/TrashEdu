@extends('templates.app')

@push('style')
    <style>
        /* Hero Background - Clean & Modern */
        .hero-background {
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.15) 0%, rgba(102, 187, 106, 0.15) 100%),
                url('https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            min-height: 85vh;
            display: flex;
            align-items: center;
            position: relative;
            margin-top: -80px;
            padding-top: 120px;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.95) 0%,
                    rgba(255, 255, 255, 0.85) 50%,
                    rgba(255, 255, 255, 0.75) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 3rem 0;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero-title-icon {
            display: inline-block;
            background: linear-gradient(135deg, #2E7D32, #66BB6A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 15px;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .hero-stats {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 3rem;
            box-shadow: 0 15px 40px rgba(46, 125, 50, 0.1);
            border: 1px solid rgba(46, 125, 50, 0.1);
        }

        .hero-stat-item {
            text-align: center;
            padding: 1rem;
            position: relative;
        }

        .hero-stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60px;
            width: 1px;
            background: linear-gradient(to bottom, transparent, #2E7D32, transparent);
        }

        .hero-stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2E7D32, #66BB6A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .hero-buttons {
            margin-top: 3rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
            color: white;
            border: none;
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(46, 125, 50, 0.4);
            color: white;
        }

        .btn-hero-secondary {
            background: white;
            color: #2E7D32;
            border: 2px solid #2E7D32;
        }

        .btn-hero-secondary:hover {
            background: #2E7D32;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.2);
        }

        /* Quiz Section Styling - IMPROVED */
        .quiz-section {
            background: #f8fafc;
            padding: 80px 0;
            position: relative;
        }

        /* Header Section */
        .section-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .section-title-main {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2E7D32;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title-main::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #2E7D32, #66BB6A);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(46, 125, 50, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(46, 125, 50, 0.12);
        }

        .stats-header {
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-item {
            padding: 1.5rem;
            text-align: center;
            border-right: 1px solid #f0f0f0;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: #2e7d32;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Quiz Grid - IMPROVED */
        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .quiz-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        /* Quiz Card - IMPROVED */
        .quiz-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .quiz-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(46, 125, 50, 0.15);
            border-color: rgba(46, 125, 50, 0.2);
        }

        .quiz-card-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .quiz-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 3;
        }

        .quiz-thumbnail {
            height: 200px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .quiz-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .quiz-card:hover .quiz-thumbnail img {
            transform: scale(1.1);
        }

        .quiz-thumbnail-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
        }

        .difficulty-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            z-index: 2;
        }

        .quiz-content {
            padding: 1.75rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .quiz-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            min-height: 3.8rem;
        }

        .quiz-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .quiz-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            margin-top: auto;
        }

        .meta-item {
            text-align: center;
            flex: 1;
            padding: 0.5rem;
        }

        .meta-value {
            font-weight: 700;
            color: #2e7d32;
            font-size: 1.1rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .progress-container {
            padding: 0 1.75rem 1.5rem;
            margin-top: auto;
        }

        .progress-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 4px;
            background: linear-gradient(90deg, #4CAF50, #66BB6A);
        }

        /* Action Button Area */
        .quiz-action {
            padding: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background: #fafafa;
        }

        .btn-quiz-action {
            border-radius: 12px;
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .btn-start {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
        }

        .btn-start:hover {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
        }

        .btn-continue {
            background: linear-gradient(135deg, #ff9800, #ffb74d);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.2);
        }

        .btn-continue:hover {
            background: linear-gradient(135deg, #f57c00, #ff9800);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 124, 0, 0.3);
        }

        .btn-result {
            background: linear-gradient(135deg, #2196f3, #64b5f6);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
        }

        .btn-result:hover {
            background: linear-gradient(135deg, #1976d2, #2196f3);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
        }

        .btn-login {
            background: white;
            border: 2px solid #2e7d32;
            color: #2e7d32;
        }

        .btn-login:hover {
            background: #2e7d32;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.2);
        }

        /* Point Reward */
        .point-reward {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 3;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin: 2rem 0;
        }

        .empty-state-icon {
            font-size: 5rem;
            color: #e0e0e0;
            margin-bottom: 2rem;
        }

        .empty-state h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Navbar Transition */
        .navbar {
            transition: all 0.3s ease-in-out;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .quiz-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title-main {
                font-size: 2rem;
            }

            .hero-background {
                min-height: 80vh;
                padding-top: 100px;
            }

            .stat-item {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .hero-stat-number {
                font-size: 2.5rem;
            }

            .quiz-thumbnail {
                height: 180px;
            }

            .meta-item {
                padding: 0.25rem;
            }

            .hero-stat-item:not(:last-child)::after {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .quiz-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stats-grid {
                flex-direction: column;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid #f0f0f0;
            }

            .stat-item:last-child {
                border-bottom: none;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-hero {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section - Clean & Modern -->
    <section class="hero-background">
        <div class="hero-overlay"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-content">
                        <h1 class="hero-title">
                            <i class="fas fa-brain hero-title-icon"></i>
                            Uji Pengetahuan Lingkunganmu
                        </h1>

                        <p class="hero-subtitle">
                            Tantang diri Anda dengan kuis interaktif tentang daur ulang, konservasi energi,
                            dan pelestarian lingkungan. Raih poin, tingkatkan peringkat, dan jadilah
                            ahli lingkungan sejati!
                        </p>

                        @auth
                            <div class="hero-stats">
                                <div class="row">
                                    <div class="col-md-4 hero-stat-item">
                                        <div class="hero-stat-number">{{ $userStats['completed_quizzes'] }}</div>
                                        <div class="hero-stat-label">Kuis Diselesaikan</div>
                                    </div>
                                    <div class="col-md-4 hero-stat-item">
                                        <div class="hero-stat-number">{{ $userStats['points_from_quiz'] }}</div>
                                        <div class="hero-stat-label">Total Poin</div>
                                    </div>
                                    <div class="col-md-4 hero-stat-item">
                                        <div class="hero-stat-number">{{ number_format($userStats['average_score'], 1) }}%</div>
                                        <div class="hero-stat-label">Skor Rata-rata</div>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <div class="hero-buttons">
                            @auth
                                @if ($quizzes->count() > 0)
                                    <a href="#quiz-section" class="btn btn-hero-primary btn-hero">
                                        <i class="fas fa-play-circle"></i>
                                        Mulai Kuis Sekarang
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-hero-primary btn-hero">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Masuk untuk Mulai
                                </a>
                                <a href="{{ route('signup') }}" class="btn btn-hero-secondary btn-hero">
                                    <i class="fas fa-user-plus"></i>
                                    Daftar Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quiz Section - IMPROVED -->
    <section id="quiz-section" class="quiz-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <h2 class="section-title-main">
                    <i class="fas fa-graduation-cap me-3"></i>Pilih Quiz Favoritmu
                </h2>
                <p class="section-subtitle">
                    Jelajahi berbagai topik menarik tentang lingkungan. Setiap quiz memberikan
                    wawasan baru dan kesempatan untuk mendapatkan poin!
                </p>
            </div>

            <!-- User Stats Card -->
            @auth
                <div class="stats-card">
                    <div class="stats-header">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistik Prestasimu
                        </h4>
                    </div>
                    <div class="row g-0 stats-grid">
                        <div class="col-md-4 stat-item">
                            <div class="stat-number">{{ $userStats['completed_quizzes'] }}</div>
                            <div class="stat-label">Quiz Diselesaikan</div>
                        </div>
                        <div class="col-md-4 stat-item">
                            <div class="stat-number">{{ $userStats['points_from_quiz'] }}</div>
                            <div class="stat-label">Total Poin</div>
                        </div>
                        <div class="col-md-4 stat-item">
                            <div class="stat-number">{{ number_format($userStats['average_score'], 1) }}%</div>
                            <div class="stat-label">Rata-rata Skor</div>
                        </div>
                    </div>
                </div>
            @endauth

            @if ($quizzes->count() > 0)
                <div class="quiz-grid">
                    @foreach ($quizzes as $quiz)
                        <div class="quiz-card">
                            <div class="quiz-card-inner">
                                <!-- Status Badge -->
                                @if ($quiz->userProgress && $quiz->userProgress->completed_at)
                                    <div class="quiz-badge">
                                        <span class="badge bg-success py-2 px-3 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>Selesai
                                        </span>
                                    </div>
                                @elseif($quiz->userProgress)
                                    <div class="quiz-badge">
                                        <span class="badge bg-warning py-2 px-3 rounded-pill">
                                            <i class="fas fa-play-circle me-1"></i>Dalam Proses
                                        </span>
                                    </div>
                                @endif

                                <!-- Thumbnail -->
                                <div class="quiz-thumbnail">
                                    <img src="{{ $quiz->thumbnail_url }}" alt="{{ $quiz->title }}">
                                    <div class="quiz-thumbnail-overlay"></div>

                                    <!-- Point Reward -->
                                    <div class="point-reward">
                                        <span class="badge bg-warning text-dark py-2 px-3 rounded-pill">
                                            <i class="fas fa-star me-1"></i>{{ $quiz->point_reward }} Poin
                                        </span>
                                    </div>

                                    <!-- Difficulty -->
                                    <div class="difficulty-badge">
                                        <span
                                            class="badge bg-{{ $quiz->difficulty == 'Mudah' ? 'success' : ($quiz->difficulty == 'Sedang' ? 'warning' : 'danger') }} py-2 px-3 rounded-pill">
                                            {{ $quiz->difficulty }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="quiz-content">
                                    <h3 class="quiz-title">{{ $quiz->title }}</h3>
                                    <p class="quiz-description">
                                        {{ Str::limit($quiz->description, 150) }}
                                    </p>

                                    <!-- Progress Bar (for in-progress quizzes) -->
                                    @if ($quiz->userProgress && !$quiz->userProgress->completed_at)
                                        <div class="progress-container">
                                            <div class="progress-label">
                                                <span>Progress Pengerjaan</span>
                                                <span
                                                    class="fw-bold">{{ $quiz->userProgress->correct_answers }}/{{ $quiz->total_questions }}</span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-info"
                                                    style="width: {{ ($quiz->userProgress->correct_answers / $quiz->total_questions) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Quiz Stats -->
                                <div class="quiz-meta">
                                    <div class="meta-item">
                                        <span class="meta-value">{{ $quiz->total_questions }}</span>
                                        <span class="meta-label">Soal</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-value">{{ $quiz->completion_count }}</span>
                                        <span class="meta-label">Peserta</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-value">{{ $quiz->average_score }}%</span>
                                        <span class="meta-label">Skor Rata²</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="quiz-action">
                                    @auth
                                        @if ($quiz->userProgress)
                                            @if ($quiz->userProgress->completed_at)
                                                <a href="{{ route('user.quizzes.my-results', $quiz->id) }}"
                                                    class="btn btn-result btn-quiz-action">
                                                    <i class="fas fa-chart-bar"></i>Lihat Hasil
                                                </a>
                                                <a href="{{ route('user.quizzes.leaderboard', $quiz->id) }}"
                                                    class="btn btn-hero-secondary btn-quiz-action">
                                                    <i class="fas fa-trophy"></i> Lihat Peringkat
                                                </a>
                                            @else
                                                <a href="{{ route('user.quizzes.show', $quiz->id) }}"
                                                    class="btn btn-continue btn-quiz-action">
                                                    <i class="fas fa-play-circle me-2"></i>Lanjutkan Quiz
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('user.quizzes.start', $quiz->id) }}"
                                                class="btn btn-start btn-quiz-action">
                                                <i class="fas fa-play me-2"></i>Mulai Quiz
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-login btn-quiz-action">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Mulai
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3>Belum Ada Quiz Tersedia</h3>
                    <p class="mb-4">Saat ini belum ada quiz yang bisa diikuti. Silakan coba lagi nanti.</p>
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-success px-5 py-2">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary px-5 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Dulu
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter animation for stats
            const statNumbers = document.querySelectorAll('.stat-number, .hero-stat-number');

            statNumbers.forEach(stat => {
                const originalText = stat.textContent;
                const isPercentage = originalText.includes('%');
                let target = parseFloat(originalText.replace('%', ''));

                if (isNaN(target)) return;

                const duration = 1500;
                const step = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        stat.textContent = isPercentage ? target.toFixed(1) + '%' : Math.round(
                            target);
                        clearInterval(timer);
                    } else {
                        stat.textContent = isPercentage ?
                            current.toFixed(1) + '%' :
                            Math.round(current);
                    }
                }, 16);
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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

            // Enhanced card hover effects
            const quizCards = document.querySelectorAll('.quiz-card');

            quizCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) scale(1.02)';
                    card.style.zIndex = '10';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.zIndex = '1';
                });
            });

        });
    </script>
@endpush
