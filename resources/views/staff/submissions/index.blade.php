@extends('templates.petugas')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📦 Data Pengajuan Sampah Pengguna</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Jenis Sampah</th>
                        <th>Berat (Kg)</th>
                        <th>Status</th>
                        <th>Tanggal Submit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $index => $item)
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->user->name ?? 'Unknown' }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $item->weight }}</td>
                            <td>
                                @if ($item->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($item->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <td>{{ $item->created_at->format('d M Y, H:i') }}</td>

                            <td>
                                @if ($item->status == 'pending')
                                    <form action="{{ route('staff.submissions.updateStatus', $item->id) }}" method="POST"
                                        class="d-flex gap-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-success btn-sm" type="submit">✔ Setujui</button>
                                    </form>

                                    <form action="{{ route('staff.submissions.updateStatus', $item->id) }}" method="POST"
                                        class="mt-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-danger btn-sm" type="submit">✘ Tolak</button>
                                    </form>
                                @else
                                    <small>Tidak ada aksi</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data pengajuan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
