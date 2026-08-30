@section('title', 'Dashboard Bendahara')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard Bendahara</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Bendahara</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <!-- Welcome Hero Banner -->
        <div class="dashboard-welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2>Selamat Datang, {{ Auth::user()->nama_takmir }}!</h2>
                <p>Kelola pencatatan kas, pantau grafik mutasi bulanan, analisa proporsi infaq & donasi, serta cetak laporan keuangan transparan.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('keuangan.create') }}" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-plus-circle me-1"></i> Catat Transaksi</a>
                <a href="{{ route('laporan.keuangan') }}" class="btn btn-outline-light btn-sm fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> Cetak Laporan PDF</a>
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
                                <span class="text-muted small">{{ $countTransaksiMasuk }} Transaksi Masuk</span>
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
                                <span class="text-muted small">{{ $countTransaksiKeluar }} Transaksi Keluar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card customers-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Saldo Kas Tersedia</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 {{ $totalSaldo >= 0 ? 'text-primary' : 'text-danger' }}">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h5>
                                <span class="text-muted small">{{ $totalSaldo >= 0 ? 'Surplus Kas' : 'Defisit Kas' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donatur Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card info-card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase fs-7 mb-2">Donatur Terdaftar</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-light text-info" style="width: 48px; height: 48px;">
                                <i class="bi bi-heart-fill fs-4"></i>
                            </div>
                            <div class="ps-3">
                                <h5 class="fw-bold mb-0 text-dark">{{ $countDonatur }} Donatur</h5>
                                <span class="text-muted small">Jamaah & Hamba Allah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= VISUAL CHARTS ROW ================= -->
        <div class="row g-3 mb-4">
            <!-- Main Monthly Bar Chart -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-bar-chart-line-fill text-success me-2"></i>Komparasi Pemasukan vs Pengeluaran Bulanan</h5>
                                <small class="text-muted">Perbandingan nilai rupiah arus masuk dan keluar kas masjid per bulan (Tahun {{ $currentYear }})</small>
                            </div>
                            <span class="badge bg-light text-dark border"><i class="bi bi-calendar-check me-1"></i>Tahun {{ $currentYear }}</span>
                        </div>
                        <div id="bendaharaBarChart" style="min-height: 330px;"></div>
                    </div>
                </div>
            </div>

            <!-- Donut Charts Column -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body pt-3">
                        <h5 class="card-title mb-1 fw-bold fs-6"><i class="bi bi-pie-chart-fill text-success me-2"></i>Sumber Pemasukan Kas</h5>
                        <small class="text-muted d-block mb-2">Proporsi infaq, donatur, dan kotak amal</small>
                        @if(empty($pemasukanLabels) || array_sum($pemasukanValues) == 0)
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                Belum ada data pemasukan tahun ini.
                            </div>
                        @else
                            <div id="pemasukanDonutChart" style="min-height: 200px;"></div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body pt-3">
                        <h5 class="card-title mb-1 fw-bold fs-6"><i class="bi bi-pie-chart text-danger me-2"></i>Alokasi Pengeluaran Kas</h5>
                        <small class="text-muted d-block mb-2">Proporsi operasional & kegiatan masjid</small>
                        @if(empty($pengeluaranLabels) || array_sum($pengeluaranValues) == 0)
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                Belum ada data pengeluaran tahun ini.
                            </div>
                        @else
                            <div id="pengeluaranDonutChart" style="min-height: 200px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('keuangan.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-primary-light p-3 text-primary"><i class="bi bi-cash-stack fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Transaksi</h6>
                        <small class="text-muted">Kelola riwayat kas</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('donatur.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-success-light p-3 text-success"><i class="bi bi-people fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Donatur</h6>
                        <small class="text-muted">Daftar donatur tetap</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('kategori.index') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-warning-light p-3 text-warning"><i class="bi bi-tags fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Kategori Kas</h6>
                        <small class="text-muted">Pemasukan & Pengeluaran</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('laporan.keuangan') }}" class="card text-decoration-none h-100 shadow-sm border-0 p-3 d-flex flex-row align-items-center gap-3 transition-hover">
                    <div class="rounded-circle bg-info-light p-3 text-info"><i class="bi bi-printer fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Laporan Kas</h6>
                        <small class="text-muted">Cetak PDF & rekap kas</small>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-receipt-cutoff me-2 text-primary"></i>Riwayat Transaksi Keuangan Terbaru</h5>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Data Kas <i class="bi bi-arrow-right ms-1"></i></a>
                </div>

                @if($keuangan->isEmpty())
                    <div class="alert alert-info text-center py-4 mb-0" role="alert">
                        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                        Belum ada catatan transaksi kas yang terdaftar.
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
    function rupiahTooltip(val) {
        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
    }

    // 1. Grouped Column Bar Chart
    const barOptions = {
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
            type: 'bar',
            height: 330,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 4
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        colors: ['#10b981', '#ef4444'],
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
        fill: { opacity: 0.9 },
        tooltip: {
            y: { formatter: function (val) { return rupiahTooltip(val); } }
        },
        legend: { position: 'top', horizontalAlign: 'right' },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };
    new ApexCharts(document.querySelector("#bendaharaBarChart"), barOptions).render();

    // 2. Pemasukan Donut Chart
    @if(!empty($pemasukanLabels) && array_sum($pemasukanValues) > 0)
    const pemasukanDonutOptions = {
        series: {!! json_encode($pemasukanValues) !!},
        labels: {!! json_encode($pemasukanLabels) !!},
        chart: {
            type: 'donut',
            height: 200,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#06b6d4', '#3b82f6', '#6366f1', '#14b8a6'],
        legend: { position: 'bottom', fontSize: '11px' },
        dataLabels: { enabled: false },
        tooltip: {
            y: { formatter: function (val) { return rupiahTooltip(val); } }
        }
    };
    new ApexCharts(document.querySelector("#pemasukanDonutChart"), pemasukanDonutOptions).render();
    @endif

    // 3. Pengeluaran Donut Chart
    @if(!empty($pengeluaranLabels) && array_sum($pengeluaranValues) > 0)
    const pengeluaranDonutOptions = {
        series: {!! json_encode($pengeluaranValues) !!},
        labels: {!! json_encode($pengeluaranLabels) !!},
        chart: {
            type: 'donut',
            height: 200,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#ef4444', '#f59e0b', '#ec4899', '#8b5cf6', '#64748b'],
        legend: { position: 'bottom', fontSize: '11px' },
        dataLabels: { enabled: false },
        tooltip: {
            y: { formatter: function (val) { return rupiahTooltip(val); } }
        }
    };
    new ApexCharts(document.querySelector("#pengeluaranDonutChart"), pengeluaranDonutOptions).render();
    @endif
});
</script>
