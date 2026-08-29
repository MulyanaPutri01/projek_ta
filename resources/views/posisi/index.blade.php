@section('title', 'Posisi')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Posisi Kepanitiaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Posisi Kepanitiaan</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <h1>Data Posisi Kepanitiaan</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('posisi.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2">
                            <label for="search" class="form-label black-text">Nama Posisi : </label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama kegiatan">
                        </div>

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#posisiCreateModal">Tambah Data</button>
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
                @if($posisis->isEmpty())
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        <h5 class="text-center">Tidak ada data posisi yang dicari.</h5>
                </div>
                @else
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th scope="col"style="text-align: center;">No</th>
                                <th scope="col"style="text-align: center;">ID</th>
                                <th scope="col"style="text-align: center;">Posisi</th>
                                <th scope="col"style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posisis as $val =>$posisi)
                                <tr>
                                    <td style="text-align: center;">{{ $val + $posisis->firstItem() }} </td>
                                    <td>{{ $posisi->id_posisi }}</td>
                                    <td>{{ $posisi->nama_posisi }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPosisiModal{{ $posisi->id_posisi }}">Edit</button>
                                        <form action="{{ route('posisi.destroy', $posisi->id_posisi) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editPosisiModal{{ $posisi->id_posisi }}" tabindex="-1" aria-labelledby="editPosisiModalLabel{{ $posisi->id_posisi }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPosisiModalLabel{{ $posisi->id_posisi }}">Edit Posisi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('posisi.update', ['posisi' => $posisi->id_posisi]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nama_posisi">Posisi Panitia</label>
                                                        <input type="text" name="nama_posisi" class="form-control" value="{{ $posisi->nama_posisi }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                            <div class="mt-3">
                                <strong>Total Posisi:</strong> {{ $totalPosisi }}
                            </div>
                    </table>
                            <!-- Pagination -->
                        {{ $posisis->links() }}
                @endif

                <!-- Modal Create -->
                <div class="modal fade" id="posisiCreateModal" tabindex="-1" aria-labelledby="posisiCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="posisiCreateModalLabel">Tambah Posisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('posisi.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_posisi">Posisi Panitia</label>
                                        <input type="text" name="nama_posisi" class="form-control" required>
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
