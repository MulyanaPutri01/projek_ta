<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Digital Masjid - {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $profil && $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/favicon.png') }}">

    <!-- Vendor Icons (Bootstrap Icons & Font Awesome 6) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Mode TV Display Broadcast-Grade Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/display-tv.css') }}">
</head>
<body class="{{ $settings['theme'] ?? 'theme-emerald' }}">

    <!-- Background Pattern & Ambient Lighting -->
    <div class="tv-geometric-pattern"></div>
    <div class="tv-ambient-blob-1"></div>
    <div class="tv-ambient-blob-2"></div>

    <div class="tv-display-container">

        <!-- ================= 1. TOP HEADER ================= -->
        <header class="tv-header tv-glass">
            <div class="tv-brand">
                <div class="tv-logo-icon">
                    <i class="fa-solid fa-mosque"></i>
                </div>
                <div>
                    <h1 class="tv-mosque-name">{{ $profil->nama_masjid ?? 'MASJID AL-IKHLAS' }}</h1>
                    <p class="tv-mosque-address">
                        <i class="bi bi-geo-alt-fill text-success"></i>
                        {{ $profil->alamat ?? 'Jl. Raya Masjid No. 01, Kelurahan Sejahtera' }}
                        &nbsp;•&nbsp; <i class="bi bi-compass text-warning"></i> Kiblat: <strong>{{ $weatherInfo['qibla'] }}</strong>
                    </p>
                </div>
            </div>

            <div class="tv-header-center">
                <div class="tv-calendar-pill">
                    <span class="tv-date-masehi" id="liveDateMasehi">Senin, 31 Agustus 2026</span>
                    <span class="tv-date-divider">•</span>
                    <span class="tv-date-hijri" id="liveDateHijri">18 Safar 1448 H</span>
                </div>
                <div class="tv-weather-pill mt-1">
                    <span><i class="bi bi-cloud-sun-fill text-warning me-1"></i>{{ $weatherInfo['condition'] }} {{ $weatherInfo['temp'] }}</span>
                    <span>•</span>
                    <span><i class="bi bi-droplet-half text-info me-1"></i>Kelembaban {{ $weatherInfo['humidity'] }}</span>
                    <span>•</span>
                    <span><i class="bi bi-geo text-success me-1"></i>{{ $weatherInfo['location'] }}</span>
                </div>
            </div>

            <div class="tv-header-right">
                <div class="tv-clock-box">
                    <span class="tv-clock-time" id="liveClockHoursMinutes">00:00</span>
                    <span class="tv-clock-seconds" id="liveClockSeconds">:00</span>
                    <span class="tv-clock-wib">WIB</span>
                </div>
            </div>
        </header>

        <!-- ================= 2. MAIN BODY GRID ================= -->
        <main class="tv-main-grid">

            <!-- LEFT STAGE: DYNAMIC MULTI-SLIDE CAROUSEL -->
            <section class="tv-stage-panel tv-glass">
                <div class="tv-carousel-container" id="tvCarousel">

                    <!-- SLIDE 1: AGENDA KEGIATAN & KAJIAN AKBAR -->
                    <div class="tv-slide active" data-slide-name="Agenda Kegiatan">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge">
                                <i class="bi bi-calendar2-event-fill"></i> Agenda Kegiatan & Kajian Masjid
                            </div>
                            <div class="tv-kegiatan-grid">
                                @forelse($kegiatans as $keg)
                                    <div class="tv-kegiatan-card">
                                        <div class="tv-kegiatan-datebox">
                                            <div class="tv-kegiatan-date-day">{{ \Carbon\Carbon::parse($keg->tanggal)->format('d') }}</div>
                                            <div class="tv-kegiatan-date-month">{{ \Carbon\Carbon::parse($keg->tanggal)->translatedFormat('M') }}</div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="tv-kegiatan-title">{{ $keg->nama_kegiatan }}</div>
                                            <div class="d-flex align-items-center gap-4 text-muted" style="font-size: 0.88rem;">
                                                <span><i class="bi bi-clock-fill text-warning me-1.5"></i>{{ $keg->waktu ?? '09:00 WIB' }}</span>
                                                <span><i class="bi bi-geo-alt-fill text-danger me-1.5"></i>{{ $keg->lokasi ?? 'Ruang Utama Masjid' }}</span>
                                                <span><i class="bi bi-person-check-fill text-success me-1.5"></i>Terbuka untuk Umum</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-check fs-1 text-success mb-2"></i>
                                        <h5 class="text-white">Belum ada agenda kegiatan mendatang</h5>
                                        <small class="text-muted">Jadwal kajian rutin ba'da Maghrib & Subuh tetap berjalan normal.</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 2: PETUGAS SHOLAT & KHUTBAH JUMAT -->
                    <div class="tv-slide" data-slide-name="Petugas Jumat">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge" style="background: rgba(245, 158, 11, 0.25); border-color: #f59e0b; color: #fef08a;">
                                <i class="bi bi-person-lines-fill"></i> Petugas Sholat & Khutbah Jumat Pekan Ini
                            </div>
                            <div class="tv-petugas-grid">
                                <div class="tv-petugas-card tv-petugas-khotib">
                                    <div class="tv-petugas-icon"><i class="fa-solid fa-microphone"></i></div>
                                    <div>
                                        <small class="text-warning text-uppercase fw-bold" style="font-size: 0.75rem;">Khotib Jumat</small>
                                        <h4 class="fw-bold text-white mb-0" style="font-size: 1.18rem;">{{ $petugasJumat['khotib'] }}</h4>
                                    </div>
                                </div>
                                <div class="tv-petugas-card tv-petugas-imam">
                                    <div class="tv-petugas-icon"><i class="fa-solid fa-mosque"></i></div>
                                    <div>
                                        <small class="text-success text-uppercase fw-bold" style="font-size: 0.75rem;">Imam Sholat</small>
                                        <h4 class="fw-bold text-white mb-0" style="font-size: 1.18rem;">{{ $petugasJumat['imam'] }}</h4>
                                    </div>
                                </div>
                                <div class="tv-petugas-card tv-petugas-muadzin">
                                    <div class="tv-petugas-icon"><i class="fa-solid fa-bullhorn"></i></div>
                                    <div>
                                        <small class="text-info text-uppercase fw-bold" style="font-size: 0.75rem;">Muadzin</small>
                                        <h4 class="fw-bold text-white mb-0" style="font-size: 1.18rem;">{{ $petugasJumat['muadzin'] }}</h4>
                                    </div>
                                </div>
                                <div class="tv-petugas-card tv-petugas-bilal">
                                    <div class="tv-petugas-icon"><i class="fa-solid fa-scroll"></i></div>
                                    <div>
                                        <small class="text-purple text-uppercase fw-bold" style="font-size: 0.75rem; color: #c084fc;">Bilal / Muroqi</small>
                                        <h4 class="fw-bold text-white mb-0" style="font-size: 1.18rem;">{{ $petugasJumat['bilal'] }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tv-jumat-reminder">
                                <span><i class="fa-solid fa-star-and-crescent me-2 text-warning"></i>Amalan Sunnah Jumat: Mandi sunnah, memakai wewangian, membaca Surat Al-Kahfi & memperbanyak shalawat Nabi.</span>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 3: KAS & QRIS DONASI DIGITAL -->
                    <div class="tv-slide" data-slide-name="Transparansi Kas & Donasi">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge" style="background: rgba(6, 182, 212, 0.25); border-color: #06b6d4; color: #67e8f9;">
                                <i class="bi bi-wallet2"></i> Transparansi Kas & Infaq QRIS Masjid
                            </div>
                            <div class="tv-kas-qris-container">
                                <div class="tv-kas-hero">
                                    <small class="text-white-50 text-uppercase fw-bold" style="letter-spacing: 1px;">Saldo Kas Akhir Masjid Terbuka</small>
                                    <div class="tv-kas-amount" id="displaySaldoKas">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</div>
                                    <div class="d-flex justify-content-center gap-3 mt-1 text-white-50 small">
                                        <span class="text-success"><i class="bi bi-arrow-down-circle me-1"></i>Pemasukan: <strong>Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</strong></span>
                                        <span class="text-danger"><i class="bi bi-arrow-up-circle me-1"></i>Pengeluaran: <strong>Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="mt-3 pt-2 border-top border-white border-opacity-10 text-white-50 small">
                                        <i class="bi bi-bank me-1 text-warning"></i> {{ $profil->nama_bank ?? 'Bank Syariah Indonesia' }}: <strong class="text-white">{{ $profil->nomor_rekening ?? '1234567890' }}</strong> (a.n {{ $profil->atas_nama ?? 'Takmir Masjid' }})
                                    </div>
                                </div>

                                <div class="tv-qris-card">
                                    <span class="badge bg-danger text-white fw-bold mb-1" style="font-size: 0.72rem;">QRIS RESMI MASJID</span>
                                    <div class="tv-qris-img-box">
                                        <i class="fa-solid fa-qrcode fs-1 text-dark"></i>
                                    </div>
                                    <small class="fw-bold text-dark" style="font-size: 0.72rem;">Scan via Mobile Banking / E-Wallet</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 4: GALERI DOKUMENTASI DENGAN KEN BURNS EFFECT -->
                    @if($galeris->isNotEmpty())
                    <div class="tv-slide" data-slide-name="Galeri Foto">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge">
                                <i class="bi bi-images"></i> Dokumentasi Aktivitas & Ibadah Masjid
                            </div>
                            <div class="tv-galeri-frame">
                                <img src="{{ asset('storage/' . $galeris->first()->foto) }}" class="tv-galeri-img" alt="Foto Galeri">
                                <div class="tv-galeri-caption">
                                    <h4 class="text-white fw-bold mb-1 fs-5">{{ $galeris->first()->judul }}</h4>
                                    <small class="text-white-50">{{ $galeris->first()->kegiatan?->nama_kegiatan ?? 'Kegiatan Rutin Jamaah & Pemakmuran Masjid' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- SLIDE 5: AYAT AL-QUR'AN & MUTIARA HADITS -->
                    <div class="tv-slide" data-slide-name="Mutiara Hadits">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge" style="background: rgba(245, 158, 11, 0.25); border-color: #f59e0b; color: #fef08a;">
                                <i class="bi bi-book-half"></i> Mutiara Ayat Al-Qur'an & Hadits
                            </div>
                            <div class="tv-hadits-card" id="haditsContainer">
                                <div class="tv-hadits-arabic" id="haditsArabText">{{ $haditsList[0]['arab'] }}</div>
                                <div class="tv-hadits-translation" id="haditsIndoText">"{{ $haditsList[0]['terjemah'] }}"</div>
                                <small class="text-warning fw-bold fs-6" id="haditsRiwayatText">- {{ $haditsList[0]['riwayat'] }} -</small>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 6: ADAB & TATA TERTIB MASJID -->
                    <div class="tv-slide" data-slide-name="Adab Ibadah">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div class="tv-slide-badge" style="background: rgba(16, 185, 129, 0.25); border-color: #10b981; color: #6ee7b7;">
                                <i class="bi bi-shield-check"></i> Adab & Tata Tertib Beribadah di Masjid
                            </div>
                            <div class="tv-adab-grid">
                                <div class="tv-adab-card">
                                    <div class="tv-adab-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                                    <div>
                                        <h5 class="fw-bold text-white mb-1 fs-6">Matikan Nada Dering HP</h5>
                                        <small class="text-muted">Senyapkan HP demi kekhusyukan ibadah sholat.</small>
                                    </div>
                                </div>
                                <div class="tv-adab-card">
                                    <div class="tv-adab-icon"><i class="fa-solid fa-person-praying"></i></div>
                                    <div>
                                        <h5 class="fw-bold text-white mb-1 fs-6">Rapatkan & Luruskan Shaf</h5>
                                        <small class="text-muted">Mengisi shaf kosong di baris depan terlebih dahulu.</small>
                                    </div>
                                </div>
                                <div class="tv-adab-card">
                                    <div class="tv-adab-icon"><i class="fa-solid fa-child-reaching"></i></div>
                                    <div>
                                        <h5 class="fw-bold text-white mb-1 fs-6">Dampingi Putra-Putri</h5>
                                        <small class="text-muted">Bimbing anak-anak agar tertib dan menjaga kesucian masjid.</small>
                                    </div>
                                </div>
                                <div class="tv-adab-card">
                                    <div class="tv-adab-icon"><i class="fa-solid fa-trash-can"></i></div>
                                    <div>
                                        <h5 class="fw-bold text-white mb-1 fs-6">Jaga Kebersihan Masjid</h5>
                                        <small class="text-muted">Buang sampah pada tempatnya dan hemat air wudhu.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Slide Indicator Dots -->
                <div class="tv-carousel-indicators" id="carouselIndicators">
                    <span class="tv-indicator-dot active" onclick="showSlide(0)"></span>
                    <span class="tv-indicator-dot" onclick="showSlide(1)"></span>
                    <span class="tv-indicator-dot" onclick="showSlide(2)"></span>
                    <span class="tv-indicator-dot" onclick="showSlide(3)"></span>
                    <span class="tv-indicator-dot" onclick="showSlide(4)"></span>
                    <span class="tv-indicator-dot" onclick="showSlide(5)"></span>
                </div>
            </section>

            <!-- RIGHT SIDE: 7 PRAYER SCHEDULE & NEXT COUNTDOWN -->
            <section class="tv-schedule-panel tv-glass">
                
                <!-- Hero Countdown to Next Prayer -->
                <div class="tv-next-prayer-hero">
                    <div>
                        <div class="tv-next-prayer-label"><i class="bi bi-hourglass-split me-1"></i> Menuju Waktu</div>
                        <div class="tv-next-prayer-name" id="nextPrayerName">DHUHUR</div>
                    </div>
                    <div class="tv-next-countdown" id="nextPrayerCountdown">-00:00:00</div>
                </div>

                <!-- 7 Prayer Times Stack -->
                <div class="tv-prayer-list">
                    
                    <!-- 1. IMSAK -->
                    <div class="tv-prayer-card" id="card-imsak">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-hourglass-start text-info"></i></div>
                            <span class="tv-prayer-name">Imsak</span>
                        </div>
                        <span class="tv-prayer-time" id="time-imsak">04:22</span>
                    </div>

                    <!-- 2. SUBUH -->
                    <div class="tv-prayer-card" id="card-subuh">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-cloud-moon text-info"></i></div>
                            <span class="tv-prayer-name">Subuh</span>
                        </div>
                        <span class="tv-prayer-time" id="time-subuh">04:32</span>
                    </div>

                    <!-- 3. SYURUQ / TERBIT -->
                    <div class="tv-prayer-card" id="card-syuruq">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-sun text-warning"></i></div>
                            <span class="tv-prayer-name">Syuruq</span>
                        </div>
                        <span class="tv-prayer-time" id="time-syuruq">05:48</span>
                    </div>

                    <!-- 4. DHUHA -->
                    <div class="tv-prayer-card" id="card-dhuha">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-cloud-sun text-warning"></i></div>
                            <span class="tv-prayer-name">Dhuha</span>
                        </div>
                        <span class="tv-prayer-time" id="time-dhuha">06:15</span>
                    </div>

                    <!-- 5. DZUHUR -->
                    <div class="tv-prayer-card" id="card-dzuhur">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-sun text-warning"></i></div>
                            <span class="tv-prayer-name">Dzuhur</span>
                        </div>
                        <span class="tv-prayer-time" id="time-dzuhur">11:52</span>
                    </div>

                    <!-- 6. ASHAR -->
                    <div class="tv-prayer-card" id="card-ashar">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-cloud-sun text-warning"></i></div>
                            <span class="tv-prayer-name">Ashar</span>
                        </div>
                        <span class="tv-prayer-time" id="time-ashar">15:10</span>
                    </div>

                    <!-- 7. MAGHRIB -->
                    <div class="tv-prayer-card" id="card-maghrib">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-moon text-warning"></i></div>
                            <span class="tv-prayer-name">Maghrib</span>
                        </div>
                        <span class="tv-prayer-time" id="time-maghrib">17:54</span>
                    </div>

                    <!-- 8. ISYA -->
                    <div class="tv-prayer-card" id="card-isya">
                        <div class="tv-prayer-info">
                            <div class="tv-prayer-icon-wrap"><i class="fa-solid fa-star-and-crescent text-purple" style="color: #c084fc;"></i></div>
                            <span class="tv-prayer-name">Isya</span>
                        </div>
                        <span class="tv-prayer-time" id="time-isya">19:04</span>
                    </div>

                </div>

            </section>

        </main>

        <!-- ================= 3. BOTTOM RUNNING TEXT MARQUEE ================= -->
        <footer class="tv-bottom-bar">
            <div class="tv-marquee-label">
                <i class="fa-solid fa-bullhorn"></i> PENGUMUMAN
            </div>
            <div class="tv-marquee-wrapper">
                <div class="tv-marquee-track" id="runningTextTrack">
                    {!! $runningTextHtml !!}
                </div>
            </div>
        </footer>

    </div>

    <!-- ================= FULLSCREEN OVERLAY 1: WAKTU ADZAN ================= -->
    <div class="tv-fullscreen-overlay" id="overlayAdzan">
        <div style="font-size: 5.5rem; color: #fbbf24; animation: pulse 1.5s infinite;"><i class="fa-solid fa-volume-high"></i></div>
        <div class="arabic-font fs-2 text-warning mb-2">اللهُ أَكْبَرُ اللهُ أَكْبَرُ</div>
        <h1 class="tv-alert-title" id="adzanTitleText" style="font-size: 3rem;">WAKTU ADZAN TELAH TIBA</h1>
        <p class="tv-alert-subtitle fs-5">Mari sejenak mendengarkan dan menjawab panggilan adzan, lalu bersiap sholat berjamaah.</p>
        
        <div class="p-3 px-5 rounded-4 bg-dark bg-opacity-60 border border-success border-opacity-40 text-success-light small my-3" style="max-width: 700px;">
            <div class="arabic-font fs-5 text-warning mb-1">اللَّهُمَّ رَبَّ هَذِهِ الدَّعْوَةِ التَّامَّةِ وَالصَّلَاةِ الْقَائِمَةِ آتِ مُحَمَّدًا الْوَسِيلَةَ وَالْفَضِيلَةَ</div>
            <span class="text-white-50">Doa Setelah Adzan: "Ya Allah, Pemilik seruan yang sempurna ini dan sholat yang didirikan..."</span>
        </div>

        <button type="button" class="btn btn-outline-warning btn-sm mt-2 px-4 rounded-pill" onclick="startIqomahCountdown(600)">
            Lanjut ke Hitung Mundur Iqomah &rarr;
        </button>
    </div>

    <!-- ================= FULLSCREEN OVERLAY 2: CIRCULAR GAUGE IQOMAH COUNTDOWN ================= -->
    <div class="tv-fullscreen-overlay" id="overlayIqomah">
        <h2 class="tv-alert-title" style="font-size: 2.3rem; margin-bottom: 0;">HITUNG MUNDUR IQOMAH</h2>
        <p class="text-white-50 small mt-1">Segera dirikan sholat sunnah qobliyah dan rapatkan barisan.</p>

        <!-- Circular SVG Gauge -->
        <div class="tv-iqomah-circular-wrap">
            <svg class="tv-iqomah-svg" viewBox="0 0 250 250">
                <circle class="tv-iqomah-circle-bg" cx="125" cy="125" r="110" />
                <circle class="tv-iqomah-circle-progress" id="iqomahCircleProgress" cx="125" cy="125" r="110" />
            </svg>
            <div class="tv-iqomah-center-text">
                <div class="tv-iqomah-timer-large" id="iqomahTimerDisplay">10:00</div>
                <small class="text-white-50 fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">MENIT : DETIK</small>
            </div>
        </div>

        <p class="text-warning fw-semibold fs-6">"Sholat sunnah dua rakaat sebelum Subuh/Dzuhur lebih baik dari dunia dan seisinya."</p>

        <button type="button" class="btn btn-outline-light btn-sm mt-3 px-4 rounded-pill" onclick="startShafMode()">
            Lewati ke Mode Sholat &rarr;
        </button>
    </div>

    <!-- ================= FULLSCREEN OVERLAY 3: MODE RAPATKAN SHAF (DARK FOCUS) ================= -->
    <div class="tv-fullscreen-overlay" id="overlayShaf" style="background: #01140f;">
        <div style="font-size: 6.5rem; color: #10b981; margin-bottom: 16px;"><i class="fa-solid fa-person-praying"></i></div>
        <div class="arabic-font text-warning mb-2" style="font-size: 2.8rem;">اسْتَوُوا وَاعْتَدِلُوا وَتَرَاصُّوا</div>
        <h1 class="tv-alert-title" style="font-size: 3.2rem; color: #34d399;">LURUS DAN RAPATKAN SHAF</h1>
        
        <div class="my-4 p-3 px-5 rounded-4 border border-warning text-warning fw-bold fs-4 bg-dark bg-opacity-75 shadow-lg">
            <i class="fa-solid fa-mobile-screen-button me-2"></i> MOHON NONAKTIFKAN NADA DERING HANDPHONE (HP)
        </div>
        
        <p class="tv-alert-subtitle fs-5" style="max-width: 800px;">
            "Luruskan shaf-shaf kalian, karena meluruskan dan merapatkan shaf adalah bagian dari kesempurnaan sholat berjamaah." (HR. Bukhari & Muslim)
        </p>

        <div class="d-flex gap-2 mt-3">
            <button type="button" class="btn btn-outline-info btn-sm px-4 rounded-pill" onclick="startDzikirMode()">
                Mode Dzikir Ba'da Sholat &rarr;
            </button>
            <button type="button" class="btn btn-outline-success btn-sm px-4 rounded-pill" onclick="closeOverlay()">
                Kembali ke Tampilan TV Normal
            </button>
        </div>
    </div>

    <!-- ================= FULLSCREEN OVERLAY 4: MODE DZIKIR BA'DA SHOLAT ================= -->
    <div class="tv-fullscreen-overlay" id="overlayDzikir" style="background: #031c15;">
        <div class="tv-slide-badge mb-2" style="background: rgba(245, 158, 11, 0.25); border-color: #f59e0b; color: #fef08a;">
            <i class="bi bi-heart-pulse-fill"></i> Dzikir & Doa Ba'da Sholat Berjamaah
        </div>
        <div class="p-4 rounded-4 border border-success border-opacity-30 bg-dark bg-opacity-75 my-3 text-center" style="max-width: 850px;">
            <div class="arabic-font fs-3 text-warning mb-3" id="dzikirArabText">{{ $dzikirList[0]['arab'] }}</div>
            <div class="text-white-50 fs-6" id="dzikirArtiText">"{{ $dzikirList[0]['arti'] }}"</div>
        </div>
        <button type="button" class="btn btn-outline-success btn-sm mt-3 px-4 rounded-pill" onclick="closeOverlay()">
            Selesai Dzikir & Kembali ke Beranda TV
        </button>
    </div>

    <!-- ================= SETTINGS DRAWER MODAL (Toggle with 'S' key or Button) ================= -->
    <div class="tv-settings-drawer" id="settingsDrawer">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-white mb-0"><i class="bi bi-gear-fill text-success me-2"></i>Pengaturan Broadcast TV</h6>
            <button type="button" class="btn-close btn-close-white btn-sm" onclick="toggleSettings()"></button>
        </div>

        <div class="mb-3">
            <label class="form-label text-white-50 small fw-bold">Pilih Tema Tampilan:</label>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success btn-sm flex-fill" onclick="setTheme('theme-emerald')">Emerald</button>
                <button type="button" class="btn btn-outline-info btn-sm flex-fill" onclick="setTheme('theme-navy')">Navy</button>
                <button type="button" class="btn btn-outline-warning btn-sm flex-fill" onclick="setTheme('theme-obsidian')">Obsidian</button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-white-50 small fw-bold">Durasi Jeda Iqomah:</label>
            <select id="selectIqomahDuration" class="form-select form-select-sm bg-dark text-white border-secondary">
                <option value="300">5 Menit (Maghrib)</option>
                <option value="420">7 Menit (Ashar/Isya)</option>
                <option value="600" selected>10 Menit (Dzuhur/Subuh)</option>
                <option value="900">15 Menit (Jumat)</option>
            </select>
        </div>

        <div class="border-top border-secondary pt-3 mt-3">
            <small class="text-white-50 d-block mb-2 fw-bold">Uji Simulasi Mode Layar:</small>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-warning btn-sm fw-semibold text-dark" onclick="simulateAdzan('DZUHUR')"><i class="bi bi-bell-fill me-1"></i> Uji Mode Adzan</button>
                <button type="button" class="btn btn-info btn-sm fw-semibold text-dark" onclick="simulateIqomah()"><i class="bi bi-hourglass-split me-1"></i> Uji Mode Iqomah Gauge</button>
                <button type="button" class="btn btn-success btn-sm fw-semibold" onclick="startShafMode()"><i class="bi bi-person-fill-check me-1"></i> Uji Mode Luruskan Shaf</button>
                <button type="button" class="btn btn-secondary btn-sm fw-semibold" onclick="startDzikirMode()"><i class="bi bi-book-half me-1"></i> Uji Mode Dzikir Ba'da Sholat</button>
            </div>
        </div>
    </div>

    <!-- ================= FLOATING TOOLS (Fullscreen & Simulation Controls) ================= -->
    <div class="tv-floating-tools">
        <button class="tv-btn-tool" onclick="toggleSettings()"><i class="bi bi-sliders"></i> Panel Setelan (S)</button>
        <button class="tv-btn-tool" id="btnAudioToggle" onclick="toggleAudio()"><i class="bi bi-volume-up"></i> Suara Aktif</button>
        <button class="tv-btn-tool" onclick="toggleFullscreen()"><i class="bi bi-arrows-fullscreen"></i> Fullscreen (F11)</button>
    </div>

    <!-- ================= TV DISPLAY ENGINE SCRIPT ================= -->
    <script>
        // Data Hadits & Dzikir Arrays
        const haditsArray = @json($haditsList);
        const dzikirArray = @json($dzikirList);
        let haditsIndex = 0;
        let dzikirIndex = 0;

        // Audio Tone Generator via Web Audio API (100% reliable without missing audio files)
        let audioCtx = null;
        let audioEnabled = true;

        function getAudioContext() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function playTone(freq, type, duration, delay = 0) {
            if (!audioEnabled) return;
            try {
                setTimeout(() => {
                    const ctx = getAudioContext();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = type;
                    osc.frequency.setValueAtTime(freq, ctx.currentTime);
                    gain.gain.setValueAtTime(0.35, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + duration);
                }, delay * 1000);
            } catch (e) {
                console.log('Audio autoplay prevented:', e);
            }
        }

        function playAdzanChime() {
            // Melodic Harmonic Chime
            playTone(523.25, 'sine', 1.5, 0.0);
            playTone(659.25, 'sine', 1.5, 0.35);
            playTone(783.99, 'sine', 2.0, 0.7);
            playTone(1046.50, 'sine', 3.0, 1.1);
        }

        function playIqomahBeep() {
            // Rapid Iqomah Alert Beep
            playTone(880, 'triangle', 0.3, 0.0);
            playTone(880, 'triangle', 0.3, 0.2);
            playTone(1174, 'triangle', 0.8, 0.4);
        }

        function toggleAudio() {
            audioEnabled = !audioEnabled;
            getAudioContext();
            document.getElementById('btnAudioToggle').innerHTML = audioEnabled 
                ? '<i class="bi bi-volume-up"></i> Suara Aktif' 
                : '<i class="bi bi-volume-mute"></i> Suara Senyap';
        }

        // Realtime Digital Clock & Dual Calendar (Masehi & Hijri)
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('liveClockHoursMinutes').innerText = `${hours}:${minutes}`;
            document.getElementById('liveClockSeconds').innerText = `:${seconds}`;

            // Masehi Date
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('liveDateMasehi').innerText = now.toLocaleDateString('id-ID', options);

            // Hijri Date
            try {
                const hijriFormatter = new Intl.DateTimeFormat('id-ID-u-ca-islamic', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('liveDateHijri').innerText = hijriFormatter.format(now) + ' H';
            } catch (e) {
                document.getElementById('liveDateHijri').innerText = '18 Safar 1448 H';
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 8 Prayer Schedule Definition
        const prayerSchedule = {
            imsak: '04:22',
            subuh: '04:32',
            syuruq: '05:48',
            dhuha: '06:15',
            dzuhur: '11:52',
            ashar: '15:10',
            maghrib: '17:54',
            isya: '19:04'
        };

        function updatePrayerTimesUI() {
            document.getElementById('time-imsak').innerText = prayerSchedule.imsak;
            document.getElementById('time-subuh').innerText = prayerSchedule.subuh;
            document.getElementById('time-syuruq').innerText = prayerSchedule.syuruq;
            document.getElementById('time-dhuha').innerText = prayerSchedule.dhuha;
            document.getElementById('time-dzuhur').innerText = prayerSchedule.dzuhur;
            document.getElementById('time-ashar').innerText = prayerSchedule.ashar;
            document.getElementById('time-maghrib').innerText = prayerSchedule.maghrib;
            document.getElementById('time-isya').innerText = prayerSchedule.isya;
        }
        updatePrayerTimesUI();

        // Realtime Countdown to Next Prayer & Active Badge Glow
        function updateNextPrayerCountdown() {
            const now = new Date();
            const currentMinutes = now.getHours() * 60 + now.getMinutes();
            const currentSeconds = now.getSeconds();
            const currentTimeInSec = currentMinutes * 60 + currentSeconds;

            const prayers = [
                { name: 'IMSAK', time: prayerSchedule.imsak, cardId: 'card-imsak' },
                { name: 'SUBUH', time: prayerSchedule.subuh, cardId: 'card-subuh' },
                { name: 'SYURUQ', time: prayerSchedule.syuruq, cardId: 'card-syuruq' },
                { name: 'DHUHA', time: prayerSchedule.dhuha, cardId: 'card-dhuha' },
                { name: 'DZUHUR', time: prayerSchedule.dzuhur, cardId: 'card-dzuhur' },
                { name: 'ASHAR', time: prayerSchedule.ashar, cardId: 'card-ashar' },
                { name: 'MAGHRIB', time: prayerSchedule.maghrib, cardId: 'card-maghrib' },
                { name: 'ISYA', time: prayerSchedule.isya, cardId: 'card-isya' },
            ];

            let nextPrayer = null;
            let targetSeconds = 0;

            for (let p of prayers) {
                const parts = p.time.split(':');
                const pSec = (parseInt(parts[0]) * 60 + parseInt(parts[1])) * 60;
                if (pSec > currentTimeInSec) {
                    nextPrayer = p;
                    targetSeconds = pSec;
                    break;
                }
            }

            if (!nextPrayer) {
                nextPrayer = prayers[0];
                const parts = prayers[0].time.split(':');
                targetSeconds = (24 * 60 + (parseInt(parts[0]) * 60 + parseInt(parts[1]))) * 60;
            }

            // Remove all active cards, then set current next
            prayers.forEach(p => {
                const el = document.getElementById(p.cardId);
                if (el) el.classList.remove('active');
            });
            const activeCard = document.getElementById(nextPrayer.cardId);
            if (activeCard) activeCard.classList.add('active');

            // Countdown calculation
            const diff = targetSeconds - currentTimeInSec;
            const diffHours = Math.floor(diff / 3600);
            const diffMins = Math.floor((diff % 3600) / 60);
            const diffSecs = diff % 60;

            const formattedTime = `-${String(diffHours).padStart(2, '0')}:${String(diffMins).padStart(2, '0')}:${String(diffSecs).padStart(2, '0')}`;
            document.getElementById('nextPrayerName').innerText = nextPrayer.name;
            document.getElementById('nextPrayerCountdown').innerText = formattedTime;

            // Trigger Adzan when exact time hits 0
            if (diff === 0 && nextPrayer.name !== 'SYURUQ' && nextPrayer.name !== 'IMSAK' && nextPrayer.name !== 'DHUHA') {
                triggerAdzan(nextPrayer.name);
            }
        }
        setInterval(updateNextPrayerCountdown, 1000);
        updateNextPrayerCountdown();

        // Auto-Carousel Engine (Rotates every 8 seconds)
        let currentSlide = 0;
        const slides = document.querySelectorAll('.tv-slide');
        const dots = document.querySelectorAll('.tv-indicator-dot');
        let carouselInterval = null;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));

            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');

            // Rotate Hadits if Hadits slide is active
            if (currentSlide === 4 && haditsArray.length > 0) {
                haditsIndex = (haditsIndex + 1) % haditsArray.length;
                document.getElementById('haditsArabText').innerText = haditsArray[haditsIndex].arab;
                document.getElementById('haditsIndoText').innerText = `"${haditsArray[haditsIndex].terjemah}"`;
                document.getElementById('haditsRiwayatText').innerText = `- ${haditsArray[haditsIndex].riwayat} -`;
            }
        }

        const slideIntervalDuration = {{ ($settings['slide_interval'] ?? 8) * 1000 }};
        function startCarousel() {
            if (carouselInterval) clearInterval(carouselInterval);
            carouselInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, slideIntervalDuration);
        }
        startCarousel();

        // Adzan, Circular Iqomah & Shaf Overlay Engine
        let iqomahCountdownInterval = null;
        const CIRCLE_CIRCUMFERENCE = 2 * Math.PI * 110; // ~691.15

        function triggerAdzan(prayerName) {
            document.getElementById('adzanTitleText').innerText = `WAKTU ADZAN ${prayerName} TELAH TIBA`;
            document.getElementById('overlayAdzan').classList.add('active');
            playAdzanChime();

            // Auto-advance to Iqomah after 3 minutes
            setTimeout(() => {
                if (document.getElementById('overlayAdzan').classList.contains('active')) {
                    const dur = parseInt(document.getElementById('selectIqomahDuration').value) || 600;
                    startIqomahCountdown(dur);
                }
            }, 180000);
        }

        function simulateAdzan(name = 'DZUHUR') {
            getAudioContext();
            triggerAdzan(name);
        }

        function simulateIqomah() {
            getAudioContext();
            const dur = parseInt(document.getElementById('selectIqomahDuration').value) || 600;
            startIqomahCountdown(dur);
        }

        function startIqomahCountdown(totalDurationSec = 600) {
            document.getElementById('overlayAdzan').classList.remove('active');
            document.getElementById('overlayShaf').classList.remove('active');
            document.getElementById('overlayDzikir').classList.remove('active');
            document.getElementById('overlayIqomah').classList.add('active');

            let timeLeft = totalDurationSec;
            if (iqomahCountdownInterval) clearInterval(iqomahCountdownInterval);

            const circleProgress = document.getElementById('iqomahCircleProgress');
            circleProgress.style.strokeDasharray = CIRCLE_CIRCUMFERENCE;

            iqomahCountdownInterval = setInterval(() => {
                timeLeft--;
                const mins = Math.floor(timeLeft / 60);
                const secs = timeLeft % 60;
                document.getElementById('iqomahTimerDisplay').innerText = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

                // Calculate Circle Gauge Progress
                const fraction = timeLeft / totalDurationSec;
                const offset = CIRCLE_CIRCUMFERENCE * (1 - fraction);
                circleProgress.style.strokeDashoffset = offset;

                // Color shift when reaching final minute
                if (timeLeft <= 60) {
                    circleProgress.style.stroke = '#ef4444';
                    document.getElementById('iqomahTimerDisplay').style.color = '#ef4444';
                } else if (timeLeft <= 180) {
                    circleProgress.style.stroke = '#f59e0b';
                    document.getElementById('iqomahTimerDisplay').style.color = '#f59e0b';
                } else {
                    circleProgress.style.stroke = '#10b981';
                    document.getElementById('iqomahTimerDisplay').style.color = '#34d399';
                }

                if (timeLeft <= 5 && timeLeft > 0) {
                    playIqomahBeep();
                }

                if (timeLeft <= 0) {
                    clearInterval(iqomahCountdownInterval);
                    playIqomahBeep();
                    startShafMode();
                }
            }, 1000);
        }

        function startShafMode() {
            if (iqomahCountdownInterval) clearInterval(iqomahCountdownInterval);
            document.getElementById('overlayAdzan').classList.remove('active');
            document.getElementById('overlayIqomah').classList.remove('active');
            document.getElementById('overlayDzikir').classList.remove('active');
            document.getElementById('overlayShaf').classList.add('active');

            // Auto advance to Dzikir after 10 minutes of prayer
            setTimeout(() => {
                if (document.getElementById('overlayShaf').classList.contains('active')) {
                    startDzikirMode();
                }
            }, 600000);
        }

        function startDzikirMode() {
            document.getElementById('overlayShaf').classList.remove('active');
            document.getElementById('overlayDzikir').classList.add('active');

            if (dzikirArray.length > 0) {
                dzikirIndex = 0;
                document.getElementById('dzikirArabText').innerText = dzikirArray[0].arab;
                document.getElementById('dzikirArtiText').innerText = `"${dzikirArray[0].arti}"`;
            }
        }

        function closeOverlay() {
            if (iqomahCountdownInterval) clearInterval(iqomahCountdownInterval);
            document.getElementById('overlayAdzan').classList.remove('active');
            document.getElementById('overlayIqomah').classList.remove('active');
            document.getElementById('overlayShaf').classList.remove('active');
            document.getElementById('overlayDzikir').classList.remove('active');
            startCarousel();
        }

        // Settings Drawer & Theme Switcher
        function toggleSettings() {
            const drawer = document.getElementById('settingsDrawer');
            drawer.classList.toggle('active');
        }

        function setTheme(themeName) {
            document.body.className = themeName;
            toggleSettings();
        }

        // Keyboard Shortcut: 'S' for Settings, 'F' for Fullscreen
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === 's') {
                toggleSettings();
            } else if (e.key.toLowerCase() === 'f') {
                toggleFullscreen();
            }
        });

        // Fullscreen Toggle
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    alert(`Error full-screen mode: ${err.message}`);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Background Live Sync (Updates Kas balance & activities every 60s)
        function syncDisplayData() {
            fetch("{{ route('display.api') }}")
                .then(res => res.json())
                .then(data => {
                    if (data && data.saldo_formatted) {
                        const el = document.getElementById('displaySaldoKas');
                        if (el) el.innerText = data.saldo_formatted;
                    }
                })
                .catch(err => console.log('Sync offline:', err));
        }
        setInterval(syncDisplayData, 60000);
    </script>
</body>
</html>
