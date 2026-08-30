@section('title', 'Edit Foto Galeri')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Edit Foto Dokumentasi</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri Dokumentasi</a></li>
                    <li class="breadcrumb-item active">Edit Foto</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('galeri.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Galeri
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" id="formEditGaleri">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: FORM INPUTS ================= -->
                <div class="col-xl-8 col-lg-7">
                    
                    <!-- 1. INFORMASI FOTO & AGENDA -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-card-heading fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Judul Foto & Agenda Kegiatan</h6>
                                <small class="text-muted">Nama dokumentasi foto dan agenda acara yang bersangkutan</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Judul Foto -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Judul / Nama Foto Dokumentasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-camera"></i></span>
                                        <input type="text" name="nama_foto" id="input_nama_foto" class="form-control" 
                                            value="{{ old('nama_foto', $galeri->nama_foto) }}" required maxlength="100" autocomplete="off">
                                    </div>
                                    <!-- Preset Chips -->
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Contoh Cepat:</small>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Suasana Khidmat Sholat Jumat Berjamaah">Sholat Jumat</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Kajian Akbar Ahad Pagi Bersama Jamaah">Kajian Ahad Pagi</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Peringatan Maulid Nabi Muhammad SAW">Maulid Nabi</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Buka Puasa Sunnah & Doa Bersama">Buka Bersama</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Kerja Bakti & Bersih-Bersih Masjid">Kerja Bakti Masjid</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Santunan Anak Yatim & Dhuafa">Santunan Yatim</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-title-chip" data-title="Kegiatan Belajar Santri TPQ Masjid">Santri TPQ</span>
                                    </div>
                                </div>

                                <!-- Agenda Terkait -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Agenda Kegiatan Terkait <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-event"></i></span>
                                        <select name="kegiatan_id" id="select_kegiatan" class="form-select" required>
                                            @foreach($kegiatans as $kegiatan)
                                                <option value="{{ $kegiatan->id }}" 
                                                    data-nama="{{ $kegiatan->nama_kegiatan }}"
                                                    data-tanggal="{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}"
                                                    {{ (old('kegiatan_id', $galeri->kegiatan_id) == $kegiatan->id) ? 'selected' : '' }}>
                                                    {{ $kegiatan->nama_kegiatan }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. UPLOAD FILE FOTO -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-image fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Ganti Foto Dokumentasi</h6>
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto yang sudah ada</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    @php
                                        $hasExistingFoto = !empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar));
                                    @endphp

                                    <div class="border-2 border-dashed rounded-4 p-4 text-center bg-light position-relative" id="dropzone_container" style="border: 2px dashed #cbd5e1;">
                                        <input type="file" name="gambar" id="input_gambar" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/*">
                                        
                                        <div id="dropzone_placeholder" class="{{ $hasExistingFoto ? 'd-none' : '' }}">
                                            <div class="rounded-circle bg-white shadow-sm p-3 d-inline-flex align-items-center justify-content-center mb-2 text-success">
                                                <i class="bi bi-cloud-arrow-up fs-2"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-1">Klik atau Tarik File Foto Dokumentasi Baru ke Sini</h6>
                                            <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maksimal 3 MB)</small>
                                            <span class="btn btn-sm btn-outline-success px-3 rounded-pill"><i class="bi bi-folder2-open me-1"></i> Pilih Foto Baru</span>
                                        </div>

                                        <div id="dropzone_preview" class="{{ $hasExistingFoto ? '' : 'd-none' }}">
                                            <div class="position-relative d-inline-block">
                                                <img id="img_preview" src="{{ $hasExistingFoto ? asset('storage/' . $galeri->gambar) : '' }}" alt="Pratinjau Foto" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 220px; object-fit: contain;">
                                                <button type="button" id="btn_remove_foto" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 translate-middle shadow" title="Ganti Foto">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <span id="file_name_display" class="fw-semibold text-dark small">{{ $hasExistingFoto ? basename($galeri->gambar) : '' }}</span>
                                                <small id="file_size_display" class="text-muted d-block" style="font-size: 0.72rem;">{{ $hasExistingFoto ? 'Foto saat ini tersimpan' : '' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. TANGGAL & PENGUNGGAH -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning-emphasis p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-calendar-check fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Tanggal Pengambilan & Pengunggah</h6>
                                <small class="text-muted">Waktu dokumentasi diambil dan identitas takmir pengunggah</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Tanggal -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Tanggal Dokumentasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-date"></i></span>
                                        <input type="date" name="tanggal" id="input_tanggal" class="form-control" 
                                            value="{{ old('tanggal', \Carbon\Carbon::parse($galeri->tanggal)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="mt-2 d-flex gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="0" style="font-size: 0.72rem;">Hari Ini</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="-1" style="font-size: 0.72rem;">Kemarin</button>
                                    </div>
                                </div>

                                <!-- Pengunggah -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Diupload Oleh</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control bg-light" 
                                            value="{{ $galeri->takmir?->nama_takmir ?? (Auth::user()?->nama_takmir ?? 'Pengurus Takmir') }}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <a href="{{ route('galeri.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Foto
                        </button>
                    </div>

                </div>

                <!-- ================= RIGHT COLUMN: LIVE DIGITAL GALLERY PHOTO CARD PREVIEW ================= -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-top" style="top: 85px; z-index: 10;">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
                                <i class="bi bi-eye me-1"></i> Pratinjau Foto Galeri
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Live Photo Card</span>
                        </div>

                        <!-- Gallery Card Preview -->
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-3" style="background: #ffffff;">
                            
                            <!-- Photo Container with Image / Placeholder -->
                            <div id="gallery_img_wrapper" class="position-relative" style="height: 220px; background: #1e293b; overflow: hidden;">
                                <img id="preview_gallery_img" src="{{ $hasExistingFoto ? asset('storage/' . $galeri->gambar) : '' }}" alt="Pratinjau Foto" class="w-100 h-100 {{ $hasExistingFoto ? '' : 'd-none' }}" style="object-fit: cover;">
                                
                                <div id="gallery_placeholder_box" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white-50 p-4 text-center {{ $hasExistingFoto ? 'd-none' : '' }}">
                                    <i class="bi bi-camera fs-1 mb-2"></i>
                                    <span class="small">Belum Ada Foto Dipilih</span>
                                </div>

                                <!-- Overlay Badges -->
                                <div class="position-absolute top-0 start-0 p-3">
                                    <span class="badge bg-success shadow-sm px-2.5 py-1.5" id="preview_agenda_badge">
                                        <i class="bi bi-calendar-event me-1"></i> {{ $galeri->kegiatan?->nama_kegiatan ?? 'Agenda Kegiatan' }}
                                    </span>
                                </div>

                                <div class="position-absolute bottom-0 end-0 p-3">
                                    <span class="badge bg-dark bg-opacity-75 text-white shadow-sm px-2 py-1 small" id="preview_date_badge">
                                        {{ \Carbon\Carbon::parse($galeri->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body Content -->
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <small class="text-muted d-block" style="font-size: 0.68rem;">JUDUL DOKUMENTASI</small>
                                    <h5 class="fw-bold text-dark mb-0 line-clamp-2" id="preview_title">{{ $galeri->nama_foto }}</h5>
                                </div>

                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-calendar2-week-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Tanggal Dokumentasi</small>
                                            <span class="fw-semibold text-dark small" id="preview_tanggal_text">{{ \Carbon\Carbon::parse($galeri->tanggal)->translatedFormat('l, d F Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-person-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Diupload Oleh</small>
                                            <span class="fw-semibold text-dark small">{{ $galeri->takmir?->nama_takmir ?? (Auth::user()?->nama_takmir ?? 'Pengurus Takmir') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2.5 rounded-3 bg-light border text-center small text-muted">
                                    <i class="bi bi-globe me-1 text-primary"></i> Ditampilkan di Publik & Landing Page Masjid
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top text-center py-2 text-muted" style="font-size: 0.72rem;">
                                <i class="bi bi-check-circle-fill text-success me-1"></i> SIMAS Galeri Dokumentasi Masjid Al-Ikhlas
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
    .preset-title-chip {
        transition: all 0.15s ease;
    }
    .preset-title-chip:hover {
        background-color: #065f46 !important;
        color: #ffffff !important;
        border-color: #065f46 !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputNamaFoto = document.getElementById('input_nama_foto');
        const selectKegiatan = document.getElementById('select_kegiatan');
        const inputTanggal = document.getElementById('input_tanggal');
        
        const previewTitle = document.getElementById('preview_title');
        const previewAgendaBadge = document.getElementById('preview_agenda_badge');
        const previewDateBadge = document.getElementById('preview_date_badge');
        const previewTanggalText = document.getElementById('preview_tanggal_text');
        
        // File Upload Elements
        const inputGambar = document.getElementById('input_gambar');
        const dropzonePlaceholder = document.getElementById('dropzone_placeholder');
        const dropzonePreview = document.getElementById('dropzone_preview');
        const imgPreview = document.getElementById('img_preview');
        const btnRemoveFoto = document.getElementById('btn_remove_foto');
        const fileNameDisplay = document.getElementById('file_name_display');
        const fileSizeDisplay = document.getElementById('file_size_display');
        const previewGalleryImg = document.getElementById('preview_gallery_img');
        const galleryPlaceholderBox = document.getElementById('gallery_placeholder_box');

        // Month & Day Names
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const bulanIndoShort = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Live input title
        inputNamaFoto.addEventListener('input', function() {
            previewTitle.textContent = this.value.trim() || '{{ $galeri->nama_foto }}';
        });

        // Live select kegiatan
        selectKegiatan.addEventListener('change', function() {
            const selected = selectKegiatan.options[selectKegiatan.selectedIndex];
            if (selected && selected.value) {
                previewAgendaBadge.innerHTML = `<i class="bi bi-calendar-event me-1"></i> ${selected.getAttribute('data-nama')}`;
            }
        });

        // Live date input
        function updateDatePreview() {
            if (!inputTanggal.value) return;
            const d = new Date(inputTanggal.value + 'T00:00:00');
            if (!isNaN(d.getTime())) {
                const day = hariIndo[d.getDay()];
                const date = d.getDate();
                const month = bulanIndo[d.getMonth()];
                const monthShort = bulanIndoShort[d.getMonth()];
                const year = d.getFullYear();
                previewDateBadge.textContent = `${date} ${monthShort} ${year}`;
                previewTanggalText.textContent = `${day}, ${date} ${month} ${year}`;
            }
        }
        inputTanggal.addEventListener('change', updateDatePreview);
        updateDatePreview();

        // Image file preview
        inputGambar.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    previewGalleryImg.src = e.target.result;
                    
                    dropzonePlaceholder.classList.add('d-none');
                    dropzonePreview.classList.remove('d-none');
                    
                    previewGalleryImg.classList.remove('d-none');
                    galleryPlaceholderBox.classList.add('d-none');

                    fileNameDisplay.textContent = file.name;
                    fileSizeDisplay.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                };
                reader.readAsDataURL(file);
            }
        });

        btnRemoveFoto.addEventListener('click', function(e) {
            e.stopPropagation();
            inputGambar.value = '';
            imgPreview.src = '';
            previewGalleryImg.src = '';
            
            dropzonePreview.classList.add('d-none');
            dropzonePlaceholder.classList.remove('d-none');
            
            previewGalleryImg.classList.add('d-none');
            galleryPlaceholderBox.classList.remove('d-none');
        });

        // Preset Chips Handlers
        document.querySelectorAll('.preset-title-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputNamaFoto.value = this.getAttribute('data-title');
                inputNamaFoto.dispatchEvent(new Event('input'));
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
                inputTanggal.value = `${yyyy}-${mm}-${dd}`;
                updateDatePreview();
            });
        });
    });
</script>
