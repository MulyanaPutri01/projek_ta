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
        <div class="dashboard-welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2>Selamat Datang, {{ Auth::user()->nama_takmir }}!</h2>
                <p>Kelola jadwal kegiatan dakwah, kepanitiaan acara, inventaris barang, dan pemantauan kondisi perlengkapan masjid.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('kegiatan.create') }}" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-calendar-plus me-1"></i> Tambah Kegiatan</a>
                <a href="{{ route('inventaris.create') }}" class="btn btn-outline-light btn-sm fw-bold"><i class="bi bi-box-seam me-1"></i> Tambah Barang</a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
            <!-- Kegiatan Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card sales-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Agenda Kegiatan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-calendar-event fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-primary">{{ $totalKegiatan }} Agenda</h5>
                                <span class="text-muted small">Kegiatan Terjadwal</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepanitiaan Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card revenue-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Struktur Panitia</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light text-success" style="width: 48px; height: 48px;">
                                <i class="bi bi-person-workspace fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-success">{{ $totalKepanitiaan }} Posisi</h5>
                                <span class="text-muted small">Penugasan Relawan & Panitia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventaris Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card customers-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Total Inventaris</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-light text-warning" style="width: 48px; height: 48px;">
                                <i class="bi bi-boxes fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-dark">{{ $totalInventaris }} Barang</h5>
                                <span class="text-muted small">Aset & Perlengkapan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Takmir Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Pengurus Takmir</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-light text-info" style="width: 48px; height: 48px;">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-dark">{{ $totalTakmir }} Personil</h5>
                                <span class="text-muted small">Divisi & Pengurus Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= VISUAL CHARTS ROW ================= -->
        <div class="row g-3 mb-4">
            <!-- Main Event Trend Chart -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Frekuensi Agenda Kegiatan Dakwah (Tahun {{ $currentYear }})</h5>
                                <small class="text-muted">Jumlah agenda acara, pengajian, dan kegiatan masjid per bulan</small>
                            </div>
                            <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i>Tahun {{ $currentYear }}</span>
                        </div>
                        <div id="kegiatanChart" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>

            <!-- Inventaris Donut Chart -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body pt-3">
                        <h5 class="card-title mb-1 fw-bold fs-6"><i class="bi bi-pie-chart-fill text-warning me-2"></i>Kondisi Fisik Barang Inventaris</h5>
                        <small class="text-muted d-block mb-3">Status kelaikan operasional {{ $totalInventaris }} aset masjid</small>
                        <div id="sekretarisKondisiChart" style="min-height: 250px;"></div>
                        <div class="mt-2 pt-2 border-top text-center">
                            <a href="{{ route('catatan.index') }}" class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-clipboard-pulse me-1"></i> Lihat Buku Catatan Kondisi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Shortcuts -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('kegiatan.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-primary-light p-3 text-primary"><i class="bi bi-calendar-check fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Jadwal Kegiatan</h6>
                        <small class="text-muted">Kelola agenda dakwah</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('kepanitiaan.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-success-light p-3 text-success"><i class="bi bi-person-workspace fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Kepanitiaan</h6>
                        <small class="text-muted">Jobdesk & SK panitia</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('inventaris.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-warning-light p-3 text-warning"><i class="bi bi-boxes fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Inventaris</h6>
                        <small class="text-muted">Aset & perlengkapan</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('catatan.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-info-light p-3 text-info"><i class="bi bi-clipboard-pulse fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Catatan Kondisi</h6>
                        <small class="text-muted">Kondisi barang berkala</small>
                    </div>
                </a>
            </div>
        </div>

        <!-- Upcoming Events Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i>Agenda Kegiatan Mendatang</h5>
                    <a href="{{ route('kegiatan.calendar') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-calendar3 me-1"></i> Buka Kalender Agenda</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
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

<!-- ================= APEXCHARTS INITIALIZATION ================= -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // 1. Kegiatan Column Chart
    const kegiatanOptions = {
        series: [{
            name: 'Jumlah Agenda',
            data: {!! json_encode($chartKegiatan) !!}
        }],
        chart: {
            height: 320,
            type: 'bar',
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                borderRadius: 5,
                columnWidth: '45%',
                dataLabels: { position: 'top' }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val > 0 ? val + " Kegiatan" : "";
            },
            offsetY: -20,
            style: { fontSize: '11px', colors: ["#334155"] }
        },
        colors: ['#3b82f6'],
        xaxis: {
            categories: {!! json_encode($chartMonths) !!},
            labels: { style: { colors: '#64748b', fontSize: '12px' } }
        },
        yaxis: {
            labels: {
                formatter: function (val) { return Math.floor(val); },
                style: { colors: '#64748b' }
            },
            min: 0,
            forceNiceScale: true
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };
    new ApexCharts(document.querySelector("#kegiatanChart"), kegiatanOptions).render();

    // 2. Inventaris Kondisi Donut Chart
    const kondisiOptions = {
        series: [{{ $kondisiInventaris['Baik'] }}, {{ $kondisiInventaris['Perbaikan'] }}, {{ $kondisiInventaris['Rusak'] }}],
        labels: ['Kondisi Baik', 'Perlu Perbaikan', 'Kondisi Rusak'],
        chart: {
            type: 'donut',
            height: 250,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#f59e0b', '#ef4444'],
        legend: { position: 'bottom', fontSize: '12px' },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Aset',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' Barang';
                            }
                        }
                    }
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#sekretarisKondisiChart"), kondisiOptions).render();
});
</script>
