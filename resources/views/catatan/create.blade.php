@section('title', 'Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Catatan Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Catatan Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <div class="container">
    <a href="/catatan" class="btn btn-secondary btn-sm">Kembali</i></a>
    <h2>Tambah Data Catatan Kondisi Inventaris</h2>

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
            <form action="{{ route('catatan.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <label for="inventaris_id_inventaris">Data Inventaris</label>
                        <select name="inventaris_id_inventaris" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($inventariss as $inventaris)
                                <option value="{{ $inventaris->id_inventaris }}">{{ $inventaris->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="tanggal_catatan">Tanggal</label>
                        <input type="date" name="tanggal_catatan" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="kondisi_id_kondisi">Kondisi Barang</label>
                        <select name="kondisi_id_kondisi" class="form-control" required>
                            <option value="">Pilih Kondisi</option>
                            @foreach($kondisis as $kondisi)
                                <option value="{{ $kondisi->id_kondisi }}">{{ $kondisi->nama_kondisi }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <!--<div class="form-row">
                    <div class="col">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" maxlength="50" required>
                    </div>

                </div>-->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

@include('layouts.footer')
