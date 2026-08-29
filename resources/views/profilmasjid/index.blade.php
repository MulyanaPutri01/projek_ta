@section('title', 'Catatan Barang')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Profil Masjid</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Profil Masjid</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container">
        <h1>Data Profil Masjid</h1>
        @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        @endif

        <br>
        <!-- Formulir Pencarian -->
        <!--<div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <form method="GET" action="{{ route('profilmasjid.index') }}" class="d-inline">
                    <div class="d-flex flex-wrap align-items-end">
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <label for="search" class="form-label black-text">Cari Lainnya : </label>
                            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ $search ?? '' }}">
                        </div>
                        
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('profilmasjid.index') }}" class="btn btn-secondary mt-2">Tampil Seluruh Data</a>
                        </div>
                        <div class="me-2 mb-2 d-flex flex-column align-items-stretch">
                            <a href="{{ route('profilmasjid.create') }}" class="btn btn-primary">Tambah Data</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>-->

        <div class="card">
            
            
            <div class="card-body">
                <br>
                <div class="me-2 ">
                    <a href="{{ route('profilmasjid.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <br>
                @if($profil->isEmpty())
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                            <h5 class="text-center">Tidak ada data profil yang dicari.</h5>
                    </div>
                @else
                <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">

                    <table class="table table-bordered" >
                        <thead class="sticky-top bg-white" >
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Nama Masjid</th>
                                <th style="text-align: center;">Sejarah Masjid</th>
                                <th style="text-align: center;">Visi</th>
                                <th style="text-align: center;">Misi</th>
                                <th style="text-align: center;">Alamat</th>
                                <th style="text-align: center;">Nomor Telepon</th>
                                <th style="text-align: center;">Dibuat Oleh</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach($profil as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_masjid}}</td>
                                <td>{{ $item->sejarah}}</td>
                                <td>{{ $item->visi}}</td>
                                <td>{{ $item->misi}}</td>
                                <td>{{ $item->alamat}}</td>
                                <td>{{ $item->telepon}}</td>
                                <td>{{ $item->takmir->nama_takmir }}</td>
                                <td style="display: flex; gap: 10px; align-items: center;">
                                    <a href="{{ route('profilmasjid.edit', $item->id_profil) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('catatan.destroy', $item->id_profil) }}" method="POST" style="display:inline;">
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
                    
                @endif

            </div>
        </div>
    </div>

@include('layouts.footer')
