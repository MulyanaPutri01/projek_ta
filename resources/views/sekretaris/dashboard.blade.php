@section('title', 'Dashboard Sekretaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard Sekretaris</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Sekretaris</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <!-- Welcome Hero Banner -->
        <div class="dashboard-welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2>Selamat Datang, {{ Auth::user()->nama_takmir }}!</h2>
                <p>Kelola jadwal kegiatan dakwah, kepanitiaan acara, inventaris barang, dan pemantauan kondisi perlengkapan masjid.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('kegiatan.create') }}" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-calendar-plus me-1"></i> Tambah Kegiatan</a>
                <a href="{{ route('inventaris.create') }}" class="btn btn-outline-light btn-sm fw-bold"><i class="bi bi-box-seam me-1"></i> Tambah Barang</a>
            </div>
        </div>

        <div class="row g-3">
            <!-- Kegiatan Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Agenda Kegiatan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light">
                                <i class="bi bi-calendar-event text-primary"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalKegiatan }}</h6>
                                <span class="text-primary small pt-1 fw-bold">Kegiatan Terjadwal</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepanitiaan Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card revenue-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Struktur Panitia</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light">
                                <i class="bi bi-people text-success"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalKepanitiaan }}</h6>
                                <span class="text-success small pt-1 fw-bold">Penugasan Panitia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventaris Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card customers-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Inventaris</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-light">
                                <i class="bi bi-box-seam text-warning"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalInventaris }}</h6>
                                <span class="text-warning small pt-1 fw-bold">Barang & Perlengkapan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Shortcuts -->
        <div class="row g-3 mt-1 mb-3">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('kegiatan.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-primary-light p-3 text-primary"><i class="bi bi-calendar-check fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Jadwal Kegiatan</h6>
                        <small class="text-muted">Kelola agenda dakwah</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('kepanitiaan.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-success-light p-3 text-success"><i class="bi bi-person-workspace fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Kepanitiaan</h6>
                        <small class="text-muted">Jobdesk panitia</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('inventaris.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-warning-light p-3 text-warning"><i class="bi bi-boxes fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Inventaris</h6>
                        <small class="text-muted">Aset & perlengkapan</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('catatan.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-info-light p-3 text-info"><i class="bi bi-clipboard-pulse fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Catatan Kondisi</h6>
                        <small class="text-muted">Kondisi barang berkala</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Agenda Kegiatan Mendatang</h5>
                    <a href="{{ route('kegiatan.calendar') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-calendar3 me-1"></i> Buka Kalender</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Tempat</th>
                                <th>Penceramah / Khotib</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentKegiatan as $kegiatan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $kegiatan->nama_kegiatan }}</strong></td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ substr($kegiatan->mulai_kegiatan, 0, 5) }} - {{ substr($kegiatan->akhir_kegiatan, 0, 5) }} WIB</span></td>
                                <td>{{ $kegiatan->tempat }}</td>
                                <td>{{ $kegiatan->pembicara ?: ($kegiatan->nama_khotib ?: '-') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-calendar-x fs-3 d-block mb-1"></i>
                                    Belum ada agenda kegiatan yang dijadwalkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
