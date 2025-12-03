@extends('templates.petugas')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Penukaran Reward Pending</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Reward</th>
                <th>Points Digunakan</th>
                <th>Status</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($redemptions as $redemption)
                <tr>
                    <td>{{ $redemption->user->name }}</td>
                    <td>{{ $redemption->user->email }}</td>
                    <td>{{ $redemption->reward->name ?? '-' }}</td>
                    <td>{{ $redemption->points_used }}</td>
                    <td>{{ ucfirst($redemption->status) }}</td>
                    <td>
                        @if($redemption->status == 'pending')
                            <form action="{{ route('staff.redemptions.approve', $redemption->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('staff.redemptions.reject', $redemption->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">Sudah {{ $redemption->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada penukaran reward pending.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
