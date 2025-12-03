@extends('templates.petugas')

@section('content')
<div class="container">
    <h1>Trash Rewards</h1>
    <a href="{{ route('staff.rewards.index') }}" class="btn btn-secondary mb-3">Kembali ke Rewards</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Point</th>
                <th>Stok</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rewards as $reward)
            <tr>
                <td>{{ $reward->name }}</td>
                <td>{{ $reward->points_required }}</td>
                <td>{{ $reward->stock }}</td>
                <td>
                    @if($reward->image)
                        <img src="{{ asset('storage/'.$reward->image) }}" width="80">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('staff.rewards.restore', $reward->id) }}" class="btn btn-info btn-sm">Restore</a>
                    <form action="{{ route('staff.rewards.forceDelete', $reward->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Force Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
