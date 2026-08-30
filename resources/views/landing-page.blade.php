<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }} - Sistem Informasi Manajemen Masjid</title>
  <meta name="description" content="Sistem Informasi Manajemen Masjid Al-Ikhlas Desa Karangmulya Tegal. Transparansi keuangan, jadwal dakwah, dan inventaris.">
  <meta name="keywords" content="masjid, al-ikhlas, karangmulya, tegal, simas, jadwal sholat">

  <!-- Favicons -->
  <link href="{{ asset('assets-landing/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets-landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets-landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets-landing/css/main.css') }}" rel="stylesheet">

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .arabic-font {
      font-family: 'Amiri', serif;
    }
    .jadwal-sholat-bar {
      background: linear-gradient(135deg, #0f766e, #065f46);
      color: #ffffff;
      padding: 10px 0;
      box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.1);
    }
    .sholat-pill {
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      padding: 6px 12px;
      text-align: center;
      transition: all 0.3s ease;
      position: relative;
    }
    .sholat-pill:hover {
      background: rgba(255, 255, 255, 0.22);
      transform: translateY(-2px);
    }
    .sholat-pill.active {
      background: rgba(245, 158, 11, 0.28) !important;
      border-color: #fbbf24 !important;
      box-shadow: 0 0 14px rgba(251, 191, 36, 0.45);
      transform: translateY(-2px);
    }
    .sholat-pill.active .name {
      color: #fef08a !important;
      font-weight: 700;
    }
    .sholat-pill.active .time {
      color: #ffffff !important;
      text-shadow: 0 0 8px rgba(251, 191, 36, 0.6);
    }
    .sholat-pill.active::after {
      content: '●';
      position: absolute;
      top: 2px;
      right: 6px;
      font-size: 0.6rem;
      color: #fbbf24;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
      0% { opacity: 0.4; }
      50% { opacity: 1; }
      100% { opacity: 0.4; }
    }
    .sholat-pill .name {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      opacity: 0.9;
    }
    .sholat-pill .time {
      font-size: 1.05rem;
      font-weight: 700;
    }
    .service-item {
      border-radius: 14px !important;
      border: 1px solid #e2e8f0 !important;
      transition: all 0.3s ease;
    }
    .service-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px -4px rgba(15, 23, 42, 0.1) !important;
      border-color: #10b981 !important;
    }
    .gallery-item {
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .gallery-item:hover img {
      transform: scale(1.05);
    }
    .gallery-item img {
      transition: transform 0.4s ease;
    }

    /* Modern Hero Section */
    .hero {
      position: relative;
      background: linear-gradient(135deg, rgba(15, 23, 42, 0.90), rgba(6, 78, 59, 0.86)), url('{{ $profil && $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/hero-bg.jpg') }}') center/cover no-repeat;
      color: #ffffff;
      padding: 85px 0 75px 0;
      min-height: auto;
    }
    .hero .bismillah-badge {
      background: rgba(16, 185, 129, 0.18);
      border: 1px solid rgba(52, 211, 153, 0.45);
      color: #6ee7b7;
      font-size: 1.15rem;
      padding: 8px 24px;
      border-radius: 50px;
      display: inline-block;
      letter-spacing: 1px;
      backdrop-filter: blur(8px);
    }
    .hero h1.hero-title {
      font-size: 2.6rem;
      font-weight: 800;
      color: #ffffff;
      line-height: 1.25;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
    }
    .hero p.hero-subtitle {
      font-size: 1.1rem;
      color: #cbd5e1;
      max-width: 620px;
      line-height: 1.6;
    }
    .hero-stat-card {
      background: rgba(255, 255, 255, 0.10);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 16px;
      padding: 18px 20px;
      color: #ffffff;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hero-stat-card:hover {
      background: rgba(255, 255, 255, 0.18);
      border-color: rgba(255, 255, 255, 0.35);
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }
    .hero-stat-card .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      flex-shrink: 0;
    }
    .hero-stat-card .stat-label {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #94a3b8;
      font-weight: 600;
      margin-bottom: 2px;
    }
    .hero-stat-card .stat-value {
      font-size: 1.35rem;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 0;
      line-height: 1.2;
    }
    .hero-stat-card .stat-subtext {
      font-size: 0.75rem;
      color: #cbd5e1;
    }

    /* ===== ENHANCED AGENDA MASJID SECTION STYLES ===== */
    .agenda-section {
      background: #f8fafc;
      position: relative;
    }
    .featured-agenda-card {
      background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #0f766e 100%);
      border-radius: 24px;
      color: #ffffff;
      padding: 32px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 40px -10px rgba(6, 78, 59, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
    .featured-agenda-card::before {
      content: '';
      position: absolute;
      top: -40%;
      right: -20%;
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, rgba(52, 211, 153, 0.25), transparent 70%);
      pointer-events: none;
    }
    .agenda-date-badge-large {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      border-radius: 20px;
      padding: 20px;
      text-align: center;
      min-width: 110px;
      color: #ffffff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .agenda-date-badge-large .day-num {
      font-size: 2.5rem;
      font-weight: 800;
      line-height: 1;
      color: #34d399;
    }
    .agenda-date-badge-large .month-year {
      font-size: 0.82rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 4px;
    }
    .agenda-date-badge-large .day-name {
      font-size: 0.75rem;
      color: #cbd5e1;
    }
    .agenda-item-card {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #e2e8f0;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 100%;
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      position: relative;
    }
    .agenda-item-card:hover {
      transform: translateY(-7px);
      box-shadow: 0 20px 30px -8px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
      border-color: #10b981;
    }
    .agenda-card-thumb {
      position: relative;
      height: 170px;
      overflow: hidden;
      background: linear-gradient(135deg, #0f766e, #065f46);
    }
    .agenda-card-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .agenda-item-card:hover .agenda-card-thumb img {
      transform: scale(1.08);
    }
    .agenda-thumb-pattern {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.9);
      position: relative;
    }
    .agenda-thumb-pattern::after {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent 70%);
    }
    .agenda-card-date-floating {
      position: absolute;
      top: 14px;
      left: 14px;
      background: #ffffff;
      border-radius: 14px;
      padding: 8px 14px;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0,0,0,0.18);
      z-index: 2;
    }
    .agenda-card-date-floating .day {
      font-size: 1.35rem;
      font-weight: 800;
      color: #065f46;
      line-height: 1;
    }
    .agenda-card-date-floating .month {
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      color: #64748b;
      line-height: 1;
      margin-top: 3px;
    }
    .agenda-category-pill {
      position: absolute;
      top: 14px;
      right: 14px;
      padding: 5px 12px;
      font-size: 0.72rem;
      font-weight: 700;
      border-radius: 50px;
      background: rgba(15, 23, 42, 0.75);
      backdrop-filter: blur(6px);
      color: #ffffff;
      border: 1px solid rgba(255, 255, 255, 0.25);
      z-index: 2;
      letter-spacing: 0.3px;
    }
    .agenda-card-body {
      padding: 22px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    .agenda-title {
      font-size: 1.12rem;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.35;
      margin-bottom: 14px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 2.8rem;
    }
    .agenda-item-card:hover .agenda-title {
      color: #065f46;
    }
    .agenda-info-row {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.85rem;
      color: #475569;
      margin-bottom: 8px;
    }
    .agenda-filter-btn {
      border: 1px solid #cbd5e1;
      background: #ffffff;
      color: #475569;
      font-size: 0.88rem;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 50px;
      transition: all 0.25s ease;
      cursor: pointer;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .agenda-filter-btn:hover,
    .agenda-filter-btn.active {
      background: #065f46 !important;
      color: #ffffff !important;
      border-color: #065f46 !important;
      box-shadow: 0 6px 16px rgba(6, 95, 70, 0.3) !important;
    }
    .agenda-pulse-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 700;
      background: rgba(239, 68, 68, 0.2);
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #fecaca;
    }
    .agenda-pulse-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #ef4444;
      box-shadow: 0 0 8px #ef4444;
      animation: pulse 1.5s infinite;
    }

    /* ===== ENHANCED KEUANGAN TRANSPARANSI SECTION STYLES ===== */
    .finance-overview-card {
      background: #ffffff;
      border-radius: 22px;
      padding: 26px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      height: 100%;
    }
    .finance-overview-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
      border-color: #cbd5e1;
    }
    .finance-overview-card.saldo-card {
      background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #0f766e 100%);
      color: #ffffff;
      border: 1px solid rgba(255, 255, 255, 0.18);
      box-shadow: 0 12px 30px rgba(6, 78, 59, 0.35);
    }
    .finance-overview-card.saldo-card:hover {
      box-shadow: 0 20px 40px rgba(6, 78, 59, 0.45);
      border-color: rgba(255, 255, 255, 0.35);
    }
    .saldo-badge-glass {
      background: rgba(255, 255, 255, 0.15) !important;
      color: #ffffff !important;
      border: 1px solid rgba(255, 255, 255, 0.28) !important;
      backdrop-filter: blur(8px);
      font-size: 0.72rem;
      letter-spacing: 0.5px;
    }
    .saldo-icon-glass {
      background: rgba(255, 255, 255, 0.15) !important;
      color: #ffffff !important;
      border: 1px solid rgba(255, 255, 255, 0.22) !important;
    }
    .finance-stat-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.55rem;
      flex-shrink: 0;
    }
    .donation-cta-card {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 60%, #bbf7d0 100%);
      border: 1.5px dashed #16a34a;
      border-radius: 22px;
      padding: 28px;
      position: relative;
      overflow: hidden;
    }
    .account-badge-pill {
      background: #ffffff;
      border-radius: 14px;
      padding: 12px 18px;
      border: 1px solid #bbf7d0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      display: inline-flex;
      align-items: center;
      gap: 12px;
    }
    .account-copy-btn {
      transition: all 0.2s ease;
      cursor: pointer;
    }
    .account-copy-btn:hover {
      transform: scale(1.05);
    }
    .table-modern-finance th {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      font-weight: 700;
      color: #475569;
      background-color: #f8fafc;
      padding: 14px 18px;
      border-top: none;
    }
    .table-modern-finance td {
      padding: 15px 18px;
      vertical-align: middle;
      font-size: 0.9rem;
      color: #1e293b;
    }
    .table-modern-finance tr:hover td {
      background-color: #f8fafc;
    }
    /* Modern Gallery Section Styles */
    .gallery-filter-btn {
      border: 1px solid #e2e8f0;
      background: #ffffff;
      color: #475569;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 8px 20px;
      border-radius: 50px;
      transition: all 0.25s ease;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .gallery-filter-btn:hover {
      background: #f1f5f9;
      color: #0f172a;
      border-color: #cbd5e1;
    }
    .gallery-filter-btn.active {
      background: #10b981;
      color: #ffffff;
      border-color: #10b981;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
    }
    .gallery-card-modern {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #eef2f6;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    .gallery-card-modern:hover {
      transform: translateY(-7px);
      box-shadow: 0 20px 35px rgba(0, 0, 0, 0.12);
      border-color: #cbd5e1;
    }
    .gallery-img-wrapper {
      position: relative;
      overflow: hidden;
      height: 230px;
      background: #0f172a;
    }
    .gallery-img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .gallery-card-modern:hover .gallery-img-wrapper img {
      transform: scale(1.08);
    }
    .gallery-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.3) 50%, rgba(15, 23, 42, 0.05) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .gallery-card-modern:hover .gallery-overlay {
      opacity: 1;
    }
    .gallery-zoom-btn {
      background: rgba(255, 255, 255, 0.95);
      color: #0f172a;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.25s ease;
      transform: scale(0.85);
    }
    .gallery-card-modern:hover .gallery-zoom-btn {
      transform: scale(1);
    }
    .gallery-zoom-btn:hover {
      background: #10b981;
      color: #ffffff;
    }
    .gallery-date-leaf {
      position: absolute;
      top: 12px;
      left: 12px;
      background: rgba(15, 23, 42, 0.75);
      backdrop-filter: blur(8px);
      color: #ffffff;
      font-size: 0.72rem;
      font-weight: 600;
      padding: 4px 11px;
      border-radius: 50px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      z-index: 2;
    }
    .gallery-category-pill {
      position: absolute;
      top: 12px;
      right: 12px;
      backdrop-filter: blur(8px);
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.4px;
      padding: 4px 11px;
      border-radius: 50px;
      z-index: 2;
      text-transform: uppercase;
    }
    .gallery-card-body {
      padding: 16px 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      flex-grow: 1;
    }
    .gallery-card-title {
      font-size: 0.98rem;
      font-weight: 700;
      color: #1e293b;
      line-height: 1.4;
      margin-bottom: 8px;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-geo-alt"><span class="ms-1">{{ $profil->alamat ?? 'Desa Karangmulya, Kec. Suradadi, Tegal, Jawa Tengah' }}</span></i>
          <i class="bi bi-telephone d-flex align-items-center ms-4"><span>{{ $profil->telepon ?? '0812-3456-7890' }}</span></i>
        </div>
        <div class="contact-info d-md-flex align-items-center">
          <i class="bi bi-calendar d-flex align-items-center ms-4">
            <span>{{ $tanggal }}</span>
            <span id="hijri-date-topbar" class="badge bg-success bg-opacity-75 ms-2 px-2 py-1 text-white fw-normal" style="font-size: 0.75rem;"></span>
          </i>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center me-auto text-decoration-none">
          <i class="fa-solid fa-mosque text-success fs-2 me-2"></i>
          <div>
            <h1 class="sitename fs-4 mb-0 fw-bold">{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</h1>
            <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: -3px;">Dukuh Semendot, Karangmulya</small>
          </div>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#beranda" class="active">Beranda</a></li>
            <li><a href="#about">Profil Masjid</a></li>
            <li><a href="#kegiatan">Kegiatan</a></li>
            <li><a href="#keuangan">Laporan Kas</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#pengurus">Takmir</a></li>
            <li><a href="{{ route('kegiatan.calendar') }}">Kalender</a></li>
            <li><a href="#kontak">Kontak</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @auth
          <a class="cta-btn d-none d-sm-block bg-primary text-white border-0" href="{{ route('dashboard') }}"><i class="bi bi-grid me-1"></i> Dashboard</a>
        @else
          <a class="cta-btn d-none d-sm-block" href="{{ route('login') }}"><i class="bi bi-lock me-1"></i> Masuk Takmir</a>
        @endauth
      </div>
    </div>

    <!-- Jadwal Sholat Bar -->
    <div class="jadwal-sholat-bar">
      <div class="container">
        <div class="row align-items-center g-2 text-center text-md-start">
          <div class="col-lg-4 col-md-5 col-12 mb-2 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
              <i class="fa-solid fa-kaaba fs-3 text-warning"></i>
              <div>
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center justify-content-md-start">
                  <span class="fw-bold small text-white">JADWAL SHOLAT</span>
                  <span id="realtime-clock" class="badge bg-black bg-opacity-40 text-warning font-monospace px-2 py-0.5" style="font-size: 0.72rem;"><i class="bi bi-clock me-1"></i>--:--:-- WIB</span>
                </div>
                <div class="d-flex align-items-center gap-1 mt-1 justify-content-center justify-content-md-start">
                  <span id="next-prayer-badge" class="badge bg-warning text-dark fw-bold px-2 py-1 shadow-sm" style="font-size: 0.72rem;">
                    <i class="bi bi-hourglass-split me-1"></i><span id="next-prayer-text">Memuat jadwal...</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-7 col-12">
            <div class="d-flex justify-content-between justify-content-md-end gap-1 gap-sm-2 flex-wrap">
              <div class="sholat-pill flex-fill" id="pill-imsak">
                <div class="name">Imsak</div>
                <div class="time" id="time-imsak">04:17</div>
              </div>
              <div class="sholat-pill flex-fill" id="pill-subuh">
                <div class="name">Subuh</div>
                <div class="time" id="time-subuh">04:27</div>
              </div>
              <div class="sholat-pill flex-fill d-none d-sm-block" id="pill-terbit">
                <div class="name">Terbit</div>
                <div class="time" id="time-terbit">05:45</div>
              </div>
              <div class="sholat-pill flex-fill" id="pill-dzuhur">
                <div class="name">Dzuhur</div>
                <div class="time" id="time-dzuhur">11:44</div>
              </div>
              <div class="sholat-pill flex-fill" id="pill-ashar">
                <div class="name">Ashar</div>
                <div class="time" id="time-ashar">15:03</div>
              </div>
              <div class="sholat-pill flex-fill" id="pill-maghrib">
                <div class="name">Maghrib</div>
                <div class="time" id="time-maghrib">17:43</div>
              </div>
              <div class="sholat-pill flex-fill" id="pill-isya">
                <div class="name">Isya</div>
                <div class="time" id="time-isya">18:53</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="beranda" class="hero section">
      <div class="container position-relative">
        <div class="row align-items-center gy-5">
          <!-- Left Column: Welcome & Info -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="bismillah-badge arabic-font mb-3 shadow-sm">
              بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
            </div>
            <h1 class="hero-title mb-3">
              Selamat Datang di <br>
              <span class="text-warning">{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</span>
            </h1>
            <p class="hero-subtitle mb-4">
              Pusat Ibadah, Pembinaan Umat, dan Pengelolaan Kas Masjid yang Amanah, Transparan, & Akuntabel untuk Masyarakat Desa Karangmulya.
            </p>
            <div class="d-flex gap-3 flex-wrap align-items-center">
              <a href="#keuangan" class="btn btn-success btn-lg px-4 py-2.5 rounded-pill shadow-lg fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-wallet2 fs-5"></i> Laporan Kas Publik
              </a>
              <a href="#kegiatan" class="btn btn-outline-light btn-lg px-4 py-2.5 rounded-pill shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-calendar3 fs-5"></i> Agenda Kegiatan
              </a>
            </div>
          </div>

          <!-- Right Column: 4 Dynamic Live Stats Cards from Database -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="row g-3">
              <!-- Saldo Kas -->
              <div class="col-sm-6">
                <div class="hero-stat-card h-100">
                  <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon bg-success bg-opacity-25 text-success border border-success border-opacity-50">
                      <i class="bi bi-wallet2 text-warning"></i>
                    </div>
                    <div>
                      <div class="stat-label">Saldo Kas Terbuka</div>
                      <h4 class="stat-value text-warning">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h4>
                    </div>
                  </div>
                  <div class="stat-subtext d-flex justify-content-between pt-2 border-top border-white border-opacity-10">
                    <span class="text-success fw-semibold"><i class="bi bi-arrow-down-left"></i> Masuk: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>

              <!-- Agenda Kegiatan -->
              <div class="col-sm-6">
                <div class="hero-stat-card h-100">
                  <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon bg-primary bg-opacity-25 text-info border border-info border-opacity-50">
                      <i class="bi bi-calendar-check text-info"></i>
                    </div>
                    <div>
                      <div class="stat-label">Agenda Dakwah</div>
                      <h4 class="stat-value">{{ $totalKegiatan }} <small class="fs-6 fw-normal text-white-50">Kegiatan</small></h4>
                    </div>
                  </div>
                  <div class="stat-subtext pt-2 border-top border-white border-opacity-10">
                    <span><i class="bi bi-clock-history me-1 text-info"></i>Kajian & Sholat Berjamaah</span>
                  </div>
                </div>
              </div>

              <!-- Pengurus Takmir -->
              <div class="col-sm-6">
                <div class="hero-stat-card h-100">
                  <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50">
                      <i class="bi bi-people-fill text-warning"></i>
                    </div>
                    <div>
                      <div class="stat-label">Pengurus Takmir</div>
                      <h4 class="stat-value">{{ $totalTakmir }} <small class="fs-6 fw-normal text-white-50">Takmir</small></h4>
                    </div>
                  </div>
                  <div class="stat-subtext pt-2 border-top border-white border-opacity-10">
                    <span><i class="bi bi-check-circle me-1 text-success"></i>Pengurus Aktif Berkhidmat</span>
                  </div>
                </div>
              </div>

              <!-- Sarana & Inventaris -->
              <div class="col-sm-6">
                <div class="hero-stat-card h-100">
                  <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon bg-teal bg-opacity-25 text-white border border-white border-opacity-25" style="background: rgba(13, 148, 136, 0.3);">
                      <i class="bi bi-box-seam text-white"></i>
                    </div>
                    <div>
                      <div class="stat-label">Sarana & Inventaris</div>
                      <h4 class="stat-value">{{ $totalInventaris }} <small class="fs-6 fw-normal text-white-50">Barang</small></h4>
                    </div>
                  </div>
                  <div class="stat-subtext pt-2 border-top border-white border-opacity-10">
                    <span><i class="bi bi-shield-check me-1 text-info"></i>Fasilitas Masjid Terdata</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About / Profil Masjid Section -->
    <section id="about" class="about section py-5">
      <div class="container">
        <div class="row gy-4 gx-5 align-items-center">
          <div class="col-lg-6 position-relative" data-aos="fade-up" data-aos-delay="200">
            <div class="position-relative overflow-hidden rounded-4 shadow-lg border">
              <img src="{{ $profil && $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/about.jpg') }}" class="img-fluid w-100 rounded-4 shadow" style="min-height: 380px; max-height: 480px; object-fit: cover;" alt="{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}">
              <div class="position-absolute bottom-0 start-0 m-3 px-3 py-1.5 rounded-pill bg-dark bg-opacity-75 text-white small d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-geo-alt text-warning"></i> {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}
              </div>
            </div>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">PROFIL MASJID</span>
            <h3 class="fw-bold fs-2 text-dark">{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</h3>
            <div class="text-muted leading-relaxed mb-3">
              {!! $profil->sejarah ?? 'Masjid Al-Ikhlas didirikan sebagai sarana ibadah umat Islam di Desa Karangmulya untuk mempererat ukhuwah islamiyah dan meningkatkan ketaqwaan masyarakat kepada Allah SWT.' !!}
            </div>
            <ul class="list-unstyled mt-4">
              <li class="d-flex mb-3">
                <div class="rounded-circle bg-success-light text-success p-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                  <i class="fa-solid fa-mosque fs-4"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-1">Visi</h5>
                  <div class="text-muted mb-0 small">{!! $profil->visi ?? 'Terwujudnya masjid yang makmur, mandiri, dan menjadi pusat pembinaan peradaban umat yang berakhlakul karimah.' !!}</div>
                </div>
              </li>
              <li class="d-flex mb-3">
                <div class="rounded-circle bg-primary-light text-primary p-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                  <i class="fa-solid fa-hands-praying fs-4"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-1">Misi</h5>
                  <div class="text-muted mb-0 small">{!! $profil->misi ?? 'Menyelenggarakan kegiatan peribadatan yang khusyuk, pengajian rutin, pengelolaan kas yang transparan, dan pelayanan sosial keumatan.' !!}</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

    <!-- Kegiatan Section -->
    <section id="kegiatan" class="agenda-section section py-5">
      <div class="container section-title text-center mb-4" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">
          <i class="fa-solid fa-mosque me-1"></i> AGENDA MASJID
        </span>
        <h2 class="fw-bold fs-2 text-dark">Jadwal & Agenda Kegiatan Umat</h2>
        <p class="text-muted mx-auto" style="max-width: 650px;">
          Ikuti berbagai agenda ibadah, kajian keislaman rutin, peringatan hari besar Islam, dan kegiatan kemasyarakatan di {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}.
        </p>
      </div>

      <div class="container">
        @if($featuredKegiatan)
          @php
            $isToday = \Carbon\Carbon::parse($featuredKegiatan->tanggal)->isToday();
            $isTomorrow = \Carbon\Carbon::parse($featuredKegiatan->tanggal)->isTomorrow();
            $diffDays = (int) \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($featuredKegiatan->tanggal), false);
            $startDateTime = \Carbon\Carbon::parse($featuredKegiatan->tanggal . ' ' . $featuredKegiatan->mulai_kegiatan)->format('Ymd\THis');
            $endDateTime = \Carbon\Carbon::parse($featuredKegiatan->tanggal . ' ' . ($featuredKegiatan->akhir_kegiatan ?: $featuredKegiatan->mulai_kegiatan))->format('Ymd\THis');
            $calTitle = urlencode($featuredKegiatan->nama_kegiatan . ' - ' . ($profil->nama_masjid ?? 'Masjid Al-Ikhlas'));
            $calDetails = urlencode('Penceramah/Khotib: ' . ($featuredKegiatan->pembicara ?: ($featuredKegiatan->nama_khotib ?: '-')) . "\nTempat: " . $featuredKegiatan->tempat . "\nAudience: " . ($featuredKegiatan->audience ?: 'Umum'));
            $calLocation = urlencode($featuredKegiatan->tempat . ', ' . ($profil->alamat ?? 'Masjid Al-Ikhlas Karangmulya'));
            $gCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$startDateTime}/{$endDateTime}&details={$calDetails}&location={$calLocation}";
          @endphp
          <!-- Featured Highlight Card (Agenda Terdekat) -->
          <div class="featured-agenda-card mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center g-4">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                  <span class="agenda-pulse-badge">
                    <span class="agenda-pulse-dot"></span>
                    AGENDA TERDEKAT
                  </span>
                  @if($isToday)
                    <span class="badge bg-danger rounded-pill px-3 py-1">HARI INI</span>
                  @elseif($isTomorrow)
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold">BESOK</span>
                  @elseif($diffDays > 1)
                    <span class="badge rounded-pill px-3 py-1 text-white" style="background: rgba(16, 185, 129, 0.35); border: 1px solid #34d399;">{{ $diffDays }} Hari Lagi</span>
                  @endif
                  <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 rounded-pill px-3 py-1">
                    <i class="bi bi-clock me-1 text-warning"></i> Sesi {{ $featuredKegiatan->nama_waktu ?? 'Kegiatan' }}
                  </span>
                </div>

                <h3 class="fw-bold text-white fs-2 mb-3">{{ $featuredKegiatan->nama_kegiatan }}</h3>

                <div class="row g-3 text-white-50 small mb-4">
                  <div class="col-sm-6 d-flex align-items-center gap-2 text-white">
                    <div class="rounded-circle bg-white bg-opacity-10 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                      <div class="text-white-50" style="font-size: 0.72rem;">LOKASI / TEMPAT</div>
                      <strong class="text-white">{{ $featuredKegiatan->tempat }}</strong>
                    </div>
                  </div>

                  <div class="col-sm-6 d-flex align-items-center gap-2 text-white">
                    <div class="rounded-circle bg-white bg-opacity-10 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                      <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                      <div class="text-white-50" style="font-size: 0.72rem;">WAKTU PELAKSANAAN</div>
                      <strong class="text-white">{{ substr($featuredKegiatan->mulai_kegiatan, 0, 5) }} - {{ substr($featuredKegiatan->akhir_kegiatan, 0, 5) }} WIB</strong>
                    </div>
                  </div>

                  <div class="col-sm-6 d-flex align-items-center gap-2 text-white">
                    <div class="rounded-circle bg-white bg-opacity-10 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                      <div class="text-white-50" style="font-size: 0.72rem;">PANCERAMAH / KHOTIB</div>
                      <strong class="text-white">{{ $featuredKegiatan->pembicara ?: ($featuredKegiatan->nama_khotib ?: 'Takmir Masjid') }}</strong>
                    </div>
                  </div>

                  <div class="col-sm-6 d-flex align-items-center gap-2 text-white">
                    <div class="rounded-circle bg-white bg-opacity-10 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                      <div class="text-white-50" style="font-size: 0.72rem;">SASARAN JAMAAH</div>
                      <strong class="text-white">{{ $featuredKegiatan->audience ?: 'Jamaah Umum' }}</strong>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                  <button type="button" class="btn btn-light btn-sm fw-bold text-success px-3 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAgenda{{ $featuredKegiatan->id }}">
                    <i class="bi bi-info-circle me-1"></i> Lihat Detail Acara
                  </button>
                  <a href="{{ $gCalUrl }}" target="_blank" class="btn btn-outline-light btn-sm fw-bold px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar-plus me-1"></i> Simpan ke Google Calendar
                  </a>
                </div>
              </div>

              <div class="col-lg-4 text-center">
                <div class="agenda-date-badge-large mx-auto d-inline-block">
                  <div class="day-name">{{ \Carbon\Carbon::parse($featuredKegiatan->tanggal)->translatedFormat('l') }}</div>
                  <div class="day-num">{{ \Carbon\Carbon::parse($featuredKegiatan->tanggal)->format('d') }}</div>
                  <div class="month-year">{{ \Carbon\Carbon::parse($featuredKegiatan->tanggal)->translatedFormat('F Y') }}</div>
                </div>
              </div>
            </div>
          </div>
        @endif

        <!-- Filter Category Tabs -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4" data-aos="fade-up">
          <button type="button" class="agenda-filter-btn active" data-filter="all">Semua Agenda</button>
          <button type="button" class="agenda-filter-btn" data-filter="kajian">Kajian & Pengajian</button>
          <button type="button" class="agenda-filter-btn" data-filter="jumat">Ibadah Jumat</button>
          <button type="button" class="agenda-filter-btn" data-filter="phbi">PHBI & Tabligh</button>
          <button type="button" class="agenda-filter-btn" data-filter="sosial">Sosial & TPQ</button>
        </div>

        <!-- Agenda Grid -->
        <div class="row gy-4" id="agendaGridContainer">
          @forelse($kegiatans as $keg)
            @php
              $namaLower = strtolower($keg->nama_kegiatan);
              $kategoriTag = 'umum';
              $kategoriLabel = 'Agenda Masjid';
              $badgeBg = 'bg-secondary';
              $patternIcon = 'fa-mosque';

              if (str_contains($namaLower, 'jumat') || str_contains($namaLower, 'khutbah')) {
                  $kategoriTag = 'jumat';
                  $kategoriLabel = 'Ibadah Jumat';
                  $badgeBg = 'bg-success';
                  $patternIcon = 'fa-kaaba';
              } elseif (str_contains($namaLower, 'kajian') || str_contains($namaLower, 'pengajian') || str_contains($namaLower, 'kuliah') || str_contains($namaLower, 'tahsin')) {
                  $kategoriTag = 'kajian';
                  $kategoriLabel = 'Kajian Dakwah';
                  $badgeBg = 'bg-primary';
                  $patternIcon = 'fa-book-quran';
              } elseif (str_contains($namaLower, 'maulid') || str_contains($namaLower, 'isra') || str_contains($namaLower, 'idul') || str_contains($namaLower, 'ramadhan') || str_contains($namaLower, 'phbi') || str_contains($namaLower, 'tabligh')) {
                  $kategoriTag = 'phbi';
                  $kategoriLabel = 'PHBI & Tabligh';
                  $badgeBg = 'bg-warning text-dark';
                  $patternIcon = 'fa-star-and-crescent';
              } elseif (str_contains($namaLower, 'santunan') || str_contains($namaLower, 'yatim') || str_contains($namaLower, 'baksos') || str_contains($namaLower, 'tpq') || str_contains($namaLower, 'bimbingan')) {
                  $kategoriTag = 'sosial';
                  $kategoriLabel = 'Sosial & TPQ';
                  $badgeBg = 'bg-info text-dark';
                  $patternIcon = 'fa-hands-holding-child';
              }
            @endphp
            <div class="col-lg-4 col-md-6 agenda-grid-item" data-category="{{ $kategoriTag }}" data-aos="fade-up" data-aos-delay="150">
              <div class="agenda-item-card h-100">
                <!-- Thumbnail / Header Image -->
                <div class="agenda-card-thumb">
                  @if($keg->foto)
                    <img src="{{ asset('storage/' . $keg->foto) }}" alt="{{ $keg->nama_kegiatan }}" loading="lazy">
                  @else
                    <div class="agenda-thumb-pattern">
                      <i class="fa-solid {{ $patternIcon }} fa-3x opacity-50"></i>
                    </div>
                  @endif

                  <!-- Floating Date Box -->
                  <div class="agenda-card-date-floating">
                    <div class="day">{{ \Carbon\Carbon::parse($keg->tanggal)->format('d') }}</div>
                    <div class="month">{{ \Carbon\Carbon::parse($keg->tanggal)->translatedFormat('M') }}</div>
                  </div>

                  <!-- Category Tag -->
                  <span class="agenda-category-pill">{{ $kategoriLabel }}</span>
                </div>

                <!-- Card Body -->
                <div class="agenda-card-body">
                  <div class="d-flex align-items-center justify-content-between text-muted small mb-2">
                    <span><i class="bi bi-clock me-1 text-success"></i> {{ substr($keg->mulai_kegiatan, 0, 5) }} - {{ substr($keg->akhir_kegiatan, 0, 5) }} WIB</span>
                    <span class="badge bg-light text-dark border">{{ $keg->nama_waktu ?? 'WIB' }}</span>
                  </div>

                  <h4 class="agenda-title" title="{{ $keg->nama_kegiatan }}">{{ $keg->nama_kegiatan }}</h4>

                  <!-- Info Rows -->
                  <div class="agenda-info-row">
                    <i class="bi bi-geo-alt-fill text-danger flex-shrink-0"></i>
                    <span class="text-truncate">{{ $keg->tempat }}</span>
                  </div>

                  <div class="agenda-info-row">
                    <i class="bi bi-person-circle text-primary flex-shrink-0"></i>
                    <span class="text-truncate">
                      @if($keg->pembicara)
                        <strong>{{ $keg->pembicara }}</strong>
                      @elseif($keg->nama_khotib)
                        Khotib: <strong>{{ $keg->nama_khotib }}</strong>
                      @else
                        Takmir Masjid
                      @endif
                    </span>
                  </div>

                  @if($keg->nama_muadzin && $keg->nama_muadzin != '-')
                    <div class="agenda-info-row">
                      <i class="bi bi-mic-fill text-success flex-shrink-0"></i>
                      <span class="text-truncate">Bilal: {{ $keg->nama_muadzin }}</span>
                    </div>
                  @endif

                  <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-secondary border">
                      <i class="bi bi-people me-1"></i> {{ $keg->audience ?: 'Umum' }}
                    </span>
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAgenda{{ $keg->id }}">
                      Detail <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center text-muted py-5">
              <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
              <p class="fs-5">Belum ada agenda kegiatan yang dijadwalkan saat ini.</p>
            </div>
          @endforelse
        </div>

        <!-- Premium Agenda CTA Banner -->
        <div class="mt-5" data-aos="fade-up">
          <div style="background: linear-gradient(135deg, #064e3b 0%, #0f766e 100%); border-radius: 20px; padding: 36px 40px; position: relative; overflow: hidden; box-shadow: 0 20px 50px rgba(6,78,59,0.3);">
            <div style="position: absolute; top: -60px; right: -60px; width: 260px; height: 260px; background: radial-gradient(circle, rgba(52,211,153,0.18), transparent 70%); pointer-events: none;"></div>
            <div style="position: absolute; bottom: -40px; left: -30px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(16,185,129,0.12), transparent 70%); pointer-events: none;"></div>
            <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
              <div class="col-lg-8 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 mb-2" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; padding: 4px 14px; font-size: 0.72rem; color: #6ee7b7; font-weight: 700; letter-spacing: 1px;"><i class="bi bi-calendar3"></i> KALENDER LENGKAP</div>
                <h3 class="text-white fw-bold mb-1" style="font-size: 1.5rem;">Lihat Semua Jadwal Kegiatan Masjid</h3>
                <p class="mb-0" style="color: rgba(255,255,255,0.65); font-size: 0.92rem;">Akses kalender lengkap agenda dakwah, sholat berjamaah, kajian rutin, dan peringatan hari besar Islam.</p>
              </div>
              <div class="col-lg-4 text-center">
                <a href="{{ route('kegiatan.calendar') }}" class="btn btn-light fw-bold px-5 py-3 shadow" style="border-radius: 50px; color: #064e3b; font-size: 1rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px) scale(1.03)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.25)';" onmouseout="this.style.transform='none'; this.style.boxShadow='';">
                  <i class="bi bi-calendar-week me-2"></i> Buka Kalender
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Kegiatan Section -->

    <!-- ================= MODAL DETAIL AGENDA KEGIATAN ================= -->
    @foreach($kegiatans as $keg)
      @php
        $startDateTime = \Carbon\Carbon::parse($keg->tanggal . ' ' . $keg->mulai_kegiatan)->format('Ymd\THis');
        $endDateTime = \Carbon\Carbon::parse($keg->tanggal . ' ' . ($keg->akhir_kegiatan ?: $keg->mulai_kegiatan))->format('Ymd\THis');
        $calTitle = urlencode($keg->nama_kegiatan . ' - ' . ($profil->nama_masjid ?? 'Masjid Al-Ikhlas'));
        $calDetails = urlencode('Penceramah/Khotib: ' . ($keg->pembicara ?: ($keg->nama_khotib ?: '-')) . "\nTempat: " . $keg->tempat . "\nAudience: " . ($keg->audience ?: 'Umum'));
        $calLocation = urlencode($keg->tempat . ', ' . ($profil->alamat ?? 'Masjid Al-Ikhlas Karangmulya'));
        $gCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$startDateTime}/{$endDateTime}&details={$calDetails}&location={$calLocation}";
      @endphp
      <div class="modal fade" id="modalAgenda{{ $keg->id }}" tabindex="-1" aria-labelledby="modalAgendaLabel{{ $keg->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-success text-white px-4 py-3">
              <h5 class="modal-title fw-bold" id="modalAgendaLabel{{ $keg->id }}">
                <i class="bi bi-calendar-event me-2"></i> Detail Informasi Agenda Kegiatan
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
              @if($keg->foto)
                <div class="text-center mb-4 rounded-3 overflow-hidden bg-dark">
                  <img src="{{ asset('storage/' . $keg->foto) }}" alt="{{ $keg->nama_kegiatan }}" class="img-fluid rounded-3" style="max-height: 380px; width: auto; object-fit: contain;">
                </div>
              @endif

              <h3 class="fw-bold text-dark mb-3">{{ $keg->nama_kegiatan }}</h3>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Hari & Tanggal</div>
                    <div class="fw-bold text-dark fs-6">
                      <i class="bi bi-calendar-check text-success me-2"></i>
                      {{ \Carbon\Carbon::parse($keg->tanggal)->translatedFormat('l, d F Y') }}
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Waktu Pelaksanaan</div>
                    <div class="fw-bold text-dark fs-6">
                      <i class="bi bi-clock text-primary me-2"></i>
                      {{ substr($keg->mulai_kegiatan, 0, 5) }} - {{ substr($keg->akhir_kegiatan, 0, 5) }} WIB (Sesi {{ $keg->nama_waktu ?? 'WIB' }})
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Lokasi / Tempat</div>
                    <div class="fw-bold text-dark fs-6">
                      <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                      {{ $keg->tempat }}
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Sasaran Jamaah</div>
                    <div class="fw-bold text-dark fs-6">
                      <i class="bi bi-people-fill text-info me-2"></i>
                      {{ $keg->audience ?: 'Kaum Muslimin / Jamaah Umum' }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="card border-0 bg-success-light p-3 mb-4 rounded-3">
                <div class="row g-2 align-items-center">
                  <div class="col-sm-6">
                    <small class="text-muted text-uppercase fw-semibold d-block">Penceramah / Khotib</small>
                    <strong class="text-success fs-6"><i class="bi bi-person-fill me-1"></i> {{ $keg->pembicara ?: ($keg->nama_khotib ?: 'Takmir Masjid') }}</strong>
                  </div>
                  @if($keg->nama_muadzin && $keg->nama_muadzin != '-')
                    <div class="col-sm-6">
                      <small class="text-muted text-uppercase fw-semibold d-block">Petugas Muadzin / Bilal</small>
                      <strong class="text-dark fs-6"><i class="bi bi-mic-fill text-primary me-1"></i> {{ $keg->nama_muadzin }}</strong>
                    </div>
                  @endif
                </div>
              </div>

              @if($keg->kepanitiaans && $keg->kepanitiaans->isNotEmpty())
                <div class="mb-3">
                  <h6 class="fw-bold text-dark mb-2"><i class="bi bi-person-workspace text-primary me-1"></i> Susunan Panitia Pelaksana:</h6>
                  <div class="d-flex flex-wrap gap-2">
                    @foreach($keg->kepanitiaans as $panitia)
                      <span class="badge bg-light text-dark border px-2 py-1">
                        {{ $panitia->posisi ? $panitia->posisi->nama_posisi : 'Panitia' }}: <strong>{{ $panitia->takmir ? $panitia->takmir->nama_takmir : 'Petugas' }}</strong>
                      </span>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
            <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
              <a href="{{ $gCalUrl }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
                <i class="bi bi-google me-1"></i> Simpan ke Google Calendar
              </a>
              <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <!-- Keuangan Section -->
    <section id="keuangan" class="departments section py-5" style="background: #f8fafc;">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">
          <i class="fa-solid fa-coins me-1"></i> TRANSPARANSI KAS MASJID
        </span>
        <h2 class="fw-bold fs-2 text-dark">Laporan & Transparansi Keuangan</h2>
        <p class="text-muted mx-auto" style="max-width: 680px;">
          Laporan keuangan real-time pemasukan infaq, shodaqoh jamaah, belanja operasional, dan saldo kas {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }} yang dikelola secara amanah, terbuka, dan akuntabel.
        </p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!-- 3 Executive Financial Summary Cards -->
        <div class="row g-4 justify-content-center mb-5">
          <!-- Card 1: Saldo Kas Utama -->
          <div class="col-lg-4 col-md-6">
            <div class="finance-overview-card saldo-card d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <span class="badge saldo-badge-glass rounded-pill px-3 py-1 text-uppercase">
                    <i class="bi bi-shield-check text-warning me-1"></i> Saldo Kas Terverifikasi
                  </span>
                  <div class="finance-stat-icon rounded-circle saldo-icon-glass text-white">
                    <i class="bi bi-wallet2 fs-4"></i>
                  </div>
                </div>
                <div class="text-white-50 small mb-1">Total Saldo Kas Tersedia Saat Ini</div>
                <h2 class="fw-bold text-white mb-0 display-6">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h2>
              </div>
              <div class="mt-4 pt-3 border-top border-white border-opacity-20 d-flex justify-content-between align-items-center text-white-50 small">
                <span>Per {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                <span class="text-white fw-bold"><i class="bi bi-check-circle-fill text-warning me-1"></i>Amanah & Siap Pakai</span>
              </div>
            </div>
          </div>

          <!-- Card 2: Total Pemasukan -->
          <div class="col-lg-4 col-md-6">
            <div class="finance-overview-card d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <span class="badge bg-success-light text-success rounded-pill px-3 py-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="bi bi-arrow-down-left me-1"></i> Arus Kas Masuk
                  </span>
                  <div class="finance-stat-icon rounded-circle bg-success-light text-success">
                    <i class="bi bi-box-arrow-in-down fs-4"></i>
                  </div>
                </div>
                <div class="text-muted small mb-1">Total Penerimaan Infaq / Donasi (Akumulasi)</div>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
              </div>
              <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center small">
                <span class="text-muted">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}:</span>
                <span class="text-success fw-bold">+Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>

          <!-- Card 3: Total Pengeluaran -->
          <div class="col-lg-4 col-md-6">
            <div class="finance-overview-card d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <span class="badge bg-danger-light text-danger rounded-pill px-3 py-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="bi bi-arrow-up-right me-1"></i> Arus Kas Keluar
                  </span>
                  <div class="finance-stat-icon rounded-circle bg-danger-light text-danger">
                    <i class="bi bi-box-arrow-up fs-4"></i>
                  </div>
                </div>
                <div class="text-muted small mb-1">Total Pengeluaran & Belanja Operasional</div>
                <h3 class="fw-bold text-danger mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
              </div>
              <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center small">
                <span class="text-muted">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}:</span>
                <span class="text-danger fw-bold">-Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Middle Row: Interactive Cashflow Chart & Infaq / Rekening Box -->
        <div class="row g-4 mb-5 align-items-stretch">
          <!-- Chart Column -->
          <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 h-100 p-4 bg-white">
              <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                  <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up-arrow text-success me-2"></i>Tren Arus Kas Infaq & Operasional</h5>
                  <small class="text-muted">Perbandingan fluktuasi pemasukan dan pengeluaran kas (Tahun {{ $currentYear }})</small>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2"><i class="bi bi-calendar3 me-1"></i>Tahun {{ $currentYear }}</span>
              </div>
              <div style="position: relative; height: 290px; width: 100%;">
                <canvas id="landingCashflowCanvas"></canvas>
              </div>
            </div>
          </div>

          <!-- Infaq Digital & Bank Account Box -->
          <div class="col-lg-4">
            <div class="donation-cta-card h-100 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                  <div class="rounded-circle bg-success text-white p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-heart-fill small"></i>
                  </div>
                  <h6 class="fw-bold text-success mb-0 text-uppercase letter-spacing-1">Infaq / Shodaqoh</h6>
                </div>
                <h4 class="fw-bold text-dark mb-2">{{ $profil->judul_infaq ?? 'Salurkan Infaq Terbaik Anda' }}</h4>
                <p class="text-muted small mb-3">{{ $profil->deskripsi_infaq ?? 'Dukung kemakmuran masjid, kegiatan dakwah, santunan yatim, dan pemeliharaan fasilitas masjid.' }}</p>

                <!-- Bank Account Pill -->
                <div class="bg-white rounded-3 p-3 border mb-3 shadow-sm">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="badge bg-success-light text-success fw-bold">{{ $profil->nama_bank ?? 'BANK SYARIAH INDONESIA (BSI)' }}</span>
                    <i class="bi bi-bank fs-5 text-secondary"></i>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-2">
                    <div>
                      <div class="text-muted" style="font-size: 0.72rem;">NOMOR REKENING MASJID</div>
                      <strong class="fs-6 text-dark letter-spacing-1" id="rek-masjid-number">{{ $profil->nomor_rekening ?? '7145-8890-2101' }}</strong>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 account-copy-btn" onclick="copyRekening('{{ preg_replace('/[^0-9]/', '', $profil->nomor_rekening ?? '714588902101') }}', this)">
                      <i class="bi bi-clipboard me-1"></i> Salin
                    </button>
                  </div>
                  <small class="text-muted d-block mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                    A.n: <strong>{{ $profil->atas_nama ?? ('Takmir ' . ($profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas')) }}</strong>
                  </small>
                </div>
              </div>

              <div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}?text=Assalamu%27alaikum%20Takmir,%20saya%20ingin%20konfirmasi%20transfer%20infaq/donasi%20untuk%20Masjid." target="_blank" class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm">
                  <i class="bi bi-whatsapp me-1"></i> Konfirmasi Donasi via WA
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- 6 Transaksi Terkini Table -->
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
          <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Catatan Transaksi Kas Terkini</h5>
              <small class="text-muted">Riwayat mutasi pencatatan pembukuan kas bendahara masjid</small>
            </div>
            <a href="{{ route('laporan.keuangan') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
              <i class="bi bi-file-earmark-text me-1"></i> Buka Pembukuan Lengkap
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-modern-finance align-middle mb-0">
              <thead>
                <tr>
                  <th class="text-center" style="width: 60px;">No</th>
                  <th>Tanggal</th>
                  <th>Jenis Transaksi</th>
                  <th>Sumber / Keterangan</th>
                  <th>Pihak / Keterkaitan</th>
                  <th class="text-end">Nominal</th>
                </tr>
              </thead>
              <tbody>
                @forelse($keuangan as $item)
                  <tr>
                    <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                      <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                      <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</small>
                    </td>
                    <td>
                      @if($item->kategori_id == 1)
                        <span class="badge rounded-pill bg-success-light text-success px-3 py-2 fw-bold">
                          <i class="bi bi-arrow-down-left me-1"></i> Pemasukan
                        </span>
                      @else
                        <span class="badge rounded-pill bg-danger-light text-danger px-3 py-2 fw-bold">
                          <i class="bi bi-arrow-up-right me-1"></i> Pengeluaran
                        </span>
                      @endif
                    </td>
                    <td>
                      <strong class="text-dark d-block">{{ $item->sumber_keuangan }}</strong>
                      @if($item->keterangan)
                        <small class="text-muted">{{ $item->keterangan }}</small>
                      @endif
                    </td>
                    <td>
                      @if($item->donatur)
                        <span class="badge bg-light text-dark border"><i class="bi bi-person-heart text-success me-1"></i>{{ $item->donatur->nama_donatur }}</span>
                      @elseif($item->kegiatan)
                        <span class="badge bg-light text-dark border"><i class="bi bi-calendar-event text-primary me-1"></i>{{ $item->kegiatan->nama_kegiatan }}</span>
                      @else
                        <span class="text-muted small">-</span>
                      @endif
                    </td>
                    <td class="text-end">
                      @if($item->kategori_id == 1)
                        <span class="text-success fw-bold fs-6">+ Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                      @else
                        <span class="text-danger fw-bold fs-6">- Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                      <i class="bi bi-wallet-x fs-1 d-block mb-2 text-secondary"></i>
                      Belum ada catatan mutasi transaksi keuangan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section><!-- /Keuangan Section -->

    <!-- Gallery Section -->
    <section id="galeri" class="gallery section bg-light py-5">
      <div class="container section-title text-center mb-4" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">
          <i class="bi bi-camera-fill me-1"></i> DOKUMENTASI & GALERI FOTO
        </span>
        <h2 class="fw-bold">Galeri Dokumentasi Masjid</h2>
        <p class="text-muted">Potret rekam jejak kegiatan ibadah, kajian keilmuan, aktivitas sosial, dan keindahan sarana di {{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }}</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!-- Interactive Category Filter Bar -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
          <button type="button" class="gallery-filter-btn active" data-filter="all">
            <i class="bi bi-grid-3x3-gap-fill"></i> Semua Foto
          </button>
          <button type="button" class="gallery-filter-btn" data-filter="ibadah">
            <i class="bi bi-moon-stars-fill"></i> Ibadah & Sholat
          </button>
          <button type="button" class="gallery-filter-btn" data-filter="kajian">
            <i class="bi bi-book-half"></i> Kajian & Dakwah
          </button>
          <button type="button" class="gallery-filter-btn" data-filter="phbi">
            <i class="bi bi-stars"></i> PHBI & Tabligh
          </button>
          <button type="button" class="gallery-filter-btn" data-filter="sosial">
            <i class="bi bi-people-fill"></i> Sosial & TPQ
          </button>
          <button type="button" class="gallery-filter-btn" data-filter="sarana">
            <i class="bi bi-building"></i> Sarana & Fasilitas
          </button>
        </div>

        <!-- Modern Cards Grid -->
        <div class="row g-4 justify-content-center" id="galleryGridContainer">
          @forelse($galeri as $item)
            @php
              $lowerTitle = strtolower($item->nama_foto . ' ' . ($item->kegiatan->nama_kegiatan ?? ''));
              $categoryFilter = 'ibadah';
              $categoryLabel = 'Ibadah';
              $categoryBg = 'bg-primary text-white';

              if (str_contains($lowerTitle, 'kajian') || str_contains($lowerTitle, 'dakwah') || str_contains($lowerTitle, 'ahad')) {
                  $categoryFilter = 'kajian';
                  $categoryLabel = 'Kajian Dakwah';
                  $categoryBg = 'bg-success text-white';
              } elseif (str_contains($lowerTitle, 'maulid') || str_contains($lowerTitle, 'phbi') || str_contains($lowerTitle, 'isra') || str_contains($lowerTitle, 'tabligh')) {
                  $categoryFilter = 'phbi';
                  $categoryLabel = 'PHBI & Tabligh';
                  $categoryBg = 'bg-warning text-dark';
              } elseif (str_contains($lowerTitle, 'santunan') || str_contains($lowerTitle, 'yatim') || str_contains($lowerTitle, 'sosial') || str_contains($lowerTitle, 'tpq') || str_contains($lowerTitle, 'tahsin')) {
                  $categoryFilter = 'sosial';
                  $categoryLabel = 'Sosial & TPQ';
                  $categoryBg = 'bg-info text-dark';
              } elseif (str_contains($lowerTitle, 'ruang') || str_contains($lowerTitle, 'mihrab') || str_contains($lowerTitle, 'sarana') || str_contains($lowerTitle, 'wudhu') || str_contains($lowerTitle, 'fasilitas')) {
                  $categoryFilter = 'sarana';
                  $categoryLabel = 'Sarana & Fasilitas';
                  $categoryBg = 'bg-secondary text-white';
              }

              $fallbackIndex = (($loop->index % 7) + 1);
              $imgSrc = asset('assets-landing/img/gallery/gallery-' . $fallbackIndex . '.jpg');
              if (!empty($item->gambar)) {
                  if (file_exists(public_path('storage/' . $item->gambar))) {
                      $imgSrc = asset('storage/' . $item->gambar);
                  } elseif (file_exists(public_path('storage/galeri_masjid/' . $item->gambar))) {
                      $imgSrc = asset('storage/galeri_masjid/' . $item->gambar);
                  } elseif (file_exists(public_path('assets-landing/img/gallery/' . $item->gambar))) {
                      $imgSrc = asset('assets-landing/img/gallery/' . $item->gambar);
                  }
              }
            @endphp
            <div class="col-lg-4 col-md-6 gallery-item-col" data-category="{{ $categoryFilter }}" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 50) }}">
              <div class="gallery-card-modern">
                <div class="gallery-img-wrapper">
                  <img src="{{ $imgSrc }}" alt="{{ $item->nama_foto }}" loading="lazy">
                  
                  <span class="gallery-date-leaf">
                    <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                  </span>

                  <span class="gallery-category-pill {{ $categoryBg }}">
                    {{ $categoryLabel }}
                  </span>

                  <a href="{{ $imgSrc }}" class="gallery-overlay glightbox" data-gallery="masjid-gallery" data-title="{{ $item->nama_foto }}" data-description="Diabadikan pada {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }} - {{ $item->kegiatan->nama_kegiatan ?? 'Dokumentasi Resmi Masjid Jami Al-Ikhlas' }}">
                    <div class="gallery-zoom-btn" title="Perbesar Foto">
                      <i class="bi bi-arrows-fullscreen"></i>
                    </div>
                  </a>
                </div>

                <div class="gallery-card-body">
                  <div>
                    <h5 class="gallery-card-title text-truncate-2 mb-2" title="{{ $item->nama_foto }}">
                      {{ $item->nama_foto }}
                    </h5>
                    
                    @if($item->kegiatan)
                      <div class="d-flex align-items-center gap-1 text-success small mb-2 fw-medium">
                        <i class="bi bi-bookmark-check-fill"></i>
                        <span class="text-truncate">{{ $item->kegiatan->nama_kegiatan }}</span>
                      </div>
                    @else
                      <div class="d-flex align-items-center gap-1 text-muted small mb-2">
                        <i class="bi bi-building-check"></i>
                        <span>Fasilitas & Lingkungan Masjid</span>
                      </div>
                    @endif
                  </div>

                  <div class="pt-3 mt-2 border-top d-flex justify-content-between align-items-center small text-muted">
                    <span class="d-flex align-items-center gap-1">
                      <i class="bi bi-person-check-fill text-secondary"></i>
                      <span>{{ $item->takmir->nama_takmir ?? 'Takmir Masjid' }}</span>
                    </span>
                    <a href="{{ $imgSrc }}" class="text-success fw-semibold text-decoration-none glightbox d-flex align-items-center gap-1" data-gallery="masjid-gallery" data-title="{{ $item->nama_foto }}">
                      Lihat Foto <i class="bi bi-arrow-right-short fs-6"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center text-muted py-5">
              <i class="bi bi-images fs-1 d-block mb-3 text-secondary"></i>
              <h5>Belum Ada Foto Dokumentasi</h5>
              <p class="small">Foto dokumentasi kegiatan dan fasilitas masjid akan dipublikasikan secara berkala.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section><!-- /Gallery Section -->

    <!-- Pengurus Takmir Section - Premium Redesign -->
    <style>
      /* ── Takmir Section Wrapper ── */
      #pengurus.takmir-section-premium {
        background: linear-gradient(160deg, #0d2b18 0%, #1a4d2e 40%, #0d2b18 100%);
        position: relative;
        overflow: hidden;
        padding: 80px 0;
      }
      #pengurus.takmir-section-premium::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('{{ asset("assets-landing/img/takmir-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        opacity: 0.18;
        pointer-events: none;
      }
      #pengurus.takmir-section-premium::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(255,215,80,0.07) 0%, transparent 70%);
        pointer-events: none;
      }

      /* ── Section Title ── */
      .takmir-section-premium .takmir-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,215,80,0.15);
        border: 1px solid rgba(255,215,80,0.35);
        color: #ffd750;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 18px;
        border-radius: 50px;
        text-transform: uppercase;
      }
      .takmir-section-premium .takmir-title {
        color: #fff;
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 12px;
      }
      .takmir-section-premium .takmir-divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ffd750, #48bb78);
        border-radius: 4px;
        margin: 14px auto;
      }
      .takmir-section-premium .takmir-subtitle {
        color: rgba(255,255,255,0.65);
        font-size: 1rem;
      }

      /* ── Quran Quote Banner ── */
      .takmir-quote-banner {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,215,80,0.2);
        border-left: 4px solid #ffd750;
        border-radius: 12px;
        padding: 18px 24px;
        margin: 0 auto 50px;
        max-width: 720px;
        text-align: center;
      }
      .takmir-quote-banner .arabic-quote {
        font-size: 1.3rem;
        color: #ffd750;
        font-style: normal;
        font-weight: 500;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 6px;
      }
      .takmir-quote-banner .trans-quote {
        color: rgba(255,255,255,0.7);
        font-size: 0.82rem;
        font-style: italic;
      }
      .takmir-quote-banner .trans-quote span {
        font-style: normal;
        color: rgba(255,215,80,0.8);
        font-size: 0.75rem;
      }

      /* ── Card Pengurus ── */
      .takmir-card-premium {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(.22,.97,.44,.98), box-shadow 0.35s ease, border-color 0.35s ease;
        position: relative;
        height: 100%;
        backdrop-filter: blur(8px);
      }
      .takmir-card-premium:hover {
        transform: translateY(-8px) scale(1.015);
        border-color: rgba(255,215,80,0.45);
        box-shadow: 0 24px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,215,80,0.15);
      }

      /* Ribbon / Role banner at top */
      .takmir-card-role-ribbon {
        background: linear-gradient(90deg, #1e5e35, #2d8a50);
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .takmir-card-role-ribbon .role-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ffd750;
        box-shadow: 0 0 8px #ffd750;
        flex-shrink: 0;
        animation: pulse-dot 2s infinite;
      }
      @keyframes pulse-dot {
        0%,100% { opacity: 1; box-shadow: 0 0 6px #ffd750; }
        50% { opacity: 0.5; box-shadow: 0 0 12px #ffd750; }
      }
      .takmir-card-role-ribbon .role-name {
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        flex: 1;
      }
      .takmir-card-role-ribbon .status-pill {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #7af5a0;
        font-size: 0.65rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 4px;
      }

      /* Card Body */
      .takmir-card-body {
        padding: 28px 24px 24px;
        text-align: center;
        position: relative;
      }

      /* Avatar Ring */
      .takmir-avatar-ring {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
      }
      .takmir-avatar-ring::before,
      .takmir-avatar-ring::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        border: 2px solid;
        animation: ring-spin 8s linear infinite;
      }
      .takmir-avatar-ring::before {
        inset: -10px;
        border-color: rgba(255,215,80,0.5) transparent transparent transparent;
        animation-duration: 6s;
      }
      .takmir-avatar-ring::after {
        inset: -18px;
        border-color: transparent rgba(72,187,120,0.35) transparent transparent;
        animation-duration: 10s;
        animation-direction: reverse;
      }
      @keyframes ring-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
      }
      .takmir-avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e8040, #48bb78);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        box-shadow: 0 8px 25px rgba(30,128,64,0.55);
        position: relative;
        z-index: 2;
        border: 3px solid rgba(255,215,80,0.4);
        letter-spacing: -1px;
      }

      .takmir-member-name {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 6px;
        line-height: 1.3;
      }
      .takmir-member-username {
        color: rgba(255,255,255,0.45);
        font-size: 0.78rem;
        margin-bottom: 14px;
      }
      .takmir-member-username i { color: rgba(255,215,80,0.6); }

      /* Info Pills Row */
      .takmir-info-pills {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 4px;
      }
      .takmir-info-pill {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.72rem;
        color: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        gap: 5px;
      }
      .takmir-info-pill i { font-size: 0.7rem; color: #7af5a0; }

      /* Card Shimmer effect on hover */
      .takmir-card-premium::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
        transition: left 0.6s ease;
        z-index: 1;
        pointer-events: none;
      }
      .takmir-card-premium:hover::before { left: 150%; }

      /* Empty State */
      .takmir-empty {
        background: rgba(255,255,255,0.06);
        border: 2px dashed rgba(255,255,255,0.15);
        border-radius: 16px;
        padding: 48px 24px;
        text-align: center;
        color: rgba(255,255,255,0.5);
      }
      .takmir-empty i { font-size: 3rem; margin-bottom: 12px; display: block; color: rgba(255,215,80,0.4); }

      /* Bottom Decorative Strip */
      .takmir-bottom-strip {
        margin-top: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
      }
      .takmir-strip-stat {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 50px;
        padding: 8px 20px;
        color: rgba(255,255,255,0.8);
        font-size: 0.82rem;
      }
      .takmir-strip-stat .strip-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(72,187,120,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7af5a0;
        font-size: 0.75rem;
      }
      .takmir-strip-stat .strip-num {
        font-weight: 700;
        color: #ffd750;
        font-size: 1rem;
      }
    </style>

    <section id="pengurus" class="takmir-section-premium">
      <div class="container position-relative" style="z-index: 2;">

        {{-- Section Header --}}
        <div class="text-center mb-4" data-aos="fade-up">
          <div class="takmir-badge mb-3">
            <i class="bi bi-people-fill"></i>
            STRUKTUR KEPENGURUSAN
          </div>
          <h2 class="takmir-title">Pengurus Takmir Masjid</h2>
          <div class="takmir-divider"></div>
          <p class="takmir-subtitle">Jajaran pengurus yang berkhidmat melayani jamaah dan kemakmuran<br>{{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }}</p>
        </div>

        {{-- Quran / Islamic Quote Banner --}}
        <div class="takmir-quote-banner" data-aos="fade-up" data-aos-delay="100">
          <em class="arabic-quote">&#8220; إِنَّمَا يَعْمُرُ مَسَاجِدَ اللَّهِ مَنْ آمَنَ بِاللَّهِ وَالْيَوْمِ الْآخِرِ &#8221;</em>
          <p class="trans-quote">
            "Sesungguhnya yang memakmurkan masjid-masjid Allah hanyalah orang-orang yang beriman kepada Allah dan hari akhir..."<br>
            <span>— QS. At-Taubah: 18</span>
          </p>
        </div>

        {{-- Pengurus Cards Grid --}}
        <div class="row gy-4 justify-content-center" data-aos="fade-up" data-aos-delay="150">
          @forelse($pengurusList as $pengurus)
          @php
            $roleColors = [
              'admin'      => ['#1e5e35','#2d8a50'],
              'bendahara'  => ['#1a4a7a','#2563a8'],
              'sekretaris' => ['#5a2d6a','#8b3fa8'],
            ];
            $roleName   = strtolower($pengurus->role->nama_role ?? 'pengurus');
            $roleGrad   = $roleColors[$roleName] ?? ['#374151','#4b5563'];
            $roleLabel  = ucfirst($pengurus->role->nama_role ?? 'Pengurus Takmir');
            $initial    = strtoupper(substr($pengurus->nama_takmir, 0, 1));
            $icons = [
              'admin'      => 'bi-shield-fill-check',
              'bendahara'  => 'bi-cash-coin',
              'sekretaris' => 'bi-journal-text',
            ];
            $roleIcon   = $icons[$roleName] ?? 'bi-person-badge-fill';
          @endphp
          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="takmir-card-premium" data-aos="zoom-in" data-aos-delay="{{ 100 + ($loop->index * 80) }}">

              {{-- Role Ribbon --}}
              <div class="takmir-card-role-ribbon" style="background: linear-gradient(90deg, {{ $roleGrad[0] }}, {{ $roleGrad[1] }});">
                <div class="role-dot"></div>
                <span class="role-name"><i class="bi {{ $roleIcon }} me-1"></i>{{ $roleLabel }}</span>
                <span class="status-pill">
                  <i class="bi bi-check-circle-fill" style="font-size: 0.6rem;"></i>
                  Aktif
                </span>
              </div>

              {{-- Card Body --}}
              <div class="takmir-card-body">
                {{-- Animated Avatar Ring --}}
                <div class="takmir-avatar-ring">
                  <div class="takmir-avatar-circle" style="background: linear-gradient(135deg, {{ $roleGrad[0] }}, {{ $roleGrad[1] }});">
                    {{ $initial }}
                  </div>
                </div>

                {{-- Name & Username --}}
                <h4 class="takmir-member-name">{{ $pengurus->nama_takmir }}</h4>
                <p class="takmir-member-username">
                  <i class="bi bi-at"></i>{{ $pengurus->username }}
                </p>

                {{-- Info Pills --}}
                <div class="takmir-info-pills">
                  <span class="takmir-info-pill">
                    <i class="bi bi-shield-check"></i> Terverifikasi
                  </span>
                  <span class="takmir-info-pill">
                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::now()->locale('id')->isoFormat('YYYY') }}
                  </span>
                </div>
              </div>

            </div>
          </div>
          @empty
          <div class="col-12">
            <div class="takmir-empty">
              <i class="bi bi-people"></i>
              <p class="mb-0">Data pengurus takmir belum ditambahkan.</p>
            </div>
          </div>
          @endforelse
        </div>

        {{-- Bottom Stats Strip --}}
        <div class="takmir-bottom-strip" data-aos="fade-up" data-aos-delay="300">
          <div class="takmir-strip-stat">
            <div class="strip-icon"><i class="bi bi-people-fill"></i></div>
            <span><span class="strip-num">{{ $totalTakmir }}</span> Pengurus Aktif</span>
          </div>
          <div class="takmir-strip-stat">
            <div class="strip-icon"><i class="bi bi-calendar2-check-fill"></i></div>
            <span><span class="strip-num">{{ $totalKegiatan }}</span> Kegiatan Terselenggara</span>
          </div>
          <div class="takmir-strip-stat">
            <div class="strip-icon"><i class="bi bi-collection-fill"></i></div>
            <span><span class="strip-num">{{ $totalInventaris }}</span> Inventaris Tercatat</span>
          </div>
        </div>

      </div>
    </section><!-- /Pengurus Section -->

    <!-- Contact Section - Premium Redesign -->
    <style>
      #kontak.contact-premium { background: #f0fdf4; padding: 80px 0; }
      .kontak-map-wrap { border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.12); position: relative; }
      .kontak-map-wrap iframe { display: block; border: none; width: 100%; height: 420px; }
      .kontak-map-badge { position: absolute; top: 16px; left: 16px; background: #064e3b; color: #fff; padding: 8px 16px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; display: flex; align-items: center; gap: 6px; z-index: 10; box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
      .kontak-info-card { background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 24px; box-shadow: 0 6px 24px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%; }
      .kontak-info-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); border-color: #10b981; }
      .kontak-icon-wrap { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; margin-bottom: 14px; }
      .kontak-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #64748b; margin-bottom: 4px; }
      .kontak-value { font-size: 0.98rem; font-weight: 700; color: #0f172a; line-height: 1.4; }
      .kontak-value a { color: #064e3b; text-decoration: none; }
      .kontak-value a:hover { text-decoration: underline; }
      .kontak-cta-card { background: linear-gradient(135deg, #064e3b, #0f766e); color: #fff; border-radius: 20px; padding: 28px 32px; box-shadow: 0 12px 40px rgba(6,78,59,0.3); }
    </style>
    <section id="kontak" class="contact-premium">
      <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5" data-aos="fade-up">
          <span style="display: inline-flex; align-items: center; gap: 8px; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #059669; font-size: 0.72rem; font-weight: 700; letter-spacing: 2px; padding: 6px 18px; border-radius: 50px; text-transform: uppercase;">
            <i class="bi bi-geo-alt-fill"></i> LOKASI &amp; KONTAK
          </span>
          <h2 class="fw-bold mt-3 mb-2" style="font-size: clamp(1.7rem,4vw,2.4rem); color: #0f172a;">Temukan &amp; Hubungi Kami</h2>
          <p class="text-muted mx-auto" style="max-width: 560px;">Kunjungi langsung atau hubungi Takmir {{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }} untuk informasi lebih lanjut.</p>
        </div>

        <div class="row g-4 align-items-start">

          <!-- Left: Map -->
          <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
            <div class="kontak-map-wrap">
              <div class="kontak-map-badge"><i class="bi bi-pin-map-fill"></i> {{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }}</div>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3032.4361612730095!2d109.23886407356817!3d-6.922493993077196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fc7acd5292c5f%3A0xb89abf11b3f0d3d0!2sMasjid%20Al%20Ikhlas%20Dk%20Simendot!5e1!3m2!1sen!2sid!4v1776051556955!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <!-- Right: Contact Info -->
          <div class="col-lg-5" data-aos="fade-left" data-aos-delay="150">
            <div class="row g-3">

              <!-- Alamat Card -->
              <div class="col-12">
                <div class="kontak-info-card">
                  <div class="kontak-icon-wrap" style="background: rgba(16,185,129,0.1); color: #059669;"><i class="bi bi-geo-alt-fill"></i></div>
                  <div class="kontak-label">Alamat Masjid</div>
                  <div class="kontak-value">{{ $profil->alamat ?? 'Jl. Raya Karangmulya RT.02/RW.01, Kec. Suradadi, Kab. Tegal, Jawa Tengah' }}</div>
                </div>
              </div>

              <!-- Telepon Card -->
              <div class="col-sm-6">
                <div class="kontak-info-card">
                  <div class="kontak-icon-wrap" style="background: rgba(37,211,102,0.12); color: #25d366;"><i class="bi bi-whatsapp"></i></div>
                  <div class="kontak-label">WhatsApp Takmir</div>
                  <div class="kontak-value">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}" target="_blank" class="d-flex align-items-center gap-1">
                      {{ $profil->telepon ?? '0812-3456-7890' }}
                      <i class="bi bi-box-arrow-up-right" style="font-size: 0.7rem; color: #25d366;"></i>
                    </a>
                  </div>
                </div>
              </div>

              <!-- Pengurus Card -->
              <div class="col-sm-6">
                <div class="kontak-info-card">
                  <div class="kontak-icon-wrap" style="background: rgba(99,102,241,0.1); color: #6366f1;"><i class="bi bi-people-fill"></i></div>
                  <div class="kontak-label">Pengurus Aktif</div>
                  <div class="kontak-value">{{ $totalTakmir }} Takmir Berkhidmat</div>
                </div>
              </div>

              <!-- CTA Card -->
              <div class="col-12">
                <div class="kontak-cta-card">
                  <div style="font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; color: rgba(255,255,255,0.6); text-transform: uppercase; margin-bottom: 6px;"><i class="bi bi-door-open me-1"></i> Waktu Operasional</div>
                  <h5 class="text-white fw-bold mb-1">Buka Setiap Hari</h5>
                  <p style="color: rgba(255,255,255,0.7); font-size: 0.88rem; margin-bottom: 16px;">Sholat Berjamaah 5 Waktu · Kajian Rutin · Konsultasi Keagamaan</p>
                  <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 10px 22px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    <i class="bi bi-whatsapp"></i> Chat Takmir Sekarang
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

  </main>

  <!-- Premium Footer -->
  <footer id="footer" style="background: linear-gradient(160deg, #051a0e 0%, #0d2b18 60%, #051a0e 100%); color: #fff; position: relative; overflow: hidden;">
    <div style="position: absolute; inset: 0; background-image: url('{{ asset("assets-landing/img/takmir-bg.jpg") }}'); background-size: cover; background-position: center; opacity: 0.06; pointer-events: none;"></div>
    <div class="container position-relative" style="z-index: 2; padding-top: 60px; padding-bottom: 32px;">

      <!-- Footer Top Grid -->
      <div class="row g-5 mb-5">

        <!-- Brand Column -->
        <div class="col-lg-4 col-md-6">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #1e5e35, #2d8a50); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 18px rgba(30,94,53,0.5);">
              <i class="fa-solid fa-mosque text-white"></i>
            </div>
            <div>
              <h5 class="mb-0 fw-bold text-white">{{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }}</h5>
              <small style="color: rgba(255,255,255,0.5); font-size: 0.75rem;">Dukuh Semendot, Karangmulya</small>
            </div>
          </div>
          <p style="color: rgba(255,255,255,0.55); font-size: 0.88rem; line-height: 1.7; margin-bottom: 20px;">Pusat ibadah, pembinaan umat, dan pengelolaan kas masjid yang amanah, transparan, dan akuntabel untuk masyarakat Desa Karangmulya.</p>
          <!-- Arabic ayat -->
          <div style="background: rgba(255,215,80,0.08); border: 1px solid rgba(255,215,80,0.2); border-radius: 10px; padding: 12px 16px; color: rgba(255,215,80,0.85); font-size: 0.82rem; font-style: italic; line-height: 1.6;">
            &#8220; إِنَّمَا يَعْمُرُ مَسَاجِدَ اللَّهِ مَنْ آمَنَ بِاللَّهِ &#8221;<br>
            <small style="color: rgba(255,255,255,0.45);">— QS. At-Taubah: 18</small>
          </div>
        </div>

        <!-- Navigasi Cepat -->
        <div class="col-lg-2 col-md-6 col-6">
          <h6 style="color: #ffd750; font-size: 0.72rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 18px;">Navigasi</h6>
          <ul class="list-unstyled" style="margin: 0;">
            @foreach([
              ['#beranda', 'bi-house-fill', 'Beranda'],
              ['#about', 'bi-info-circle-fill', 'Profil Masjid'],
              ['#kegiatan', 'bi-calendar-event-fill', 'Agenda Kegiatan'],
              ['#keuangan', 'bi-wallet2', 'Laporan Kas'],
              ['#galeri', 'bi-images', 'Galeri Foto'],
              ['#pengurus', 'bi-people-fill', 'Takmir'],
              ['#kontak', 'bi-geo-alt-fill', 'Kontak'],
            ] as [$href, $icon, $label])
            <li style="margin-bottom: 10px;">
              <a href="{{ $href }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.87rem; display: flex; align-items: center; gap: 8px; transition: color 0.2s ease;" onmouseover="this.style.color='#ffd750'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                <i class="bi {{ $icon }}" style="font-size: 0.8rem; color: #48bb78;"></i> {{ $label }}
              </a>
            </li>
            @endforeach
          </ul>
        </div>

        <!-- Statistik Masjid -->
        <div class="col-lg-3 col-md-6">
          <h6 style="color: #ffd750; font-size: 0.72rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 18px;">Statistik Masjid</h6>
          <div class="d-flex flex-column gap-3">
            @foreach([
              [$totalKegiatan, 'bi-calendar-check-fill', 'Kegiatan Terselenggara', '#2563a8'],
              [$totalTakmir, 'bi-people-fill', 'Pengurus Takmir Aktif', '#1e5e35'],
              [$totalInventaris, 'bi-collection-fill', 'Sarana & Inventaris', '#7e22ce'],
              [$totalDonatur ?? 0, 'bi-heart-fill', 'Donatur & Jamaah', '#be185d'],
            ] as [$val, $icon, $label, $color])
            <div style="display: flex; align-items: center; gap: 12px;">
              <div style="width: 38px; height: 38px; background: {{ $color }}33; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #fff; flex-shrink: 0; border: 1px solid {{ $color }}55;">
                <i class="bi {{ $icon }}"></i>
              </div>
              <div>
                <div style="font-size: 1.2rem; font-weight: 800; color: #fff; line-height: 1;">{{ $val }}</div>
                <div style="font-size: 0.73rem; color: rgba(255,255,255,0.5);">{{ $label }}</div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Kontak Cepat -->
        <div class="col-lg-3 col-md-6">
          <h6 style="color: #ffd750; font-size: 0.72rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 18px;">Hubungi Kami</h6>
          <ul class="list-unstyled" style="margin: 0;">
            <li class="d-flex gap-3 mb-3">
              <div style="width: 36px; height: 36px; background: rgba(16,185,129,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; color: #34d399; flex-shrink: 0;"><i class="bi bi-geo-alt-fill"></i></div>
              <div style="font-size: 0.83rem; color: rgba(255,255,255,0.6); line-height: 1.5;">{{ $profil->alamat ?? 'Jl. Raya Karangmulya, Kec. Suradadi, Tegal, Jawa Tengah' }}</div>
            </li>
            <li class="d-flex gap-3 mb-3">
              <div style="width: 36px; height: 36px; background: rgba(37,211,102,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; color: #25d366; flex-shrink: 0;"><i class="bi bi-whatsapp"></i></div>
              <div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}" target="_blank" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.83rem;" onmouseover="this.style.color='#25d366'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                  {{ $profil->telepon ?? '0812-3456-7890' }}
                </a>
              </div>
            </li>
          </ul>
          <!-- Social / Action Buttons -->
          <div class="d-flex gap-2 mt-3 flex-wrap">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}" target="_blank" style="background: rgba(37,211,102,0.15); border: 1px solid rgba(37,211,102,0.3); color: #25d366; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(37,211,102,0.3)'" onmouseout="this.style.background='rgba(37,211,102,0.15)'" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <a href="#keuangan" style="background: rgba(255,215,80,0.1); border: 1px solid rgba(255,215,80,0.25); color: #ffd750; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(255,215,80,0.2)'" onmouseout="this.style.background='rgba(255,215,80,0.1)'" title="Laporan Keuangan"><i class="bi bi-wallet2"></i></a>
            <a href="{{ route('login') }}" style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(99,102,241,0.3)'" onmouseout="this.style.background='rgba(99,102,241,0.15)'" title="Masuk Takmir"><i class="bi bi-lock-fill"></i></a>
          </div>
        </div>

      </div><!-- /Footer Top -->

      <!-- Divider -->
      <div style="height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent); margin-bottom: 24px;"></div>

      <!-- Footer Bottom -->
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <p class="mb-0" style="font-size: 0.82rem; color: rgba(255,255,255,0.45);">© {{ date('Y') }} <strong style="color: rgba(255,255,255,0.7);">{{ $profil->nama_masjid ?? 'Masjid Jami Al-Ikhlas' }}</strong>. All Rights Reserved.</p>
        <p class="mb-0" style="font-size: 0.78rem; color: rgba(255,255,255,0.35);">Sistem Informasi Manajemen Masjid (SIMAS) · Dukuh Semendot, Karangmulya, Tegal</p>
      </div>

    </div>
  </footer><!-- /Footer -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets-landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets-landing/js/main.js') }}"></script>

  <!-- Realtime Prayer Schedule & Live Clock Engine -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Default Fallback Schedule for Tegal & Suradadi (WIB / UTC+7)
      let prayerTimings = {
        Imsak: "04:17",
        Subuh: "04:27",
        Terbit: "05:45",
        Dzuhur: "11:44",
        Ashar: "15:03",
        Maghrib: "17:43",
        Isya: "18:53"
      };

      const todayStr = new Date().toISOString().slice(0, 10);
      const cacheKey = 'jadwal_sholat_tegal_' + todayStr;

      // 1. Try Loading from Local Cache for Instant Render (0ms)
      try {
        const cached = localStorage.getItem(cacheKey);
        if (cached) {
          const parsed = JSON.parse(cached);
          if (parsed.timings) {
            prayerTimings = parsed.timings;
            renderTimings(prayerTimings);
          }
          if (parsed.hijri) {
            renderHijri(parsed.hijri);
          }
        }
      } catch (e) {
        console.warn('Cache read error:', e);
      }

      // 2. Fetch Realtime Prayer API for Tegal (Method 20: Kemenag RI)
      fetch('https://api.aladhan.com/v1/timingsByCity?city=Tegal&country=Indonesia&method=20')
        .then(response => {
          if (!response.ok) throw new Error('Network response not ok');
          return response.json();
        })
        .then(data => {
          if (data && data.data && data.data.timings) {
            const t = data.data.timings;
            prayerTimings = {
              Imsak: t.Imsak ? t.Imsak.substring(0, 5) : "04:17",
              Subuh: t.Fajr ? t.Fajr.substring(0, 5) : "04:27",
              Terbit: t.Sunrise ? t.Sunrise.substring(0, 5) : "05:45",
              Dzuhur: t.Dhuhr ? t.Dhuhr.substring(0, 5) : "11:44",
              Ashar: t.Asr ? t.Asr.substring(0, 5) : "15:03",
              Maghrib: t.Maghrib ? t.Maghrib.substring(0, 5) : "17:43",
              Isya: t.Isha ? t.Isha.substring(0, 5) : "18:53"
            };

            renderTimings(prayerTimings);

            let hijriStr = '';
            if (data.data.date && data.data.date.hijri) {
              const h = data.data.date.hijri;
              hijriStr = `${h.day} ${h.month.en} ${h.year} H`;
              renderHijri(hijriStr);
            }

            // Save to cache for today
            try {
              localStorage.setItem(cacheKey, JSON.stringify({
                timings: prayerTimings,
                hijri: hijriStr
              }));
            } catch (e) {}

            updateCountdownAndClock();
          }
        })
        .catch(err => {
          console.log('Prayer API note: using cached/standard timings for Tegal.');
          renderTimings(prayerTimings);
        });

      function renderTimings(timings) {
        if (document.getElementById('time-imsak')) document.getElementById('time-imsak').innerText = timings.Imsak;
        if (document.getElementById('time-subuh')) document.getElementById('time-subuh').innerText = timings.Subuh;
        if (document.getElementById('time-terbit')) document.getElementById('time-terbit').innerText = timings.Terbit;
        if (document.getElementById('time-dzuhur')) document.getElementById('time-dzuhur').innerText = timings.Dzuhur;
        if (document.getElementById('time-ashar')) document.getElementById('time-ashar').innerText = timings.Ashar;
        if (document.getElementById('time-maghrib')) document.getElementById('time-maghrib').innerText = timings.Maghrib;
        if (document.getElementById('time-isya')) document.getElementById('time-isya').innerText = timings.Isya;
      }

      function renderHijri(hijriText) {
        const el = document.getElementById('hijri-date-topbar');
        if (el && hijriText) {
          el.innerText = hijriText;
          el.style.display = 'inline-block';
        }
      }

      function padZero(num) {
        return num < 10 ? '0' + num : num;
      }

      // 3. Realtime Ticking Clock & Dynamic Countdown Loop
      function updateCountdownAndClock() {
        const now = new Date();

        // Update Live Clock (WIB)
        const hours = padZero(now.getHours());
        const minutes = padZero(now.getMinutes());
        const seconds = padZero(now.getSeconds());
        const clockEl = document.getElementById('realtime-clock');
        if (clockEl) {
          clockEl.innerHTML = `<i class="bi bi-clock me-1"></i>${hours}:${minutes}:${seconds} WIB`;
        }

        // Calculate Next Prayer Countdown
        const prayerList = [
          { key: 'imsak', name: 'Imsak', time: prayerTimings.Imsak },
          { key: 'subuh', name: 'Subuh', time: prayerTimings.Subuh },
          { key: 'terbit', name: 'Terbit', time: prayerTimings.Terbit },
          { key: 'dzuhur', name: 'Dzuhur', time: prayerTimings.Dzuhur },
          { key: 'ashar', name: 'Ashar', time: prayerTimings.Ashar },
          { key: 'maghrib', name: 'Maghrib', time: prayerTimings.Maghrib },
          { key: 'isya', name: 'Isya', time: prayerTimings.Isya }
        ];

        let nextPrayer = null;
        let nextPrayerDate = null;

        for (let i = 0; i < prayerList.length; i++) {
          const p = prayerList[i];
          const parts = p.time.split(':');
          const pDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), parseInt(parts[0]), parseInt(parts[1]), 0);
          if (pDate > now) {
            nextPrayer = p;
            nextPrayerDate = pDate;
            break;
          }
        }

        // If all prayers today have passed, next is tomorrow's Imsak
        if (!nextPrayer) {
          const firstP = prayerList[0];
          const parts = firstP.time.split(':');
          nextPrayerDate = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, parseInt(parts[0]), parseInt(parts[1]), 0);
          nextPrayer = firstP;
        }

        // Clear active class from all pills
        document.querySelectorAll('.sholat-pill').forEach(pill => pill.classList.remove('active'));

        // Highlight the upcoming prayer pill
        if (nextPrayer) {
          const activePill = document.getElementById('pill-' + nextPrayer.key);
          if (activePill) {
            activePill.classList.add('active');
          }

          // Countdown calculation
          const diffMs = nextPrayerDate - now;
          if (diffMs > 0) {
            const diffSec = Math.floor(diffMs / 1000);
            const h = Math.floor(diffSec / 3600);
            const m = Math.floor((diffSec % 3600) / 60);
            const s = diffSec % 60;

            const timeRemaining = `${padZero(h)}:${padZero(m)}:${padZero(s)}`;
            const countdownEl = document.getElementById('next-prayer-text');
            if (countdownEl) {
              countdownEl.innerText = `Menuju ${nextPrayer.name} - ${timeRemaining}`;
            }
          }
        }
      }

      // Initial execution and start 1-second interval
      updateCountdownAndClock();
      setInterval(updateCountdownAndClock, 1000);

      // 4. Interactive Agenda Category Filter
      const filterBtns = document.querySelectorAll('.agenda-filter-btn');
      const agendaItems = document.querySelectorAll('.agenda-grid-item');

      filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          filterBtns.forEach(b => b.classList.remove('active'));
          this.classList.add('active');

          const selectedFilter = this.getAttribute('data-filter');

          agendaItems.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            if (selectedFilter === 'all' || itemCat === selectedFilter) {
              item.style.display = 'block';
              item.style.opacity = '1';
            } else {
              item.style.display = 'none';
              item.style.opacity = '0';
            }
          });
        });
      });

      // 4b. Interactive Gallery Category Filter
      const galleryFilterBtns = document.querySelectorAll('.gallery-filter-btn');
      const galleryItems = document.querySelectorAll('.gallery-item-col');

      galleryFilterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          galleryFilterBtns.forEach(b => b.classList.remove('active'));
          this.classList.add('active');

          const selectedFilter = this.getAttribute('data-filter');

          galleryItems.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            if (selectedFilter === 'all' || itemCat === selectedFilter) {
              item.style.display = 'block';
              item.style.opacity = '1';
            } else {
              item.style.display = 'none';
              item.style.opacity = '0';
            }
          });
        });
      });

    });

    // 5. Landing Page Interactive Cashflow Chart (Chart.js)
    (function() {
      function renderLandingCashflowChart() {
        const canvas = document.getElementById("landingCashflowCanvas");
        if (!canvas) return;
        if (typeof Chart === 'undefined') {
          setTimeout(renderLandingCashflowChart, 100);
          return;
        }
        if (canvas.getAttribute('data-chart-rendered') === 'true') return;
        canvas.setAttribute('data-chart-rendered', 'true');

        const ctx = canvas.getContext('2d');
        const greenGradient = ctx.createLinearGradient(0, 0, 0, 260);
        greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.40)');
        greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

        const redGradient = ctx.createLinearGradient(0, 0, 0, 260);
        redGradient.addColorStop(0, 'rgba(239, 68, 68, 0.40)');
        redGradient.addColorStop(1, 'rgba(239, 68, 68, 0.02)');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: {!! json_encode($chartMonths) !!},
            datasets: [
              {
                label: 'Pemasukan Infaq',
                data: {!! json_encode($chartPemasukan) !!},
                borderColor: '#10b981',
                backgroundColor: greenGradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#10b981',
                borderWidth: 2.5
              },
              {
                label: 'Pengeluaran Operasional',
                data: {!! json_encode($chartPengeluaran) !!},
                borderColor: '#ef4444',
                backgroundColor: redGradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#ef4444',
                borderWidth: 2.5
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              intersect: false,
              mode: 'index'
            },
            plugins: {
              legend: {
                position: 'top',
                align: 'end',
                labels: {
                  font: { family: 'Plus Jakarta Sans', size: 12 },
                  usePointStyle: true,
                  boxWidth: 8
                }
              },
              tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                padding: 12,
                titleFont: { family: 'Plus Jakarta Sans', size: 13, weight: 'bold' },
                bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                callbacks: {
                  label: function(context) {
                    let label = context.dataset.label || '';
                    if (label) label += ': ';
                    if (context.parsed.y !== null) {
                      label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                    return label;
                  }
                }
              }
            },
            scales: {
              x: {
                grid: { display: false },
                ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
              },
              y: {
                beginAtZero: true,
                ticks: {
                  font: { family: 'Plus Jakarta Sans', size: 11 },
                  color: '#64748b',
                  callback: function(value) {
                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                    return 'Rp ' + value;
                  }
                },
                grid: { color: '#f1f5f9' }
              }
            }
          }
        });
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderLandingCashflowChart);
      } else {
        renderLandingCashflowChart();
      }
      window.addEventListener('load', renderLandingCashflowChart);
    })();

    // 1-Click Copy Rekening Function
    function copyRekening(text, btnElement) {
      navigator.clipboard.writeText(text).then(() => {
        const originalHtml = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="bi bi-check2 me-1"></i> Tersalin!';
        btnElement.classList.remove('btn-outline-success');
        btnElement.classList.add('btn-success');

        setTimeout(() => {
          btnElement.innerHTML = originalHtml;
          btnElement.classList.remove('btn-success');
          btnElement.classList.add('btn-outline-success');
        }, 2200);
      }).catch(err => {
        console.error('Copy failed: ', err);
      });
    }
  </script>

</body>

</html>
