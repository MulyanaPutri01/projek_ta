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
        <button type="button" class="btn btn-success shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#donaturCreateModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Donatur
        </button>
    </div>

    <div class="container-fluid px-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Summary Stat Cards -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small text-white-50 text-uppercase fw-semibold d-block">Total Donatur Terdaftar</span>
                            <h3 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalDonatur ?? 0) }} Orang</h3>
                        </div>
                        <div class="rounded-3 bg-white bg-opacity-20 p-3 text-white">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: #ffffff;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small text-white-50 text-uppercase fw-semibold d-block">Total Infaq dari Donatur</span>
                            <h3 class="fw-bold text-white mb-0 mt-1">Rp {{ number_format($totalInfaqDonatur ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="rounded-3 bg-white bg-opacity-20 p-3 text-white">
                            <i class="bi bi-cash-stack fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small text-white-50 text-uppercase fw-semibold d-block">Donatur Bulan Ini</span>
                            <h3 class="fw-bold text-white mb-0 mt-1">{{ number_format($donaturBulanIni ?? 0) }} Orang</h3>
                        </div>
                        <div class="rounded-3 bg-white bg-opacity-20 p-3 text-white">
                            <i class="bi bi-calendar-check-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <th style="width: 120px;">Tanggal</th>
                                <th class="text-start">Nama & Kontak Donatur</th>
                                <th class="text-end" style="width: 170px;">Total Infaq</th>
                                <th style="width: 150px;">Dicatat Oleh</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editDonaturModal" tabindex="-1" aria-labelledby="editDonaturModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title fw-bold" id="editDonaturModalLabel"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Donatur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form id="formEditDonatur" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Tanggal Pencatatan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                            <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Nama Donatur <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nama_donatur" id="edit_nama_donatur" class="form-control" required maxlength="100">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Nomor Telepon / WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="telepon" id="edit_telepon" class="form-control" maxlength="25" placeholder="Contoh: 081234567890">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" name="alamat" id="edit_alamat" class="form-control" required maxlength="255" placeholder="Contoh: Jl. Merdeka No. 10">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="donaturCreateModal" tabindex="-1" aria-labelledby="donaturCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title fw-bold" id="donaturCreateModalLabel"><i class="bi bi-person-plus-fill text-success me-2"></i>Tambah Data Donatur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('donatur.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Tanggal Pencatatan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Nama Donatur <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nama_donatur" class="form-control" placeholder="Contoh: H. Ahmad Subarjo" required maxlength="100">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Nomor Telepon / WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="telepon" class="form-control" placeholder="Contoh: 081234567890" maxlength="25">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl. Merdeka No. 10" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Simpan Donatur</button>
                                    </div>
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
        const donaturBaseUrl = "{{ url('donatur') }}";

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
                { data: 'nominal_formatted', name: 'nominal_formatted', orderable: false, searchable: false, className: 'text-end' },
                { data: 'takmir_name', name: 'takmir_name', orderable: false, className: 'text-center' },
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
            var telepon = $(this).data('telepon');
            var tanggal = $(this).data('tanggal');

            $('#edit_nama_donatur').val(nama);
            $('#edit_alamat').val(alamat);
            $('#edit_telepon').val(telepon);
            $('#edit_tanggal').val(tanggal);
            $('#formEditDonatur').attr('action', donaturBaseUrl + '/' + id);
            $('#editDonaturModal').modal('show');
        });
    });
</script>
