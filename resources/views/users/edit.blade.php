@section('title', 'Edit Pengguna')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-body pt-4">
                <form action="{{ route('users.update', $takmir->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_takmir" class="form-control" value="{{ old('nama_takmir', $takmir->nama_takmir) }}" required maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control bg-light" value="{{ $takmir->username }}" readonly disabled>
                        <small class="text-muted">Username tidak dapat diubah</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" minlength="8" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ (old('role_id', $takmir->role_id) == $role->id) ? 'selected' : '' }}>
                                    {{ ucfirst($role->nama_role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Akun</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status', $takmir->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $takmir->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
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
