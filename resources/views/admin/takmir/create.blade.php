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
        <h1>Tambah Takmir</h1>
        <div class="card">
            <div class="card-body">
                <br>
                <form action="{{ route('takmir.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id_role">Role</label>
                        <select name="role_id_role" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id_role }}" {{ old('role_id_role') == $role->id_role ? 'selected' : '' }}>
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
                        <input type="text" name="nama_takmir" class="form-control" value="{{ old('nama_takmir') }}" required>
                        @error('nama_takmir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@include('layouts.footer')
