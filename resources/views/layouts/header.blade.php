@props(['bodyClass'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Manajemen Masjid Al-Ikhlas</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

 <!-- Favicons -->
  <link href="{{ asset ('assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset ('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <script src="https://kit.fontawesome.com/5ce91ef74a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset ('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset ('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="{{ asset ('assets/css/style.css')}}" rel="stylesheet">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

</head>

<body>

   <!-- ======= Header ======= -->
   <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt=""> 
        <span class="d-none d-lg-block fs-5">Sistem Manajemen <br> Masjid Al Ikhlas</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!--<div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!--<li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>End Search Icon-->

        <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ Auth::check() ? '#' : route('login') }}" data-bs-toggle="dropdown">
                @if(Auth::check())
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nama_takmir }}</span>
                @else
                    <span class="d-none d-md-block dropdown-toggle ps-2">Login</span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <br>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <!-- Logout Option -->
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>

                <!-- Logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->


      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset ('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ asset ('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset ('assets/vendor/chart.js')}}/chart.umd.js')}}"></script>
  <script src="{{ asset ('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ asset ('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ asset ('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ asset ('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ asset ('assets/vendor/php-email-form/validate.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.4/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.4/main.min.js"></script>



  <!-- Template Main JS File -->
  <script src="{{ asset ('assets/js/main.js')}}"></script>

  <main class="container">

    @yield('content')
  </main>


  @yield('script')
</body>

</html>

