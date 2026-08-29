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
    <section id="kegiatan" class="services section bg-light py-5">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">AGENDA MASJID</span>
        <h2 class="fw-bold">Jadwal & Agenda Kegiatan</h2>
        <p class="text-muted">Ikuti berbagai kegiatan dakwah, kajian keislaman, dan kemasyarakatan di {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}.</p>
      </div>

      <div class="container">
        <div class="row gy-4">
          @forelse($kegiatans as $keg)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative p-4 rounded-4 bg-white shadow-sm h-100">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="badge bg-primary rounded-pill px-3 py-2"><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($keg->tanggal)->translatedFormat('d M Y') }}</span>
                <span class="badge bg-secondary">{{ substr($keg->mulai_kegiatan, 0, 5) }} - {{ substr($keg->akhir_kegiatan, 0, 5) }} WIB</span>
              </div>
              <h4 class="fs-5 fw-bold text-dark mb-2">{{ $keg->nama_kegiatan }}</h4>
              <p class="mb-2 text-muted small"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $keg->tempat }}</p>
              @if($keg->pembicara)
                <p class="mb-0 text-muted small"><i class="bi bi-person-circle text-primary me-1"></i> Penceramah: <strong>{{ $keg->pembicara }}</strong></p>
              @elseif($keg->nama_khotib)
                <p class="mb-0 text-muted small"><i class="bi bi-person-circle text-primary me-1"></i> Khotib: <strong>{{ $keg->nama_khotib }}</strong></p>
              @endif
            </div>
          </div>
          @empty
          <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
            <p>Belum ada agenda kegiatan yang dijadwalkan saat ini.</p>
          </div>
          @endforelse
        </div>
        <div class="text-center mt-4">
          <a href="{{ route('kegiatan.calendar') }}" class="btn btn-success px-4 py-2 rounded-pill shadow-sm"><i class="bi bi-calendar3 me-1"></i> Buka Kalender Kegiatan Lengkap</a>
        </div>
      </div>
    </section><!-- /Kegiatan Section -->

    <!-- Keuangan Section -->
    <section id="keuangan" class="departments section py-5">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">TRANSPARANSI KAS</span>
        <h2 class="fw-bold">Laporan Keuangan Masjid</h2>
        <p class="text-muted">Ringkasan real-time arus kas pemasukan infaq, pengeluaran, dan saldo kas {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-3 justify-content-center text-center mb-4">
          <div class="col-lg-4 col-md-6">
            <div class="card p-4 shadow-sm border-0 bg-white rounded-4 h-100">
              <div class="rounded-circle bg-success-light text-success mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-box-arrow-in-down fs-2"></i>
              </div>
              <h6 class="text-muted mb-1">Total Pemasukan (Infaq/Donasi)</h6>
              <h3 class="text-success fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="card p-4 shadow-sm border-0 bg-white rounded-4 h-100">
              <div class="rounded-circle bg-danger-light text-danger mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-box-arrow-up fs-2"></i>
              </div>
              <h6 class="text-muted mb-1">Total Pengeluaran</h6>
              <h3 class="text-danger fw-bold mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="card p-4 shadow-sm border-0 bg-white rounded-4 h-100">
              <div class="rounded-circle bg-primary-light text-primary mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-wallet2 fs-2"></i>
              </div>
              <h6 class="text-muted mb-1">Total Saldo Kas Saat Ini</h6>
              <h3 class="text-primary fw-bold mb-0">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>5 Transaksi Terkini</h5>
            @if($keuangan->isEmpty())
              <div class="alert alert-info text-center" role="alert">
                Belum ada catatan transaksi keuangan.
              </div>
            @else
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0">
                  <thead class="table-light text-center">
                    <tr>
                      <th style="width: 50px;">No</th>
                      <th>Tanggal</th>
                      <th>Sumber / Keterangan</th>
                      <th>Donatur / Kegiatan</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($keuangan as $item)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                      <td>
                        <strong>{{ $item->sumber_keuangan }}</strong>
                        @if($item->keterangan)<br><small class="text-muted">{{ $item->keterangan }}</small>@endif
                      </td>
                      <td>
                        @if($item->donatur)
                          <span class="badge bg-info">{{ $item->donatur->nama_donatur }}</span>
                        @elseif($item->kegiatan)
                          <span class="badge bg-secondary">{{ $item->kegiatan->nama_kegiatan }}</span>
                        @else
                          -
                        @endif
                      </td>
                      <td class="text-end text-success fw-bold">
                        {{ $item->kategori_id == 1 ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                      </td>
                      <td class="text-end text-danger fw-bold">
                        {{ $item->kategori_id == 2 ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section><!-- /Keuangan Section -->

    <!-- Gallery Section -->
    <section id="galeri" class="gallery section bg-light py-5">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">DOKUMENTASI</span>
        <h2 class="fw-bold">Galeri Foto Masjid</h2>
        <p class="text-muted">Dokumentasi kegiatan ibadah, kajian, dan sarana di {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-3 justify-content-center">
          @forelse($galeri as $item)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="gallery-item rounded-4 shadow-sm bg-white p-2">
              <a href="{{ asset('storage/' . $item->gambar) }}" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid w-100 rounded-3" alt="{{ $item->nama_foto }}" style="height: 200px; object-fit: cover;">
              </a>
              <div class="p-2 text-center">
                <small class="fw-semibold text-dark d-block text-truncate">{{ $item->nama_foto }}</small>
                <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</small>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 text-center text-muted py-4">
            <p>Belum ada foto dokumentasi di galeri.</p>
          </div>
          @endforelse
        </div>
      </div>
    </section><!-- /Gallery Section -->

    <!-- Pengurus Takmir Section -->
    <section id="pengurus" class="doctors section py-5">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">STRUKTUR KEPENGURUSAN</span>
        <h2 class="fw-bold">Pengurus Takmir Masjid</h2>
        <p class="text-muted">Jajaran pengurus yang berkhidmat melayani jamaah dan kemakmuran {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          @forelse($pengurusList as $pengurus)
          <div class="col-lg-4 col-md-6">
            <div class="member d-flex align-items-center p-3 rounded-4 bg-white shadow-sm border h-100">
              <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold fs-4 flex-shrink-0 shadow-sm me-3" style="width: 58px; height: 58px;">
                {{ strtoupper(substr($pengurus->nama_takmir, 0, 1)) }}
              </div>
              <div class="member-info">
                <h5 class="fw-bold mb-1 fs-6 text-dark">{{ $pengurus->nama_takmir }}</h5>
                <span class="badge bg-success-light text-success fw-semibold">{{ ucfirst($pengurus->role->nama_role ?? 'Pengurus Takmir') }}</span>
                <p class="mb-0 text-muted small mt-1"><i class="bi bi-shield-check text-success me-1"></i>Status: <span class="text-success fw-semibold">Aktif</span></p>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 text-center text-muted py-4">
            <p>Data pengurus takmir belum ditambahkan.</p>
          </div>
          @endforelse
        </div>
      </div>
    </section><!-- /Pengurus Section -->

    <!-- Contact Section -->
    <section id="kontak" class="contact section py-5">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="badge bg-success-light text-success fw-bold px-3 py-2 mb-2 rounded-pill">LOKASI & KONTAK</span>
        <h2 class="fw-bold">Hubungi Kami</h2>
        <p class="text-muted">Kunjungi atau hubungi Takmir {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="mb-4 shadow-sm rounded-4 overflow-hidden">
          <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3032.4361612730095!2d109.23886407356817!3d-6.922493993077196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fc7acd5292c5f%3A0xb89abf11b3f0d3d0!2sMasjid%20Al%20Ikhlas%20Dk%20Simendot!5e1!3m2!1sen!2sid!4v1776051556955!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="row gy-3">
          <div class="col-lg-4">
            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white shadow-sm border" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt fs-2 text-success me-3"></i>
              <div>
                <h6 class="fw-bold mb-1">Alamat</h6>
                <p class="mb-0 text-muted small">{{ $profil->alamat ?? 'Karangmulya, Kec. Suradadi, Kabupaten Tegal, Jawa Tengah 52182' }}</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white shadow-sm border" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-whatsapp fs-2 text-success me-3"></i>
              <div>
                <h6 class="fw-bold mb-1">Telepon / WhatsApp</h6>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '081234567890') }}" target="_blank" class="mb-0 text-success fw-semibold small text-decoration-none d-flex align-items-center gap-1">
                  {{ $profil->telepon ?? '0812-3456-7890' }} <i class="bi bi-box-arrow-up-right" style="font-size: 0.75rem;"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white shadow-sm border" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-person-badge fs-2 text-success me-3"></i>
              <div>
                <h6 class="fw-bold mb-1">Pengurus Takmir</h6>
                <p class="mb-0 text-muted small">Takmir {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer bg-dark text-white py-4">
    <div class="container text-center">
      <p class="mb-1 text-white">© Copyright <strong><span>{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</span></strong>. All Rights Reserved.</p>
      <small class="text-white-50">Sistem Informasi Manajemen Masjid (SIMAS) Dukuh Semendot, Karangmulya, Tegal</small>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets-landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets-landing/vendor/swiper/swiper-bundle.min.js') }}"></script>

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
    });
  </script>

</body>

</html>
