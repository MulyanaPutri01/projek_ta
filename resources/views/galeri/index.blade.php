@section('title', 'Galeri')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Galeri</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Galeri</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<div class="container">
    <h1>Daftar Galeri</h1>

    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">

            <form method="GET" action="{{ route('galeri.index') }}" class="d-inline">
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

                    </div>
                    <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                        <a href="{{ route('galeri.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                        <a href="{{ route('galeri.index') }}" class="btn btn-secondary mt-2">Tampil Seluruh Data</a>
                    </div>


                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <br>
            @if($galeri->isEmpty())
                    <p class="text-center">Tidak ada gambar yang dicari.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"style="text-align: center;">No</th>
                            <th scope="col"style="text-align: center;">Tanggal</th>
                            <th scope="col"style="text-align: center;">Nama Foto</th>
                            <th scope="col"style="text-align: center;">Foto</th>
                            <th scope="col"style="text-align: center;">Kegiatan</th>
                            <th scope="col"style="text-align: center;">Dibuat Oleh</th>
                            <th scope="col"style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galeri as $key => $item)
                        <tr>
                            <td style="text-align: center;">{{ $key + $galeri->firstItem() }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->nama_foto }}</td>
                            <td><img src="{{ asset('storage/' . $item->gambar) }}" width="100" alt="Gambar"></td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->nama_takmir }}</td>
                            <td style="display: flex; gap: 10px; align-items: center;">
                                <a href="{{ route('galeri.edit', $item->id_galeri) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('galeri.destroy', $item->id_galeri) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <div class="mt-3">
                        <strong>Total Foto:</strong> {{ $totalGaleri }}
                    </div>
                </table>
                {{ $galeri->links() }}
            @endif
        </div>
    </div>
</div>
@include('layouts.footer')
