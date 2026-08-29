@section('title', 'Edit Catatan Kondisi Barang')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Edit Catatan Kondisi Barang</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catatan.index') }}">Catatan Kondisi</a></li>
                    <li class="breadcrumb-item active">Edit Catatan</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('catatan.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <form action="{{ route('catatan.update', $catatan->id) }}" method="POST" id="formEditCatatan">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: FORM INPUTS ================= -->
                <div class="col-xl-8 col-lg-7">
                    
                    <!-- 1. PEMILIHAN BARANG INVENTARIS -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Pilih Barang yang Diinspeksi <span class="text-danger">*</span></h6>
                                <small class="text-muted">Pilih aset inventaris yang dicek kondisi fisiknya</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Barang Inventaris Terdaftar <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-boxes"></i></span>
                                        <select name="inventaris_id" id="select_inventaris" class="form-select" required>
                                            @foreach($inventariss as $inventaris)
                                                <option value="{{ $inventaris->id }}" 
                                                    data-nama="{{ $inventaris->nama_barang }}"
                                                    data-lokasi="{{ $inventaris->lokasi }}"
                                                    data-jumlah="{{ $inventaris->jumlah }}"
                                                    data-tahun="{{ $inventaris->tahun_pembelian }}"
                                                    {{ (old('inventaris_id', $catatan->inventaris_id) == $inventaris->id) ? 'selected' : '' }}>
                                                    {{ $inventaris->nama_barang }} (Lokasi: {{ $inventaris->lokasi }} • {{ $inventaris->jumlah }} Unit)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. STATUS KONDISI FISIK (VISUAL CONDITION RADIO CARDS) -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-clipboard-pulse fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Hasil Evaluasi Kondisi Fisik <span class="text-danger">*</span></h6>
                                <small class="text-muted">Pilih status kelaikan barang berdasarkan hasil pemeriksaan</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @foreach($kondisis as $kondisi)
                                    @php
                                        $namaKondisi = strtolower($kondisi->nama_kondisi);
                                        $isCurrent = (old('kondisi_id', $catatan->kondisi_id) == $kondisi->id);
                                        
                                        $cardColor = 'info';
                                        $cardIcon = 'bi-check-circle';
                                        $cardDesc = 'Status kondisi aset';

                                        if (str_contains($namaKondisi, 'baik') || str_contains($namaKondisi, 'bagus') || str_contains($namaKondisi, 'normal')) {
                                            $cardColor = 'success';
                                            $cardIcon = 'bi-check-circle-fill';
                                            $cardDesc = 'Barang dalam keadaan prima, berfungsi 100% normal, dan siap digunakan untuk kegiatan ibadah';
                                        } elseif (str_contains($namaKondisi, 'rusak')) {
                                            $cardColor = 'danger';
                                            $cardIcon = 'bi-x-circle-fill';
                                            $cardDesc = 'Barang mengalami kerusakan fisik/fungsi, tidak dapat dipakai, dan membutuhkan perbaikan segera atau diganti';
                                        } elseif (str_contains($namaKondisi, 'perbaikan') || str_contains($namaKondisi, 'servis') || str_contains($namaKondisi, 'kurang')) {
                                            $cardColor = 'warning';
                                            $cardIcon = 'bi-wrench-adjustable-circle-fill';
                                            $cardDesc = 'Barang masih bisa digunakan tetapi terdapat penurunan fungsi dan perlu diservis/dirawat';
                                        }
                                    @endphp

                                    <div class="col-md-12">
                                        <label class="kondisi-card-label d-block cursor-pointer position-relative">
                                            <input type="radio" name="kondisi_id" value="{{ $kondisi->id }}" 
                                                class="kondisi-radio-input d-none" 
                                                data-kondisi-name="{{ $kondisi->nama_kondisi }}"
                                                data-kondisi-color="{{ $cardColor }}"
                                                data-kondisi-icon="{{ $cardIcon }}"
                                                data-kondisi-desc="{{ $cardDesc }}"
                                                {{ $isCurrent ? 'checked' : '' }} required>
                                            
                                            <div class="card kondisi-card border h-100 p-3 transition-all">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div class="rounded-3 bg-{{ $cardColor }}-subtle text-{{ $cardColor }} p-3 d-flex align-items-center justify-content-center fs-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                                        <i class="bi {{ $cardIcon }}"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="fw-bold text-dark mb-0">{{ $kondisi->nama_kondisi }}</h6>
                                                            <span class="kondisi-checked-badge badge bg-{{ $cardColor }} rounded-pill px-2 py-1 small">
                                                                <i class="bi bi-check-lg me-1"></i> Terpilih
                                                            </span>
                                                        </div>
                                                        <p class="small text-muted mb-0">{{ $cardDesc }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 3. TANGGAL INSPEKSI & PETUGAS -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning-emphasis p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-person-check fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Waktu & Petugas Inspeksi</h6>
                                <small class="text-muted">Tanggal dilakukannya pengecekan dan petugas yang bertanggung jawab</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Tanggal Catatan -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Tanggal Pemeriksaan / Catatan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                                        <input type="date" name="tanggal_catatan" id="input_tanggal" class="form-control" 
                                            value="{{ old('tanggal_catatan', \Carbon\Carbon::parse($catatan->tanggal_catatan)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="mt-2 d-flex gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="0" style="font-size: 0.72rem;">Hari Ini</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-date" data-days="-1" style="font-size: 0.72rem;">Kemarin</button>
                                    </div>
                                </div>

                                <!-- Petugas Takmir -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Petugas Inspektur (Pencatat)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control bg-light" 
                                            value="{{ $catatan->takmir?->nama_takmir ?? (Auth::user()?->nama_takmir ?? 'Pengurus Takmir') }}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <a href="{{ route('catatan.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Catatan
                        </button>
                    </div>

                </div>

                <!-- ================= RIGHT COLUMN: LIVE DIGITAL INSPECTION CARD PREVIEW ================= -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-top" style="top: 85px; z-index: 10;">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
                                <i class="bi bi-clipboard-check me-1"></i> Lembar Inspeksi Digital
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Live Inspection</span>
                        </div>

                        <!-- Inspection Card Preview -->
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-3" style="background: #ffffff;">
                            
                            <!-- Top Decorative Banner -->
                            <div class="p-3 text-center text-white position-relative" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                                <div class="position-absolute top-0 end-0 p-2 opacity-20">
                                    <i class="bi bi-clipboard-pulse" style="font-size: 3.5rem;"></i>
                                </div>
                                <small class="text-white-50 text-uppercase fw-semibold letter-spacing-1 d-block" style="font-size: 0.68rem;">HASIL INSPEKSI ASET FISIK</small>
                                <h6 class="fw-bold mb-0 text-white">MASJID AL-IKHLAS</h6>
                                <small class="text-white-75" style="font-size: 0.72rem;">Karangmulya, Suradadi, Tegal</small>
                            </div>

                            <!-- Inspection Code Strip -->
                            <div class="bg-dark text-white py-2 px-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block" style="font-size: 0.65rem;">NOMOR CATATAN AUDIT</small>
                                    <span class="fw-bold text-warning font-monospace small">LOG-{{ str_pad($catatan->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-dark small" style="font-size: 0.68rem;"><i class="bi bi-shield-check text-success me-1"></i>Terverifikasi</span>
                                </div>
                            </div>

                            <!-- Body Content -->
                            <div class="card-body p-4">
                                <!-- Status Badge Glow -->
                                <div class="text-center mb-3">
                                    <span id="preview_kondisi_badge" class="badge bg-success px-3 py-2 text-uppercase fw-bold shadow-sm" style="font-size: 0.85rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i> KONDISI BAIK
                                    </span>
                                </div>

                                <div class="mb-3 bg-light p-3 rounded-3 border">
                                    <small class="text-muted d-block" style="font-size: 0.68rem;">BARANG YANG DIINSPEKSI</small>
                                    <h5 class="fw-bold text-dark mb-1" id="preview_barang_nama">{{ $catatan->inventaris?->nama_barang ?? 'Barang Inventaris' }}</h5>
                                    <div class="d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                                        <span id="preview_barang_lokasi"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $catatan->inventaris?->lokasi ?? '-' }}</span>
                                        <span id="preview_barang_qty"><i class="bi bi-box me-1 text-primary"></i>{{ $catatan->inventaris?->jumlah ?? '1' }} Unit</span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-calendar-check-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Tanggal Pemeriksaan</small>
                                            <span class="fw-semibold text-dark small" id="preview_tanggal">{{ \Carbon\Carbon::parse($catatan->tanggal_catatan)->translatedFormat('l, d F Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-person-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Petugas Pemeriksa</small>
                                            <span class="fw-semibold text-dark small">{{ $catatan->takmir?->nama_takmir ?? 'Pengurus Takmir' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-2">
                                    <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.72rem;">Deskripsi Status:</small>
                                    <p class="small text-muted mb-0" id="preview_kondisi_desc" style="font-size: 0.75rem;">
                                        Barang dalam keadaan prima, berfungsi 100% normal, dan siap digunakan untuk kegiatan ibadah.
                                    </p>
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top text-center py-2 text-muted" style="font-size: 0.72rem;">
                                <i class="bi bi-shield-check text-success me-1"></i> SIMAS Catatan Kondisi Inventaris Masjid
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layouts.footer')

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    
    .kondisi-card {
        border-color: #e2e8f0;
        background: #ffffff;
    }
    .kondisi-card:hover {
        border-color: #94a3b8;
        transform: translateY(-2px);
    }
    .kondisi-radio-input:checked + .kondisi-card {
        border-color: #065f46 !important;
        border-width: 2px !important;
        background: #f0fdf4 !important;
        box-shadow: 0 4px 12px rgba(6, 95, 70, 0.12) !important;
    }
    .kondisi-radio-input:not(:checked) + .kondisi-card .kondisi-checked-badge {
        display: none !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectInventaris = document.getElementById('select_inventaris');
        const inputTanggal = document.getElementById('input_tanggal');
        
        const previewBarangNama = document.getElementById('preview_barang_nama');
        const previewBarangLokasi = document.getElementById('preview_barang_lokasi');
        const previewBarangQty = document.getElementById('preview_barang_qty');
        const previewTanggal = document.getElementById('preview_tanggal');
        const previewKondisiBadge = document.getElementById('preview_kondisi_badge');
        const previewKondisiDesc = document.getElementById('preview_kondisi_desc');

        // Month & Day Names
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // 1. Live Inventaris Select Handler
        function updateInventarisPreview() {
            const selected = selectInventaris.options[selectInventaris.selectedIndex];
            if (selected && selected.value) {
                previewBarangNama.textContent = selected.getAttribute('data-nama') || 'Barang Inventaris';
                previewBarangLokasi.innerHTML = `<i class="bi bi-geo-alt me-1 text-danger"></i>${selected.getAttribute('data-lokasi') || '-'}`;
                previewBarangQty.innerHTML = `<i class="bi bi-box me-1 text-primary"></i>${selected.getAttribute('data-jumlah') || '1'} Unit`;
            }
        }
        selectInventaris.addEventListener('change', updateInventarisPreview);
        updateInventarisPreview();

        // 2. Live Kondisi Radio Handler
        const kondisiRadios = document.querySelectorAll('.kondisi-radio-input');
        function updateKondisiPreview() {
            const checked = document.querySelector('.kondisi-radio-input:checked');
            if (checked) {
                const name = checked.getAttribute('data-kondisi-name');
                const color = checked.getAttribute('data-kondisi-color');
                const icon = checked.getAttribute('data-kondisi-icon');
                const desc = checked.getAttribute('data-kondisi-desc');

                previewKondisiBadge.className = `badge bg-${color} px-3 py-2 text-uppercase fw-bold shadow-sm`;
                previewKondisiBadge.innerHTML = `<i class="bi ${icon} me-1"></i> ${name}`;
                previewKondisiDesc.textContent = desc;
            }
        }
        kondisiRadios.forEach(radio => {
            radio.addEventListener('change', updateKondisiPreview);
        });
        updateKondisiPreview();

        // 3. Live Date Handler
        function updateDatePreview() {
            if (!inputTanggal.value) return;
            const d = new Date(inputTanggal.value + 'T00:00:00');
            if (!isNaN(d.getTime())) {
                const day = hariIndo[d.getDay()];
                const date = d.getDate();
                const month = bulanIndo[d.getMonth()];
                const year = d.getFullYear();
                previewTanggal.textContent = `${day}, ${date} ${month} ${year}`;
            }
        }
        inputTanggal.addEventListener('change', updateDatePreview);
        updateDatePreview();

        // 4. Quick Date Buttons
        document.querySelectorAll('.quick-date').forEach(btn => {
            btn.addEventListener('click', function() {
                const days = parseInt(this.getAttribute('data-days'));
                const target = new Date();
                target.setDate(target.getDate() + days);
                const yyyy = target.getFullYear();
                const mm = String(target.getMonth() + 1).padStart(2, '0');
                const dd = String(target.getDate()).padStart(2, '0');
                inputTanggal.value = `${yyyy}-${mm}-${dd}`;
                updateDatePreview();
            });
        });
    });
</script>
