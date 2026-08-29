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
    <a href="/galeri" class="btn btn-secondary btn-sm">Kembali</i></a>
    <h1>Edit Galeri</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <br>
            <form action="{{ route('galeri.update', $galeri->id_galeri) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $galeri->tanggal }}" required>
                </div>
                <div class="form-group">
                    <label for="nama_foto">Nama Foto</label>
                    <input type="text" name="nama_foto" class="form-control" value="{{ $galeri->nama_foto }}" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Foto (Opsional)</label>
                    <input type="file" name="gambar" class="form-control">
                    <p class="mt-2">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $galeri->gambar) }}" width="150" alt="Gambar Lama">
                </div>
                <div class="form-group">
                    <label for="kegiatan_id_kegiatan">Kegiatan</label>
                    <select name="kegiatan_id_kegiatan" class="form-control" required>
                        @foreach($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id_kegiatan }}" {{ $galeri->kegiatan_id_kegiatan == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                            {{ $kegiatan->nama_kegiatan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@include('layouts.footer')
