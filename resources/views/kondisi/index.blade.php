@section('title', 'Kondisi')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kondisi Kepanitiaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Kondisi Kepanitiaan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Kondisi Kepanitiaan</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('kondisi.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2">
                            <label for="search" class="form-label black-text">Nama Kondisi : </label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari kondisi">
                        </div>

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kondisiCreateModal">Tambah Data</button>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('kondisi.index') }}" class="btn btn-secondary mt-2">Seluruh Data</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <br>
                @if($kondisis->isEmpty())
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        <h5 class="text-center">Tidak ada data kondisi yang dicari.</h5>
                </div>
                @else
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th scope="col"style="text-align: center;">No</th>
                                <th scope="col"style="text-align: center;">ID</th>
                                <th scope="col"style="text-align: center;">Kondisi</th>
                                <th scope="col"style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kondisis as $val =>$kondisi)
                                <tr>
                                    <td style="text-align: center;">{{ $val + $kondisis->firstItem() }} </td>
                                    <td>{{ $kondisi->id_kondisi }}</td>
                                    <td>{{ $kondisi->nama_kondisi }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKondisiModal{{ $kondisi->id_kondisi }}">Edit</button>
                                        <form action="{{ route('kondisi.destroy', $kondisi->id_kondisi) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editKondisiModal{{ $kondisi->id_kondisi }}" tabindex="-1" aria-labelledby="editKondisiModalLabel{{ $kondisi->id_kondisi }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editKondisiModalLabel{{ $kondisi->id_kondisi }}">Edit Kondisi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('kondisi.update', ['kondisi' => $kondisi->id_kondisi]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nama_kondisi">Kondisi Barang</label>
                                                        <input type="text" name="nama_kondisi" class="form-control" value="{{ $kondisi->nama_kondisi }}" required>
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
                                <strong>Total Kondisi:</strong> {{ $totalKondisi }}
                            </div>
                    </table>
                            <!-- Pagination -->
                        {{ $kondisis->links() }}
                @endif

                <!-- Modal Create -->
                <div class="modal fade" id="kondisiCreateModal" tabindex="-1" aria-labelledby="kondisiCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="kondisiCreateModalLabel">Tambah Kondisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kondisi.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_kondisi">Kondisi Barang</label>
                                        <input type="text" name="nama_kondisi" class="form-control" required>
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
