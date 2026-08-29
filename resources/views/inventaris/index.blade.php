@section('title', 'Inventaris')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Barang Inventaris Masjid</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('inventaris.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2 ">
                            <label for="search" class="form-label black-text">Pencarian : </label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control w-1000" placeholder="Cari nama inventaris">
                        </div>

                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('inventaris.create') }}" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary mt-2">Tampil Seluruh Data</a>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                        <a href="{{ route('inventaris.pdf') }}" class="btn btn-success">Unduh PDF</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <br>
                @if($inventariss->isEmpty())
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        <h5 class="text-center">Tidak ada data inventaris yang dicari.</h5>
                </div>
                @else

                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th scope="col"style="text-align: center;">No</th>
                                <th scope="col"style="text-align: center;">ID</th>
                                <th scope="col"style="text-align: center;">Nama Barang</th>
                                <th scope="col"style="text-align: center;">Jumlah Barang</th>
                                <th scope="col"style="text-align: center;">Tahun Pembelian</th>
                                <th scope="col"style="text-align: center;">Lokasi Barang </th>
                                <th scope="col"style="text-align: center;">Keterangan </th>
                                <th scope="col"style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventariss as $val =>$inventaris)
                                <tr>
                                    <td style="text-align: center;">{{ $val + $inventariss->firstItem() }} </td>
                                    <td>{{ $inventaris->id_inventaris }}</td>
                                    <td>{{ $inventaris->nama_barang }}</td>
                                    <td>{{ $inventaris->jumlah }}</td>
                                    <td>{{ $inventaris->tahun_pembelian }}</td>
                                    <td>{{ $inventaris->lokasi }}</td>
                                    <td>{{ $inventaris->keterangan }}</td>
                                    <td>
                                        <div style="display: flex; flex-direction: row;">
                                            <a href="{{ route('inventaris.edit', $inventaris->id_inventaris) }}" class="btn btn-info" data-bs-placement="bottom">Edit</a>
                                            <form action="{{ route('inventaris.destroy', $inventaris->id_inventaris) }}" method="POST" style="margin-left: 5px;">
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-warning" data-bs-placement="bottom">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                            <div class="mt-3">
                                <strong>Total Inventaris:</strong> {{ $totalInventaris }}
                            </div>
                    </table>
                            <!-- Pagination -->
                        {{ $inventariss->links() }}
                @endif
            </div>
        </div>
    </div>
@include('layouts.footer')
