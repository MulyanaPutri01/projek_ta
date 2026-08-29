@section('title', 'Laporan Keuangan')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Laporan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Laporan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<div class="container">
    <h1>Laporan Keuangan</h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form method="GET" action="{{ route('laporan.keuangan') }}" class="d-inline">
                <div class="d-flex flex-wrap align-items-end">
                    <div class="me-2 mb-2">
                        <label for="filter" class="form-label black-text">Pilih Jenis Laporan :</label>
                        <select name="filter" class="form-select">
                            <option value="">Pilih Laporan</option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="periode" {{ request('filter') == 'periode' ? 'selected' : '' }}>Periode Tanggal</option>
                        </select>
                    </div>
                    <div class="me-2 mb-2">
                        <label for="year" class="form-label black-text">Tahun : </label>
                        <input type="text" name="year" class="form-control" placeholder="Ketik 2024" value="{{ request('year') }}">
                    </div>
                    <div class="me-2 mb-2">
                        <label for="month" class="form-label black-text">Bulan : </label>
                        <select name="month" class="form-select">
                            <option value="">Pilih Bulan</option>
                            <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div class="me-2 mb-2">
                        <label for="start_date" class="form-label black-text">Periode Tanggal Awal : </label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="me-2 mb-2">
                        <label for="end_date" class="form-label black-text">Periode Tanggal Akhir : </label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="me-2 mb-2">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </div>
                    <div class="me-2 mb-2">
                        <a href="{{ route('laporan.pdf', request()->all()) }}" class="btn btn-success">Cetak Laporan</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <br>
            <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                <h4 class="text-center fw-bold mb-0">RINCIAN KEUANGAN MASJID AL-IKHLAS</h4>
                <h5 class="text-center mb-0">
                    DUKUH SEMENDOT PERIODE
                    @if($filter === 'tahunan')
                        DI TAHUN {{ $tahun }}
                    @elseif($filter === 'bulanan')
                        DI BULAN {{ strtoupper($namaBulan) }}
                    @elseif($filter === 'periode')
                        DI PERIODE {{ strtoupper(\Carbon\Carbon::parse($start)->translatedFormat('d F Y')) }} - {{ strtoupper(\Carbon\Carbon::parse($end)->translatedFormat('d F Y')) }}
                    @else
                        SEMUA
                    @endif
                </h5>


                <table class="table table-bordered">
                    <!-- Pemasukan -->
                    <thead>
                        <tr>
                            <th colspan="8" class="text-start border-bottom">A. Keuangan Pemasukan</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Sumber Keuangan</th>
                            <th>Donatur</th>
                            <th>Kegiatan</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Total Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $pemasukanIndex = 1; @endphp <!-- Inisialisasi variabel untuk pemasukan -->
                        @foreach($keuangan as $item)
                            @if($item->kategori_id_kategori == 'K1') <!-- Pemasukan -->
                                <tr>
                                    <td>{{ $pemasukanIndex++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->sumber_keuangan }}</td>
                                    <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                                    <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                                    <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}.-</td>
                                    <td>-</td>
                                    <td></td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                    <!-- Pengeluaran -->
                    <thead>
                        <tr>
                            <th colspan="8" class="text-start border-bottom">B. Keuangan Pengeluaran</th>
                        </tr>
                        <!--<tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keperluan</th>
                            <th>Donatur</th>
                            <th>Kegiatan</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Total Saldo</th>
                        </tr>-->
                    </thead>
                    <tbody>
                        @php $pengeluaranIndex = 1; @endphp <!-- Inisialisasi variabel untuk pengeluaran -->
                        @foreach($keuangan as $item)
                            @if($item->kategori_id_kategori == 'K2') <!-- Pengeluaran -->
                                <tr>
                                    <td>{{ $pengeluaranIndex++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                                    <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                                    <td>-</td>
                                    <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}.-</td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                        <!-- Total Keseluruhan -->
                        <tr>
                            <td colspan="5" class="text-center fw-bold">JUMLAH KESELURUHAN</td>
                            <td class="fw-bold">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</td>
                            <td class="fw-bold">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</td>
                            <td class="fw-bold">Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-start"> Saldo Awal</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-start">Total Pemasukan</td>
                                <td>Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-start">Total Pengeluaran</td>
                                <td>Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-start">Saldo Akhir</td>
                                <td>Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</td>
                            </tr>
                        </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
