@extends('templates.app')

@push('style')
<style>
    .result-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 80px 0 40px;
    }

    .result-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        margin: 0 auto;
        overflow: hidden;
    }

    .result-header {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .result-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .quiz-name {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    .result-body {
        padding: 2rem;
    }

    /* Score Circle */
    .score-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .score-circle {
        width: 140px;
        height: 140px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        background: conic-gradient(
            {{ $progress->score >= 60 ? '#4CAF50' : '#FF5722' }} {{ $progress->score * 3.6 }}deg,
            #f0f0f0 0deg
        );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .score-inner {
        width: 110px;
        height: 110px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .score-percent {
        font-size: 2rem;
        font-weight: 800;
        color: #2E7D32;
    }

    .score-label {
        font-size: 0.9rem;
        color: #666;
    }

    /* Result Message */
    .result-message {
        text-align: center;
        margin-bottom: 2rem;
    }

    .message-box {
        display: inline-block;
        padding: 1.5rem 2rem;
        border-radius: 10px;
        background: {{ $progress->score >= 60 ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)' }};
        border: 2px solid {{ $progress->score >= 60 ? 'rgba(76, 175, 80, 0.3)' : 'rgba(244, 67, 54, 0.3)' }};
        max-width: 400px;
    }

    .message-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .message-text {
        font-size: 1.2rem;
        font-weight: 600;
        color: {{ $progress->score >= 60 ? '#2E7D32' : '#D32F2F' }};
        margin-bottom: 0.5rem;
    }

    /* Points Reward */
    @if($progress->score >= 60)
    .points-reward {
        text-align: center;
        margin-bottom: 2rem;
    }

    .points-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #FFD700, #FFC107);
        color: #000;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
    }
    @endif

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        min-width: 180px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        border: none;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #2196F3, #1976D2);
        color: white;
        border: none;
    }

    .btn-success-custom:hover {
        background: linear-gradient(135deg, #1976D2, #0D47A1);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }

    /* Simple Stats */
    .simple-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        min-width: 120px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2E7D32;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
    }

    @media (max-width: 768px) {
        .result-page {
            padding: 60px 0 30px;
        }

        .result-header {
            padding: 1.5rem;
        }

        .result-title {
            font-size: 1.5rem;
        }

        .result-body {
            padding: 1.5rem;
        }

        .score-circle {
            width: 120px;
            height: 120px;
        }

        .score-inner {
            width: 90px;
            height: 90px;
        }

        .score-percent {
            font-size: 1.8rem;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-custom {
            width: 100%;
            max-width: 300px;
        }

        .simple-stats {
            gap: 1rem;
        }

        .stat-item {
            min-width: 100px;
            padding: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="result-page">
    <div class="result-card">
        <!-- Header -->
        <div class="result-header">
            <h1 class="result-title">Hasil Quiz</h1>
            <div class="quiz-name">{{ $quiz->title }}</div>
        </div>

        <!-- Body -->
        <div class="result-body">
            <!-- Score -->
            <div class="score-container">
                <div class="score-circle">
                    <div class="score-inner">
                        <div class="score-percent">{{ $progress->score }}%</div>
                        <div class="score-label">Skor</div>
                    </div>
                </div>
            </div>

            <!-- Simple Stats -->
            <div class="simple-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $quiz->total_questions }}</div>
                    <div class="stat-label">Total Soal</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $progress->correct_answers }}</div>
                    <div class="stat-label">Jawaban Benar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $progress->time_spent }}</div>
                    <div class="stat-label">Waktu (detik)</div>
                </div>
            </div>

            <!-- Message -->
            <div class="result-message">
                <div class="message-box">
                    @if($progress->score >= 60)
                        <div class="message-icon">🎉</div>
                        <div class="message-text">Selamat! Anda Lulus</div>
                        <div class="text-muted">Skor Anda memenuhi syarat kelulusan</div>
                    @else
                        <div class="message-icon">😢</div>
                        <div class="message-text">Belum Lulus</div>
                    @endif
                </div>
            </div>

            <!-- Points Reward -->
            @if($progress->score >= 60)
            <div class="points-reward">
                <div class="points-badge">
                    <i class="fas fa-star"></i>
                    +{{ $quiz->point_reward }} Poin
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('user.quizzes.index') }}" class="btn btn-primary-custom btn-custom">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Quiz
                </a>
                <a href="{{ route('user.quizzes.leaderboard', $quiz->id) }}" class="btn btn-success-custom btn-custom">
                    <i class="fas fa-trophy"></i>
                    Lihat Leaderboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
