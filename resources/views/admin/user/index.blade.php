@extends('templates.admin')

@section('content')
    <div class="container-fluid">
        <!-- Header Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="h4 mb-2 text-dark-green fw-bold">
                            <i class="bi bi-people me-2"></i>User Management
                        </h2>
                        <p class="text-muted mb-0">Kelola semua akun pengguna di sistem TrashEdu</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Export Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.export') }}?type=all">
                                            <i class="bi bi-people me-2"></i> Semua Users (.xlxx)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.export') }}?type=trash">
                                            <i class="bi bi-trash me-2"></i> Users di Trash (.xlxx)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.export.pdf') }}?type=all">
                                            <i class="bi bi-people me-2"></i> Semua Users (.pdf)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.export.pdf') }}?type=trash">
                                            <i class="bi bi-trash me-2"></i> Users di Trash (.pdf)
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="{{ route('admin.users.trash') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-trash me-1"></i> Trash
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Staff
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4">#</th>
                                <th class="border-0">User</th>
                                <th class="border-0">Kontak</th>
                                <th class="border-0">Informasi</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="align-middle">
                                    <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-light-green rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <span
                                                    class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark-green fw-semibold">{{ $user->name }}</h6>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark-green">{{ $user->email }}</div>
                                        <small class="text-muted">{{ $user->alamat ?? 'Alamat belum diisi' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="badge bg-{{ $user->JK == 'Laki-laki' ? 'primary' : 'pink' }} mb-1">
                                                {{ $user->JK ?? 'Belum diisi' }}
                                            </span>
                                            <span class="text-muted small">Point: {{ $user->total_points ?? 0 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'staff' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Edit User">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Hapus user ini?')" data-bs-toggle="tooltip"
                                                    title="Hapus User">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-5">
                                            <i class="bi bi-people display-1 text-muted"></i>
                                            <h5 class="text-muted mt-3">Belum ada data user</h5>
                                            <p class="text-muted">Mulai dengan menambahkan user baru</p>
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                                                <i class="bi bi-plus-circle me-1"></i> Tambah User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-dark-green {
            color: var(--dark-green);
        }

        .bg-light-green {
            background-color: var(--light-green);
        }

        .bg-pink {
            background-color: #e91e63;
            color: white;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
