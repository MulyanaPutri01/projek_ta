@section('title', 'Galeri')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Galeri Dokumentasi</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Galeri</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('galeri.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-camera-fill me-1"></i> Tambah Foto
        </a>
    </div>

    <div class="container-fluid px-0">

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Kegiatan</label>
                        <select id="filter_kegiatan" class="form-select form-select-sm">
                            <option value="">Semua Kegiatan</option>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
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
                    <table id="galeriTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 100px;">Preview</th>
                                <th class="text-start">Nama Foto</th>
                                <th>Tanggal</th>
                                <th>Agenda Kegiatan</th>
                                <th>Diupload Oleh</th>
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
        var table = $('#galeriTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('galeri.index') }}",
                data: function (d) {
                    d.kegiatan_id = $('#filter_kegiatan').val();
                    d.month = $('#filter_month').val();
                    d.year = $('#filter_year').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'preview_gambar', name: 'gambar', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nama_foto', name: 'nama_foto' },
                { data: 'tanggal', name: 'tanggal', className: 'text-center' },
                { data: 'kegiatan_name', name: 'kegiatan.nama_kegiatan' },
                { data: 'takmir_name', name: 'takmir.nama_takmir' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_kegiatan').val('');
            $('#filter_month').val('');
            $('#filter_year').val('');
            table.draw();
        });
    });
</script>
