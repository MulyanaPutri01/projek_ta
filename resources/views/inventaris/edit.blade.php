@section('title', 'Inventaris')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<div class="container">
    <a href="/inventaris" class="btn btn-secondary btn-sm">Kembali</i></a>
    <br>
    <h1>Edit Inventaris</h1>

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
            <form action="{{ route('inventaris.update', $inventaris->id_inventaris) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="{{ $inventaris->nama_barang }}" required>
                    </div>
                    <div class="col">
                        <label for="tahun_pembelian">Tahun Pembelian</label>
                        <input type="number" class="form-control" name="tahun_pembelian" id="tahun_pembelian" value="{{ $inventaris->tahun_pembelian }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ $inventaris->jumlah }}" required>
                    </div>
                    <div class="col">
                        <label for="lokasi">Tempat Penyimpanan Barang</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" value="{{ $inventaris->lokasi }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="keterangan">Keterangan Barang</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $inventaris->keterangan }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Data</button>
            </form>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    @include('layouts.footer')
