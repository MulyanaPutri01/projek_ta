@section('title', 'Edit Foto Galeri')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Galeri</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        <h2>Edit Foto Galeri</h2>

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
                <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $galeri->tanggal) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Foto / Judul Dokumentasi</label>
                        <input type="text" name="nama_foto" class="form-control" value="{{ old('nama_foto', $galeri->nama_foto) }}" required maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ganti Foto (Opsional, Maks. 2MB)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        @if($galeri->gambar)
                        <div class="mt-2">
                            <small class="text-muted d-block">Foto saat ini:</small>
                            <img src="{{ asset('storage/' . $galeri->gambar) }}" class="img-thumbnail mt-1" width="140" alt="Gambar">
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kegiatan Terkait</label>
                        <select name="kegiatan_id" class="form-select" required>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id', $galeri->kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>
                                    {{ $kegiatan->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
