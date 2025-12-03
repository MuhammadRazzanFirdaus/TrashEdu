@extends('templates.app')

@push('style')
<style>
    .leaderboard-container {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05) 0%, rgba(102, 187, 106, 0.05) 100%);
        min-height: 100vh;
        padding: 100px 0 50px;
    }

    .leaderboard-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(46, 125, 50, 0.1);
        overflow: hidden;
    }

    .leaderboard-header {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .leaderboard-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .leaderboard-title i {
        font-size: 1.3rem;
    }

    .table-container {
        padding: 1.5rem;
    }

    .leaderboard-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .leaderboard-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }

    .leaderboard-table th {
        padding: 1rem 0.75rem;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-align: center;
    }

    .leaderboard-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .leaderboard-table tbody tr:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .leaderboard-table tbody tr:last-child {
        border-bottom: none;
    }

    .leaderboard-table td {
        padding: 1.25rem 0.75rem;
        text-align: center;
        vertical-align: middle;
    }

    /* Rank styling */
    .rank-cell {
        font-weight: 700;
        font-size: 1.1rem;
        width: 100px;
    }

    .rank-1 {
        color: #FFD700;
        background: linear-gradient(45deg, rgba(255, 215, 0, 0.1), transparent);
        border-radius: 5px;
    }

    .rank-2 {
        color: #C0C0C0;
        background: linear-gradient(45deg, rgba(192, 192, 192, 0.1), transparent);
        border-radius: 5px;
    }

    .rank-3 {
        color: #CD7F32;
        background: linear-gradient(45deg, rgba(205, 127, 50, 0.1), transparent);
        border-radius: 5px;
    }

    .rank-other {
        color: #2E7D32;
    }

    /* User name styling */
    .user-cell {
        text-align: left;
        padding-left: 1.5rem !important;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.2rem;
    }

    .user-email {
        font-size: 0.85rem;
        color: #666;
    }

    /* Score styling */
    .score-cell {
        font-weight: 700;
        color: #2E7D32;
        font-size: 1.1rem;
        width: 120px;
    }

    /* Top 3 badges */
    .top-rank-badge {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        margin-right: 8px;
        font-weight: bold;
    }

    .badge-1 {
        background: #FFD700;
        color: #000;
    }

    .badge-2 {
        background: #C0C0C0;
        color: #000;
    }

    .badge-3 {
        background: #CD7F32;
        color: white;
    }

    /* Back button */
    .btn-back {
        background: white;
        color: #2E7D32;
        border: 2px solid #2E7D32;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 2rem;
    }

    .btn-back:hover {
        background: #2E7D32;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.2);
    }

    @media (max-width: 768px) {
        .leaderboard-container {
            padding: 80px 0 30px;
        }

        .leaderboard-title {
            font-size: 1.3rem;
        }

        .leaderboard-table {
            display: block;
            overflow-x: auto;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 1rem 0.5rem;
            font-size: 0.9rem;
        }

        .user-cell {
            min-width: 200px;
        }
    }

    @media (max-width: 576px) {
        .leaderboard-header {
            padding: 1rem;
        }

        .table-container {
            padding: 1rem;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 0.75rem 0.25rem;
            font-size: 0.85rem;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="leaderboard-container">
    <div class="container">
        <div class="leaderboard-card">
            <!-- Header -->
            <div class="leaderboard-header">
                <h1 class="leaderboard-title">
                    <i class="fas fa-trophy"></i>
                    Leaderboard - {{ $quiz->title }}
                </h1>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th class="rank-cell">Peringkat</th>
                            <th class="user-cell">Nama</th>
                            <th class="score-cell">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaderboard as $i => $progress)
                        <tr>
                            <td class="rank-cell
                                {{ $i == 0 ? 'rank-1' : '' }}
                                {{ $i == 1 ? 'rank-2' : '' }}
                                {{ $i == 2 ? 'rank-3' : '' }}
                                {{ $i > 2 ? 'rank-other' : '' }}">
                                <strong>
                                    @if($i < 3)
                                        <span class="top-rank-badge badge-{{ $i + 1 }}">
                                            {{ $i + 1 }}
                                        </span>
                                    @endif
                                    {{ $i + 1 }}
                                </strong>
                            </td>
                            <td class="user-cell">
                                <div class="user-name">{{ $progress->user->name }}</div>
                                <div class="user-email">{{ $progress->user->email }}</div>
                            </td>
                            <td class="score-cell">{{ $progress->score }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('user.quizzes.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Quiz
            </a>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Simple hover effect
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.leaderboard-table tbody tr');

        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endpush
