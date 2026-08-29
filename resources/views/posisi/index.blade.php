@section('title', 'Master Posisi')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Master Posisi Panitia</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kepanitiaan.index') }}">Kepanitiaan</a></li>
                    <li class="breadcrumb-item active">Posisi</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#posisiCreateModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Posisi
            </button>
            <a href="{{ route('kepanitiaan.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kepanitiaan
            </a>
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

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="posisiTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th class="text-start">Nama Posisi Kepanitiaan</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editPosisiModal" tabindex="-1" aria-labelledby="editPosisiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="editPosisiModalLabel">Edit Posisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditPosisi" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Nama Posisi</label>
                                        <input type="text" name="nama_posisi" id="edit_nama_posisi" class="form-control" required maxlength="50">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="posisiCreateModal" tabindex="-1" aria-labelledby="posisiCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="posisiCreateModalLabel">Tambah Posisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('posisi.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Posisi</label>
                                        <input type="text" name="nama_posisi" class="form-control" placeholder="Contoh: Sie Konsumsi" required maxlength="50">
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
        var table = $('#posisiTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('posisi.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nama_posisi', name: 'nama_posisi' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#edit_nama_posisi').val(nama);
            $('#formEditPosisi').attr('action', '/posisi/' + id);
            $('#editPosisiModal').modal('show');
        });
    });
</script>
