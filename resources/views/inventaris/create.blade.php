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
    <h1>Tambah Barang</h1>

    <div class="card">
        <div class="card-body">
            <br>
            <form action="{{ route('inventaris.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Speaker"required>
                    </div>

                    <div class="col">
                        <label for="tahun_pembelian">Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" class="form-control" placeholder="2024" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="lokasi">Tempat Penyimpanan Barang</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lemari" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="keterangan">Keterangan Barang</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Perlu diganti" required>
                    </div>

                </div>
                
                <button type="submit" class="btn btn-primary">Tambah inventaris</button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

@include('layouts.footer')

