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
    <h2>Edit Data Catatan Barang</h2>

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

            <form action="{{ route('catatan.update', $catatan->id_catatan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="inventaris_id_inventaris" class="form-label">Inventaris</label>
                    <select name="inventaris_id_inventaris" id="inventaris_id_inventaris" class="form-control">
                        @foreach($inventariss as $inventaris)
                            <option value="{{ $inventaris->id_inventaris }}" {{ $inventaris->id_inventaris == $catatan->inventaris_id_inventaris ? 'selected' : '' }}>
                                {{ $inventaris->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_catatan" class="form-label">Tanggal Catatan</label>
                    <input type="date" name="tanggal_catatan" id="tanggal_catatan" class="form-control" value="{{ $catatan->tanggal_catatan }}">
                </div>

                <div class="mb-3">
                    <label for="kondisi_id_kondisi" class="form-label">Kondisi</label>
                    <select name="kondisi_id_kondisi" id="kondisi_id_kondisi" class="form-control">
                        @foreach($kondisis as $kondisi)
                            <option value="{{ $kondisi->id_kondisi }}" {{ $kondisi->id_kondisi == $catatan->kondisi_id_kondisi ? 'selected' : '' }}>
                                {{ $kondisi->nama_kondisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $catatan->keterangan }}">
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

