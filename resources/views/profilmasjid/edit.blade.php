@section('title', 'Edit Profil Masjid')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Profil Masjid</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profilmasjid.index') }}">Profil Masjid</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('profilmasjid.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Edit Profil Masjid</h2>

        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('profilmasjid.update', $profil->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Nama Masjid</label>
                        <input type="text" name="nama_masjid" class="form-control" value="{{ old('nama_masjid', $profil->nama_masjid) }}" required maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telepon / WhatsApp</label>
                        <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}" maxlength="15">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $profil->alamat) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Sejarah Masjid</label>
                        <textarea name="sejarah" class="form-control" rows="4">{{ old('sejarah', $profil->sejarah) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Visi Masjid</label>
                        <textarea name="visi" class="form-control" rows="3">{{ old('visi', $profil->visi) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Misi Masjid</label>
                        <textarea name="misi" class="form-control" rows="3">{{ old('misi', $profil->misi) }}</textarea>
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
