@section('title', 'Kepanitiaan Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Kepanitiaan Kegiatan Masjid</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Kepanitiaan</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#kepanitiaanCreateModal">
                <i class="bi bi-person-plus me-1"></i> Tambah Panitia
            </button>
            @if($selectedKegiatan)
                <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSkPdfOptions" title="Download Surat Keputusan Panitia Resmi">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Cetak SK Panitia (PDF)
                </button>
            @endif
            <a href="{{ route('posisi.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-person-badge me-1"></i> Master Posisi
            </a>
        </div>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Header Filter & Active Event Selector Bar -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #065f46 0%, #044e3a 100%); color: #ffffff;">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3 d-flex align-items-center justify-content-center text-white" style="width: 55px; height: 55px;">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <div>
                                <small class="text-white-50 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Susunan Organisasi & Panitia</small>
                                <h4 class="fw-bold mb-0 text-white">
                                    {{ $selectedKegiatan ? $selectedKegiatan->nama_kegiatan : 'Pilih Agenda Kegiatan' }}
                                </h4>
                                @if($selectedKegiatan)
                                    <small class="text-white-75">
                                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($selectedKegiatan->tanggal)->translatedFormat('d F Y') }}
                                        &nbsp;|&nbsp; <i class="bi bi-geo-alt me-1"></i> {{ $selectedKegiatan->lokasi ?? 'Masjid Al-Ikhlas' }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form method="GET" action="{{ route('kepanitiaan.index') }}" class="d-flex justify-content-lg-end gap-2 align-items-center">
                            <label class="text-white small fw-semibold text-nowrap d-none d-sm-block">Pilih Agenda Kegiatan:</label>
                            <select name="kegiatan_id" class="form-select form-select-sm bg-white text-dark fw-semibold" style="max-width: 280px;" onchange="this.form.submit()">
                                @foreach($kegiatans as $keg)
                                    <option value="{{ $keg->id }}" {{ $selectedKegiatanId == $keg->id ? 'selected' : '' }}>
                                        {{ $keg->nama_kegiatan }} ({{ \Carbon\Carbon::parse($keg->tanggal)->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Event Stats Overview -->
                <div class="row g-3 mt-3 pt-3 border-top border-white border-opacity-10 text-center">
                    <div class="col-3">
                        <small class="text-white-50 text-uppercase d-block" style="font-size: 0.72rem;">Total Panitia Kegiatan</small>
                        <span class="fs-5 fw-bold text-white">{{ $panitiaList->count() }} Anggota</span>
                    </div>
                    <div class="col-3">
                        <small class="text-white-50 text-uppercase d-block" style="font-size: 0.72rem;">Pimpinan Inti</small>
                        <span class="fs-5 fw-bold text-warning">{{ $pimpinanInti->count() }} Orang</span>
                    </div>
                    <div class="col-3">
                        <small class="text-white-50 text-uppercase d-block" style="font-size: 0.72rem;">Divisi / Seksi Lapangan</small>
                        <span class="fs-5 fw-bold text-info">{{ $seksiSeksi->count() }} Seksi</span>
                    </div>
                    <div class="col-3">
                        <small class="text-white-50 text-uppercase d-block" style="font-size: 0.72rem;">Status Kepanitiaan</small>
                        <span class="badge bg-success bg-opacity-75 text-white">{{ $panitiaList->count() > 0 ? 'Siap Bertugas' : 'Belum Terbentuk' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mode View Switcher Tabs -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="kepanitiaanTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="organigram-tab" data-bs-toggle="tab" data-bs-target="#organigram-view" type="button" role="tab">
                    <i class="bi bi-diagram-3-fill me-1"></i> Bagan Struktur & Kartu Panitia (Visual)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-view" type="button" role="tab">
                    <i class="bi bi-table me-1"></i> Rekapitulasi Data (DataTables)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="kepanitiaanTabContent">
            
            <!-- ================= TAB 1: VISUAL ORGANIGRAM & TEAM CARDS ================= -->
            <div class="tab-pane fade show active" id="organigram-view" role="tabpanel">

                @if($panitiaList->isEmpty())
                    <div class="card border-0 shadow-sm text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-people text-muted" style="font-size: 3.5rem;"></i>
                            <h5 class="fw-bold text-dark mt-3">Belum Ada Susunan Panitia</h5>
                            <p class="text-muted small">Susunan kepanitiaan untuk kegiatan <strong>{{ $selectedKegiatan ? $selectedKegiatan->nama_kegiatan : '' }}</strong> belum ditambahkan.</p>
                            <button type="button" class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#kepanitiaanCreateModal">
                                <i class="bi bi-person-plus me-1"></i> Bentuk Panitia Sekarang
                            </button>
                        </div>
                    </div>
                @else

                    <!-- A. PIMPINAN INTI (CORE COMMITTEE) -->
                    @if($pimpinanInti->isNotEmpty())
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-star-fill me-1"></i> TIER 1</span>
                                <h5 class="fw-bold text-dark mb-0">Pimpinan Inti & Koordinator Utama</h5>
                            </div>

                            <div class="row g-3">
                                @foreach($pimpinanInti as $item)
                                    @php
                                        $namaPosisi = strtolower($item->posisi?->nama_posisi ?? '');
                                        $borderClass = 'border-success';
                                        $badgeBg = 'bg-success';
                                        $iconClass = 'bi-award-fill';

                                        if (str_contains($namaPosisi, 'ketua')) {
                                            $borderClass = 'border-success';
                                            $badgeBg = 'bg-success';
                                            $iconClass = 'bi-person-crown';
                                        } elseif (str_contains($namaPosisi, 'sekretaris')) {
                                            $borderClass = 'border-info';
                                            $badgeBg = 'bg-info text-dark';
                                            $iconClass = 'bi-pencil-square';
                                        } elseif (str_contains($namaPosisi, 'bendahara')) {
                                            $borderClass = 'border-warning';
                                            $badgeBg = 'bg-warning text-dark';
                                            $iconClass = 'bi-wallet-fill';
                                        }
                                    @endphp
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 border-0 shadow-sm position-relative overflow-hidden" style="border-top: 4px solid var(--bs-{{ str_contains($namaPosisi, 'ketua') ? 'success' : (str_contains($namaPosisi, 'sekretaris') ? 'info' : 'warning') }}) !important;">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <span class="badge {{ $badgeBg }} small text-uppercase">
                                                        <i class="bi {{ $iconClass }} me-1"></i> {{ $item->posisi?->nama_posisi ?? 'Panitia' }}
                                                    </span>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light btn-sm py-0 px-1 text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                            <li>
                                                                <button class="dropdown-item btn-edit" 
                                                                    data-id="{{ $item->id }}" 
                                                                    data-kegiatan="{{ $item->kegiatan_id }}" 
                                                                    data-posisi="{{ $item->posisi_id }}" 
                                                                    data-takmir="{{ $item->takmir_id }}" 
                                                                    data-jobdesk="{{ e($item->jobdesk) }}">
                                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit Panitia
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('kepanitiaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus panitia ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center gap-3 my-2">
                                                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 46px; height: 46px;">
                                                        {{ strtoupper(substr($item->takmir?->nama_takmir ?? 'P', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-0">{{ $item->takmir?->nama_takmir ?? 'Petugas Takmir' }}</h6>
                                                        <small class="text-muted">{{ $item->takmir?->telepon ?? 'Takmir Masjid' }}</small>
                                                    </div>
                                                </div>

                                                <div class="bg-light p-2 rounded-2 mt-2">
                                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.72rem;">Uraian Tugas / Jobdesk:</small>
                                                    <span class="small text-dark">{{ $item->jobdesk }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- B. DIVISI / SEKSI OPERASIONAL (OPERATIONAL SECTIONS) -->
                    @if($seksiSeksi->isNotEmpty())
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-grid-fill me-1"></i> TIER 2</span>
                                <h5 class="fw-bold text-dark mb-0">Divisi / Seksi-Seksi Operasional Lapangan</h5>
                            </div>

                            <div class="row g-3">
                                @foreach($seksiSeksi as $posisiId => $members)
                                    @php $posisiFirst = $members->first()->posisi; @endphp
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-light border-0 py-2.5 d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark small text-uppercase">
                                                    <i class="bi bi-tag-fill me-1 text-primary"></i> {{ $posisiFirst?->nama_posisi ?? 'Seksi Operasional' }}
                                                </span>
                                                <span class="badge bg-secondary-subtle text-secondary small">{{ $members->count() }} Anggota</span>
                                            </div>
                                            <div class="card-body p-3">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($members as $m)
                                                        <li class="list-group-item px-0 py-2.5 border-bottom d-flex justify-content-between align-items-start">
                                                            <div class="d-flex gap-2">
                                                                <div class="rounded-circle bg-light border text-secondary d-flex align-items-center justify-content-center fw-bold small mt-0.5" style="width: 28px; height: 28px;">
                                                                    {{ strtoupper(substr($m->takmir?->nama_takmir ?? 'P', 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <div class="fw-semibold text-dark small">{{ $m->takmir?->nama_takmir ?? 'Petugas Takmir' }}</div>
                                                                    <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                                        <i class="bi bi-check2-circle text-success me-1"></i>{{ $m->jobdesk }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-1 ms-2">
                                                                <button type="button" class="btn btn-light btn-xs p-1 text-warning btn-edit" 
                                                                    data-id="{{ $m->id }}" 
                                                                    data-kegiatan="{{ $m->kegiatan_id }}" 
                                                                    data-posisi="{{ $m->posisi_id }}" 
                                                                    data-takmir="{{ $m->takmir_id }}" 
                                                                    data-jobdesk="{{ e($m->jobdesk) }}"
                                                                    title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <form action="{{ route('kepanitiaan.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus anggota?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-light btn-xs p-1 text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @endif

            </div>

            <!-- ================= TAB 2: DATATABLES TAB ================= -->
            <div class="tab-pane fade" id="table-view" role="tabpanel">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body pt-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Filter Agenda Kegiatan</label>
                                <select id="filter_kegiatan" class="form-select form-select-sm">
                                    <option value="">Semua Kegiatan</option>
                                    @foreach($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" {{ $selectedKegiatanId == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Filter Posisi / Jabatan</label>
                                <select id="filter_posisi" class="form-select form-select-sm">
                                    <option value="">Semua Posisi</option>
                                    @foreach($posisis as $posisi)
                                        <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5 d-flex justify-content-end gap-2 mt-3">
                                <button id="btn_filter" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i> Terapkan Filter</button>
                                <button id="btn_reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body pt-4">
                        <div class="table-responsive">
                            <table id="kepanitiaanTable" class="table table-hover align-middle w-100">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th class="text-start">Nama Kegiatan</th>
                                        <th>Posisi / Jabatan</th>
                                        <th>Nama Takmir / Relawan</th>
                                        <th>Uraian Tugas / Jobdesk</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal Tambah Panitia -->
    <div class="modal fade" id="kepanitiaanCreateModal" tabindex="-1" aria-labelledby="kepanitiaanCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="kepanitiaanCreateModalLabel">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Anggota Panitia Kegiatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('kepanitiaan.store') }}" method="POST" id="formCreatePanitia">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Agenda Kegiatan Masjid <span class="text-danger">*</span></label>
                                <select name="kegiatan_id" class="form-select" required>
                                    <option value="">-- Pilih Agenda Kegiatan --</option>
                                    @foreach($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" {{ $selectedKegiatanId == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->nama_kegiatan }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Takmir / Relawan Ditugaskan <span class="text-danger">*</span></label>
                                <select name="takmir_id" class="form-select" required>
                                    <option value="">-- Pilih Takmir / Pengurus --</option>
                                    @foreach($takmirs as $takmir)
                                        <option value="{{ $takmir->id }}">
                                            {{ $takmir->nama_takmir }} ({{ $takmir->role?->nama_role ?? 'Takmir' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Posisi / Jabatan Panitia <span class="text-danger">*</span></label>
                                <select name="posisi_id" id="create_posisi_id" class="form-select" required>
                                    <option value="">-- Pilih Posisi Kepanitiaan --</option>
                                    @foreach($posisis as $posisi)
                                        <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Uraian Tugas / Jobdesk <span class="text-danger">*</span></label>
                                <input type="text" name="jobdesk" id="create_jobdesk" class="form-control" placeholder="Contoh: Mengatur susunan acara pengajian dan menghubungi penceramah" required maxlength="255">
                                
                                <div class="mt-2">
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.72rem;">Pintasan Jobdesk Cepat (Klik untuk mengisi):</small>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Koordinator utama pelaksanaan agenda kegiatan dari awal sampai akhir">Koordinator Utama</button>
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Menyusun rundown acara, briefing MC, dan koordinasi penceramah">Rundown & MC</button>
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Menyiapkan konsumsi jamaah, snack box penceramah, dan air mineral">Konsumsi Jamaah</button>
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Mempersiapkan sound system, mic wireless, panggung, dan genset">Sound & Tempat</button>
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Desain banner acara, live streaming YouTube, dan dokumentasi foto">Publikasi & Medsos</button>
                                        <button type="button" class="btn btn-light border btn-xs py-0 px-2 jobdesk-preset" data-text="Mengatur ketertiban parkir kendaraan jamaah dan keamanan masjid">Keamanan & Parkir</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan Panitia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Panitia -->
    <div class="modal fade" id="editKepanitiaanModal" tabindex="-1" aria-labelledby="editKepanitiaanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="editKepanitiaanModalLabel">
                        <i class="bi bi-pencil-square me-1"></i> Edit Data Panitia Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formEditKepanitiaan" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Agenda Kegiatan Masjid <span class="text-danger">*</span></label>
                                <select name="kegiatan_id" id="edit_kegiatan_id" class="form-select" required>
                                    <option value="">-- Pilih Agenda Kegiatan --</option>
                                    @foreach($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Takmir / Relawan Ditugaskan <span class="text-danger">*</span></label>
                                <select name="takmir_id" id="edit_takmir_id" class="form-select" required>
                                    <option value="">-- Pilih Takmir / Pengurus --</option>
                                    @foreach($takmirs as $takmir)
                                        <option value="{{ $takmir->id }}">{{ $takmir->nama_takmir }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Posisi / Jabatan Panitia <span class="text-danger">*</span></label>
                                <select name="posisi_id" id="edit_posisi_id" class="form-select" required>
                                    <option value="">-- Pilih Posisi Kepanitiaan --</option>
                                    @foreach($posisis as $posisi)
                                        <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Uraian Tugas / Jobdesk <span class="text-danger">*</span></label>
                                <input type="text" name="jobdesk" id="edit_jobdesk" class="form-control" required maxlength="255">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning shadow-sm fw-semibold">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var table = $('#kepanitiaanTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('kepanitiaan.index') }}",
                data: function (d) {
                    d.kegiatan_id = $('#filter_kegiatan').val();
                    d.posisi_id = $('#filter_posisi').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'kegiatan_name', name: 'kegiatan.nama_kegiatan' },
                { data: 'posisi_name', name: 'posisi.nama_posisi', className: 'text-center' },
                { data: 'takmir_name', name: 'takmir.nama_takmir' },
                { data: 'jobdesk', name: 'jobdesk' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_kegiatan').val('');
            $('#filter_posisi').val('');
            table.draw();
        });

        // Edit Modal Trigger Handler
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var kegiatan = $(this).data('kegiatan');
            var posisi = $(this).data('posisi');
            var takmir = $(this).data('takmir');
            var jobdesk = $(this).data('jobdesk');

            $('#edit_kegiatan_id').val(kegiatan);
            $('#edit_posisi_id').val(posisi);
            if (takmir) $('#edit_takmir_id').val(takmir);
            $('#edit_jobdesk').val(jobdesk);

            var updateUrl = "{{ route('kepanitiaan.update', ':id') }}".replace(':id', id);
            $('#formEditKepanitiaan').attr('action', updateUrl);

            $('#editKepanitiaanModal').modal('show');
        });

        // Quick Preset Jobdesk Clicker
        document.querySelectorAll('.jobdesk-preset').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('create_jobdesk').value = this.getAttribute('data-text');
            });
        });

        // SK PDF Paper selection styling
        document.querySelectorAll('.sk-paper-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.sk-paper-card').forEach(c => c.classList.remove('selected-paper'));
                this.closest('label').querySelector('.sk-paper-card').classList.add('selected-paper');
            });
        });

        // SK PDF Orientation selection styling
        document.querySelectorAll('.sk-orientation-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.sk-orientation-card').forEach(c => c.classList.remove('selected-orientation'));
                this.closest('label').querySelector('.sk-orientation-card').classList.add('selected-orientation');
            });
        });

        // Generate SK PDF Click
        var btnSkPdf = document.getElementById('btn_generate_sk_pdf');
        if (btnSkPdf) {
            btnSkPdf.addEventListener('click', function() {
                var paper = document.querySelector('.sk-paper-radio:checked').value;
                var orientation = document.querySelector('.sk-orientation-radio:checked').value;
                var kegiatanId = this.getAttribute('data-kegiatan-id');

                var url = "{{ route('kepanitiaan.sk-pdf', ':id') }}".replace(':id', kegiatanId) + '?paper=' + paper + '&orientation=' + orientation;
                window.open(url, '_blank');

                var modalEl = document.getElementById('modalSkPdfOptions');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }
    });
</script>

@if($selectedKegiatan)
<!-- Modal Opsi Cetak SK Panitia PDF -->
<div class="modal fade" id="modalSkPdfOptions" tabindex="-1" aria-labelledby="modalSkPdfOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white py-3">
                <h6 class="modal-title fw-bold" id="modalSkPdfOptionsLabel">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Opsi Cetak SK Panitia (PDF)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- 1. Pilihan Ukuran Kertas -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark mb-2">1. Pilih Ukuran Kertas:</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="sk_pdf_paper" value="a4" class="d-none sk-paper-radio" checked>
                                <div class="card border p-3 text-center transition-all sk-paper-card selected-paper">
                                    <div class="fw-bold text-dark fs-6 mb-1">A4</div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">210 x 297 mm</small>
                                    <span class="badge bg-primary-subtle text-primary mt-1" style="font-size: 0.68rem;">Standar Internasional</span>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="sk_pdf_paper" value="f4" class="d-none sk-paper-radio">
                                <div class="card border p-3 text-center transition-all sk-paper-card">
                                    <div class="fw-bold text-dark fs-6 mb-1">F4 / Folio</div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">215 x 330 mm</small>
                                    <span class="badge bg-success-subtle text-success mt-1" style="font-size: 0.68rem;">Standar Dokumen Resmi</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 2. Pilihan Orientasi Kertas -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-2">2. Pilih Orientasi Halaman:</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="sk_pdf_orientation" value="portrait" class="d-none sk-orientation-radio" checked>
                                <div class="card border p-3 text-center transition-all sk-orientation-card selected-orientation">
                                    <i class="bi bi-file-earmark-text text-primary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Portrait</div>
                                    <small class="text-success fw-semibold d-block" style="font-size: 0.68rem;">★ Standar Surat SK</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="sk_pdf_orientation" value="landscape" class="d-none sk-orientation-radio">
                                <div class="card border p-3 text-center transition-all sk-orientation-card">
                                    <i class="bi bi-aspect-ratio text-secondary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Landscape</div>
                                    <small class="text-muted d-block" style="font-size: 0.68rem;">Mendatar Horizontal</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border small text-muted mb-0 py-2">
                    <i class="bi bi-info-circle text-primary me-1"></i> SK Panitia diterbitkan resmi dengan Kop Surat Takmir Masjid dan lembar tanda tangan pengesahan.
                </div>

            </div>
            <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn_generate_sk_pdf" data-kegiatan-id="{{ $selectedKegiatan->id }}" class="btn btn-danger btn-sm shadow-sm fw-semibold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Buka & Unduh SK Panitia
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .sk-paper-card:hover, .sk-orientation-card:hover {
        border-color: #065f46 !important;
        transform: translateY(-2px);
    }
    .selected-paper, .selected-orientation {
        border-color: #065f46 !important;
        border-width: 2px !important;
        background-color: #f0fdf4 !important;
    }
</style>

