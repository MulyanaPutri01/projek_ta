@section('title', 'Data Donatur')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Data Donatur</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Donatur</li>
                </ol>
            </nav>
        </div>
        <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#donaturCreateModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Donatur
        </button>
    </div>

    <div class="container-fluid px-0">

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Bulan</label>
                        <select id="filter_month" class="form-select form-select-sm">
                            <option value="">Semua Bulan</option>
                            @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                                <option value="{{ $key }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Tahun</label>
                        <select id="filter_year" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach(range(date('Y'), date('Y') - 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
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
                    <table id="donaturTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Tanggal</th>
                                <th class="text-start">Nama Donatur</th>
                                <th class="text-end">Nominal Infaq</th>
                                <th>Dicatat Oleh</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editDonaturModal" tabindex="-1" aria-labelledby="editDonaturModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="editDonaturModalLabel">Edit Data Donatur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditDonatur" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Donatur</label>
                                        <input type="text" name="nama_donatur" id="edit_nama_donatur" class="form-control" required maxlength="100">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" id="edit_alamat" class="form-control" required maxlength="255" placeholder="Contoh: Jl. Merdeka No. 10">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="donaturCreateModal" tabindex="-1" aria-labelledby="donaturCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="donaturCreateModalLabel">Tambah Donatur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('donatur.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Donatur</label>
                                        <input type="text" name="nama_donatur" class="form-control" placeholder="Contoh: H. Ahmad Subarjo" required maxlength="100">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl. Merdeka No. 10" required maxlength="255">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save me-1"></i> Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

@include('layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var table = $('#donaturTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('donatur.index') }}",
                data: function (d) {
                    d.month = $('#filter_month').val();
                    d.year = $('#filter_year').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'tanggal', name: 'tanggal', className: 'text-center' },
                { data: 'nama_donatur', name: 'nama_donatur' },
                { data: 'nominal_formatted', name: 'nominal', className: 'text-end' },
                { data: 'takmir_name', name: 'takmir.nama_takmir' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_month').val('');
            $('#filter_year').val('');
            table.draw();
        });

        $(document).on('click', '.btn-edit', function() {
            var id      = $(this).data('id');
            var nama    = $(this).data('nama');
            var alamat  = $(this).data('alamat');
            var tanggal = $(this).data('tanggal');

            $('#edit_nama_donatur').val(nama);
            $('#edit_alamat').val(alamat);
            $('#edit_tanggal').val(tanggal);
            $('#formEditDonatur').attr('action', '/donatur/' + id);
            $('#editDonaturModal').modal('show');
        });
    });
</script>
