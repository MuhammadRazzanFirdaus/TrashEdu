@extends('templates.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Riwayat Penukaran Hadiah</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Hadiah</th>
                <th>Poin Digunakan</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($redemptions as $index => $redemption)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $redemption->reward->name ?? '-' }}</td>
                    <td>{{ $redemption->points_used }}</td>
                    <td>
                        @if($redemption->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($redemption->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $redemption->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada penukaran hadiah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
