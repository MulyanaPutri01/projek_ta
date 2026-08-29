@section('title', 'Edit Jadwal Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Edit Jadwal Kegiatan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Jadwal Kegiatan</a></li>
                    <li class="breadcrumb-item active">Edit Agenda</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Jadwal
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" id="formEditKegiatan">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: FORM INPUTS ================= -->
                <div class="col-xl-8 col-lg-7">
                    
                    <!-- 1. INFORMASI UTAMA ACARA -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-calendar-event fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Informasi Agenda Acara</h6>
                                <small class="text-muted">Nama kegiatan, lokasi masjid, dan sasaran peserta</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Nama Kegiatan -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Nama Agenda Kegiatan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-bookmark-star"></i></span>
                                        <input type="text" name="nama_kegiatan" id="input_nama_kegiatan" class="form-control" 
                                            value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required maxlength="150" autocomplete="off">
                                    </div>
                                    <!-- Preset Chips -->
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Contoh Cepat:</small>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Kajian Rutin Ahad Pagi">Kajian Ahad Pagi</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Sholat Jumat & Khutbah">Sholat Jumat & Khutbah</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Peringatan Maulid Nabi Muhammad SAW">Maulid Nabi</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Kajian Muslimah Bulanan">Kajian Muslimah</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Buka Puasa Sunnah Bersama">Buka Bersama</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Khotmil Qur'an & Doa Bersama">Khotmil Qur'an</span>
                                    </div>
                                </div>

                                <!-- Lokasi / Tempat -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Lokasi / Tempat Pelaksanaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-geo-alt"></i></span>
                                        <input type="text" name="tempat" id="input_tempat" class="form-control" 
                                            value="{{ old('tempat', $kegiatan->tempat) }}" required maxlength="100">
                                    </div>
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Pilihan:</small>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-place-chip" data-place="Ruang Utama Masjid Al-Ikhlas">Ruang Utama</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-place-chip" data-place="Serambi / Teras Masjid">Serambi Masjid</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-place-chip" data-place="Aula Serbaguna Masjid">Aula Masjid</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-place-chip" data-place="Halaman Utama Masjid">Halaman Luar</span>
                                    </div>
                                </div>

                                <!-- Target Peserta / Audience -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Sasaran Peserta / Jamaah</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-people"></i></span>
                                        <input type="text" name="audience" id="input_audience" class="form-control" 
                                            value="{{ old('audience', $kegiatan->audience) }}" maxlength="100">
                                    </div>
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Pilihan:</small>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-aud-chip" data-aud="Jamaah Umum">Jamaah Umum</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-aud-chip" data-aud="Remaja Masjid (IRMA)">Remaja Masjid</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-aud-chip" data-aud="Ibu-ibu Pengajian">Ibu-ibu Pengajian</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-aud-chip" data-aud="Santri TPQ & Anak-anak">Santri TPQ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. WAKTU & JADWAL PELAKSANAAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-clock-history fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Waktu & Jadwal Pelaksanaan</h6>
                                <small class="text-muted">Tanggal, jam mulai s/d selesai, dan waktu sholat terkait</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Tanggal -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                                        <input type="date" name="tanggal" id="input_tanggal" class="form-control" 
                                            value="{{ old('tanggal', \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="mt-2 d-flex gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="0" style="font-size: 0.72rem;">Hari Ini</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="1" style="font-size: 0.72rem;">Besok</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="7" style="font-size: 0.72rem;">+7 Hari</button>
                                    </div>
                                </div>

                                <!-- Waktu Mulai -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark">Waktu Mulai <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-clock"></i></span>
                                        <input type="time" name="mulai_kegiatan" id="input_mulai" class="form-control" 
                                            value="{{ old('mulai_kegiatan', \Carbon\Carbon::parse($kegiatan->mulai_kegiatan)->format('H:i')) }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Format 24 Jam (WIB)</small>
                                </div>

                                <!-- Waktu Selesai -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark">Waktu Selesai <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-clock-fill"></i></span>
                                        <input type="time" name="akhir_kegiatan" id="input_akhir" class="form-control" 
                                            value="{{ old('akhir_kegiatan', \Carbon\Carbon::parse($kegiatan->akhir_kegiatan)->format('H:i')) }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Atau perkiraan selesai</small>
                                </div>

                                <!-- Periode / Waktu Sholat -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Periode / Waktu Sholat Terkait</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-sun"></i></span>
                                        <input type="text" name="nama_waktu" id="input_nama_waktu" class="form-control" 
                                            placeholder="Contoh: Ba'da Isya, Pagi Hari, atau Sholat Jumat" 
                                            value="{{ old('nama_waktu', $kegiatan->nama_waktu) }}" maxlength="50">
                                    </div>
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Pilihan:</small>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Ba'da Subuh">Ba'da Subuh</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Pagi Hari (08.00)">Pagi Hari</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Ba'da Dzuhur">Ba'da Dzuhur</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Ba'da Ashar">Ba'da Ashar</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Ba'da Maghrib">Ba'da Maghrib</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-time-chip" data-time="Ba'da Isya">Ba'da Isya</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. UPLOAD BROSUR / FOTO KEGIATAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-image fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Brosur / Pamflet / Foto Kegiatan</h6>
                                <small class="text-muted">Ganti atau unggah brosur resmi kegiatan</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    @php
                                        $hasExistingFoto = !empty($kegiatan->foto) && file_exists(public_path('storage/' . $kegiatan->foto));
                                    @endphp

                                    <div class="border-2 border-dashed rounded-4 p-4 text-center bg-light position-relative" id="dropzone_container" style="border: 2px dashed #cbd5e1;">
                                        <input type="file" name="foto" id="input_foto" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/*">
                                        
                                        <div id="dropzone_placeholder" class="{{ $hasExistingFoto ? 'd-none' : '' }}">
                                            <div class="rounded-circle bg-white shadow-sm p-3 d-inline-flex align-items-center justify-content-center mb-2 text-primary">
                                                <i class="bi bi-cloud-arrow-up fs-2"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-1">Klik atau Tarik File Brosur Baru ke Sini</h6>
                                            <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maksimal 3 MB)</small>
                                            <span class="btn btn-sm btn-outline-primary px-3 rounded-pill"><i class="bi bi-folder2-open me-1"></i> Pilih Gambar</span>
                                        </div>

                                        <div id="dropzone_preview" class="{{ $hasExistingFoto ? '' : 'd-none' }}">
                                            <div class="position-relative d-inline-block">
                                                <img id="img_preview" src="{{ $hasExistingFoto ? asset('storage/' . $kegiatan->foto) : '' }}" alt="Pratinjau Brosur" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 200px; object-fit: contain;">
                                                <button type="button" id="btn_remove_foto" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 translate-middle shadow" title="Hapus Foto">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <span id="file_name_display" class="fw-semibold text-dark small">{{ $hasExistingFoto ? basename($kegiatan->foto) : '' }}</span>
                                                <small id="file_size_display" class="text-muted d-block" style="font-size: 0.72rem;">{{ $hasExistingFoto ? 'Brosur saat ini tersimpan' : '' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. PENCERAMAH & PETUGAS -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning-emphasis p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-person-video3 fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Petugas, Penceramah, & Khotib</h6>
                                <small class="text-muted">Daftar narasumber atau petugas sholat berjamaah</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Penceramah / Pemateri -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Penceramah / Narasumber / Ustadz</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-mic"></i></span>
                                        <input type="text" name="pembicara" id="input_pembicara" class="form-control" 
                                            value="{{ old('pembicara', $kegiatan->pembicara) }}" maxlength="100">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Sertakan gelar atau asal daerah narasumber jika ada.</small>
                                </div>

                                <!-- Khotib -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Nama Khotib (Khusus Jumat/Hari Raya)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="nama_khotib" id="input_khotib" class="form-control" 
                                            value="{{ old('nama_khotib', $kegiatan->nama_khotib) }}" maxlength="100">
                                    </div>
                                </div>

                                <!-- Muadzin -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Nama Muadzin / Bilal</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-soundwave"></i></span>
                                        <input type="text" name="nama_muadzin" id="input_muadzin" class="form-control" 
                                            value="{{ old('nama_muadzin', $kegiatan->nama_muadzin) }}" maxlength="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Jadwal
                        </button>
                    </div>

                </div>

                <!-- ================= RIGHT COLUMN: LIVE DIGITAL EVENT FLYER PREVIEW ================= -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-top" style="top: 85px; z-index: 10;">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
                                <i class="bi bi-ticket-perforated me-1"></i> Pratinjau Brosur Digital
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Live Flyer</span>
                        </div>

                        <!-- Flyer Card Preview -->
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-3" style="background: #ffffff;">
                            
                            <!-- Uploaded Flyer Image (If Exists) -->
                            <div id="flyer_img_container" class="position-relative {{ $hasExistingFoto ? '' : 'd-none' }}" style="max-height: 220px; overflow: hidden; background: #1e293b;">
                                <img id="preview_flyer_img" src="{{ $hasExistingFoto ? asset('storage/' . $kegiatan->foto) : '' }}" alt="Flyer Brosur" class="w-100" style="height: 220px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 small"><i class="bi bi-image me-1"></i> Brosur Resmi</span>
                                </div>
                            </div>

                            <!-- Top Decorative Banner (Shown when no image) -->
                            <div id="flyer_default_header" class="p-4 text-center text-white position-relative {{ $hasExistingFoto ? 'd-none' : '' }}" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                                <div class="position-absolute top-0 end-0 p-3 opacity-20">
                                    <i class="bi bi-calendar-week" style="font-size: 4rem;"></i>
                                </div>
                                <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill text-uppercase mb-2 shadow-sm" style="font-size: 0.7rem;">
                                    AGENDA KEGIATAN MASJID
                                </span>
                                <h5 class="fw-extrabold mb-0 text-white">MASJID AL-IKHLAS</h5>
                                <small class="text-white-75" style="font-size: 0.75rem;">Karangmulya, Suradadi, Tegal</small>
                            </div>

                            <!-- Event Details -->
                            <div class="card-body p-4">
                                <!-- Date Badge Banner -->
                                <div class="bg-light border rounded-3 p-3 text-center mb-3">
                                    <div class="small text-uppercase fw-bold text-success" id="preview_day_name" style="font-size: 0.75rem;">HARI PELAKSANAAN</div>
                                    <h4 class="fw-bold text-dark mb-0" id="preview_date_text">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}</h4>
                                </div>

                                <!-- Title -->
                                <h5 class="fw-bold text-dark mb-3 line-clamp-2" id="preview_title">{{ $kegiatan->nama_kegiatan }}</h5>

                                <!-- Info List -->
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-clock-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Waktu & Jam Acara</small>
                                            <span class="fw-semibold text-dark small" id="preview_time">
                                                {{ \Carbon\Carbon::parse($kegiatan->mulai_kegiatan)->format('H:i') }} - {{ \Carbon\Carbon::parse($kegiatan->akhir_kegiatan)->format('H:i') }} WIB
                                                @if($kegiatan->nama_waktu) ({{ $kegiatan->nama_waktu }}) @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-geo-alt-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Tempat / Lokasi</small>
                                            <span class="fw-semibold text-dark small" id="preview_place">{{ $kegiatan->tempat }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2" id="preview_speaker_box">
                                        <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-mic-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Penceramah / Khotib</small>
                                            <span class="fw-semibold text-dark small" id="preview_speaker">
                                                {{ $kegiatan->pembicara ?: ($kegiatan->nama_khotib ? 'Khotib: ' . $kegiatan->nama_khotib : 'Terbuka / Belum Ditentukan') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-people-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Sasaran Jamaah</small>
                                            <span class="fw-semibold text-dark small" id="preview_aud">{{ $kegiatan->audience ?: 'Jamaah Umum' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2.5 rounded-3 bg-success-subtle text-success border border-success-subtle text-center small fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Terbuka Untuk Umum • Gratis
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top text-center py-2 text-muted" style="font-size: 0.72rem;">
                                <i class="bi bi-info-circle me-1"></i> SIMAS Masjid Al-Ikhlas Karangmulya
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layouts.footer')

<style>
    .cursor-pointer { cursor: pointer; }
    .cursor-pointer:hover { opacity: 0.85; transform: scale(1.02); }
    .transition-all { transition: all 0.2s ease-in-out; }
    .preset-title-chip, .preset-place-chip, .preset-aud-chip, .preset-time-chip {
        transition: all 0.15s ease;
    }
    .preset-title-chip:hover, .preset-place-chip:hover, .preset-aud-chip:hover, .preset-time-chip:hover {
        background-color: #065f46 !important;
        color: #ffffff !important;
        border-color: #065f46 !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputTitle = document.getElementById('input_nama_kegiatan');
        const inputPlace = document.getElementById('input_tempat');
        const inputAud = document.getElementById('input_audience');
        const inputDate = document.getElementById('input_tanggal');
        const inputStart = document.getElementById('input_mulai');
        const inputEnd = document.getElementById('input_akhir');
        const inputTimeName = document.getElementById('input_nama_waktu');
        const inputSpeaker = document.getElementById('input_pembicara');
        const inputKhotib = document.getElementById('input_khotib');

        const previewTitle = document.getElementById('preview_title');
        const previewPlace = document.getElementById('preview_place');
        const previewAud = document.getElementById('preview_aud');
        const previewDateText = document.getElementById('preview_date_text');
        const previewDayName = document.getElementById('preview_day_name');
        const previewTime = document.getElementById('preview_time');
        const previewSpeaker = document.getElementById('preview_speaker');

        // File Upload Elements
        const inputFoto = document.getElementById('input_foto');
        const dropzonePlaceholder = document.getElementById('dropzone_placeholder');
        const dropzonePreview = document.getElementById('dropzone_preview');
        const imgPreview = document.getElementById('img_preview');
        const btnRemoveFoto = document.getElementById('btn_remove_foto');
        const fileNameDisplay = document.getElementById('file_name_display');
        const fileSizeDisplay = document.getElementById('file_size_display');
        const flyerImgContainer = document.getElementById('flyer_img_container');
        const previewFlyerImg = document.getElementById('preview_flyer_img');
        const flyerDefaultHeader = document.getElementById('flyer_default_header');

        // Month Names in ID
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        function updateDatePreview() {
            if (!inputDate.value) return;
            const d = new Date(inputDate.value + 'T00:00:00');
            if (!isNaN(d.getTime())) {
                const day = hariIndo[d.getDay()];
                const date = d.getDate();
                const month = bulanIndo[d.getMonth()];
                const year = d.getFullYear();
                previewDayName.textContent = day;
                previewDateText.textContent = `${date} ${month} ${year}`;
            }
        }

        function updateTimePreview() {
            const start = inputStart.value || '08:00';
            const end = inputEnd.value || '10:00';
            const period = inputTimeName.value ? ` (${inputTimeName.value})` : '';
            previewTime.textContent = `${start} - ${end} WIB${period}`;
        }

        function updateSpeakerPreview() {
            const speaker = inputSpeaker.value.trim();
            const khotib = inputKhotib.value.trim();
            if (speaker && khotib) {
                previewSpeaker.textContent = `${speaker} (Khotib: ${khotib})`;
            } else if (speaker) {
                previewSpeaker.textContent = speaker;
            } else if (khotib) {
                previewSpeaker.textContent = `Khotib: ${khotib}`;
            } else {
                previewSpeaker.textContent = 'Terbuka / Belum Ditentukan';
            }
        }

        // Live input listeners
        inputTitle.addEventListener('input', function() {
            previewTitle.textContent = this.value.trim() || 'Nama Agenda Kegiatan';
        });

        inputPlace.addEventListener('input', function() {
            previewPlace.textContent = this.value.trim() || 'Ruang Utama Masjid Al-Ikhlas';
        });

        inputAud.addEventListener('input', function() {
            previewAud.textContent = this.value.trim() || 'Jamaah Umum';
        });

        inputDate.addEventListener('change', updateDatePreview);
        inputStart.addEventListener('input', updateTimePreview);
        inputEnd.addEventListener('input', updateTimePreview);
        inputTimeName.addEventListener('input', updateTimePreview);
        inputSpeaker.addEventListener('input', updateSpeakerPreview);
        inputKhotib.addEventListener('input', updateSpeakerPreview);

        // Photo Upload Handling & Live Preview
        inputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    previewFlyerImg.src = e.target.result;
                    
                    dropzonePlaceholder.classList.add('d-none');
                    dropzonePreview.classList.remove('d-none');
                    
                    flyerImgContainer.classList.remove('d-none');
                    flyerDefaultHeader.classList.add('d-none');

                    fileNameDisplay.textContent = file.name;
                    fileSizeDisplay.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                };
                reader.readAsDataURL(file);
            }
        });

        btnRemoveFoto.addEventListener('click', function(e) {
            e.stopPropagation();
            inputFoto.value = '';
            imgPreview.src = '';
            previewFlyerImg.src = '';
            
            dropzonePreview.classList.add('d-none');
            dropzonePlaceholder.classList.remove('d-none');
            
            flyerImgContainer.classList.add('d-none');
            flyerDefaultHeader.classList.remove('d-none');
        });

        // Preset Chips Handlers
        document.querySelectorAll('.preset-title-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputTitle.value = this.getAttribute('data-title');
                inputTitle.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.preset-place-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputPlace.value = this.getAttribute('data-place');
                inputPlace.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.preset-aud-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputAud.value = this.getAttribute('data-aud');
                inputAud.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.preset-time-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputTimeName.value = this.getAttribute('data-time');
                inputTimeName.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.quick-date').forEach(btn => {
            btn.addEventListener('click', function() {
                const days = parseInt(this.getAttribute('data-days'));
                const target = new Date();
                target.setDate(target.getDate() + days);
                const yyyy = target.getFullYear();
                const mm = String(target.getMonth() + 1).padStart(2, '0');
                const dd = String(target.getDate()).padStart(2, '0');
                inputDate.value = `${yyyy}-${mm}-${dd}`;
                updateDatePreview();
            });
        });

        // Initialize preview
        updateDatePreview();
        updateTimePreview();
        updateSpeakerPreview();
    });
</script>
