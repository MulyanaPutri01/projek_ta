@section('title', 'Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Catatan Kondisi Inventaris</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Catatan Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Catatan Kondisi Inventaris Masjid</h1>
        @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        @endif

        <br>
        <!-- Formulir Pencarian -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('catatan.index') }}" class="d-inline">
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
                            <a href="{{ route('catatan.index') }}" class="btn btn-secondary mt-2">Tampil Seluruh Data</a>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('catatan.create') }}" class="btn btn-primary">Tambah Data</a>
                            <a href="{{ route('kondisi.index') }}" class="btn btn-secondary mt-2">Kondisi</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>
                @if($catatan->isEmpty())
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                            <h5 class="text-center">Tidak ada data catatan yang dicari.</h5>
                    </div>
                @else
                <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">

                    <table class="table table-bordered" >
                        <thead class="sticky-top bg-white" >
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nama Barang</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Kondisi Barang</th>
                                <!--<th style="text-align: center;">Keterangan</th>-->
                                <th style="text-align: center;">Dibuat Oleh</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach($catatan as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($catatan->currentPage() - 1) * $catatan->perPage() }}</td>
                                <td>{{ $item->nama_barang}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_catatan)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->nama_kondisi}}</td>
                               
                                <td>{{ $item->nama_takmir }}</td>
                                <td style="display: flex; gap: 10px; align-items: center;">
                                    <a href="{{ route('catatan.edit', $item->id_catatan) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('catatan.destroy', $item->id_catatan) }}" method="POST" style="display:inline;">
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
                    <!-- Tombol Pagination -->
                    {{ $catatan->withQueryString()->links() }}
                @endif

            </div>
        </div>
    </div>

@include('layouts.footer')
