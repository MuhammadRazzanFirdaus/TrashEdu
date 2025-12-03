<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon"
        href="https://play-lh.googleusercontent.com/FcRZx_UEXN2uc7uKM5EKGn7Jmb65c8VVELlmligxdfUcjKKIpzFX0SHXFePllD2g4ik"
        type="image/x-icon">
    <title>TrashEdu - Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <style>
        /* Back Button Styles */
        .btn-back {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #1a3c2a;
            border-radius: 25px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px) translateX(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
            color: #1a3c2a;
        }

        .btn-back i {
            transition: transform 0.3s ease;
        }

        .btn-back:hover i {
            transform: translateX(-3px);
        }

        /* Card Styles */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .form-control {
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
            background: #fff;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(34, 197, 94, 0.15);
            border-color: #22c55e;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            color: #16a34a;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(34, 197, 94, 0.3);
        }

        .header-simple {
            position: relative;
            padding: 2rem 0 1rem 0;
            margin-bottom: 1rem;
            text-align: center;
            border-bottom: 2px solid #dcfce7;
        }

        .header-simple h2 {
            color: #15803d;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header-simple p {
            color: #65a30d;
            font-size: 1rem;
        }

        .form-section {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .password-strength {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #ef4444;
            width: 33%;
        }

        .strength-medium {
            background: #f59e0b;
            width: 66%;
        }

        .strength-strong {
            background: #22c55e;
            width: 100%;
        }

        .login-link {
            color: #15803d;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: #16a34a;
            text-decoration: underline;
        }

        .form-text {
            color: #6b7280 !important;
            font-size: 0.875rem;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.875rem;
        }

        .valid-feedback {
            color: #16a34a;
            font-size: 0.875rem;
        }

        /* Simple accent elements */
        .form-accent {
            position: relative;
        }

        .form-accent::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #22c55e;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .form-floating:focus-within .form-accent::before {
            height: 70%;
        }

        /* Simple hover effect for form groups */
        .form-floating {
            transition: all 0.3s ease;
        }

        .form-floating:hover {
            transform: translateX(5px);
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .btn-back {
                top: 15px;
                left: 15px;
                padding: 10px 16px;
                font-size: 0.8rem;
            }

            .container {
                padding-top: 80px !important;
            }
        }

        @media (max-width: 576px) {
            .btn-back {
                top: 10px;
                left: 10px;
                padding: 8px 14px;
            }

            .btn-back span {
                display: none;
            }

            .btn-back i {
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <a href="{{ url()->previous() }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <div class="container py-5" style="min-height: 100vh; background: #ffffff;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <!-- Simple Header -->
                        <div class="header-simple">
                            <h2>Buat Akun Baru</h2>
                            <p class="mb-0">Isi data diri Anda untuk bergabung</p>
                        </div>

                        <!-- Alert Messages -->
                        @if (Session::get('ok'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ Session::get('ok') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="needs-validation" method="POST" action="" novalidate>
                            @csrf
                            <div class="row mb-4 form-section">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-floating form-accent">
                                        <input type="text" id="form3Example1"
                                            class="form-control rounded-3 @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ old('first_name') }}" placeholder="Nama Depan"
                                            required>
                                        <label for="form3Example1" class="form-label">
                                            <i class="fas fa-user me-2 text-success"></i>Nama Depan
                                        </label>
                                        @error('first_name')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-accent">
                                        <input type="text" id="form3Example2"
                                            class="form-control rounded-3 @error('last_name') is-invalid @enderror"
                                            name="last_name" value="{{ old('last_name') }}" placeholder="Nama Belakang"
                                            required>
                                        <label for="form3Example2" class="form-label">
                                            <i class="fas fa-user me-2 text-success"></i>Nama Belakang
                                        </label>
                                        @error('last_name')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4 form-section">
                                <div class="form-floating form-accent">
                                    <input type="email" id="email"
                                        class="form-control rounded-3 @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="name@example.com"
                                        required>
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2 text-success"></i>Alamat Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4 form-section">
                                <div class="form-floating form-accent position-relative">
                                    <input type="password" id="password"
                                        class="form-control rounded-3 @error('password') is-invalid @enderror"
                                        name="password" placeholder="Password" required minlength="8">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2 text-success"></i>Password
                                    </label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor: pointer;" onclick="togglePassword()">
                                        <i class="fas fa-eye text-muted" id="toggleIcon"></i>
                                    </span>
                                    <div class="password-strength mt-2">
                                        <div class="strength-bar" id="passwordStrength"></div>
                                    </div>
                                    <div class="form-text">
                                        Minimal 8 karakter dengan kombinasi huruf dan angka
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <div class="form-floating form-accent position-relative">
                                    <input type="password" id="confirmPassword" name="password_confirmation"
                                        class="form-control rounded-3" placeholder="Konfirmasi Password" required
                                        minlength="8">

                                    <label for="confirmPassword" class="form-label">
                                        <i class="fas fa-lock me-2 text-success"></i>Konfirmasi Password
                                    </label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor: pointer;" onclick="toggleConfirmPassword()">
                                        <i class="fas fa-eye text-muted" id="toggleConfirmIcon"></i>
                                    </span>
                                    <div class="invalid-feedback" id="confirmPasswordFeedback">
                                        Password tidak cocok!
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 py-3 fw-bold">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="mb-0 text-muted">Sudah punya akun?
                                    <a href="{{ route('login') }}" class="login-link">Masuk di sini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
                toggleIcon.classList.remove('text-muted');
                toggleIcon.classList.add('text-success');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
                toggleIcon.classList.remove('text-success');
                toggleIcon.classList.add('text-muted');
            }
        }

        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                toggleConfirmIcon.classList.remove('fa-eye');
                toggleConfirmIcon.classList.add('fa-eye-slash');
                toggleConfirmIcon.classList.remove('text-muted');
                toggleConfirmIcon.classList.add('text-success');
            } else {
                confirmPasswordInput.type = 'password';
                toggleConfirmIcon.classList.remove('fa-eye-slash');
                toggleConfirmIcon.classList.add('fa-eye');
                toggleConfirmIcon.classList.remove('text-success');
                toggleConfirmIcon.classList.add('text-muted');
            }
        }

        // Password strength indicator
        function checkPasswordStrength(password) {
            let strength = 0;
            const strengthBar = document.getElementById('passwordStrength');

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;

            strengthBar.className = 'strength-bar';
            if (strength < 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength < 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        }

        // Password confirmation validation
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');

            // Password strength
            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });

            function validatePasswordMatch() {
                const password = passwordInput.value.trim();
                const confirmPassword = confirmPasswordInput.value.trim();

                if (confirmPassword === '') {
                    confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                    confirmPasswordFeedback.style.display = 'none';
                    return;
                }

                if (password === confirmPassword) {
                    confirmPasswordInput.classList.remove('is-invalid');
                    confirmPasswordInput.classList.add('is-valid');
                    confirmPasswordFeedback.style.display = 'none';
                } else {
                    confirmPasswordInput.classList.add('is-invalid');
                    confirmPasswordInput.classList.remove('is-valid');
                    confirmPasswordFeedback.style.display = 'block';
                }
            }


            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);

            // Form validation
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            // Back button animation on hover
            const backBtn = document.querySelector('.btn-back');
            if (backBtn) {
                backBtn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) translateX(-2px)';
                });

                backBtn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) translateX(0)';
                });
            }
        });

        // Optional: Add smooth scroll behavior for back button
        document.querySelector('.btn-back')?.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');

            // Add smooth transition effect
            document.body.style.opacity = '0.8';
            document.body.style.transition = 'opacity 0.3s ease';

            setTimeout(() => {
                window.location.href = href;
            }, 300);
        });
    </script>
</body>

</html>
