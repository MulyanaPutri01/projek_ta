@section('title', 'Edit Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Catatan Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('catatan.index') }}">Catatan Barang</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <a href="{{ route('catatan.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        <h2>Edit Data Catatan Barang</h2>

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('catatan.update', $catatan->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Data Inventaris</label>
                        <select name="inventaris_id" class="form-select" required>
                            @foreach($inventariss as $inventaris)
                                <option value="{{ $inventaris->id }}" {{ $inventaris->id == $catatan->inventaris_id ? 'selected' : '' }}>
                                    {{ $inventaris->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Catatan</label>
                        <input type="date" name="tanggal_catatan" class="form-control" value="{{ old('tanggal_catatan', $catatan->tanggal_catatan) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi Barang</label>
                        <select name="kondisi_id" class="form-select" required>
                            @foreach($kondisis as $kondisi)
                                <option value="{{ $kondisi->id }}" {{ $kondisi->id == $catatan->kondisi_id ? 'selected' : '' }}>
                                    {{ $kondisi->nama_kondisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
