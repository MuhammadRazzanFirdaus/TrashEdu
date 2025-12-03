@extends('templates.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="h4 mb-2 text-dark-green fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Edit User
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-dark-green mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Pribadi</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label text-dark-green fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-dark-green fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="JK" class="form-label text-dark-green fw-semibold">Jenis Kelamin</label>
                            <select class="form-select @error('JK') is-invalid @enderror" id="JK" name="JK">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('JK', $user->JK) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('JK', $user->JK) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('JK')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-dark-green mb-3"><i class="bi bi-shield-lock me-2"></i>Keamanan & Role</h5>

                        <div class="mb-3">
                            <label for="password" class="form-label text-dark-green fw-semibold">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                            <div class="form-text">Minimal 8 karakter</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-dark-green fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label text-dark-green fw-semibold">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label text-dark-green fw-semibold">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.text-dark-green { color: var(--dark-green); }
.form-control:focus, .form-select:focus {
    border-color: var(--light-green);
    box-shadow: 0 0 0 0.2rem rgba(102, 187, 106, 0.25);
}
</style>
@endsection
