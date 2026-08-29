@section('title', 'Data Barang Inventaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Data Barang Inventaris</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Barang Inventaris</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventaris.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Barang
            </a>
            <a href="{{ route('inventaris.pdf') }}" class="btn btn-danger shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh Laporan PDF
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
                                <i class="bi bi-boxes"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-primary fw-bold small text-uppercase letter-spacing-1">Jenis Barang</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalJenis }}</h3>
                                <small class="text-muted">Item Barang Terdata</small>
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
                                <i class="bi bi-box-seam-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-success fw-bold small text-uppercase letter-spacing-1">Total Kuantitas</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalUnit }}</h3>
                                <small class="text-muted">Unit / Set Aset Fisik</small>
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
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-warning-emphasis fw-bold small text-uppercase letter-spacing-1">Titik Lokasi</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ count($lokasiList) }}</h3>
                                <small class="text-muted">Ruang Penyimpanan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card Table with Filters -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row g-2 align-items-center justify-content-between">
                    <div class="col-md-4 col-12">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table me-2 text-primary"></i>Daftar Aset Barang Inventaris</h5>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
                            <div style="min-width: 170px;">
                                <select id="filter_lokasi" class="form-select form-select-sm">
                                    <option value="">Semua Lokasi Ruang</option>
                                    @foreach($lokasiList as $lok)
                                        <option value="{{ $lok }}">{{ $lok }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="min-width: 140px;">
                                <select id="filter_tahun" class="form-select form-select-sm">
                                    <option value="">Semua Tahun</option>
                                    @foreach(range(date('Y'), date('Y') - 10) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
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
                    <table id="inventarisTable" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Nama Barang & Kode</th>
                                <th class="text-center" style="width: 100px;">Jumlah</th>
                                <th class="text-center" style="width: 80px;">Tahun</th>
                                <th>Lokasi Ruangan</th>
                                <th class="text-center" style="width: 160px;">Kondisi Terakhir</th>
                                <th>Sumber / Keterangan</th>
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
            initInventarisTable();
        } else {
            window.addEventListener('load', initInventarisTable);
        }

        function initInventarisTable() {
            var table = $('#inventarisTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('inventaris.index') }}",
                    data: function (d) {
                        d.lokasi = $('#filter_lokasi').val();
                        d.tahun = $('#filter_tahun').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'jumlah', name: 'jumlah', className: 'text-center' },
                    { data: 'tahun_pembelian', name: 'tahun_pembelian', className: 'text-center' },
                    { data: 'lokasi', name: 'lokasi' },
                    { data: 'kondisi_terakhir', name: 'kondisi_terakhir', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'asc']],
                language: {
                    processing: "<div class='spinner-border text-primary spinner-border-sm me-2'></div> Memuat data inventaris...",
                    search: "Cari Barang:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ barang",
                    infoEmpty: "Tidak ada data barang",
                    emptyTable: "Belum ada aset barang inventaris yang terdaftar",
                    paginate: {
                        first: "«",
                        previous: "‹",
                        next: "›",
                        last: "»"
                    }
                }
            });

            $('#filter_lokasi, #filter_tahun').on('change', function() {
                table.draw();
            });

            $('#btn_reset').on('click', function() {
                $('#filter_lokasi').val('');
                $('#filter_tahun').val('');
                table.draw();
            });
        }
    });
</script>
