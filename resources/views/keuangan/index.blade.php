@section('title', 'Keuangan')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Keuangan Umum</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Keuangan Umum</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Keuangan Masjid</h1>
        @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        @endif
        <div class="row">
            <!-- Pemasukan Hari Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan Hari Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pemasukanHariIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemasukan Bulan Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan Bulan Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemasukan Tahun Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan Tahun Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pemasukanTahunIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pengeluaran Hari Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran Hari Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pengeluaranHariIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Pengeluaran Bulan Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran Bulan Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pengeluaranBulanIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Pengeluaran Tahun Ini -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran Tahun Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($pengeluaranTahunIni, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Pemasukan -->
            <div class="col-md-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pemasukan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="col-md-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengeluaran</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Saldo Saat Ini -->
            <div class="col-md-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Saldo Saat Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <h5>Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('keuangan.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2">
                            <label for="search" class="form-label black-text">Cari Lainnya : </label>
                            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ $search ?? '' }}">
                        </div>
                        <div class="me-2 mb-2">
                            <label for="month" class="form-label black-text">Bulan :</label>
                            <select name="month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                                    <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="me-2 mb-2">
                            <label for="year" class="form-label black-text">Tahun :</label>
                            <select name="year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('keuangan.index') }}" class="btn btn-secondary mt-2">Tampil Seluruh Data</a>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('keuangan.create') }}" class="btn btn-primary">Tambah Data</a>
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-2">Kategori</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>
                @if($keuangan->isEmpty())
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                            <h5 class="text-center">Tidak ada data keuangan yang dicari.</h5>
                    </div>
                @else
                <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                    <table class="table table-bordered" >
                        <thead class="sticky-top bg-white" >
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Sumber Keuangan</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="text-align: center;">Nominal</th>
                                <th style="text-align: center;">Nama Donatur</th>
                                <th style="text-align: center;">Nama Kegiatan</th>
                                <th style="text-align: center;">Pemasukan</th>
                                <th style="text-align: center;">Pengeluaran</th>
                                <th style="text-align: center;">Dibuat Oleh</th>
                                <th style="text-align: center;">Total Saldo</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>

                        </thead>
                        <tbody>

                            @php
                                // Set saldo awal dari Controller
                                $runningSaldo = $saldoAwal;
                            @endphp
                            @foreach($keuangan as $item)
                            @php
                                // Tambahkan atau kurangi berdasarkan kategori K1 (pemasukan) atau K2 (pengeluaran)
                                if($item->kategori_id_kategori == 'K1') {
                                    $runningSaldo += $item->nominal;
                                } else {
                                    $runningSaldo -= $item->nominal;
                                }
                            @endphp
                          
                            <tr>
                                <td>{{ $loop->iteration + ($keuangan->currentPage() - 1) * $keuangan->perPage()  }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->sumber_keuangan }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}.-</td>
                                <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                                <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                                <td><span style="white-space: nowrap;">Rp{{ number_format($item->kategori_id_kategori === 'K1' ? $item->nominal : 0, 0, ',', '.') }}.-</span></td>
                                <td><span style="white-space: nowrap;">Rp{{ number_format($item->kategori_id_kategori === 'K2' ? $item->nominal : 0, 0, ',', '.') }}.-</span></td>
                                <td>{{ $item->takmir->nama_takmir }}</td>
                                <!-- TAMPILKAN RUNNING SALDO (Bukan $saldoAkhir) -->
                                <td><span style="white-space: nowrap;">Rp{{ number_format($runningSaldo, 0, ',', '.') }}</span></td>

                                <td style="display: flex; gap: 10px; align-items: center;">
                                    <a href="{{ route('keuangan.edit', $item->id_keuangan) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('keuangan.destroy', $item->id_keuangan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                            <div class="mt-3">
                                <strong>Total Keuangan:</strong> {{ $totalKeuangan }}
                            </div>

                    </table>
                </div>
                    <!-- Tombol Pagination -->
                    {{ $keuangan->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </div>

@include('layouts.footer')
