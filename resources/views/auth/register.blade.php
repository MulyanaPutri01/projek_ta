<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Daftar Akun Takmir | SIMAS Masjid Al-Ikhlas</title>
  <meta content="Registrasi akun takmir baru" name="description">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <script src="https://kit.fontawesome.com/5ce91ef74a.js" crossorigin="anonymous"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom-ui.css') }}" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0f766e 100%) !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .register-card {
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      background: #ffffff;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    }
  </style>
</head>
<body>
    <main class="w-100 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-11">

                    <div class="card register-card mb-3">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center pb-3">
                                <div class="rounded-circle bg-primary-light text-primary d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 64px; height: 64px;">
                                    <i class="fa-solid fa-user-shield fs-2"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">Registrasi Takmir Baru</h4>
                                <p class="text-muted small mb-0">Lengkapi formulir pendaftaran untuk mengajukan akun takmir</p>
                            </div>

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" class="row g-3">
                                @csrf

                                <div class="col-md-12">
                                    <label for="nama_takmir" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nama_takmir" id="nama_takmir" class="form-control border-start-0 ps-0" placeholder="Nama lengkap takmir" value="{{ old('nama_takmir') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-at"></i></span>
                                        <input type="text" name="username" id="username" class="form-control border-start-0 ps-0" placeholder="Username login" value="{{ old('username') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="role_id" class="form-label">Peran / Role</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-shield-check"></i></span>
                                        <select name="role_id" id="role_id" class="form-select border-start-0 ps-0" required>
                                            <option value="" disabled selected>Pilih Role...</option>
                                            @foreach($roles ?? [] as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ ucfirst($role->nama_role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control border-start-0 ps-0" placeholder="Min. 8 karakter" required minlength="8">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Ulangi password" required minlength="8">
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6 fw-bold">
                                        <i class="bi bi-person-check me-1"></i> Daftar Sekarang
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4 pt-2 border-top">
                                <p class="small text-muted mb-2">Sudah memiliki akun Takmir?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm w-100">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk di Sini
                                </a>
                                <div class="mt-3">
                                    <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center text-white-50 small">
                        &copy; {{ date('Y') }} SIMAS Masjid Al-Ikhlas Karangmulya
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
