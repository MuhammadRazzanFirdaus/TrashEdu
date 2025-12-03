@extends('templates.petugas')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Hadiah</h1>

    <div class="mb-3 d-flex justify-content-between flex-wrap">
        <div>
            <a href="{{ route('staff.rewards.create') }}" class="btn btn-primary mb-2">Tambah Hadiah</a>
            <a href="{{ route('staff.rewards.trash') }}" class="btn btn-secondary mb-2">Trash</a>
        </div>
        <div>
            <a href="{{ route('staff.rewards.exportExcel') }}" class="btn btn-success mb-2">Export Excel</a>
            <a href="{{ route('staff.rewards.exportPDF') }}" class="btn btn-danger mb-2">Export PDF</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Point</th>
                <th>Stok</th>
                <th>Status</th>
                <th style="width: 250px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rewards as $reward)
                <tr @if($reward->trashed()) class="table-danger" @endif>
                    <td>
                        @if($reward->image)
                            <img src="{{ asset('storage/'.$reward->image) }}" alt="Reward Image" width="80">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $reward->name }}</td>
                    <td>{{ $reward->points_required }}</td>
                    <td>{{ $reward->stock }}</td>
                    <td>{{ $reward->trashed() ? 'Deleted' : 'Active' }}</td>
                    <td>
                        @if(!$reward->trashed())
                            <a href="{{ route('staff.rewards.edit', $reward->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('staff.rewards.destroy', $reward->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin memindahkan ke trash?')">Soft Delete</button>
                            </form>
                        @else
                            <a href="{{ route('staff.rewards.restore', $reward->id) }}" class="btn btn-info btn-sm" onclick="return confirm('Restore reward ini?')">Restore</a>
                            <form action="{{ route('staff.rewards.forceDelete', $reward->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen reward ini?')">Force Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data reward.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
