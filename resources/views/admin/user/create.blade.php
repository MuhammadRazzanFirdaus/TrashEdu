@extends('templates.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="h4 mb-2 text-dark-green fw-bold">
                        <i class="bi bi-person-plus me-2"></i>Tambah Staff Baru
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                            <li class="breadcrumb-item active">Tambah Staff</li>
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
            <form action="{{ route('admin.users.storeStaff') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-dark-green mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Pribadi</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label text-dark-green fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-dark-green fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="JK" class="form-label text-dark-green fw-semibold">Jenis Kelamin</label>
                            <select class="form-select @error('JK') is-invalid @enderror" id="JK" name="JK">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('JK') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('JK') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('JK')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-dark-green mb-3"><i class="bi bi-shield-lock me-2"></i>Keamanan & Alamat</h5>

                        <div class="mb-3">
                            <label for="password" class="form-label text-dark-green fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-dark-green fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label text-dark-green fw-semibold">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info border-0">
                            <div class="d-flex">
                                <i class="bi bi-info-circle me-2 mt-1"></i>
                                <div>
                                    <strong>Informasi:</strong> Akun yang dibuat melalui form ini akan secara otomatis mendapatkan role <span class="badge bg-success">Staff</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Simpan Staff
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
