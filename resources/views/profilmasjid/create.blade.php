@section('title', 'Tambah Profil Masjid')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Profil Masjid</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profilmasjid.index') }}">Profil Masjid</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('profilmasjid.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Tambah Profil Masjid</h2>

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
                <form action="{{ route('profilmasjid.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Nama Masjid</label>
                        <input type="text" name="nama_masjid" class="form-control" placeholder="Contoh: Masjid Al-Ikhlas" value="{{ old('nama_masjid') }}" maxlength="50" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="telepon" class="form-control" placeholder="08123456789" value="{{ old('telepon') }}" maxlength="15">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Masjid</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap masjid" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Sejarah Singkat Masjid</label>
                        <textarea name="sejarah" class="form-control" rows="4" placeholder="Sejarah pendirian masjid...">{{ old('sejarah') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Visi Masjid</label>
                        <textarea name="visi" class="form-control" rows="3" placeholder="Visi masjid...">{{ old('visi') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Misi Masjid</label>
                        <textarea name="misi" class="form-control" rows="3" placeholder="Misi masjid...">{{ old('misi') }}</textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
