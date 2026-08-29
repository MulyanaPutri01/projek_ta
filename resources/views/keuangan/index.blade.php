@section('title', 'Keuangan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Transaksi Keuangan Masjid</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Keuangan</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('keuangan.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
        </a>
    </div>

    <div class="container-fluid px-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <!-- Pemasukan Cards -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                    <div class="card-body p-3">
                        <span class="text-success fw-bold small text-uppercase">Pemasukan Hari Ini</span>
                        <h4 class="fw-bold text-success mb-1">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</h4>
                        <small class="text-muted">Total Pemasukan: <strong class="text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></small>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Cards -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);">
                    <div class="card-body p-3">
                        <span class="text-danger fw-bold small text-uppercase">Pengeluaran Hari Ini</span>
                        <h4 class="fw-bold text-danger mb-1">Rp {{ number_format($pengeluaranHariIni, 0, ',', '.') }}</h4>
                        <small class="text-muted">Total Pengeluaran: <strong class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></small>
                    </div>
                </div>
            </div>

            <!-- Saldo Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="card-body p-3">
                        <span class="text-primary fw-bold small text-uppercase">Total Saldo Kas Tersedia</span>
                        <h4 class="fw-bold text-primary mb-1">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h4>
                        <small class="text-muted">Status Kas Terkini</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Kategori</label>
                        <select id="filter_kategori" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Bulan</label>
                        <select id="filter_month" class="form-select form-select-sm">
                            <option value="">Semua Bulan</option>
                            @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                                <option value="{{ $key }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Filter Tahun</label>
                        <select id="filter_year" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach(range(date('Y'), date('Y') - 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex justify-content-end gap-2 mt-3">
                        <button id="btn_filter" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <button id="btn_reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="keuanganTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Tanggal</th>
                                <th class="text-start">Sumber Keuangan</th>
                                <th>Keterangan</th>
                                <th class="text-end">Pemasukan</th>
                                <th class="text-end">Pengeluaran</th>
                                <th>Donatur</th>
                                <th>Kegiatan</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 120px;">Aksi</th>
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
        var table = $('#keuanganTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('keuangan.index') }}",
                data: function (d) {
                    d.kategori_id = $('#filter_kategori').val();
                    d.month = $('#filter_month').val();
                    d.year = $('#filter_year').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'tanggal', name: 'tanggal', className: 'text-center' },
                { data: 'sumber_keuangan', name: 'sumber_keuangan' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'nominal_pemasukan', name: 'nominal', className: 'text-end' },
                { data: 'nominal_pengeluaran', name: 'nominal', className: 'text-end' },
                { data: 'donatur_name', name: 'donatur.nama_donatur' },
                { data: 'kegiatan_name', name: 'kegiatan.nama_kegiatan' },
                { data: 'takmir_name', name: 'takmir.nama_takmir' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_kategori').val('');
            $('#filter_month').val('');
            $('#filter_year').val('');
            table.draw();
        });
    });
</script>
