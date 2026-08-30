@props(['bodyClass'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Manajemen Masjid Al-Ikhlas')</title>
    <meta content="Sistem Informasi Manajemen Masjid Al-Ikhlas" name="description">
    <meta content="masjid, al-ikhlas, simas, manajemen masjid" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <script src="https://kit.fontawesome.com/5ce91ef74a.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    {{--  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">  --}}
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Summernote Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Custom UI Enhancement Layer -->
    <link href="{{ asset('assets/css/custom-ui.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <i class="fa-solid fa-mosque text-success fs-3 me-2"></i>
                <span class="d-none d-lg-block fw-bold fs-6" style="line-height: 1.2;">SIMAS<br><small
                        class="text-muted fw-normal" style="font-size: 0.75rem;">Masjid Al-Ikhlas</small></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn ms-3 fs-4" style="cursor: pointer;"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item me-2 d-none d-sm-inline-block">
                    <a href="{{ route('display.index') }}" class="btn btn-outline-primary btn-sm rounded-pill shadow-sm" target="_blank" title="Buka Mode Layar TV Digital Masjid">
                        <i class="bi bi-tv me-1"></i> Mode TV Display
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm rounded-pill shadow-sm" target="_blank">
                        <i class="bi bi-globe me-1"></i> Lihat Website
                    </a>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                            style="width: 36px; height: 36px; font-size: 0.9rem;">
                            {{ strtoupper(substr(Auth::user()?->nama_takmir ?? 'A', 0, 1)) }}
                        </div>
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2 fw-semibold text-dark">{{ Auth::user()?->nama_takmir ?? 'Takmir' }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header text-start">
                            <h6 class="mb-0 fw-bold text-dark">{{ Auth::user()?->nama_takmir ?? 'Guest' }}</h6>
                            <span
                                class="badge bg-primary mt-1">{{ ucfirst(Auth::user()?->roles?->first()?->name ?? (Auth::user()?->role?->nama_role ?? 'Pengguna')) }}</span>
                            <p class="small text-muted mb-0 mt-1"><i
                                    class="bi bi-person me-1"></i>{{ Auth::user()?->username ?? '-' }}</p>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger fw-semibold"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                <span>Keluar (Logout)</span>
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
