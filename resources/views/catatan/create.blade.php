@section('title', 'Tambah Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Catatan Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('catatan.index') }}">Catatan Barang</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <a href="{{ route('catatan.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        <h2>Tambah Data Catatan Kondisi Inventaris</h2>

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('catatan.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Data Inventaris</label>
                        <select name="inventaris_id" class="form-select" required>
                            <option value="">Pilih Barang...</option>
                            @foreach($inventariss as $inventaris)
                                <option value="{{ $inventaris->id }}" {{ old('inventaris_id') == $inventaris->id ? 'selected' : '' }}>
                                    {{ $inventaris->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Catatan</label>
                        <input type="date" name="tanggal_catatan" class="form-control" value="{{ old('tanggal_catatan', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi Barang</label>
                        <select name="kondisi_id" class="form-select" required>
                            <option value="">Pilih Kondisi...</option>
                            @foreach($kondisis as $kondisi)
                                <option value="{{ $kondisi->id }}" {{ old('kondisi_id') == $kondisi->id ? 'selected' : '' }}>
                                    {{ $kondisi->nama_kondisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
