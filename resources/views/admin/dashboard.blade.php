@section('title', 'Dashboard Admin')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard Administrator</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <!-- Welcome Hero Banner -->
        <div class="dashboard-welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2>Selamat Datang, {{ Auth::user()->nama_takmir }}!</h2>
                <p>Pantau ringkasan statistik kas masjid, grafik arus kas bulanan, kondisi aset inventaris, dan aktivitas sistem secara real-time.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('takmir.create') }}" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-person-plus me-1"></i> Tambah Takmir</a>
                <a href="{{ route('galeri.create') }}" class="btn btn-outline-light btn-sm fw-bold"><i class="bi bi-camera me-1"></i> Upload Foto</a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
            <!-- Pemasukan Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card sales-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Total Pemasukan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light text-success" style="width: 48px; height: 48px;">
                                <i class="bi bi-arrow-down-left fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h5>
                                <span class="text-muted small">Infaq, Donasi & Shadaqah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card revenue-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Total Pengeluaran</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-light text-danger" style="width: 48px; height: 48px;">
                                <i class="bi bi-arrow-up-right fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h5>
                                <span class="text-muted small">Operasional & Kegiatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card customers-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Total Saldo Kas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 {{ $totalSaldo >= 0 ? 'text-primary' : 'text-danger' }}">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h5>
                                <span class="text-muted small">{{ $totalSaldo >= 0 ? 'Kas Tersedia' : 'Defisit Kas' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengguna & Takmir Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Takmir & Pengguna</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-light text-info" style="width: 48px; height: 48px;">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-dark">{{ $countTakmir }} Pengurus</h5>
                                <span class="text-muted small">{{ $countUser }} Akun Terdaftar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= VISUAL CHARTS ROW ================= -->
        <div class="row g-3 mb-4">
            <!-- Main Trend Chart (Area Chart) -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Tren Arus Kas Bulanan (Tahun {{ $currentYear }})</h5>
                                <small class="text-muted">Perbandingan fluktuasi pemasukan dan pengeluaran kas masjid per bulan</small>
                            </div>
                            <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i>Tahun {{ $currentYear }}</span>
                        </div>
                        <div id="cashflowTrendChart" style="min-height: 330px;"></div>
                    </div>
                </div>
            </div>

            <!-- Donut Charts Column -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body pt-3">
                        <h5 class="card-title mb-1 fw-bold fs-6"><i class="bi bi-pie-chart text-danger me-2"></i>Alokasi Pengeluaran Kas</h5>
                        <small class="text-muted d-block mb-3">5 Pengeluaran terbesar tahun ini</small>
                        @if(empty($pengeluaranLabels) || array_sum($pengeluaranValues) == 0)
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                Belum ada data pengeluaran kas tahun ini.
                            </div>
                        @else
                            <div id="pengeluaranDonutChart" style="min-height: 220px;"></div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body pt-3">
                        <h5 class="card-title mb-1 fw-bold fs-6"><i class="bi bi-shield-check text-success me-2"></i>Kondisi Fisik Inventaris</h5>
                        <small class="text-muted d-block mb-2">Status kelayakan {{ $countInventaris }} barang aset</small>
                        <div id="inventarisKondisiChart" style="min-height: 190px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Shortcuts -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('takmir.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-primary-light p-3 text-primary"><i class="bi bi-people fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Kelola Takmir</h6>
                        <small class="text-muted">Aktivasi & status takmir</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('users.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-success-light p-3 text-success"><i class="bi bi-person-gear fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Pengguna</h6>
                        <small class="text-muted">Akun & hak akses role</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('profilmasjid.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-info-light p-3 text-info"><i class="ri-building-2-line fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Profil Masjid</h6>
                        <small class="text-muted">Visi, misi & kontak</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('galeri.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-warning-light p-3 text-warning"><i class="bi bi-images fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Galeri Foto</h6>
                        <small class="text-muted">Dokumentasi kegiatan</small>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Transaksi Keuangan Terbaru</h5>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-outline-primary btn-sm">Buka Modul Keuangan <i class="bi bi-arrow-right ms-1"></i></a>
                </div>

                @if($keuangan->isEmpty())
                    <div class="alert alert-info text-center py-4 mb-0" role="alert">
                        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                        Belum ada catatan transaksi keuangan yang terdata.
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
                                <th>Dicatat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keuangan as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($keuangan->currentPage() - 1) * $keuangan->perPage() }}</td>
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
                                <td>{{ $item->takmir ? $item->takmir->nama_takmir : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $keuangan->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')

<!-- ================= APEXCHARTS INITIALIZATION ================= -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Helper Format Rupiah untuk Chart Tooltip
    function rupiahTooltip(val) {
        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
    }

    // 1. Cashflow Trend Area Chart
    const cashflowOptions = {
        series: [
            {
                name: 'Pemasukan Kas',
                data: {!! json_encode($chartPemasukan) !!}
            },
            {
                name: 'Pengeluaran Kas',
                data: {!! json_encode($chartPengeluaran) !!}
            }
        ],
        chart: {
            height: 330,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#ef4444'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100]
            }
        },
        xaxis: {
            categories: {!! json_encode($chartMonths) !!},
            labels: { style: { colors: '#64748b', fontSize: '12px' } }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    if (value >= 1000000) {
                        return (value / 1000000).toFixed(1) + ' Jt';
                    } else if (value >= 1000) {
                        return (value / 1000).toFixed(0) + ' Rb';
                    }
                    return value;
                },
                style: { colors: '#64748b' }
            }
        },
        tooltip: {
            y: { formatter: function (val) { return rupiahTooltip(val); } }
        },
        legend: { position: 'top', horizontalAlign: 'right' },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };
    new ApexCharts(document.querySelector("#cashflowTrendChart"), cashflowOptions).render();

    // 2. Pengeluaran Donut Chart
    @if(!empty($pengeluaranLabels) && array_sum($pengeluaranValues) > 0)
    const pengeluaranDonutOptions = {
        series: {!! json_encode($pengeluaranValues) !!},
        labels: {!! json_encode($pengeluaranLabels) !!},
        chart: {
            type: 'donut',
            height: 220,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6', '#ec4899'],
        legend: { position: 'bottom', fontSize: '11px' },
        dataLabels: { enabled: false },
        tooltip: {
            y: { formatter: function (val) { return rupiahTooltip(val); } }
        }
    };
    new ApexCharts(document.querySelector("#pengeluaranDonutChart"), pengeluaranDonutOptions).render();
    @endif

    // 3. Inventaris Kondisi Chart (Radial / Donut)
    const kondisiOptions = {
        series: [{{ $kondisiInventaris['Baik'] }}, {{ $kondisiInventaris['Perbaikan'] }}, {{ $kondisiInventaris['Rusak'] }}],
        labels: ['Kondisi Baik', 'Perlu Perbaikan', 'Rusak'],
        chart: {
            type: 'donut',
            height: 190,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#f59e0b', '#dc2626'],
        legend: { position: 'bottom', fontSize: '11px' },
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
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' Item';
                            }
                        }
                    }
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#inventarisKondisiChart"), kondisiOptions).render();
});
</script>
