@section('title', 'Edit Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Jadwal Kegiatan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Jadwal Kegiatan</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Edit Jadwal Kegiatan</h2>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-8">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required maxlength="150">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tempat</label>
                        <input type="text" class="form-control" name="tempat" value="{{ old('tempat', $kegiatan->tempat) }}" required maxlength="100">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mulai Acara</label>
                        <input type="time" class="form-control" name="mulai_kegiatan" value="{{ old('mulai_kegiatan', \Carbon\Carbon::parse($kegiatan->mulai_kegiatan)->format('H:i')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Akhir Acara</label>
                        <input type="time" class="form-control" name="akhir_kegiatan" value="{{ old('akhir_kegiatan', \Carbon\Carbon::parse($kegiatan->akhir_kegiatan)->format('H:i')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Waktu Sholat / Periode</label>
                        <input type="text" class="form-control" name="nama_waktu" value="{{ old('nama_waktu', $kegiatan->nama_waktu) }}" maxlength="50">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Penceramah / Pembicara</label>
                        <input type="text" class="form-control" name="pembicara" value="{{ old('pembicara', $kegiatan->pembicara) }}" maxlength="100">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Audience / Peserta</label>
                        <input type="text" class="form-control" name="audience" value="{{ old('audience', $kegiatan->audience) }}" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Khotib</label>
                        <input type="text" class="form-control" name="nama_khotib" value="{{ old('nama_khotib', $kegiatan->nama_khotib) }}" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Muadzin</label>
                        <input type="text" class="form-control" name="nama_muadzin" value="{{ old('nama_muadzin', $kegiatan->nama_muadzin) }}" maxlength="100">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Perbarui Kegiatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
