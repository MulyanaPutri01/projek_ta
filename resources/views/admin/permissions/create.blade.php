@section('title', 'Tambah Hak Akses Baru')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">
                <i class="bi bi-plus-circle text-primary me-2"></i>Tambah Hak Akses (Permission)
            </h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Hak Akses</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-shield-plus text-primary fs-5"></i>
                        <h5 class="fw-bold text-dark mb-0">Formulir Hak Akses Baru</h5>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('permissions.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <!-- Nama Permission Slug -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold text-dark">
                                    Nama Permission (Slug) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                    <input type="text" name="name" id="name" class="form-control border-start-0 font-monospace" 
                                           placeholder="Contoh: broadcast-manage, laporan-export, santunan-list" 
                                           value="{{ old('name') }}" required autofocus>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    Format standar berupa huruf kecil dipisahkan tanda hubung (<code>modul-aksi</code>), contoh: <code>keuangan-delete</code>, <code>inventaris-pdf</code>.
                                </small>
                            </div>

                            <!-- Quick Prefix Suggestions -->
                            <div class="mb-4 p-3 bg-light rounded-3 border">
                                <label class="form-label fw-semibold text-dark small mb-2">Bantuan Awalan Modul (Klik untuk menambahkan):</label>
                                <div class="d-flex flex-wrap gap-1.5">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="setPrefix('user-')">user-</button>
                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill" onclick="setPrefix('keuangan-')">keuangan-</button>
                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill" onclick="setPrefix('laporan-')">laporan-</button>
                                    <button type="button" class="btn btn-outline-warning btn-sm rounded-pill text-dark" onclick="setPrefix('kegiatan-')">kegiatan-</button>
                                    <button type="button" class="btn btn-outline-warning btn-sm rounded-pill text-dark" onclick="setPrefix('kepanitiaan-')">kepanitiaan-</button>
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="setPrefix('inventaris-')">inventaris-</button>
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="setPrefix('catatan-')">catatan-</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" onclick="setPrefix('profilmasjid-')">profilmasjid-</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" onclick="setPrefix('galeri-')">galeri-</button>
                                </div>
                            </div>

                            <!-- Assign to Roles -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-2">
                                    Berikan Hak Akses Ini Langsung Kepada Peran (Roles):
                                </label>
                                <div class="row g-3">
                                    @foreach($roles as $role)
                                        @php
                                            $roleName = strtolower($role->name);
                                            $bg = 'border-secondary';
                                            if ($roleName === 'admin') $bg = 'border-primary bg-primary bg-opacity-10';
                                            elseif ($roleName === 'bendahara') $bg = 'border-success bg-success bg-opacity-10';
                                            elseif ($roleName === 'sekretaris') $bg = 'border-warning bg-warning bg-opacity-10';
                                        @endphp
                                        <div class="col-md-4 col-sm-6">
                                            <label class="d-flex align-items-center gap-2 p-3 rounded-3 border {{ $bg }} cursor-pointer h-100">
                                                <input class="form-check-input mt-0" type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                       {{ $roleName === 'admin' || (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
                                                <div>
                                                    <span class="fw-bold text-dark d-block">{{ ucfirst($role->name) }}</span>
                                                    <small class="text-muted" style="font-size: 0.72rem;">Guard: {{ $role->guard_name }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    💡 <em>Role <strong>Administrator</strong> secara otomatis memiliki seluruh hak akses sistem.</em>
                                </small>
                            </div>

                            <hr class="my-4">

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('permissions.index') }}" class="btn btn-light px-4 rounded-pill">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Hak Akses
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

<script>
    function setPrefix(prefix) {
        const input = document.getElementById('name');
        if (input) {
            input.value = prefix;
            input.focus();
        }
    }
</script>
