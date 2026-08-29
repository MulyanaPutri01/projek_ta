@section('title', 'Galeri')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Galeri</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Galeri</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="container mt-4">
        <h1 class="mb-4">Daftar Galeri</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($galeri->isEmpty())
            <p class="text-center">Tidak ada data galeri yang tersedia.</p>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($galeri as $item)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="Gambar" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama_foto }}</h5>
                                <p class="card-text"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</p>
                                <p class="card-text"><strong>Kegiatan:</strong> {{ $item->kegiatan->nama_kegiatan }}</p>
                                <p class="card-text"><strong>Dibuat Oleh:</strong> {{ $item->takmir->nama_takmir }}</p>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-primary btn-sm">Lihat Detail</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $galeri->links() }}
            </div>
        @endif
    </div>
</main>
@include('layouts.footer')
