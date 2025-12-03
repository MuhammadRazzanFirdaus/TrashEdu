<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Users</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #222;
        }
        th {
            background: #eaeaea;
            font-weight: bold;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
    </style>

</head>
<body>

    <h2 class="title">Laporan Data Users</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->JK ?? '-' }}</td>
                <td>{{ $user->alamat ?? '-' }}</td>
                <td>{{ $user->created_at?->format('d M Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
