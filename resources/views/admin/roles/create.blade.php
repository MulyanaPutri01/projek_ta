@section('title', 'Tambah Peran Baru')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Tambah Peran (Role) Baru</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Peran & Hak Akses</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <!-- Role Basic Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body pt-3">
                    <h5 class="card-title fw-bold text-dark mb-2">Informasi Peran</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Peran (Role Name) <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: koordinator_humas" value="{{ old('name') }}" required maxlength="50">
                            <small class="text-muted">Gunakan huruf kecil atau underscore tanpa spasi.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permission Groups Grid -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-shield-check me-2 text-primary"></i>Pilih Hak Akses (Permissions)</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn-select-all"><i class="bi bi-check-all me-1"></i> Pilih Semua</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-deselect-all"><i class="bi bi-x me-1"></i> Hapus Pilihan</button>
                </div>
            </div>

            <div class="row g-4">
                @foreach($permissionGroups as $groupName => $perms)
                    <div class="col-lg-6 col-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light py-2 px-3 fw-bold text-dark d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-folder2-open me-2 text-primary"></i>{{ $groupName }}</span>
                                <span class="badge bg-secondary rounded-pill small">{{ count($perms) }} Akses</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    @foreach($perms as $permKey => $permLabel)
                                        <div class="col-md-6 col-12">
                                            <div class="form-check form-switch p-2 border rounded bg-white h-100 d-flex align-items-center">
                                                <input class="form-check-input ms-0 me-2 perm-checkbox" type="checkbox" name="permissions[]" value="{{ $permKey }}" id="perm_{{ $permKey }}">
                                                <label class="form-check-label small fw-medium text-dark cursor-pointer" for="perm_{{ $permKey }}">
                                                    {{ $permLabel }}
                                                    <span class="d-block text-muted" style="font-size: 0.7rem;">{{ $permKey }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body py-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Peran & Hak Akses
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#btn-select-all').on('click', function() {
            $('.perm-checkbox').prop('checked', true);
        });
        $('#btn-deselect-all').on('click', function() {
            $('.perm-checkbox').prop('checked', false);
        });
    });
</script>
