<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login Takmir | SIMAS Masjid Al-Ikhlas</title>
  <meta content="Sistem Informasi Manajemen Masjid Al-Ikhlas" name="description">

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
    .login-card {
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
                <div class="col-lg-5 col-md-7 col-sm-10">

                    <div class="card login-card mb-3">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center pb-3">
                                <div class="rounded-circle bg-success-light text-success d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 64px; height: 64px;">
                                    <i class="fa-solid fa-mosque fs-2"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">Masuk Takmir</h4>
                                <p class="text-muted small mb-0">Sistem Informasi Manajemen Masjid Al-Ikhlas</p>
                            </div>

                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

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

                            <form method="POST" action="{{ route('login') }}" class="row g-3">
                                @csrf
                                <div class="col-12">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                                        <input type="text" name="username" id="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 ps-0" placeholder="Masukkan password" required>
                                        <button class="btn btn-outline-secondary border-start-0 bg-light" type="button" id="togglePassword">
                                            <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success w-100 py-2 fs-6 fw-bold">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4 pt-2 border-top">
                                <p class="small text-muted mb-2">Belum memiliki akun Takmir?</p>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-person-plus me-1"></i> Registrasi Akun Baru
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
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
