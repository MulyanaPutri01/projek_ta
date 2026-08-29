@section('title', 'Kepanitiaan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Kepanitiaan Kegiatan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Kepanitiaan</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#kepanitiaanCreateModal"><i class="bi bi-person-plus me-1"></i> Tambah Panitia</button>
            <a href="{{ route('posisi.index') }}" class="btn btn-outline-primary shadow-sm"><i class="bi bi-person-badge me-1"></i> Master Posisi</a>
        </div>
    </div>

    <div class="container-fluid px-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body pt-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Filter Kegiatan</label>
                        <select id="filter_kegiatan" class="form-select form-select-sm">
                            <option value="">Semua Kegiatan</option>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Posisi</label>
                        <select id="filter_posisi" class="form-select form-select-sm">
                            <option value="">Semua Posisi</option>
                            @foreach($posisis as $posisi)
                                <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5 d-flex justify-content-end gap-2 mt-3">
                        <button id="btn_filter" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <button id="btn_reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="kepanitiaanTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th class="text-start">Nama Kegiatan</th>
                                <th>Posisi</th>
                                <th>Jobdesk / Tugas</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editKepanitiaanModal" tabindex="-1" aria-labelledby="editKepanitiaanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="editKepanitiaanModalLabel">Edit Kepanitiaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditKepanitiaan" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Kegiatan</label>
                                        <select name="kegiatan_id" id="edit_kegiatan_id" class="form-select" required>
                                            <option value="">Pilih Kegiatan...</option>
                                            @foreach($kegiatans as $kegiatan)
                                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Posisi</label>
                                        <select name="posisi_id" id="edit_posisi_id" class="form-select" required>
                                            <option value="">Pilih Posisi...</option>
                                            @foreach($posisis as $posisi)
                                                <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jobdesk</label>
                                        <input type="text" name="jobdesk" id="edit_jobdesk" class="form-control" required maxlength="255">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="kepanitiaanCreateModal" tabindex="-1" aria-labelledby="kepanitiaanCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="kepanitiaanCreateModalLabel">Tambah Kepanitiaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kepanitiaan.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Kegiatan</label>
                                        <select name="kegiatan_id" class="form-select" required>
                                            <option value="">Pilih Kegiatan...</option>
                                            @foreach($kegiatans as $kegiatan)
                                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Posisi</label>
                                        <select name="posisi_id" class="form-select" required>
                                            <option value="">Pilih Posisi...</option>
                                            @foreach($posisis as $posisi)
                                                <option value="{{ $posisi->id }}">{{ $posisi->nama_posisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jobdesk</label>
                                        <input type="text" name="jobdesk" class="form-control" placeholder="Contoh: Mengatur konsumsi peserta" required maxlength="255">
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
        var table = $('#kepanitiaanTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('kepanitiaan.index') }}",
                data: function (d) {
                    d.kegiatan_id = $('#filter_kegiatan').val();
                    d.posisi_id = $('#filter_posisi').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'kegiatan_name', name: 'kegiatan.nama_kegiatan' },
                { data: 'posisi_name', name: 'posisi.nama_posisi', className: 'text-center' },
                { data: 'jobdesk', name: 'jobdesk' },
                { data: 'takmir_name', name: 'takmir.nama_takmir' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#btn_filter').click(function() {
            table.draw();
        });

        $('#btn_reset').click(function() {
            $('#filter_kegiatan').val('');
            $('#filter_posisi').val('');
            table.draw();
        });

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var kegiatan = $(this).data('kegiatan');
            var posisi = $(this).data('posisi');
            var jobdesk = $(this).data('jobdesk');

            $('#edit_kegiatan_id').val(kegiatan);
            $('#edit_posisi_id').val(posisi);
            $('#edit_jobdesk').val(jobdesk);
            $('#formEditKepanitiaan').attr('action', '/kepanitiaan/' + id);
            $('#editKepanitiaanModal').modal('show');
        });
    });
</script>
