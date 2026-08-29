@section('title', 'Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kegiatan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Kegiatan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<div class="container">

    <a href="/kegiatan" class="btn btn-secondary btn-sm">Kembali</i></a>
    <h1>Tambah Kegiatan</h1>

    <div class="card">
        <div class="card-body">
            <br>
            <form action="{{ route('kegiatan.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="nama_kegiatan" id="nama_kegiatan" placeholder="Idul Fitri"required>
                    </div>
                    <div class="col">
                        <label for="tempat">Tempat</label>
                        <input type="text" class="form-control" name="tempat" id="tempat" placeholder="Masjid"required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="col">
                        <label for="nama_waktu">Nama Waktu</label>
                        <input type="text" class="form-control" name="nama_waktu" id="nama_waktu" placeholder="Ba'da Isya" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="pembicara">Pembicara</label>
                        <input type="text" class="form-control" name="pembicara" id="pembicara" placeholder="Nama Pembicara Acara" required>
                    </div>
                    <div class="col">
                        <label for="mulai_kegiatan">Mulai Acara</label>
                        <input type="time" class="form-control" name="mulai_kegiatan" id="mulai_kegiatan" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="audience">Audience</label>
                        <input type="text" class="form-control" name="audience" id="audience" placeholder="Umum"required>
                    </div>
                    <div class="col">
                        <label for="akhir_kegiatan">Akhir Acara</label>
                        <input type="time" class="form-control" name="akhir_kegiatan" id="akhir_kegiatan" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Kegiatan</button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

@include('layouts.footer')

