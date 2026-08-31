@section('title', 'Edit Hak Akses')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">
                <i class="bi bi-pencil-square text-warning me-2"></i>Edit Hak Akses (Permission)
            </h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Hak Akses</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-key-fill text-warning fs-5"></i>
                            <h5 class="fw-bold text-dark mb-0">Edit Hak Akses: <span class="font-monospace text-primary">{{ $permission->name }}</span></h5>
                        </div>
                        <span class="badge bg-light text-muted border font-monospace">ID: #{{ $permission->id }}</span>
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

                        <form action="{{ route('permissions.update', $permission->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <!-- Nama Permission Slug -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold text-dark">
                                    Nama Permission (Slug) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                    <input type="text" name="name" id="name" class="form-control border-start-0 font-monospace fw-semibold" 
                                           placeholder="Contoh: keuangan-create, kegiatan-edit" 
                                           value="{{ old('name', $permission->name) }}" required autofocus>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    Format slug berupa huruf kecil dan tanda minus penghubung.
                                </small>
                            </div>

                            <!-- Assign to Roles -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-2">
                                    Atur Peran (Roles) yang Memiliki Hak Akses Ini:
                                </label>
                                <div class="row g-3">
                                    @foreach($roles as $role)
                                        @php
                                            $roleName = strtolower($role->name);
                                            $hasPerm = in_array($role->id, old('roles', $assignedRoleIds));
                                            $bg = 'border-secondary';
                                            if ($roleName === 'admin') $bg = 'border-primary bg-primary bg-opacity-10';
                                            elseif ($roleName === 'bendahara') $bg = 'border-success bg-success bg-opacity-10';
                                            elseif ($roleName === 'sekretaris') $bg = 'border-warning bg-warning bg-opacity-10';
                                        @endphp
                                        <div class="col-md-4 col-sm-6">
                                            <label class="d-flex align-items-center gap-2 p-3 rounded-3 border {{ $bg }} cursor-pointer h-100">
                                                <input class="form-check-input mt-0" type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                       {{ $roleName === 'admin' || $hasPerm ? 'checked' : '' }}
                                                       {{ $roleName === 'admin' ? 'disabled' : '' }}>
                                                <div>
                                                    <span class="fw-bold text-dark d-block">{{ ucfirst($role->name) }}</span>
                                                    <small class="text-muted" style="font-size: 0.72rem;">Guard: {{ $role->guard_name }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    💡 <em>Role <strong>Administrator</strong> selalu mempertahankan seluruh izin sistem secara penuh.</em>
                                </small>
                            </div>

                            <hr class="my-4">

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('permissions.index') }}" class="btn btn-light px-4 rounded-pill">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-warning px-4 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
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
