@section('title', 'Master Kondisi')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Master Kondisi Barang</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventaris.index') }}">Inventaris</a></li>
                    <li class="breadcrumb-item active">Kondisi</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#kondisiCreateModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kondisi
            </button>
            <a href="{{ route('catatan.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Catatan Barang
            </a>
        </div>
    </div>

    <div class="container-fluid px-0">

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="kondisiTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th class="text-start">Nama Kondisi Barang</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editKondisiModal" tabindex="-1" aria-labelledby="editKondisiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="editKondisiModalLabel">Edit Kondisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditKondisi" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kondisi</label>
                                        <input type="text" name="nama_kondisi" id="edit_nama_kondisi" class="form-control" required maxlength="50">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="kondisiCreateModal" tabindex="-1" aria-labelledby="kondisiCreateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="kondisiCreateModalLabel">Tambah Kondisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kondisi.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kondisi</label>
                                        <input type="text" name="nama_kondisi" class="form-control" placeholder="Contoh: Rusak Ringan" required maxlength="50">
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
        var table = $('#kondisiTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('kondisi.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'nama_kondisi', name: 'nama_kondisi' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            $('#edit_nama_kondisi').val(nama);
            $('#formEditKondisi').attr('action', '/kondisi/' + id);
            $('#editKondisiModal').modal('show');
        });
    });
</script>
