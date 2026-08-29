<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Sistem Manajemen Masjid Al Ikhlas</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset ('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset ('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset ('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset ('assets/css/style.css') }}" rel="stylesheet">

</head>
<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                
                                <br> </br>
                                <span class="d-none d-lg-block">Sistem Manajemen <br> Masjid Al-Ikhlas</span>
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">

                                        <h5 class="card-title text-center pb-0 fs-4">{{ __('Login') }} ke akun Anda</h5>
                                    </div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation">
                                        @csrf
                                        <div class="col-12">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" id="username" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Login</button>
                                    </form>
                                    <a href="{{ route('register') }}">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset ('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset ('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset ('assets/vendor/chart.js') }}/chart.umd.js') }}"></script>
    <script src="{{ asset ('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset ('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset ('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset ('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset ('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset ('assets/js/main.js') }}"></script>

</body>
</html>
