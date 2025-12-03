<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Quiz</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }
        table {
            width: 100%;
            margin-top: 14px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px;
        }
        th {
            background: #e9e9e9;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-bottom: 4px;
        }
        .meta {
            font-size: 11px;
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>

    <h2>Data Quiz</h2>
    <p class="meta">Export pada: {{ $export_date->format('d M Y, H:i') }}</p>
    <p class="meta">Total: {{ $total }} Quiz</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Quiz</th>
                <th>Jumlah Soal</th>
                <th>Reward Poin</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $i => $quiz)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>{{ $quiz->point_reward }}</td>
                    <td>{{ $quiz->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $quiz->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
