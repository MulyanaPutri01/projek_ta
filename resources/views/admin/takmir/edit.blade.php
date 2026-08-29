@section('title', 'Kelola Pengguna')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kelola Pengguna</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Kelola Pengguna</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <div class="container">
        <a href="/takmir" class="btn btn-secondary btn-sm">Kembali</i></a>
        <h1>Edit Takmir</h1>
        <div class="card">
            <div class="card-body">
                <br>
                <form action="{{ route('takmir.update', $takmir->id_takmir) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $takmir->username) }}" required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password (Kosongkan jika tidak ingin diubah)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak diubah">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="toggle-password">👁️</button>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password jika diubah">
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id_role">Role</label>
                        <select class="form-control" id="role_id_role" name="role_id_role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id_role }}" {{ old('role_id_role', $takmir->role_id_role) == $role->id_role ? 'selected' : '' }}>
                                    {{ $role->nama_role }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id_role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_takmir">Nama Takmir</label>
                        <input type="text" class="form-control" id="nama_takmir" name="nama_takmir" value="{{ old('nama_takmir', $takmir->nama_takmir) }}" required>
                        @error('nama_takmir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.innerHTML = type === 'password' ? '👁️' : '🙈';
        });
    </script>
    @endsection
@include('layouts.footer')
