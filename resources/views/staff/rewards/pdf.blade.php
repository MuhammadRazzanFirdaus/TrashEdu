<h1>Daftar Hadiah</h1>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Point Required</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rewards as $reward)
        <tr>
            <td>{{ $reward->id }}</td>
            <td>{{ $reward->name }}</td>
            <td>{{ $reward->description }}</td>
            <td>{{ $reward->points_required }}</td>
            <td>{{ $reward->stock }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
