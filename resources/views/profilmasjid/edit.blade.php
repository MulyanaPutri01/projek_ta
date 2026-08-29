@section('title', 'Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Profil Masjid Al-Ikhlas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Profil Masjid</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<div class="container">
    <a href="/profilmasjid" class="btn btn-secondary btn-sm">Kembali</i></a>
    <h2>Edit data profil masjid</h2>

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
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('profilmasjid.update', $profil->id_profil) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Masjid</label>
                    <input type="text" name="nama_masjid" class="form-control" value="{{ $profil->nama_masjid }}" maxlength="50">
                </div>

                <div class="mb-3">
                    <label class="form-label">Sejarah</label>
                    <textarea name="sejarah" class="form-control" rows="4">{{ $profil->sejarah }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Visi</label>
                    <textarea name="visi" class="form-control" rows="2">{{ $profil->visi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Misi</label>
                    <textarea name="misi" class="form-control" rows="3">{{ $profil->misi }}</textarea>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ $profil->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ $profil->telepon }}" maxlength="15">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

@include('layouts.footer')

