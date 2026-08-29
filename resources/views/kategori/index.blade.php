@section('title', 'Kategori')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kategori</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Kategori</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <h1>Data Kategori</h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('kategori.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kategoriCreateModal">Tambah Data</button>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('posisi.index') }}" class="btn btn-secondary mt-2">Seluruh Data</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <br>
                <table class="table table-bordered" >
                    <thead>
                        <tr>

                            <th scope="col"style="text-align: center;">ID Kategori</th>
                            <th scope="col"style="text-align: center;">Nama Kategori</th>
                            <th scope="col"style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as  $kategori)
                            <tr>

                                <td style="text-align: center;">{{ $kategori->id_kategori }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKategoriModal{{ $kategori->id_kategori }}">Edit</button>
                                    <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editKategoriModal{{ $kategori->id_kategori }}" tabindex="-1" aria-labelledby="editKategoriModalLabel{{ $kategori->id_kategori }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editKategoriModalLabel{{ $kategori->id_kategori }}">Edit Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('kategori.update', ['kategori' => $kategori->id_kategori]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="id_kategori">ID Kategori:</label>
                                                    <input type="text" name="id_kategori" class="form-control" id="id_kategori" value="{{ old('id_kategori', $kategori->id_kategori) }}" required maxlength="2">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_kategori">Nama Kategori:</label>
                                                    <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required maxlength="15">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>

                <!-- Modal Create -->
                <div class="modal fade" id="kategoriCreateModal" tabindex="-1" aria-labelledby="kategoriCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="kategoriCreateModalLabel">Tambah Posisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kategori.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="id_kategori">ID Kategori:</label>
                                        <input type="text" name="id_kategori" class="form-control" id="id_kategori" value="{{ old('id_kategori') }}" required maxlength="2">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kategori">Nama Kategori:</label>
                                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}" required maxlength="15">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@include('layouts.footer')
