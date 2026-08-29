@section('title', 'Edit Takmir')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kelola Takmir</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('takmir.index') }}">Kelola Takmir</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <a href="{{ route('takmir.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h2>Edit Akun Takmir</h2>

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
                <form action="{{ route('takmir.update', $takmir->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap Takmir</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            <input type="text" name="nama_takmir" class="form-control" value="{{ old('nama_takmir', $takmir->nama_takmir) }}" required maxlength="50">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username Login</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-at"></i></span>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $takmir->username) }}" required maxlength="30">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password Baru (Kosongkan jika tidak diubah)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah" minlength="8">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password jika diubah" minlength="8">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Peran / Role Akses</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-shield-check"></i></span>
                            <select name="role_id" class="form-select" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ (old('role_id', $takmir->role_id) == $role->id) ? 'selected' : '' }}>
                                        {{ ucfirst($role->nama_role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
