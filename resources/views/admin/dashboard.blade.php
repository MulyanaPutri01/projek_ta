@section('title', 'Dashboard Admin')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard Admin</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <!-- Welcome Hero Banner -->
        <div class="dashboard-welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2>Selamat Datang, {{ Auth::user()->nama_takmir }}!</h2>
                <p>Anda memiliki hak akses Administrator untuk mengelola takmir, pengguna sistem, profil masjid, dan galeri dokumentasi.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('takmir.create') }}" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-person-plus me-1"></i> Tambah Takmir</a>
                <a href="{{ route('galeri.create') }}" class="btn btn-outline-light btn-sm fw-bold"><i class="bi bi-camera me-1"></i> Upload Foto</a>
            </div>
        </div>

        <div class="row g-3">
            <!-- Pemasukan Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Pemasukan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light">
                                <i class="bi bi-arrow-down-left text-success"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h6>
                                <span class="text-success small pt-1 fw-bold">Infaq & Donasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card revenue-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengeluaran</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-light">
                                <i class="bi bi-arrow-up-right text-danger"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h6>
                                <span class="text-danger small pt-1 fw-bold">Operasional & Kegiatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card customers-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Saldo Kas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light">
                                <i class="bi bi-wallet2 text-primary"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h6>
                                <span class="text-primary small pt-1 fw-bold">Kas Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Shortcuts -->
        <div class="row g-3 mt-1 mb-3">
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('takmir.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-primary-light p-3 text-primary"><i class="bi bi-people fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Kelola Takmir</h6>
                        <small class="text-muted">Aktivasi & status takmir</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('users.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-success-light p-3 text-success"><i class="bi bi-person-gear fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Pengguna</h6>
                        <small class="text-muted">Akun & hak akses role</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('profilmasjid.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-info-light p-3 text-info"><i class="ri-building-2-line fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Profil Masjid</h6>
                        <small class="text-muted">Visi, misi & kontak</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('galeri.index') }}" class="card text-decoration-none h-100 border p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-warning-light p-3 text-warning"><i class="bi bi-images fs-4"></i></div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Galeri Foto</h6>
                        <small class="text-muted">Dokumentasi kegiatan</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Ringkasan Arus Kas Terbaru</h5>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-outline-primary btn-sm">Buka Modul Keuangan</a>
                </div>

                @if($keuangan->isEmpty())
                    <div class="alert alert-info text-center py-4 mb-0" role="alert">
                        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                        Belum ada catatan transaksi keuangan yang terdata.
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
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
                                    {{ $item->kategori_id == 1 ? 'Rp' . number_format($item->nominal, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-end text-danger fw-bold">
                                    {{ $item->kategori_id == 2 ? 'Rp' . number_format($item->nominal, 0, ',', '.') : '-' }}
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
