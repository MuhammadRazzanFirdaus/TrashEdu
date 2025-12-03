@extends('templates.admin')

@section('content')
<div class="container-fluid">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="h4 mb-2 text-dark-green fw-bold">
                        <i class="bi bi-trash me-2"></i>User Trash
                    </h2>
                    <p class="text-muted mb-0">Data user yang telah dihapus (soft delete)</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">#</th>
                            <th class="border-0">User</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Role</th>
                            <th class="border-0">Dihapus Pada</th>
                            <th class="border-0 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="align-middle">
                            <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark-green fw-semibold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'staff' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ $user->deleted_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" onclick="return confirm('Pulihkan user ini?')" data-bs-toggle="tooltip" title="Restore User">
                                            <i class="bi bi-arrow-clockwise"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Hapus permanen user ini? Tindakan ini tidak dapat dibatalkan!')" data-bs-toggle="tooltip" title="Hapus Permanen">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-trash display-1 text-muted"></i>
                <h5 class="text-muted mt-3">Trash kosong</h5>
                <p class="text-muted">Tidak ada data user yang dihapus</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.text-dark-green { color: var(--dark-green); }
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 0.9rem;
}
.table > :not(caption) > * > * {
    padding: 1rem 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection
