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
    <h1>Tambah Galeri</h1>
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
            <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nama_foto">Nama Foto</label>
                    <input type="text" name="nama_foto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kegiatan_id_kegiatan">Kegiatan</label>
                    <select name="kegiatan_id_kegiatan" class="form-control" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id_kegiatan }}">{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@include('layouts.footer')
