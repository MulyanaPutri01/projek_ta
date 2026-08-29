@section('title', 'Donatur')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Donatur</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Donatur</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Donatur</h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('donatur.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2">
                            <label for="search" class="form-label black-text">Nama Donatur : </label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama donatur...">
                        </div>
                        <div class="me-2 mb-2">
                            <label for="month" class="form-label black-text">Bulan :</label>
                            <select name="month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                                    <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="me-2 mb-2">
                            <label for="year" class="form-label black-text">Tahun :</label>
                            <select name="year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#donaturCreateModal">Tambah Data</button>
                        </div>

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('donatur.index') }}" class="btn btn-secondary mt-2">Seluruh Data</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <br>
                @if($donaturs->isEmpty())
                    <p class="text-center">Tidak ada data kegiatan yang dicari.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col"style="text-align: center;">No</th>
                                <th scope="col"style="text-align: center;">ID Donatur</th>
                                <th scope="col"style="text-align: center;">Tanggal</th>
                                <th scope="col"style="text-align: center;">Nama Donatur</th>
                                <th scope="col"style="text-align: center;">Alamat</th>
                                <th scope="col"style="text-align: center;">Dibuat Oleh</th>
                                <th scope="col"style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donaturs as $val =>$donatur)
                                <tr>
                                    <td style="text-align: center;">{{ $val + $donaturs->firstItem() }}</td>
                                    <td>{{ $donatur->id_donatur }}</td>
                                    <td>{{ \Carbon\Carbon::parse($donatur->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $donatur->nama_donatur }}</td>
                                    <td>{{ $donatur->alamat }}</td>

                                    <td>{{ $donatur->nama_takmir ?? 'Unknown' }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDonaturModal{{ $donatur->id_donatur }}">Edit</button>
                                        <form action="{{ route('donatur.destroy', $donatur->id_donatur) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editDonaturModal{{ $donatur->id_donatur }}" tabindex="-1" aria-labelledby="editDonaturModalLabel{{ $donatur->id_donatur }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editDonaturModalLabel{{ $donatur->id_donatur }}">Edit Donatur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('donatur.update', ['donatur' => $donatur->id_donatur]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nama_donatur">Nama Donatur</label>
                                                        <input type="text" name="nama_donatur" class="form-control" value="{{ $donatur->nama_donatur }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat">Alamat</label>
                                                        <input type="text" name="alamat" class="form-control" value="{{ $donatur->alamat }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggal">Tanggal</label>
                                                        <input type="date" name="tanggal" class="form-control" value="{{ $donatur->tanggal }}" required>
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
                                <strong>Total Kegiatan:</strong> {{ $totalDonatur }}
                            </div>
                    </table>
                            <!-- Pagination -->
                        {{ $donaturs->links() }}
                @endif

                <!-- Modal Create -->
                <div class="modal fade" id="donaturCreateModal" tabindex="-1" aria-labelledby="donaturCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="donaturCreateModalLabel">Tambah Donatur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('donatur.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_donatur">Nama Donatur</label>
                                        <input type="text" name="nama_donatur" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" required>
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
