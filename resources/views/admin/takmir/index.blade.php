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
        <h1>Daftar Pengguna</h1>
        <a href="{{ route('takmir.create') }}" class="btn btn-primary">Tambah Pengguna</a>
        <br>
        <br>
        <div class="card">
            <div class="card-body">
                <br>
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th scope="col"style="text-align: center;">ID Takmir</th>
                            <th scope="col"style="text-align: center;">Username</th>
                            <th scope="col"style="text-align: center;">Nama Pengguna</th>
                            <th scope="col"style="text-align: center;">Status</th>
                            <th scope="col"style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($takmirs as $takmir)
                            <tr>
                                <td style="text-align: center;">{{ $takmir->id_takmir }}</td>
                                <td>{{ $takmir->username }}</td>
                                <td>{{ $takmir->nama_takmir }}</td>
                                <td>
                                    @if ($takmir->status == 'active')
                                        <span class="text-success">✅ Aktif</span>
                                    @else
                                        <span class="text-danger">❌ Nonaktif</span>
                                    @endif
                                </td>

                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('takmir.edit', $takmir->id_takmir) }}" class="btn btn-primary btn-sm">Edit</a>

                                    <!-- Tombol Aktif/Nonaktif -->
                                    @if ($takmir->status == 'active')
                                        <form action="{{ route('takmir.toggleStatus', $takmir->id_takmir) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning btn-sm">Nonaktifkan</button>
                                        </form>
                                    @else
                                        <form action="{{ route('takmir.toggleStatus', $takmir->id_takmir) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
                                        </form>
                                    @endif

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('takmir.destroy', $takmir->id_takmir) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@include('layouts.footer')
