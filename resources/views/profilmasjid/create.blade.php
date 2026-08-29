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
    <h2>Tambah Profil Masjid</h2>

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
            <form action="{{ route('profilmasjid.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Nama Masjid</label>
                        <input type="text" name="nama_masjid" class="form-control" maxlength="50" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Sejarah Masjid</label>
                        <textarea name="sejarah" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Visi Masjid</label>
                        <textarea name="visi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Misi Masjid</label>
                        <textarea name="misi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Alamat Masjid</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" maxlength="15">
                    </div>
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
