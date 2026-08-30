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
            <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalInventarisPdfOptions">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh / Cetak PDF
            </button>
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

<!-- Modal Opsi Cetak PDF Inventaris -->
<div class="modal fade" id="modalInventarisPdfOptions" tabindex="-1" aria-labelledby="modalInventarisPdfOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white py-3">
                <h6 class="modal-title fw-bold" id="modalInventarisPdfOptionsLabel">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Opsi Cetak & Unduh PDF Inventaris
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- 1. Pilihan Ukuran Kertas -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark mb-2">1. Pilih Ukuran Kertas:</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="inv_pdf_paper" value="a4" class="d-none inv-paper-radio" checked>
                                <div class="card border p-3 text-center transition-all inv-paper-card selected-paper">
                                    <div class="fw-bold text-dark fs-6 mb-1">A4</div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">210 x 297 mm</small>
                                    <span class="badge bg-primary-subtle text-primary mt-1" style="font-size: 0.68rem;">Standar Internasional</span>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="inv_pdf_paper" value="f4" class="d-none inv-paper-radio">
                                <div class="card border p-3 text-center transition-all inv-paper-card">
                                    <div class="fw-bold text-dark fs-6 mb-1">F4 / Folio</div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">215 x 330 mm</small>
                                    <span class="badge bg-success-subtle text-success mt-1" style="font-size: 0.68rem;">Standar Indonesia</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 2. Pilihan Orientasi Kertas -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-2">2. Pilih Orientasi Halaman:</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="inv_pdf_orientation" value="landscape" class="d-none inv-orientation-radio" checked>
                                <div class="card border p-3 text-center transition-all inv-orientation-card selected-orientation">
                                    <i class="bi bi-aspect-ratio text-primary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Landscape</div>
                                    <small class="text-success fw-semibold d-block" style="font-size: 0.68rem;">★ Pas Untuk Tabel</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="inv_pdf_orientation" value="portrait" class="d-none inv-orientation-radio">
                                <div class="card border p-3 text-center transition-all inv-orientation-card">
                                    <i class="bi bi-file-earmark text-secondary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Portrait</div>
                                    <small class="text-muted d-block" style="font-size: 0.68rem;">Tegak Vertikal</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border small text-muted mb-0 py-2">
                    <i class="bi bi-info-circle text-primary me-1"></i> Dokumen PDF mencakup seluruh data aset fisik inventaris masjid dan disesuaikan agar tidak terpotong.
                </div>

            </div>
            <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn_generate_inv_pdf" class="btn btn-danger btn-sm shadow-sm fw-semibold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Buka & Unduh PDF
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .inv-paper-card:hover, .inv-orientation-card:hover {
        border-color: #065f46 !important;
        transform: translateY(-2px);
    }
    .selected-paper, .selected-orientation {
        border-color: #065f46 !important;
        border-width: 2px !important;
        background-color: #f0fdf4 !important;
    }
</style>

<script>
$(document).ready(function() {
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

    // Paper selection styling
    document.querySelectorAll('.inv-paper-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.inv-paper-card').forEach(c => c.classList.remove('selected-paper'));
            this.closest('label').querySelector('.inv-paper-card').classList.add('selected-paper');
        });
    });

    // Orientation selection styling
    document.querySelectorAll('.inv-orientation-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.inv-orientation-card').forEach(c => c.classList.remove('selected-orientation'));
            this.closest('label').querySelector('.inv-orientation-card').classList.add('selected-orientation');
        });
    });

    // Generate PDF Click
    var btnGenInvPdf = document.getElementById('btn_generate_inv_pdf');
    if (btnGenInvPdf) {
        btnGenInvPdf.addEventListener('click', function() {
            var paperEl = document.querySelector('.inv-paper-radio:checked');
            var orientationEl = document.querySelector('.inv-orientation-radio:checked');

            var paper = paperEl ? paperEl.value : 'a4';
            var orientation = orientationEl ? orientationEl.value : 'landscape';

            var params = new URLSearchParams({
                lokasi: $('#filter_lokasi').val(),
                tahun: $('#filter_tahun').val(),
                paper: paper,
                orientation: orientation
            });

            var url = '{{ route("inventaris.pdf") }}?' + params.toString();
            window.open(url, '_blank');

            var modalEl = document.getElementById('modalInventarisPdfOptions');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    }
});
</script>

