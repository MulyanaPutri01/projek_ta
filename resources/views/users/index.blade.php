@extends('layouts.layout')

@section('content')
<h1>Manajemen Pengguna</h1>

<form method="GET" action="{{ route('users.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama pengguna" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">Pilih Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </div>
</form>

<a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>


<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->nama_takmir }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role->nama_role }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id_takmir) }}" class="btn btn-warning"
                       onclick="return confirm('Apakah Anda yakin ingin mengubah status user ini?');">
                       Edit Status
                    </a>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
