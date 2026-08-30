@section('title', 'Profil Masjid')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Profil Masjid</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil Masjid</li>
                </ol>
            </nav>
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

        <div class="row g-4">
            <!-- Left Side: Mosque Summary Badge Card -->
            <div class="col-xl-4 col-lg-5 col-12">
                <div class="card border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <div class="position-relative rounded-4 overflow-hidden mb-3 shadow-sm border" style="max-height: 190px;">
                            <img id="sideBgPreview" src="{{ $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/hero-bg.jpg') }}" class="w-100 h-100 object-fit-cover" style="height: 180px; object-fit: cover;" alt="Hero Background Masjid">
                            <span class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white small">
                                <i class="bi bi-image me-1"></i> Background Hero
                            </span>
                        </div>

                        <h4 class="fw-bold text-dark mb-1">{{ $profil->nama_masjid }}</h4>
                        <span class="badge bg-success-light text-success mb-3 px-3 py-1 rounded-pill">
                            <i class="bi bi-shield-check me-1"></i> Sistem Profil Resmi
                        </span>

                        <hr class="my-3">

                        <div class="text-start">
                            <div class="mb-3">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-1">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Alamat:
                                </span>
                                <p class="text-dark small mb-0">{{ $profil->alamat }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-1">
                                    <i class="bi bi-telephone-fill text-success me-1"></i> Telepon / WhatsApp:
                                </span>
                                <p class="text-dark small mb-0">{{ $profil->telepon ?? '-' }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-1">
                                    <i class="bi bi-bank2 text-primary me-1"></i> Rekening Donasi / Infaq:
                                </span>
                                <div class="bg-light p-2 rounded-2 border">
                                    <small class="text-primary fw-bold d-block">{{ $profil->nama_bank ?? 'BANK SYARIAH INDONESIA (BSI)' }}</small>
                                    <strong class="text-dark">{{ $profil->nomor_rekening ?? '7145-8890-2101' }}</strong>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">A.n: {{ $profil->atas_nama ?? 'Takmir Masjid Jami Al-Ikhlas' }}</small>
                                </div>
                            </div>

                            <div class="mb-0">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-1">
                                    <i class="bi bi-person-check-fill text-primary me-1"></i> Diperbarui Oleh:
                                </span>
                                <p class="text-dark small mb-0">
                                    {{ $profil->takmir ? $profil->takmir->nama_takmir : 'Administrator' }}
                                    <span class="text-muted d-block small">{{ $profil->updated_at ? $profil->updated_at->diffForHumans() : '-' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Profile Tabs (Overview & Edit with Summernote) -->
            <div class="col-xl-8 col-lg-7 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#profile-overview" type="button" role="tab">
                                    <i class="bi bi-card-text me-1"></i> Ringkasan Profil
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#profile-edit" type="button" role="tab">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Profil, Rekening & Background
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">

                            <!-- Tab 1: Ringkasan Profil (Overview) -->
                            <div class="tab-pane fade show active" id="profile-overview" role="tabpanel">
                                <h5 class="card-title text-dark fw-bold pb-2 fs-5">Informasi Umum</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 text-muted fw-bold small">Nama Masjid</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold text-dark">{{ $profil->nama_masjid }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 text-muted fw-bold small">Nomor Telepon</div>
                                    <div class="col-lg-9 col-md-8 text-dark">{{ $profil->telepon ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 text-muted fw-bold small">Alamat Lengkap</div>
                                    <div class="col-lg-9 col-md-8 text-dark">{{ $profil->alamat }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 text-muted fw-bold small">Foto Background Hero</div>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="border rounded-3 p-1 bg-light d-inline-block" style="max-width: 280px;">
                                            <img src="{{ $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/hero-bg.jpg') }}" class="img-fluid rounded-2" style="max-height: 130px; object-fit: cover;" alt="Hero Background">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="card-title text-dark fw-bold pt-3 pb-2 fs-5">Rekening Bank & Infaq Digital (Landing Page)</h5>
                                <div class="p-3 bg-light rounded-3 mb-3 border">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Nama Bank:</small>
                                            <strong class="text-dark">{{ $profil->nama_bank ?? 'BANK SYARIAH INDONESIA (BSI)' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Nomor Rekening:</small>
                                            <strong class="text-success fs-6">{{ $profil->nomor_rekening ?? '7145-8890-2101' }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Atas Nama Rekening:</small>
                                            <span class="text-dark fw-semibold">{{ $profil->atas_nama ?? 'Takmir Masjid Jami Al-Ikhlas' }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Judul Banner Infaq:</small>
                                            <span class="text-dark fw-semibold">{{ $profil->judul_infaq ?? 'Salurkan Infaq Terbaik Anda' }}</span>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted d-block">Deskripsi Ajakan Infaq:</small>
                                            <p class="mb-0 text-muted small">{{ $profil->deskripsi_infaq ?? 'Dukung kemakmuran masjid, kegiatan dakwah, santunan yatim, dan pemeliharaan fasilitas masjid.' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="card-title text-dark fw-bold pt-2 pb-2 fs-5"><i class="bi bi-clock-history text-success me-1"></i> Sejarah Masjid</h5>
                                <div class="p-4 bg-white rounded-3 mb-4 border shadow-sm summernote-content" style="line-height: 1.8;">
                                    {!! $profil->sejarah ?? '<p class="text-muted">Belum ada catatan sejarah masjid.</p>' !!}
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-3 h-100 border" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-color: #bbf7d0 !important;">
                                            <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom border-success border-opacity-25">
                                                <div class="rounded-circle bg-success text-white p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">
                                                    <i class="bi bi-compass fs-6"></i>
                                                </div>
                                                <h6 class="fw-bold text-success mb-0">Visi Masjid</h6>
                                            </div>
                                            <div class="summernote-content text-dark small">
                                                {!! $profil->visi ?? '<p class="text-muted">Belum ada visi.</p>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-4 rounded-3 h-100 border" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #bfdbfe !important;">
                                            <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom border-primary border-opacity-25">
                                                <div class="rounded-circle bg-primary text-white p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">
                                                    <i class="bi bi-bullseye fs-6"></i>
                                                </div>
                                                <h6 class="fw-bold text-primary mb-0">Misi Masjid</h6>
                                            </div>
                                            <div class="summernote-content text-dark small">
                                                {!! $profil->misi ?? '<p class="text-muted">Belum ada misi.</p>' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Edit Profil Masjid Form with Summernote -->
                            <div class="tab-pane fade" id="profile-edit" role="tabpanel">
                                <form action="{{ route('profilmasjid.update', $profil->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 pt-2">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-12">
                                        <h6 class="fw-bold text-primary mb-0 border-bottom pb-2"><i class="bi bi-info-circle me-1"></i> 1. Identitas & Kontak Masjid</h6>
                                    </div>

                                    <div class="col-md-7">
                                        <label class="form-label fw-bold small">Nama Masjid <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                            <input type="text" name="nama_masjid" class="form-control" value="{{ old('nama_masjid', $profil->nama_masjid) }}" required maxlength="100">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label fw-bold small">Nomor Telepon / WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}" placeholder="08123456789" maxlength="20">
                                        </div>
                                    </div>

                                    <!-- Upload Foto / Background Hero Utama -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Foto Background Hero Halaman Utama Website</label>
                                        <div class="d-flex align-items-center gap-3 flex-wrap p-3 bg-light rounded-3 border">
                                            <div class="border rounded-3 p-1 bg-white text-center shadow-sm" style="width: 150px; height: 95px;">
                                                <img id="bgPreview" src="{{ $profil->foto_masjid ? asset('storage/' . $profil->foto_masjid) : asset('assets-landing/img/hero-bg.jpg') }}" class="w-100 h-100 rounded-2" style="object-fit: cover;" alt="Preview Background">
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="file" name="foto_masjid" id="fotoMasjidInput" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/webp">
                                                <small class="text-muted d-block mt-1">
                                                    <i class="bi bi-info-circle me-1"></i>Pilih foto bangunan masjid atau pemandangan untuk dijadikan background tampilan hero landing page (Format: JPG, PNG, WEBP, Maks. 5MB).
                                                </small>
                                                @if($profil->foto_masjid)
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" name="hapus_foto" value="1" id="hapusFotoCheck">
                                                        <label class="form-check-label small text-danger fw-semibold" for="hapusFotoCheck">
                                                            <i class="bi bi-trash me-1"></i>Hapus background kustom & gunakan gambar default
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Alamat Lengkap Masjid <span class="text-danger">*</span></label>
                                        <textarea name="alamat" class="form-control" rows="2" required placeholder="Dukuh, Desa, Kecamatan, Kabupaten...">{{ old('alamat', $profil->alamat) }}</textarea>
                                    </div>

                                    <!-- Section 2: Rekening & Infaq Digital -->
                                    <div class="col-12 mt-4">
                                        <h6 class="fw-bold text-success mb-0 border-bottom pb-2"><i class="bi bi-bank me-1"></i> 2. Rekening Bank & Informasi Infaq Digital</h6>
                                        <small class="text-muted">Data ini ditampilkan pada kartu Infaq / Shodaqoh di halaman publik Landing Page.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Nama Bank</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-bank2"></i></span>
                                            <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $profil->nama_bank ?? 'BANK SYARIAH INDONESIA (BSI)') }}" placeholder="Contoh: BANK SYARIAH INDONESIA (BSI)" maxlength="100">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Nomor Rekening</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                            <input type="text" name="nomor_rekening" class="form-control fw-bold" value="{{ old('nomor_rekening', $profil->nomor_rekening ?? '7145-8890-2101') }}" placeholder="Contoh: 7145-8890-2101" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Atas Nama Rekening</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person-check"></i></span>
                                            <input type="text" name="atas_nama" class="form-control" value="{{ old('atas_nama', $profil->atas_nama ?? 'Takmir Masjid Jami Al-Ikhlas') }}" placeholder="Contoh: Takmir Masjid Jami Al-Ikhlas" maxlength="100">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Judul Banner Infaq</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-heart"></i></span>
                                            <input type="text" name="judul_infaq" class="form-control" value="{{ old('judul_infaq', $profil->judul_infaq ?? 'Salurkan Infaq Terbaik Anda') }}" placeholder="Contoh: Salurkan Infaq Terbaik Anda" maxlength="150">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Deskripsi Ajakan Infaq</label>
                                        <textarea name="deskripsi_infaq" class="form-control" rows="2" placeholder="Dukung kemakmuran masjid, kegiatan dakwah, santunan yatim...">{{ old('deskripsi_infaq', $profil->deskripsi_infaq ?? 'Dukung kemakmuran masjid, kegiatan dakwah, santunan yatim, dan pemeliharaan fasilitas masjid.') }}</textarea>
                                    </div>

                                    <!-- Section 3: Sejarah, Visi, Misi -->
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 flex-wrap gap-2">
                                            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-journal-richtext me-1"></i> 3. Sejarah, Visi & Misi Masjid (Editor Summernote)</h6>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill" onclick="applyTemplateVisiMisi()">
                                                    <i class="bi bi-magic me-1"></i> Sisipkan Contoh Visi & Misi
                                                </button>
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="applyTemplateSejarah()">
                                                    <i class="bi bi-file-text me-1"></i> Sisipkan Contoh Sejarah
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mt-1">Gunakan toolbar di atas editor untuk memformat teks (penomoran 1.2.3, bullet list, cetak tebal, tabel, atau kutipan).</small>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold small mb-0">Sejarah Singkat Masjid</label>
                                            <small class="text-muted">Tampilkan ringkasan awal mula berdirinya masjid</small>
                                        </div>
                                        <textarea name="sejarah" id="summernote_sejarah" class="form-control summernote" rows="6" placeholder="Tuliskan sejarah singkat pendirian masjid...">{{ old('sejarah', $profil->sejarah) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold small mb-0 text-success"><i class="bi bi-compass me-1"></i> Visi Masjid</label>
                                            <small class="text-muted">Cita-cita & tujuan utama</small>
                                        </div>
                                        <textarea name="visi" id="summernote_visi" class="form-control summernote" rows="5" placeholder="Visi masjid...">{{ old('visi', $profil->visi) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold small mb-0 text-primary"><i class="bi bi-bullseye me-1"></i> Misi Masjid</label>
                                            <small class="text-muted">Langkah nyata & program</small>
                                        </div>
                                        <textarea name="misi" id="summernote_misi" class="form-control summernote" rows="5" placeholder="Misi masjid...">{{ old('misi', $profil->misi) }}</textarea>
                                    </div>

                                    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                            <i class="bi bi-save me-1"></i> Simpan Perubahan Profil, Rekening & Background
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>

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
            $('.summernote').summernote({
                placeholder: 'Ketik konten di sini... Anda dapat menggunakan penomoran, daftar poin, tebal, miring, dan tabel.',
                tabsize: 2,
                height: 200,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                styleTags: [
                    'p',
                    { title: 'Judul Heading 3', tag: 'h3', className: 'fw-bold text-dark', value: 'h3' },
                    { title: 'Subjudul Heading 4', tag: 'h4', className: 'fw-bold text-primary', value: 'h4' },
                    { title: 'Kutipan Mutiara', tag: 'blockquote', className: 'blockquote', value: 'blockquote' }
                ]
            });
        }

        // Live image preview for hero background input
        const fotoInput = document.getElementById('fotoMasjidInput');
        if (fotoInput) {
            fotoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const previewEl = document.getElementById('bgPreview');
                        const sidePreviewEl = document.getElementById('sideBgPreview');
                        if (previewEl) previewEl.src = event.target.result;
                        if (sidePreviewEl) sidePreviewEl.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Helper functions for template insertion
    function applyTemplateVisiMisi() {
        const contohVisi = '<p>Terwujudnya <strong>Masjid Al-Ikhlas</strong> sebagai pusat peribadatan yang makmur, mandiri, berkeadaban, dan menjadi pelopor pembinaan umat yang berakhlakul karimah serta berdaya saing.</p>';
        
        const contohMisi = '<ol>' +
            '<li>Menyelenggarakan kegiatan ibadah sholat berjamaah lima waktu dan sholat Jumat yang khusyuk dan nyaman.</li>' +
            '<li>Melaksanakan kajian keislaman, bimbingan tahsin/tahfidz Al-Qur\'an, dan pembinaan generasi muda Islam.</li>' +
            '<li>Mengelola dana kas, infaq, dan shodaqoh secara profesional, transparan, akuntabel, dan berbasis teknologi digital.</li>' +
            '<li>Mengembangkan program kepedulian sosial, santunan yatim dan dhuafa, serta pelayanan kemaslahatan masyarakat.</li>' +
            '<li>Memelihara dan meningkatkan sarana dan prasarana masjid demi kenyamanan seluruh jamaah.</li>' +
            '</ol>';

        if (confirm('Sisipkan contoh format Visi dan Misi standar? Konten pada editor Visi & Misi akan diperbarui.')) {
            $('#summernote_visi').summernote('code', contohVisi);
            $('#summernote_misi').summernote('code', contohMisi);
        }
    }

    function applyTemplateSejarah() {
        const contohSejarah = '<p><strong>Masjid Al-Ikhlas</strong> didirikan atas dasar kebersamaan dan semangat gotong royong masyarakat kaum muslimin Desa Karangmulya untuk mewujudkan sarana peribadatan yang representatif dan menaungi kegiatan dakwah islamiyah.</p>' +
            '<p>Sejak berdirinya, masjid ini terus mengalami perkembangan sarana dan prasarana guna menampung antusiasme jamaah dalam mengikuti sholat berjamaah, kajian majelis taklim, dan kegiatan pembinaan sosial kemasyarakatan.</p>' +
            '<p>Kini, dengan dukungan penuh dari seluruh warga dan para donatur, Masjid Al-Ikhlas bertransformasi menjadi pusat pembinaan keumatan yang amanah, terbuka, dan transparan dalam tata kelola fasilitas dan keuangan masjid.</p>';

        if (confirm('Sisipkan contoh catatan Sejarah Masjid? Konten pada editor Sejarah akan diperbarui.')) {
            $('#summernote_sejarah').summernote('code', contohSejarah);
        }
    }
</script>
