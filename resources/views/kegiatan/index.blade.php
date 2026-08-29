@section('title', 'Jadwal Agenda Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Jadwal Agenda Kegiatan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Jadwal Kegiatan</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('kegiatan.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-calendar-plus-fill me-1"></i> Tambah Kegiatan
            </a>
            <a href="{{ route('kegiatan.calendar') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-calendar3 me-1"></i> Tampilan Kalender
            </a>
        </div>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-calendar-range-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-primary fw-bold small text-uppercase letter-spacing-1">Total Agenda</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalKegiatan }}</h3>
                                <small class="text-muted">Semua Kegiatan Terjadwal</small>
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
                                <i class="bi bi-calendar-month-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-success fw-bold small text-uppercase letter-spacing-1">Bulan Ini</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $bulanIni }}</h3>
                                <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-warning-emphasis fw-bold small text-uppercase letter-spacing-1">Agenda Mendatang</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $mendatang }}</h3>
                                <small class="text-muted">Akan Datang / Hari Ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row g-2 align-items-center justify-content-between">
                    <div class="col-md-4 col-12">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table me-2 text-primary"></i>Daftar Seluruh Agenda Kegiatan</h5>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
                            <div style="min-width: 150px;">
                                <select id="filter_month" class="form-select form-select-sm">
                                    <option value="">Semua Bulan</option>
                                    @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                                        <option value="{{ $key }}">{{ $bulan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="min-width: 140px;">
                                <select id="filter_year" class="form-select form-select-sm">
                                    <option value="">Semua Tahun</option>
                                    @foreach(range(date('Y'), date('Y') - 5) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
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
                    <table id="kegiatanTable" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th class="text-center" style="width: 70px;">Brosur</th>
                                <th>Informasi Agenda Kegiatan</th>
                                <th class="text-center" style="width: 140px;">Tanggal Pelaksanaan</th>
                                <th class="text-center" style="width: 170px;">Waktu Acara</th>
                                <th>Tempat & Sasaran</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
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
            initKegiatanTable();
        } else {
            window.addEventListener('load', initKegiatanTable);
        }

        function initKegiatanTable() {
            var table = $('#kegiatanTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('kegiatan.index') }}",
                    data: function (d) {
                        d.month = $('#filter_month').val();
                        d.year = $('#filter_year').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'brosur_thumb', name: 'foto', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'nama_kegiatan', name: 'nama_kegiatan' },
                    { data: 'tanggal', name: 'tanggal', className: 'text-center' },
                    { data: 'waktu_acara', name: 'mulai_kegiatan', className: 'text-center' },
                    { data: 'tempat', name: 'tempat' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[3, 'desc']],
                language: {
                    processing: "<div class='spinner-border text-primary spinner-border-sm me-2'></div> Memuat jadwal kegiatan...",
                    search: "Cari Agenda:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ agenda",
                    infoEmpty: "Tidak ada data agenda",
                    emptyTable: "Belum ada agenda kegiatan yang dijadwalkan",
                    paginate: {
                        first: "«",
                        previous: "‹",
                        next: "›",
                        last: "»"
                    }
                }
            });

            $('#filter_month, #filter_year').on('change', function() {
                table.draw();
            });

            $('#btn_reset').on('click', function() {
                $('#filter_month').val('');
                $('#filter_year').val('');
                table.draw();
            });
        }
    });
</script>
