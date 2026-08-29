@section('title', 'Kelola Takmir')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Kelola Takmir</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelola Takmir</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('takmir.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Takmir
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-primary fw-bold small text-uppercase letter-spacing-1">Total Takmir</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalTakmir }}</h3>
                                <small class="text-muted">Pengurus Terdaftar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-success fw-bold small text-uppercase letter-spacing-1">Takmir Aktif</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalActive }}</h3>
                                <small class="text-muted">Akses Sistem Aktif</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-danger text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-person-x-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-danger fw-bold small text-uppercase letter-spacing-1">Takmir Nonaktif</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalInactive }}</h3>
                                <small class="text-muted">Akses Dinonaktifkan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card with Table & Integrated Filters -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row g-2 align-items-center justify-content-between">
                    <div class="col-md-4 col-12">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table me-2 text-primary"></i>Daftar Pengurus Takmir</h5>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
                            <div style="min-width: 150px;">
                                <select id="filter_role" class="form-select form-select-sm">
                                    <option value="">Semua Peran (Role)</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->nama_role) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="min-width: 140px;">
                                <select id="filter_status" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif Saja</option>
                                    <option value="inactive">Nonaktif Saja</option>
                                </select>
                            </div>

                            <button id="btn_reset" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="takmirTable" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Informasi Takmir</th>
                                <th class="text-center" style="width: 150px;">Peran / Hak Akses</th>
                                <th class="text-center" style="width: 130px;">Status Akun</th>
                                <th class="text-center" style="width: 260px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery !== 'undefined' && $.fn.DataTable) {
            initTakmirTable();
        } else {
            // Fallback if jQuery takes a few ms to load
            window.addEventListener('load', initTakmirTable);
        }

        function initTakmirTable() {
            var table = $('#takmirTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('takmir.index') }}",
                    data: function (d) {
                        d.status = $('#filter_status').val();
                        d.role_id = $('#filter_role').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'user_info', name: 'nama_takmir' },
                    { data: 'role_name', name: 'role.nama_role', className: 'text-center' },
                    { data: 'status_badge', name: 'status', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'asc']],
                language: {
                    processing: "<div class='spinner-border text-primary spinner-border-sm me-2'></div> Memuat data takmir...",
                    search: "Cari Takmir:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ takmir",
                    infoEmpty: "Tidak ada data takmir",
                    emptyTable: "Belum ada data pengurus takmir",
                    paginate: {
                        first: "«",
                        previous: "‹",
                        next: "›",
                        last: "»"
                    }
                }
            });

            $('#filter_status, #filter_role').on('change', function() {
                table.draw();
            });

            $('#btn_reset').on('click', function() {
                $('#filter_status').val('');
                $('#filter_role').val('');
                table.draw();
            });
        }
    });
</script>
