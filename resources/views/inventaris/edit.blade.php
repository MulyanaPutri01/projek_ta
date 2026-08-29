@section('title', 'Edit Barang Inventaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Barang Inventaris</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('inventaris.index') }}">Inventaris</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Edit Barang Inventaris</h2>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-8">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" value="{{ old('nama_barang', $inventaris->nama_barang) }}" required maxlength="100">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jumlah / Unit</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $inventaris->jumlah) }}" min="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun Pembelian / Pengadaan</label>
                        <input type="number" name="tahun_pembelian" class="form-control" value="{{ old('tahun_pembelian', $inventaris->tahun_pembelian) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi', $inventaris->lokasi) }}" required maxlength="100">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan Barang (Opsional)</label>
                        <input type="text" class="form-control" name="keterangan" value="{{ old('keterangan', $inventaris->keterangan) }}" maxlength="255">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Perbarui Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
