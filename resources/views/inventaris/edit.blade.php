@section('title', 'Edit Barang Inventaris')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Edit Barang Inventaris</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventaris.index') }}">Inventaris</a></li>
                    <li class="breadcrumb-item active">Edit Barang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('inventaris.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Inventaris
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST" id="formEditInventaris">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: FORM INPUTS ================= -->
                <div class="col-xl-8 col-lg-7">
                    
                    <!-- 1. IDENTITAS & RINCIAN BARANG -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Identitas & Kuantitas Barang</h6>
                                <small class="text-muted">Nama aset barang masjid dan jumlah unit yang terdaftar</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Nama Barang -->
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold text-dark">Nama Barang Inventaris <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-tag"></i></span>
                                        <input type="text" name="nama_barang" id="input_nama_barang" class="form-control" 
                                            value="{{ old('nama_barang', $inventaris->nama_barang) }}" required maxlength="100" autocomplete="off">
                                    </div>
                                    <!-- Preset Chips -->
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Contoh Cepat:</small>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Sound System Wireless & Mixer">Sound System</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Karpet Sajadah Roll Tebal 12mm">Karpet Sajadah Roll</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Air Conditioner (AC) Split 2 PK">AC Split</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Microphone Wireless & Stand">Mic Wireless</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Mimbar Khutbah Kayu Jati Ukir">Mimbar Khutbah Jati</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Genset Listrik 5000 Watt">Genset Cadangan</span>
                                        <span class="badge bg-light text-dark border cursor-pointer preset-name-chip" data-name="Vacuum Cleaner Basah & Kering">Vacuum Cleaner</span>
                                    </div>
                                </div>

                                <!-- Jumlah Unit -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark">Jumlah Kuantitas <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_minus_qty"><i class="bi bi-dash"></i></button>
                                        <input type="number" name="jumlah" id="input_jumlah" class="form-control text-center fw-bold" 
                                            value="{{ old('jumlah', $inventaris->jumlah) }}" min="1" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn_plus_qty"><i class="bi bi-plus"></i></button>
                                    </div>
                                    <small class="text-muted text-center d-block mt-1" style="font-size: 0.75rem;">Satuan: Unit / Set</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. PENGADAAN & LOKASI PENEMPATAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-geo-alt fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Lokasi Penempatan & Tahun Perolehan</h6>
                                <small class="text-muted">Ruangan aset disimpan dan tahun pengadaan aset</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Tahun Pembelian -->
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-dark">Tahun Pembelian / Pengadaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar"></i></span>
                                        <input type="number" name="tahun_pembelian" id="input_tahun" class="form-control" 
                                            value="{{ old('tahun_pembelian', $inventaris->tahun_pembelian) }}" required min="1900" max="{{ date('Y') + 1 }}">
                                    </div>
                                    <div class="mt-2 d-flex gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-year" data-year="{{ date('Y') }}" style="font-size: 0.72rem;">{{ date('Y') }}</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-year" data-year="{{ date('Y') - 1 }}" style="font-size: 0.72rem;">{{ date('Y') - 1 }}</button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2 quick-year" data-year="{{ date('Y') - 2 }}" style="font-size: 0.72rem;">{{ date('Y') - 2 }}</button>
                                    </div>
                                </div>

                                <!-- Lokasi Penyimpanan -->
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold text-dark">Lokasi Ruang / Tempat Penyimpanan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-geo"></i></span>
                                        <input type="text" name="lokasi" id="input_lokasi" class="form-control" 
                                            value="{{ old('lokasi', $inventaris->lokasi) }}" required maxlength="100">
                                    </div>
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Pilihan:</small>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Ruang Utama Sholat">Ruang Utama</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Ruang Sound & Operator">Ruang Sound</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Serambi / Teras Masjid">Serambi Teras</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Gudang Inventaris Masjid">Gudang Inventaris</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Tempat Wudhu & Sanitasi">Tempat Wudhu</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-loc-chip" data-loc="Kantor Takmir Masjid">Kantor Takmir</span>
                                    </div>
                                </div>

                                <!-- Keterangan / Sumber Perolehan -->
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-dark">Keterangan & Sumber Perolehan Aset (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-chat-left-text"></i></span>
                                        <input type="text" name="keterangan" id="input_keterangan" class="form-control" 
                                            value="{{ old('keterangan', $inventaris->keterangan) }}" maxlength="255">
                                    </div>
                                    <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-muted me-1" style="font-size: 0.75rem;">Sumber:</small>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-ket-chip" data-ket="Pembelian Kas Masjid">Pembelian Kas Masjid</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-ket-chip" data-ket="Wakaf / Hibah Jamaah">Wakaf / Hibah Jamaah</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-ket-chip" data-ket="Bantuan Donatur Khusus">Bantuan Donatur</span>
                                        <span class="badge bg-light text-secondary border cursor-pointer preset-ket-chip" data-ket="Infaq Pengadaan Fasilitas">Infaq Fasilitas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <a href="{{ route('inventaris.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Barang
                        </button>
                    </div>

                </div>

                <!-- ================= RIGHT COLUMN: LIVE DIGITAL ASSET TAG PREVIEW ================= -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-top" style="top: 85px; z-index: 10;">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
                                <i class="bi bi-upc-scan me-1"></i> Label Aset Inventaris Digital
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Live Asset Tag</span>
                        </div>

                        <!-- Asset Tag Card Preview -->
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-3" style="background: #ffffff;">
                            
                            <!-- Top Decorative Banner -->
                            <div class="p-3 text-center text-white position-relative" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                                <div class="position-absolute top-0 end-0 p-2 opacity-20">
                                    <i class="bi bi-box-seam" style="font-size: 3.5rem;"></i>
                                </div>
                                <small class="text-white-50 text-uppercase fw-semibold letter-spacing-1 d-block" style="font-size: 0.68rem;">LABEL INVENTARIS RESMI</small>
                                <h6 class="fw-bold mb-0 text-white">MASJID AL-IKHLAS</h6>
                                <small class="text-white-75" style="font-size: 0.72rem;">Karangmulya, Suradadi, Tegal</small>
                            </div>

                            <!-- Barcode Strip -->
                            <div class="bg-dark text-white py-2 px-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block" style="font-size: 0.65rem;">KODE REGISTER ASET</small>
                                    <span class="fw-bold text-warning font-monospace small" id="preview_code">INV-{{ str_pad($inventaris->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="text-end">
                                    <i class="bi bi-qr-code text-white fs-4"></i>
                                </div>
                            </div>

                            <!-- Body Content -->
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">NAMA BARANG / ASET</small>
                                    <h5 class="fw-bold text-dark mb-0 line-clamp-2" id="preview_nama">{{ $inventaris->nama_barang }}</h5>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="bg-light p-2.5 rounded-3 border">
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Kuantitas</small>
                                            <span class="fw-bold text-primary" id="preview_qty">{{ $inventaris->jumlah }} Unit</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light p-2.5 rounded-3 border">
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Tahun Pengadaan</small>
                                            <span class="fw-bold text-dark" id="preview_tahun">{{ $inventaris->tahun_pembelian }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-geo-alt-fill small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Lokasi Ruangan</small>
                                            <span class="fw-semibold text-dark small" id="preview_lokasi">{{ $inventaris->lokasi }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-wallet2 small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Sumber / Keterangan</small>
                                            <span class="fw-semibold text-dark small" id="preview_ket">{{ $inventaris->keterangan ?: 'Pembelian Kas Masjid' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                            <i class="bi bi-shield-check small"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.68rem;">Status Kondisi Awal</small>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small fw-semibold">
                                                <i class="bi bi-check-circle me-1"></i> Terdaftar di SIMAS
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top text-center py-2 text-muted" style="font-size: 0.72rem;">
                                <i class="bi bi-check-circle-fill text-success me-1"></i> Terotentikasi SIMAS Inventaris Masjid
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
    .cursor-pointer:hover { opacity: 0.85; transform: scale(1.02); }
    .transition-all { transition: all 0.2s ease-in-out; }
    .preset-name-chip, .preset-loc-chip, .preset-ket-chip {
        transition: all 0.15s ease;
    }
    .preset-name-chip:hover, .preset-loc-chip:hover, .preset-ket-chip:hover {
        background-color: #065f46 !important;
        color: #ffffff !important;
        border-color: #065f46 !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputNama = document.getElementById('input_nama_barang');
        const inputJumlah = document.getElementById('input_jumlah');
        const inputTahun = document.getElementById('input_tahun');
        const inputLokasi = document.getElementById('input_lokasi');
        const inputKet = document.getElementById('input_keterangan');

        const previewNama = document.getElementById('preview_nama');
        const previewQty = document.getElementById('preview_qty');
        const previewTahun = document.getElementById('preview_tahun');
        const previewLokasi = document.getElementById('preview_lokasi');
        const previewKet = document.getElementById('preview_ket');

        // Quantity Stepper Buttons
        document.getElementById('btn_minus_qty').addEventListener('click', function() {
            let val = parseInt(inputJumlah.value) || 1;
            if (val > 1) {
                inputJumlah.value = val - 1;
                inputJumlah.dispatchEvent(new Event('input'));
            }
        });

        document.getElementById('btn_plus_qty').addEventListener('click', function() {
            let val = parseInt(inputJumlah.value) || 1;
            inputJumlah.value = val + 1;
            inputJumlah.dispatchEvent(new Event('input'));
        });

        // Live input listeners
        inputNama.addEventListener('input', function() {
            previewNama.textContent = this.value.trim() || '{{ $inventaris->nama_barang }}';
        });

        inputJumlah.addEventListener('input', function() {
            let val = parseInt(this.value) || 1;
            previewQty.textContent = val + ' Unit';
        });

        inputTahun.addEventListener('input', function() {
            previewTahun.textContent = this.value || '{{ $inventaris->tahun_pembelian }}';
        });

        inputLokasi.addEventListener('input', function() {
            previewLokasi.textContent = this.value.trim() || '{{ $inventaris->lokasi }}';
        });

        inputKet.addEventListener('input', function() {
            previewKet.textContent = this.value.trim() || 'Pembelian Kas Masjid';
        });

        // Preset Chips Handlers
        document.querySelectorAll('.preset-name-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputNama.value = this.getAttribute('data-name');
                inputNama.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.preset-loc-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputLokasi.value = this.getAttribute('data-loc');
                inputLokasi.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.preset-ket-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                inputKet.value = this.getAttribute('data-ket');
                inputKet.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.quick-year').forEach(btn => {
            btn.addEventListener('click', function() {
                inputTahun.value = this.getAttribute('data-year');
                inputTahun.dispatchEvent(new Event('input'));
            });
        });
    });
</script>
