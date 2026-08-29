@section('title', 'Tambah Foto Galeri')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Galeri</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        <h2>Tambah Foto Galeri</h2>

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Foto / Judul Dokumentasi</label>
                        <input type="text" name="nama_foto" class="form-control" value="{{ old('nama_foto') }}" placeholder="Contoh: Suasana Kajian Akbar" required maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">File Foto / Gambar (Maks. 2MB)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kegiatan Terkait</label>
                        <select name="kegiatan_id" class="form-select" required>
                            <option value="">Pilih Kegiatan...</option>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                                    {{ $kegiatan->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
