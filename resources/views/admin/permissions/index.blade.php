@section('title', 'Kelola Hak Akses (Permissions)')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">
                <i class="bi bi-key text-primary me-2"></i>Kelola Hak Akses (Permissions)
            </h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Peran & Hak Akses</a></li>
                    <li class="breadcrumb-item active">Hak Akses</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-3 fw-semibold">
                <i class="bi bi-shield-lock me-1"></i> Kelola Peran (Roles)
            </a>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary rounded-pill shadow-sm px-3 fw-semibold">
                <i class="bi bi-plus-circle me-1"></i> Tambah Hak Akses Baru
            </a>
        </div>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Hak Akses</small>
                            <h4 class="fw-bold text-dark mb-0">{{ $totalPermissions }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Peran Aktif</small>
                            <h4 class="fw-bold text-dark mb-0">{{ $totalRoles }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-layers-fill"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Sistem Keamanan</small>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Spatie Role & Permission</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter & Table Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-table text-primary fs-5"></i>
                    <h5 class="fw-bold text-dark mb-0">Daftar Hak Akses Sistem (Permissions)</h5>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Filter Modul -->
                    <select id="filter_module" class="form-select form-select-sm" style="min-width: 170px;">
                        <option value="">Semua Modul...</option>
                        <option value="user">Pengguna</option>
                        <option value="role">Peran (Role)</option>
                        <option value="permission">Hak Akses</option>
                        <option value="keuangan">Keuangan Kas</option>
                        <option value="laporan">Laporan Kas</option>
                        <option value="donatur">Data Donatur</option>
                        <option value="kategori">Kategori Kas</option>
                        <option value="kegiatan">Agenda Kegiatan</option>
                        <option value="kepanitiaan">Kepanitiaan</option>
                        <option value="posisi">Master Posisi</option>
                        <option value="inventaris">Inventaris Barang</option>
                        <option value="catatan">Catatan Kondisi</option>
                        <option value="kondisi">Master Kondisi</option>
                        <option value="profilmasjid">Profil Masjid</option>
                        <option value="galeri">Galeri Foto</option>
                    </select>

                    <!-- Filter Peran -->
                    <select id="filter_role" class="form-select form-select-sm" style="min-width: 150px;">
                        <option value="">Semua Peran...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>

                    <button type="button" id="btn_reset_filter" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100" id="permissionsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th style="min-width: 180px;">Nama Permission (Slug)</th>
                                <th style="min-width: 160px;">Modul / Fitur</th>
                                <th style="min-width: 220px;">Diberikan Kepada Peran</th>
                                <th class="text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

@include('layouts.footer')

@push('styles')
<style>
    #permissionsTable_wrapper .dataTables_paginate .paginate_button.active a {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
    }
</style>
@endpush

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
            initPermissionsTable();
        } else {
            window.addEventListener('load', initPermissionsTable);
        }

        function initPermissionsTable() {
            const table = $('#permissionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('permissions.index') }}",
                    data: function (d) {
                        d.module = $('#filter_module').val();
                        d.role = $('#filter_role').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center fw-semibold text-muted' },
                    { data: 'name', name: 'name' },
                    { data: 'module_badge', name: 'module_badge', orderable: false },
                    { data: 'roles_list', name: 'roles_list', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'asc']],
                language: {
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Memuat...</span></div> Memuat data...',
                    search: "Cari Permission:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ hak akses",
                    infoEmpty: "Tidak ada hak akses",
                    emptyTable: "Belum ada data hak akses yang terdaftar",
                    zeroRecords: "Tidak ditemukan data yang sesuai dengan pencarian",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "&rarr;",
                        previous: "&larr;"
                    }
                }
            });

            $('#filter_module, #filter_role').on('change', function() {
                table.draw();
            });

            $('#btn_reset_filter').on('click', function() {
                $('#filter_module').val('');
                $('#filter_role').val('');
                table.draw();
            });
        }
    });
</script>
