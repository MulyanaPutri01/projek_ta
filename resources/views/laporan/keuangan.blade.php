@section('title', 'Laporan Keuangan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Laporan Keuangan Masjid</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Keuangan</li>
                </ol>
            </nav>
        </div>
        @can('laporan-print')
        <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPdfOptions">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh / Cetak PDF
        </button>
        @endcan
    </div>

    <div class="container-fluid px-0">

        {{-- ===================== STAT CARDS ===================== --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                    <div class="card-body p-3">
                        <span class="text-success fw-bold small text-uppercase">Total Pemasukan</span>
                        <h4 class="fw-bold text-success mb-1" id="stat-pemasukan">Rp {{ number_format($stats->total_pemasukan ?? 0, 0, ',', '.') }}</h4>
                        <small class="text-muted">{{ $stats->jumlah_pemasukan ?? 0 }} transaksi pemasukan</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);">
                    <div class="card-body p-3">
                        <span class="text-danger fw-bold small text-uppercase">Total Pengeluaran</span>
                        <h4 class="fw-bold text-danger mb-1" id="stat-pengeluaran">Rp {{ number_format($stats->total_pengeluaran ?? 0, 0, ',', '.') }}</h4>
                        <small class="text-muted">{{ $stats->jumlah_pengeluaran ?? 0 }} transaksi pengeluaran</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="card-body p-3">
                        <span class="text-primary fw-bold small text-uppercase">Total Saldo Kas Tersedia</span>
                        <h4 class="fw-bold text-primary mb-1" id="stat-saldo">Rp {{ number_format(($stats->total_pemasukan ?? 0) - ($stats->total_pengeluaran ?? 0), 0, ',', '.') }}</h4>
                        <small class="text-muted">Status Kas Terkini</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== FILTER CARD ===================== --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Jenis Laporan</label>
                        <select id="filter_jenis" class="form-select form-select-sm">
                            <option value="">Semua Data</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="periode">Periode Tanggal</option>
                        </select>
                    </div>

                    <div class="col-md-2" id="wrap-year">
                        <label class="form-label small fw-bold">Tahun</label>
                        <select id="filter_year" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach(range(date('Y'), date('Y') - 5) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2" id="wrap-month" style="display:none;">
                        <label class="form-label small fw-bold">Bulan</label>
                        <select id="filter_month" class="form-select form-select-sm">
                            <option value="">Semua Bulan</option>
                            @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2" id="wrap-start" style="display:none;">
                        <label class="form-label small fw-bold">Tanggal Awal</label>
                        <input type="date" id="filter_start" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2" id="wrap-end" style="display:none;">
                        <label class="form-label small fw-bold">Tanggal Akhir</label>
                        <input type="date" id="filter_end" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3 d-flex justify-content-end gap-2 mt-3">
                        <button id="btn_filter" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <button id="btn_reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                        @can('laporan-print')
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalPdfOptions">
                            <i class="bi bi-file-pdf me-1"></i> PDF
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== DATATABLE ===================== --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="laporanTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width:40px;">No</th>
                                <th>Tanggal</th>
                                <th class="text-start">Sumber / Keterangan</th>
                                <th>Donatur</th>
                                <th>Kegiatan</th>
                                <th>Jenis</th>
                                <th class="text-end">Pemasukan</th>
                                <th class="text-end">Pengeluaran</th>
                                <th class="text-end">Saldo Berjalan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr class="table-light fw-bold">
                                <td colspan="6" class="text-end">Jumlah Keseluruhan :</td>
                                <td class="text-end text-success" id="foot-pemasukan">—</td>
                                <td class="text-end text-danger" id="foot-pengeluaran">—</td>
                                <td class="text-end text-primary" id="foot-saldo">—</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

@include('layouts.footer')

<!-- Modal Opsi Cetak PDF -->
<div class="modal fade" id="modalPdfOptions" tabindex="-1" aria-labelledby="modalPdfOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white py-3">
                <h6 class="modal-title fw-bold" id="modalPdfOptionsLabel">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Opsi Cetak & Unduh Laporan PDF
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
                                <input type="radio" name="pdf_paper" value="a4" class="d-none pdf-paper-radio" checked>
                                <div class="card border p-3 text-center transition-all paper-card selected-paper">
                                    <div class="fw-bold text-dark fs-6 mb-1">A4</div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">210 x 297 mm</small>
                                    <span class="badge bg-primary-subtle text-primary mt-1" style="font-size: 0.68rem;">Standar Internasional</span>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="pdf_paper" value="f4" class="d-none pdf-paper-radio">
                                <div class="card border p-3 text-center transition-all paper-card">
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
                                <input type="radio" name="pdf_orientation" value="landscape" class="d-none pdf-orientation-radio" checked>
                                <div class="card border p-3 text-center transition-all orientation-card selected-orientation">
                                    <i class="bi bi-aspect-ratio text-primary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Landscape</div>
                                    <small class="text-success fw-semibold d-block" style="font-size: 0.68rem;">★ Direkomendasikan</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="d-block cursor-pointer">
                                <input type="radio" name="pdf_orientation" value="portrait" class="d-none pdf-orientation-radio">
                                <div class="card border p-3 text-center transition-all orientation-card">
                                    <i class="bi bi-file-earmark text-secondary fs-3 mb-1"></i>
                                    <div class="fw-bold text-dark small">Portrait</div>
                                    <small class="text-muted d-block" style="font-size: 0.68rem;">Tegak Vertikal</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border small text-muted mb-0 py-2">
                    <i class="bi bi-info-circle text-primary me-1"></i> Dokumen PDF akan digenerate otomatis sesuai filter aktif saat ini dan dipastikan pas dengan kertas tanpa terpotong.
                </div>

            </div>
            <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn_generate_pdf" class="btn btn-danger btn-sm shadow-sm fw-semibold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Buka & Unduh PDF
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .paper-card:hover, .orientation-card:hover {
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
$(document).ready(function () {

    // ---- Filter field visibility ----
    const jenisEl  = document.getElementById('filter_jenis');
    const wrapYear  = document.getElementById('wrap-year');
    const wrapMonth = document.getElementById('wrap-month');
    const wrapStart = document.getElementById('wrap-start');
    const wrapEnd   = document.getElementById('wrap-end');

    function toggleFields() {
        if (!jenisEl) return;
        const val = jenisEl.value;
        if (wrapYear) wrapYear.style.display  = (val === 'tahunan' || val === 'bulanan' || val === '') ? '' : 'none';
        if (wrapMonth) wrapMonth.style.display = (val === 'bulanan') ? '' : 'none';
        if (wrapStart) wrapStart.style.display = (val === 'periode') ? '' : 'none';
        if (wrapEnd) wrapEnd.style.display   = (val === 'periode') ? '' : 'none';
    }

    if (jenisEl) {
        jenisEl.addEventListener('change', toggleFields);
        toggleFields();
    }

    // ---- DataTable ----
    var table = $('#laporanTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('laporan.datatables') }}",
            data: function (d) {
                d.filter     = jenisEl ? jenisEl.value : '';
                d.year       = $('#filter_year').val();
                d.month      = $('#filter_month').val();
                d.start_date = $('#filter_start').val();
                d.end_date   = $('#filter_end').val();
            },
            complete: function (json) {
                if (json.responseJSON && json.responseJSON.summary) {
                    var s = json.responseJSON.summary;
                    $('#foot-pemasukan').html('Rp ' + s.total_pemasukan);
                    $('#foot-pengeluaran').html('Rp ' + s.total_pengeluaran);
                    $('#foot-saldo').html('Rp ' + s.saldo);
                }
            }
        },
        columns: [
            { data: 'DT_RowIndex',        name: 'id',                 orderable: false, searchable: false, className: 'text-center' },
            { data: 'tanggal',            name: 'tanggal',            className: 'text-center' },
            { data: 'keterangan_display', name: 'keterangan_display', orderable: false },
            { data: 'donatur_display',    name: 'donatur_display',    orderable: false, className: 'text-center' },
            { data: 'kegiatan_display',   name: 'kegiatan_display',   orderable: false, className: 'text-center' },
            { data: 'jenis_badge',        name: 'kategori_id',        orderable: false, className: 'text-center' },
            { data: 'nominal_pemasukan',  name: 'nominal',            orderable: false, searchable: false, className: 'text-end' },
            { data: 'nominal_pengeluaran',name: 'nominal',            orderable: false, searchable: false, className: 'text-end' },
            { data: 'saldo_berjalan',     name: 'saldo_berjalan',     orderable: false, searchable: false, className: 'text-end' },
        ],
        createdRow: function (row, data) {
            if (data.kategori_id == 1) {
                $(row).css('background-color', '#f8fefb');
            } else {
                $(row).css('background-color', '#fffafa');
            }
        },
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="d-flex align-items-center gap-2"><div class="spinner-border spinner-border-sm text-primary"></div><span>Memuat data laporan...</span></div>',
            searchPlaceholder: 'Cari transaksi...',
            lengthMenu: 'Tampilkan _MENU_ baris',
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ transaksi',
            infoEmpty: 'Tidak ada data transaksi',
            infoFiltered: '(dari total _MAX_ transaksi)',
            paginate: { previous: '‹', next: '›' },
            zeroRecords: 'Tidak ada data untuk filter yang dipilih',
            emptyTable: 'Belum ada data transaksi keuangan',
        }
    });

    // ---- Filter & Reset Buttons ----
    $('#btn_filter').click(function () {
        table.draw();
    });

    $('#btn_reset').click(function () {
        if (jenisEl) jenisEl.value = '';
        $('#filter_year').val('');
        $('#filter_month').val('');
        $('#filter_start').val('');
        $('#filter_end').val('');
        toggleFields();
        table.draw();
    });

    // Paper selection styling
    document.querySelectorAll('.pdf-paper-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.paper-card').forEach(c => c.classList.remove('selected-paper'));
            this.closest('label').querySelector('.paper-card').classList.add('selected-paper');
        });
    });

    // Orientation selection styling
    document.querySelectorAll('.pdf-orientation-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.orientation-card').forEach(c => c.classList.remove('selected-orientation'));
            this.closest('label').querySelector('.orientation-card').classList.add('selected-orientation');
        });
    });

    // Generate PDF Click
    var btnGenPdf = document.getElementById('btn_generate_pdf');
    if (btnGenPdf) {
        btnGenPdf.addEventListener('click', function() {
            var paperEl = document.querySelector('.pdf-paper-radio:checked');
            var orientationEl = document.querySelector('.pdf-orientation-radio:checked');

            var paper = paperEl ? paperEl.value : 'a4';
            var orientation = orientationEl ? orientationEl.value : 'landscape';

            var params = new URLSearchParams({
                filter: jenisEl ? jenisEl.value : '',
                year: $('#filter_year').val(),
                month: $('#filter_month').val(),
                start_date: $('#filter_start').val(),
                end_date: $('#filter_end').val(),
                paper: paper,
                orientation: orientation
            });

            var url = '{{ route("laporan.pdf") }}?' + params.toString();
            window.open(url, '_blank');

            var modalEl = document.getElementById('modalPdfOptions');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    }
});
</script>

