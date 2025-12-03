@extends('templates.app')

@push('style')
<style>
    .history-container {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05) 0%, rgba(102, 187, 106, 0.05) 100%);
        min-height: 100vh;
        padding: 100px 0 50px;
    }

    .history-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(46, 125, 50, 0.1);
        overflow: hidden;
    }

    .history-header {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .history-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-container {
        padding: 1.5rem;
    }

    .history-table {
        margin-bottom: 0;
    }

    .history-table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        text-align: center;
    }

    .history-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .history-table tbody tr:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
    }

    .history-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        text-align: center;
    }

    /* Quiz title styling */
    .quiz-title-cell {
        text-align: left !important;
        font-weight: 600;
        color: #2c3e50;
    }

    /* Score styling */
    .score-cell {
        font-weight: 700;
        width: 120px;
    }

    .score-badge {
        display: inline-block;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .score-excellent {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
    }

    .score-good {
        background: linear-gradient(135deg, #8BC34A, #689F38);
        color: white;
    }

    .score-average {
        background: linear-gradient(135deg, #FFC107, #FF9800);
        color: #000;
    }

    .score-poor {
        background: linear-gradient(135deg, #FF5722, #D84315);
        color: white;
    }

    /* Date styling */
    .date-cell {
        color: #666;
        width: 180px;
    }

    .date-icon {
        color: #2E7D32;
        margin-right: 5px;
    }

    /* Action button */
    .action-cell {
        width: 120px;
    }

    .btn-detail {
        background: linear-gradient(135deg, #2196F3, #0D47A1);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }

    /* Empty state */
    .empty-history {
        text-align: center;
        padding: 3rem 2rem;
        color: #666;
    }

    .empty-icon {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }

    .btn-start {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-start:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
    }

    /* Pagination styling */
    .pagination-container {
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .pagination .page-link {
        color: #2E7D32;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #2E7D32;
        border-color: #2E7D32;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #f8f9fa;
        color: #1b5e20;
    }

    @media (max-width: 768px) {
        .history-container {
            padding: 80px 0 30px;
        }

        .history-title {
            font-size: 1.3rem;
        }

        .table-container {
            padding: 1rem;
            overflow-x: auto;
        }

        .history-table {
            min-width: 600px;
        }

        .history-table th,
        .history-table td {
            padding: 0.75rem 0.5rem;
        }

        .score-badge {
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
        }

        .btn-detail {
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .history-header {
            padding: 1rem;
        }

        .table-container {
            padding: 0.75rem;
        }

        .pagination-container {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="history-container">
    <div class="container">
        <div class="history-card">
            <!-- Header -->
            <div class="history-header">
                <h1 class="history-title">
                    <i class="fas fa-history"></i>
                    Riwayat Quiz Saya
                </h1>
            </div>

            @if($completedQuizzes->count() > 0)
            <!-- Table -->
            <div class="table-container">
                <table class="table history-table">
                    <thead>
                        <tr>
                            <th>Quiz</th>
                            <th>Skor</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedQuizzes as $progress)
                        <tr>
                            <td class="quiz-title-cell">
                                {{ $progress->quiz->title }}
                            </td>
                            <td class="score-cell">
                                @php
                                    $scoreClass = '';
                                    if ($progress->score >= 90) {
                                        $scoreClass = 'score-excellent';
                                    } elseif ($progress->score >= 75) {
                                        $scoreClass = 'score-good';
                                    } elseif ($progress->score >= 60) {
                                        $scoreClass = 'score-average';
                                    } else {
                                        $scoreClass = 'score-poor';
                                    }
                                @endphp
                                <span class="score-badge {{ $scoreClass }}">
                                    {{ $progress->score }}%
                                </span>
                            </td>
                            <td class="date-cell">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                {{ $progress->completed_at->format('d M Y - H:i') }}
                            </td>
                            <td class="action-cell">
                                <a href="{{ route('user.quizzes.result', $progress->quiz_id) }}"
                                   class="btn btn-detail">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($completedQuizzes->hasPages())
            <div class="pagination-container">
                {{ $completedQuizzes->links() }}
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="empty-history">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h4 class="mb-3">Belum Ada Riwayat Quiz</h4>
                <p class="text-muted mb-4">Mulailah mengerjakan quiz untuk melihat riwayat di sini</p>
                <a href="{{ route('user.quizzes.index') }}" class="btn btn-start">
                    <i class="fas fa-play-circle me-2"></i>Mulai Quiz
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to table rows
        const rows = document.querySelectorAll('.history-table tbody tr');

        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Add animation to score badges
        const scoreBadges = document.querySelectorAll('.score-badge');
        scoreBadges.forEach(badge => {
            badge.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });

            badge.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endpush
