@section('title', 'Pengaturan Smart TV Digital Signage')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">
                <i class="bi bi-tv text-success me-2"></i>Pengaturan Smart TV Digital Signage
            </h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Smart TV Signage</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('display.index') }}" target="_blank" class="btn btn-success rounded-pill shadow-sm px-3 fw-semibold">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Layar Smart TV
            </a>
        </div>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.display.update') }}" method="POST">
            @csrf

            <div class="row g-4">

                <!-- Left Column: Form Controls -->
                <div class="col-lg-8">

                    <!-- Card 1: Petugas Khutbah & Sholat Jumat -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                            <i class="bi bi-person-lines-fill text-warning fs-5"></i>
                            <h5 class="fw-bold text-dark mb-0">1. Petugas Sholat & Khutbah Jumat Pekan Ini</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-4">
                                Data ini akan otomatis ditampilkan pada slide khusus <strong>Petugas Jumat</strong> di Smart TV Display masjid.
                            </p>

                            <div class="row g-3">
                                <!-- Khotib Jumat -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fa-solid fa-microphone text-warning me-1"></i> Khotib Jumat
                                    </label>
                                    <input type="text" name="khotib" class="form-control" 
                                           value="{{ old('khotib', $settings['petugas_jumat']['khotib'] ?? '') }}" 
                                           placeholder="Contoh: Ustadz H. Ahmad Fauzi, Lc." required>
                                </div>

                                <!-- Imam Sholat -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fa-solid fa-mosque text-success me-1"></i> Imam Sholat
                                    </label>
                                    <input type="text" name="imam" class="form-control" 
                                           value="{{ old('imam', $settings['petugas_jumat']['imam'] ?? '') }}" 
                                           placeholder="Contoh: Ustadz M. Syarifuddin, S.Pd.I" required>
                                </div>

                                <!-- Muadzin -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fa-solid fa-bullhorn text-info me-1"></i> Muadzin
                                    </label>
                                    <input type="text" name="muadzin" class="form-control" 
                                           value="{{ old('muadzin', $settings['petugas_jumat']['muadzin'] ?? '') }}" 
                                           placeholder="Contoh: Ustadz Bilal Ramadhan" required>
                                </div>

                                <!-- Bilal / Muroqi -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fa-solid fa-scroll text-purple me-1" style="color: #a855f7;"></i> Bilal / Muroqi
                                    </label>
                                    <input type="text" name="bilal" class="form-control" 
                                           value="{{ old('bilal', $settings['petugas_jumat']['bilal'] ?? '') }}" 
                                           placeholder="Contoh: Ustadz Ridwan Al-Hafidz" required>
                                </div>

                                <!-- Tema Khutbah -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="bi bi-bookmark-star text-warning me-1"></i> Tema / Judul Khutbah Jumat
                                    </label>
                                    <input type="text" name="tema_khutbah" class="form-control" 
                                           value="{{ old('tema_khutbah', $settings['petugas_jumat']['tema'] ?? 'Menjaga Keikhlasan & Kemakmuran Masjid') }}" 
                                           placeholder="Contoh: Menjaga Keikhlasan & Kemakmuran Masjid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Running Text Ticker Pengumuman (Summernote Rich Editor) -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-badge-ad text-success fs-5"></i>
                                <h5 class="fw-bold text-dark mb-0">2. Papan Teks Berjalan (Running Text Ticker)</h5>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill small">
                                <i class="bi bi-pencil-square me-1"></i> Summernote Editor
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <label class="form-label fw-semibold text-dark mb-1">
                                Kelola Pesan Berjalan di Layar TV (Mendukung Teks Tebal, Warna, Poin, & Paragraf):
                            </label>
                            <p class="text-muted small mb-3">
                                Setiap paragraf `<p>` atau poin `<li>` yang Anda buat di bawah ini akan otomatis berjalan secara horizontal di bagian bawah layar Smart TV dan dipisahkan dengan tanda bintang pemisah (✦).
                            </p>

                            <!-- Quick Template Snippet Buttons -->
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill" onclick="appendTemplate('welcome')">
                                    <i class="bi bi-plus-circle me-1"></i> + Sambutan Masjid
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="appendTemplate('infaq')">
                                    <i class="bi bi-plus-circle me-1"></i> + Info Donasi & Bank
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm rounded-pill" onclick="appendTemplate('hp')">
                                    <i class="bi bi-plus-circle me-1"></i> + Himbauan Silent HP
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="appendTemplate('hadits')">
                                    <i class="bi bi-plus-circle me-1"></i> + Kutipan Hadits
                                </button>
                            </div>

                            @php
                                $runningTextContent = $settings['running_texts_html'] ?? '';
                                if (empty($runningTextContent) && !empty($settings['running_texts'])) {
                                    $runningTextContent = '<p>' . implode('</p><p>', $settings['running_texts']) . '</p>';
                                }
                            @endphp

                            <div class="summernote-wrapper">
                                <textarea name="running_texts_html" class="summernote" id="summernote_running_text">{{ old('running_texts_html', $runningTextContent) }}</textarea>
                            </div>

                            <small class="text-muted d-block mt-2">
                                💡 <em>Informasi laporan saldo kas real-time dan agenda dakwah terdekat otomatis disinkronkan oleh sistem ke dalam running text.</em>
                            </small>
                        </div>
                    </div>

                    <!-- Card 3: Durasi Jeda Iqomah per Sholat -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                            <i class="bi bi-hourglass-split text-info fs-5"></i>
                            <h5 class="fw-bold text-dark mb-0">3. Durasi Jeda Hitung Mundur Iqomah (Menit)</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">
                                Tentukan berapa menit waktu sholat sunnah qobliyah sebelum adzan beralih ke iqomah dan sholat berjamaah.
                            </p>
                            <div class="row g-3">
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Subuh</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_subuh" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_subuh', $settings['iqomah_duration']['subuh'] ?? 10) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Dzuhur</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_dzuhur" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_dzuhur', $settings['iqomah_duration']['dzuhur'] ?? 10) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Ashar</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_ashar" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_ashar', $settings['iqomah_duration']['ashar'] ?? 8) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Maghrib</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_maghrib" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_maghrib', $settings['iqomah_duration']['maghrib'] ?? 7) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Isya</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_isya" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_isya', $settings['iqomah_duration']['isya'] ?? 10) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="form-label small fw-bold text-dark">Jumat (Shubuh/Jumat)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="iqomah_jumat" class="form-control text-center fw-bold" min="1" max="30" value="{{ old('iqomah_jumat', $settings['iqomah_duration']['jumat'] ?? 15) }}">
                                        <span class="input-group-text">Menit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Theme & Actions -->
                <div class="col-lg-4">

                    <!-- Theme & Appearance -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                            <i class="bi bi-palette text-primary fs-5"></i>
                            <h5 class="fw-bold text-dark mb-0">Tema & Tampilan</h5>
                        </div>
                        <div class="card-body p-4">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Tema Warna Display TV:</label>
                                <div class="d-flex flex-column gap-2">
                                    <label class="d-flex align-items-center gap-2 p-2.5 rounded border cursor-pointer {{ ($settings['theme'] ?? 'theme-emerald') === 'theme-emerald' ? 'border-success bg-success bg-opacity-10' : '' }}">
                                        <input type="radio" name="theme" value="theme-emerald" {{ ($settings['theme'] ?? 'theme-emerald') === 'theme-emerald' ? 'checked' : '' }}>
                                        <div>
                                            <strong class="d-block text-dark">🌿 Emerald Zamrud</strong>
                                            <small class="text-muted">Khas masjid nan teduh & elegan</small>
                                        </div>
                                    </label>

                                    <label class="d-flex align-items-center gap-2 p-2.5 rounded border cursor-pointer {{ ($settings['theme'] ?? '') === 'theme-navy' ? 'border-info bg-info bg-opacity-10' : '' }}">
                                        <input type="radio" name="theme" value="theme-navy" {{ ($settings['theme'] ?? '') === 'theme-navy' ? 'checked' : '' }}>
                                        <div>
                                            <strong class="d-block text-dark">🌊 Royal Midnight Navy</strong>
                                            <small class="text-muted">Biru sapphire modern & kontras tinggi</small>
                                        </div>
                                    </label>

                                    <label class="d-flex align-items-center gap-2 p-2.5 rounded border cursor-pointer {{ ($settings['theme'] ?? '') === 'theme-obsidian' ? 'border-warning bg-warning bg-opacity-10' : '' }}">
                                        <input type="radio" name="theme" value="theme-obsidian" {{ ($settings['theme'] ?? '') === 'theme-obsidian' ? 'checked' : '' }}>
                                        <div>
                                            <strong class="d-block text-dark">👑 Obsidian Black Gold</strong>
                                            <small class="text-muted">Hitam arang eksklusif beraksen emas</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Kecepatan Rotasi Slide:</label>
                                <div class="input-group">
                                    <input type="number" name="slide_interval" class="form-control" min="4" max="60" value="{{ old('slide_interval', $settings['slide_interval'] ?? 8) }}" required>
                                    <span class="input-group-text">Detik</span>
                                </div>
                                <small class="text-muted">Waktu tayang setiap poster/slide sebelum berganti.</small>
                            </div>

                        </div>
                    </div>

                    <!-- Save Actions Card -->
                    <div class="card border-0 shadow-sm p-3">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold mb-2">
                                <i class="bi bi-save me-1"></i> Simpan Pengaturan
                            </button>
                            <a href="{{ route('display.index') }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill fw-semibold">
                                <i class="bi bi-tv me-1"></i> Pratinjau Layar TV
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
</main>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery !== 'undefined' && typeof $.fn.summernote !== 'undefined') {
            initSummernote();
        } else {
            window.addEventListener('load', initSummernote);
        }

        function initSummernote() {
            $('#summernote_running_text').summernote({
                placeholder: 'Ketik teks pengumuman di sini... Contoh: Selamat datang di Masjid Al-Ikhlas • Harap senyapkan nada dering HP.',
                tabsize: 2,
                height: 180,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }
    });

    // Helper functions to append snippet templates into Summernote
    function appendTemplate(type) {
        let snippet = '';
        if (type === 'welcome') {
            snippet = '<p>Selamat datang di <strong>{{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</strong> • Mari makmurkan rumah Allah dengan shalat berjamaah dan menjaga ketertiban.</p>';
        } else if (type === 'infaq') {
            snippet = '<p>Infaq &amp; Sedekah Pembangunan: <strong>{{ $profil->nama_bank ?? 'Bank Syariah Indonesia' }}</strong> No. Rek: <strong>{{ $profil->nomor_rekening ?? '1234567890' }}</strong> a.n {{ $profil->atas_nama ?? 'Takmir Masjid' }} (Scan QRIS pada layar slide).</p>';
        } else if (type === 'hp') {
            snippet = '<p>Peringatan Ibadah: Harap <strong>menonaktifkan atau mengubah mode senyap</strong> pada nada dering handphone (HP) saat berada di ruang utama sholat.</p>';
        } else if (type === 'hadits') {
            snippet = '<p>Mutiara Hadits: <em>"Shalat berjamaah lebih utama daripada shalat sendirian dengan selisih dua puluh tujuh derajat."</em> (HR. Bukhari &amp; Muslim)</p>';
        }

        if (typeof $ !== 'undefined' && $('#summernote_running_text').length) {
            const currentCode = $('#summernote_running_text').summernote('code');
            $('#summernote_running_text').summernote('code', currentCode + snippet);
        }
    }
</script>
