@section('title', 'Tambah Data Donatur')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Tambah Data Donatur</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('donatur.index') }}">Donatur</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('donatur.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('donatur.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Tanggal Pencatatan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nama Lengkap Donatur <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama_donatur" class="form-control" value="{{ old('nama_donatur') }}" placeholder="Contoh: H. Ahmad Subarjo" required maxlength="100">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nomor Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="Contoh: 081234567890" maxlength="25">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Alamat Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Contoh: Jl. Merdeka No. 10, RT 01/RW 02" required maxlength="255">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('donatur.index') }}" class="btn btn-light border px-3">Batal</a>
                                <button type="submit" class="btn btn-success px-4 shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan Donatur
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
