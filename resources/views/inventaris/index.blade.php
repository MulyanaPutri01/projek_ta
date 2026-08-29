@section('title', 'Inventaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Data Barang Inventaris</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Barang</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventaris.create') }}" class="btn btn-success shadow-sm"><i class="bi bi-plus-circle me-1"></i> Tambah Barang</a>
            <a href="{{ route('inventaris.pdf') }}" class="btn btn-danger shadow-sm" target="_blank"><i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF</a>
        </div>
    </div>

    <div class="container-fluid px-0">

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Lokasi</label>
                        <input type="text" id="filter_lokasi" class="form-control form-select-sm" placeholder="Cari nama lokasi...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Tahun Beli</label>
                        <select id="filter_tahun" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach(range(date('Y'), date('Y') - 10) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2 mt-3">
                        <button id="btn_filter" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <button id="btn_reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="inventarisTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th class="text-start">Nama Barang</th>
                                <th style="width: 70px;">Jumlah</th>
                                <th style="width: 80px;">Tahun</th>
                                <th>Lokasi</th>
                                <th>Kondisi Terakhir</th>
                                <th>Keterangan</th>
                                <th style="width: 140px;">Aksi</th>
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
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_lokasi').val('');
            $('#filter_tahun').val('');
            table.draw();
        });
    });
</script>
