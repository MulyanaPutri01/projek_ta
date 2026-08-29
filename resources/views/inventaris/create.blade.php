@section('title', 'Tambah Barang Inventaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Barang Inventaris</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('inventaris.index') }}">Inventaris</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Tambah Barang Inventaris</h2>

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('inventaris.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-8">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" placeholder="Contoh: Sound System Wireless" value="{{ old('nama_barang') }}" required maxlength="100">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jumlah / Unit</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="1" value="{{ old('jumlah', 1) }}" min="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun Pembelian / Pengadaan</label>
                        <input type="number" name="tahun_pembelian" class="form-control" placeholder="2024" value="{{ old('tahun_pembelian', date('Y')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control" name="lokasi" placeholder="Contoh: Ruang Sound, Lemari Utama" value="{{ old('lokasi') }}" required maxlength="100">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan Barang (Opsional)</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Contoh: Hibah dari H. Ahmad / Pembelian kas masjid" value="{{ old('keterangan') }}" maxlength="255">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
