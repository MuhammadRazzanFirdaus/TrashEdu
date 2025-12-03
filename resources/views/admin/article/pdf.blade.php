<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Artikel</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #777;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #f1f1f1;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
        .meta {
            font-size: 11px;
            margin-top: 4px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Laporan Data Artikel</h2>
    <p class="meta">Tanggal Export: {{ $export_date->format('d M Y - H:i') }}</p>
    <p class="meta">Total Data: {{ $total }} artikel</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Artikel</th>
                <th>Diupdate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $index => $article)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->updated_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
