@section('title', 'Keuangan')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Keuangan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Keuangan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<div class="container">
    <a href="/keuangan" class="btn btn-secondary btn-sm">Kembali</i></a>
    <h2>Edit Data Keuangan</h2>

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
            <form action="{{ route('keuangan.update', $keuangan->id_keuangan) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="col">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $keuangan->tanggal }}" required>
                    </div>
                    <div class="col">
                        <label for="kategori_id_kategori">Kategori</label>
                        <select name="kategori_id_kategori" class="form-control" required>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ $keuangan->kategori_id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="sumber_keuangan">Sumber Keuangan</label>
                        <input type="text" name="sumber_keuangan" class="form-control" value="{{ $keuangan->sumber_keuangan }}" required>
                    </div>
                    <div class="col">
                        <label for="nominal">Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="nominal" class="form-control" value="{{ $keuangan->nominal }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="donatur_id_donatur">Donatur</label>
                        <select name="donatur_id_donatur" class="form-control">
                            <option value="">Pilih Donatur (Opsional)</option>
                            @foreach($donaturs as $donatur)
                                <option value="{{ $donatur->id_donatur }}" {{ $keuangan->donatur_id_donatur == $donatur->id_donatur ? 'selected' : '' }}>{{ $donatur->nama_donatur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ $keuangan->keterangan }}" maxlength="100" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="kegiatan_id_kegiatan">Kegiatan</label>
                        <select name="kegiatan_id_kegiatan" class="form-control">
                            <option value="">Pilih Kegiatan (Opsional)</option>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id_kegiatan }}" {{ $keuangan->kegiatan_id_kegiatan == $kegiatan->id_kegiatan ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

@include('layouts.footer')

