@section('title', 'Kepanitiaan')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kepanitiaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Kepanitiaan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Kepanitiaan</h1>

        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form method="GET" action="{{ route('kepanitiaan.index') }}" class="d-flex flex-wrap align-items-end mb-4">
                <div class="me-2 mb-2">
                    <label for="search" class="form-label">Pencarian :</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari data....">
                </div>
                <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                    <button type="submit" class="btn btn-primary">Cari</button>

                </div>
                <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kepanitiaanCreateModal">Tambah Data1</button>
                </div>
                <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kepanitiaanCreateModal">Tambah Data</button>
                </div>
                <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                    <a href="{{ route('posisi.index') }}" class="btn btn-secondary mt-2">Posisi</a>
                </div>
                <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                    <a href="{{ route('kepanitiaan.index') }}" class="btn btn-secondary mt-2">Seluruh Data</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <br>
                <table class="table table-bordered" >
                    <thead class="sticky-top bg-white" >
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Jobdesk</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kepanitiaans as $kepanitiaan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kepanitiaan->kegiatan->nama_kegiatan }}</td>
                            <td>{{ $kepanitiaan->jobdesk }}</td>
                            <td>{{ $kepanitiaan->posisi->nama_posisi }}</td>

                            <td>
                                <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#kepanitiaanEditModal{{ $kepanitiaan->id_panitia }}">
                                    Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kepanitiaan.destroy', $kepanitiaan->id_panitia) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty


                        <!-- Modal Edit -->
                <div class="modal fade" id="kepanitiaanEditModal{{ $kepanitiaan->id_panitia }}" tabindex="-1" aria-labelledby="kepanitiaanEditModalLabel{{ $kepanitiaan->id_panitia }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="kepanitiaanEditModalLabel{{ $kepanitiaan->id_panitia }}">Edit Data Kepanitiaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Edit langsung dengan method PUT -->
                                <form action="{{ route('kepanitiaan.update', $kepanitiaan->id_panitia) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label for="kegiatan_id_kegiatan">Kegiatan</label>
                                        <select name="kegiatan_id_kegiatan" class="form-control" required>
                                            @foreach($kegiatans as $kegiatan)
                                                <option value="{{ $kegiatan->id_kegiatan }}"
                                                    @if($kepanitiaan->kegiatan_id_kegiatan == $kegiatan->id_kegiatan) selected @endif>
                                                    {{ $kegiatan->nama_kegiatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="jobdesk">Jobdesk</label>
                                        <input type="text" name="jobdesk" class="form-control" value="{{ $kepanitiaan->jobdesk }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="posisi_id_posisi">Posisi</label>
                                        <select name="posisi_id_posisi" class="form-control" required>
                                            @foreach($posisis as $posisi)
                                                <option value="{{ $posisi->id_posisi }}"
                                                    @if($kepanitiaan->posisi_id_posisi == $posisi->id_posisi) selected @endif>
                                                    {{ $posisi->nama_posisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $kepanitiaans->links() }}



        </div>
    </div>



</div>

<!-- Modal Create -->
<div class="modal fade" id="kepanitiaanCreateModal" tabindex="-1" aria-labelledby="kepanitiaanCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kepanitiaanCreateModalLabel">Tambah Kepanitiaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kepanitiaan.store') }}" method="POST">
                    @csrf
                    <!-- Kegiatan -->
                    <div class="form-group mb-3">
                        <label for="kegiatan_id_kegiatan">Kegiatan</label>
                        <select name="kegiatan_id_kegiatan" class="form-control" required>
                            <option value="">Pilih Kegiatan</option>
                            @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id_kegiatan }}">{{ $kegiatan->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Jobdesk -->
                    <div class="form-group mb-3">
                        <label for="jobdesk">Jobdesk</label>
                        <input type="text" name="jobdesk" class="form-control" required>
                    </div>
                    <!-- Posisi -->
                    <div class="form-group mb-3">
                        <label for="posisi_id_posisi">Posisi</label>
                        <select name="posisi_id_posisi" class="form-control" required>
                            <option value="">Pilih Posisi</option>
                            @foreach($posisis as $posisi)
                            <option value="{{ $posisi->id_posisi }}">{{ $posisi->nama_posisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('layouts.footer')


