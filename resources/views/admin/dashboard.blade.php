@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Admin Dashboard</h1>
                <p>Selamat datang, {{ Auth::user()->nama_takmir }} Anda memiliki hak akses penuh untuk mengelola sistem.</p>
            </div>
        </div>



            <div class="row">
                <!-- Sales Card -->
                <div class="col-xxl-9 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pemasukan</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h3>Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-9 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengeluaran</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h3>Rp{{ number_format($totalPengeluaran, 0, ',', '.')}}.-</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revenue Card -->
                <div class="col-xxl-9 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Saldo Saat Ini</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h3>Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</h3>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="sticky-top bg-white">
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
                                    $totalPemasukan = 0;
                                    $totalPengeluaran = 0;
                                    $saldoAkhir = 0;
                                @endphp
                                @foreach($keuangan as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($keuangan->currentPage() - 1) * $keuangan->perPage() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->sumber_keuangan }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->nominal }}</td>
                                    <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                                    <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                                    <td>Rp{{ number_format($item->kategori_id_kategori === 'K1' ? $item->nominal : 0, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->kategori_id_kategori === 'K2' ? $item->nominal : 0, 0, ',', '.') }}</td>
                                    <td>{{ $item->takmir->nama_takmir }}</td>
                                    @php
                                        if ($item->kategori_id_kategori === 'K1') {
                                            $totalPemasukan += $item->nominal;
                                        } elseif ($item->kategori_id_kategori === 'K2') {
                                            $totalPengeluaran += $item->nominal;
                                        }
                                        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
                                    @endphp
                                    <td>Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('keuangan.edit', $item->id_keuangan) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('keuangan.destroy', $item->id_keuangan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $keuangan->links() }}
                    @endif
                </div>
            </div>



    </div>

@include('layouts.footer')
