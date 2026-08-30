@section('title', 'Tambah Transaksi Keuangan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Catat Transaksi Keuangan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
                    <li class="breadcrumb-item active">Tambah Transaksi</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('keuangan.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <div class="row g-4">
            <!-- Left Column: Form Input Transaksi -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('keuangan.store') }}" method="POST" id="formKeuangan">
                            @csrf

                            <!-- 1. Pilihan Jenis Transaksi (Visual Card Radio) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark small text-uppercase mb-2">
                                    <i class="bi bi-arrow-left-right me-1 text-primary"></i> 1. Jenis Transaksi Keuangan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="row g-3">
                                    @foreach ($kategoris as $kat)
                                        @php
                                            $isPemasukan = $kat->id == 1;
                                            $checked = old('kategori_id', '1') == $kat->id;
                                        @endphp
                                        <div class="col-sm-6">
                                            <label
                                                class="card h-100 p-3 border cursor-pointer category-card {{ $checked ? ($isPemasukan ? 'border-success bg-success bg-opacity-10 text-success active' : 'border-danger bg-danger bg-opacity-10 text-danger active') : 'border-light-subtle bg-white text-secondary' }}"
                                                style="cursor: pointer; transition: all 0.25s ease;"
                                                for="kat_{{ $kat->id }}">
                                                <div class="d-flex align-items-center">
                                                    <input type="radio" name="kategori_id"
                                                        id="kat_{{ $kat->id }}" value="{{ $kat->id }}"
                                                        class="form-check-input mt-0 me-3 category-radio"
                                                        {{ $checked ? 'checked' : '' }} required>
                                                    <div>
                                                        <div class="fw-bold fs-6 d-flex align-items-center gap-1">
                                                            <i
                                                                class="bi {{ $isPemasukan ? 'bi-arrow-down-left-circle-fill text-success' : 'bi-arrow-up-right-circle-fill text-danger' }} fs-5"></i>
                                                            {{ $kat->nama_kategori }}
                                                        </div>
                                                        <small class="text-muted d-block">
                                                            {{ $isPemasukan ? 'Infaq, Sedekah, Zakat, Donasi Jamaah' : 'Operasional, Listrik, Khotib, Pembangunan' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- 2. Rincian Transaksi & Nominal -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small text-uppercase mb-2">
                                    <i class="bi bi-card-text me-1 text-primary"></i> 2. Rincian & Jumlah Nominal
                                </label>

                                <div class="row g-3">
                                    <!-- Tanggal Transaksi -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-secondary">Tanggal Transaksi
                                            <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-calendar-event"></i></span>
                                            <input type="date" name="tanggal" id="tanggalInput" class="form-control"
                                                value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                        </div>
                                        <div class="d-flex gap-1 mt-1">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-xs py-0 px-2 date-shortcut"
                                                data-date="{{ date('Y-m-d') }}" style="font-size: 0.75rem;">Hari
                                                Ini</button>
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-xs py-0 px-2 date-shortcut"
                                                data-date="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                                style="font-size: 0.75rem;">Kemarin</button>
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-xs py-0 px-2 date-shortcut"
                                                data-date="{{ date('Y-m-d', strtotime('last friday')) }}"
                                                style="font-size: 0.75rem;">Jumat Lalu</button>
                                        </div>
                                    </div>

                                    <!-- Nominal Transaksi -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-secondary">Jumlah Nominal (Rp)
                                            <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light fw-bold text-dark">Rp</span>
                                            <input type="number" name="nominal" id="nominalInput"
                                                class="form-control form-control-lg fw-bold text-dark" placeholder="0"
                                                value="{{ old('nominal') }}" required min="0" step="100">
                                        </div>
                                        <div id="terbilangPreview" class="small text-muted fst-italic mt-1"
                                            style="min-height: 18px;"></div>
                                        <div class="d-flex gap-1 flex-wrap mt-1">
                                            <button type="button"
                                                class="btn btn-light border btn-xs py-0 px-2 nominal-chip"
                                                data-nominal="50000" style="font-size: 0.72rem;">+50 Ribu</button>
                                            <button type="button"
                                                class="btn btn-light border btn-xs py-0 px-2 nominal-chip"
                                                data-nominal="100000" style="font-size: 0.72rem;">+100 Ribu</button>
                                            <button type="button"
                                                class="btn btn-light border btn-xs py-0 px-2 nominal-chip"
                                                data-nominal="500000" style="font-size: 0.72rem;">+500 Ribu</button>
                                            <button type="button"
                                                class="btn btn-light border btn-xs py-0 px-2 nominal-chip"
                                                data-nominal="1000000" style="font-size: 0.72rem;">+1 Juta</button>
                                            <button type="button"
                                                class="btn btn-light border btn-xs py-0 px-2 nominal-chip"
                                                data-nominal="5000000" style="font-size: 0.72rem;">+5 Juta</button>
                                        </div>
                                    </div>

                                    <!-- Nama Transaksi / Sumber Dana -->
                                    <div class="col-12">
                                        <label class="form-label small fw-semibold text-secondary" id="sumberLabel">
                                            Nama / Sumber Penerimaan Transaksi <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                            <input type="text" name="sumber_keuangan" id="sumberInput"
                                                class="form-control"
                                                placeholder="Contoh: Infaq Kotak Jumat, Infaq Pembangunan, Donasi Transfer"
                                                value="{{ old('sumber_keuangan') }}" required maxlength="255">
                                        </div>
                                    </div>

                                    <!-- Keterangan Tambahan -->
                                    <div class="col-12">
                                        <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan
                                            Tambahan (Opsional)</label>
                                        <textarea name="keterangan" id="keteranganInput" class="form-control" rows="2"
                                            placeholder="Catatan opsional mengenai nomor kwitansi, rincian keperluan, atau peruntukan khusus...">{{ old('keterangan') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- 3. Hubungan Relasi (Donatur & Kegiatan) -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small text-uppercase mb-2">
                                    <i class="bi bi-link-45deg me-1 text-primary"></i> 3. Keterkaitan Donatur & Agenda
                                    Kegiatan (Opsional)
                                </label>

                                <div class="row g-3">
                                    <!-- Donatur -->
                                    <div class="col-md-6" id="wrapDonatur">
                                        <label class="form-label small fw-semibold text-secondary">Nama Donatur /
                                            Muzakki</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-person-heart"></i></span>
                                            <select name="donatur_id" id="donaturSelect" class="form-select">
                                                <option value="">-- Hamba Allah / Jamaah Umum --</option>
                                                @foreach ($donaturs as $donatur)
                                                    <option value="{{ $donatur->id }}"
                                                        {{ old('donatur_id') == $donatur->id ? 'selected' : '' }}>
                                                        {{ $donatur->nama_donatur }}
                                                        ({{ $donatur->telepon ?? 'Donatur Tetap' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="text-muted d-block mt-1">Pilih donatur terdaftar atau kosongkan
                                            jika berupa infaq umum.</small>
                                    </div>

                                    <!-- Kegiatan -->
                                    <div class="col-md-6" id="wrapKegiatan">
                                        <label class="form-label small fw-semibold text-secondary">Terkait Agenda
                                            Kegiatan Masjid</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i
                                                    class="bi bi-calendar-check"></i></span>
                                            <select name="kegiatan_id" id="kegiatanSelect" class="form-select">
                                                <option value="">-- Tidak Terkait Agenda Spesifik --</option>
                                                @foreach ($kegiatans as $kegiatan)
                                                    <option value="{{ $kegiatan->id }}"
                                                        {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                                                        {{ $kegiatan->nama_kegiatan }}
                                                        ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="text-muted d-block mt-1">Hubungkan transaksi dengan acara dakwah
                                            / peringatan hari besar.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                                <a href="{{ route('keuangan.index') }}" class="btn btn-light border px-4">Batal</a>
                                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btnSubmit">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Transaksi Kas
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Voucher Receipt Preview & Kas Status -->
            <div class="col-lg-4">
                <!-- Status Kas Saat Ini Card -->
                <div class="card border-0 shadow-sm mb-3"
                    style="background: linear-gradient(135deg, #0f766e 0%, #065f46 100%); color: #ffffff;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-uppercase text-white-50 fw-semibold">Saldo Kas Masjid Saat
                                Ini</span>
                            <i class="bi bi-wallet2 fs-4 text-warning"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-2" id="currentSaldoText">Rp
                            {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
                        <div
                            class="pt-2 border-top border-white border-opacity-25 d-flex justify-content-between small text-white-75">
                            <span><i class="bi bi-arrow-down-left text-success-emphasis"></i> Masuk:
                                {{ number_format($totalPemasukan / 1000000, 1) }}Jt</span>
                            <span><i class="bi bi-arrow-up-right text-danger-emphasis"></i> Keluar:
                                {{ number_format($totalPengeluaran / 1000000, 1) }}Jt</span>
                        </div>
                    </div>
                </div>

                <!-- Live Transaction Voucher Preview -->
                <div class="card border-0 shadow-sm position-sticky" style="top: 85px;">
                    <div class="card-header bg-light border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark small text-uppercase">
                                <i class="bi bi-receipt me-1 text-primary"></i> Pratinjau Bukti Kas
                            </span>
                            <span class="badge bg-success bg-opacity-75 text-white" id="previewBadge">PEMASUKAN</span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="p-3 rounded-3 bg-light border text-center mb-3">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.75rem;">Nominal
                                Transaksi</small>
                            <h3 class="fw-bold mb-1 text-success" id="previewNominal">Rp 0</h3>
                            <div class="badge bg-secondary-subtle text-secondary small fw-normal"
                                id="previewTerbilang">Nol Rupiah</div>
                        </div>

                        <div class="small">
                            <div class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted">Tanggal:</span>
                                <span class="fw-semibold text-dark"
                                    id="previewTanggal">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted">Uraian:</span>
                                <span class="fw-semibold text-dark text-end ms-2" id="previewUraian">-</span>
                            </div>
                            <div class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted">Donatur:</span>
                                <span class="fw-semibold text-dark" id="previewDonatur">Hamba Allah</span>
                            </div>
                            <div class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted">Agenda:</span>
                                <span class="fw-semibold text-dark" id="previewKegiatan">-</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 mt-2 bg-success-subtle px-2 rounded-2"
                                id="previewSimulasiWrap">
                                <span class="text-success-emphasis fw-semibold">Estimasi Saldo Baru:</span>
                                <span class="fw-bold text-success" id="previewSimulasiSaldo">Rp
                                    {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-3 p-2 bg-light rounded-2 text-muted" style="font-size: 0.72rem;">
                            <i class="bi bi-shield-check text-success me-1"></i> Data keuangan tercatat otomatis dalam
                            buku kas umum & laporan transparansi publik.
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
        const rawSaldo = {{ (float) $totalSaldo }};
        const nominalInput = document.getElementById('nominalInput');
        const tanggalInput = document.getElementById('tanggalInput');
        const sumberInput = document.getElementById('sumberInput');
        const keteranganInput = document.getElementById('keteranganInput');
        const donaturSelect = document.getElementById('donaturSelect');
        const kegiatanSelect = document.getElementById('kegiatanSelect');
        const sumberLabel = document.getElementById('sumberLabel');

        // Category Card Toggle
        const categoryRadios = document.querySelectorAll('.category-radio');
        const categoryCards = document.querySelectorAll('.category-card');

        function updateCategoryUI() {
            const selectedRadio = document.querySelector('.category-radio:checked');
            const isPemasukan = selectedRadio && selectedRadio.value === '1';

            categoryCards.forEach(card => {
                card.classList.remove('border-success', 'bg-success', 'border-danger', 'bg-danger',
                    'bg-opacity-10', 'text-success', 'text-danger', 'active');
                card.classList.add('border-light-subtle', 'bg-white', 'text-secondary');
            });

            if (selectedRadio) {
                const parentCard = selectedRadio.closest('.category-card');
                if (parentCard) {
                    parentCard.classList.remove('border-light-subtle', 'bg-white', 'text-secondary');
                    if (isPemasukan) {
                        parentCard.classList.add('border-success', 'bg-success', 'bg-opacity-10',
                            'text-success', 'active');
                    } else {
                        parentCard.classList.add('border-danger', 'bg-danger', 'bg-opacity-10', 'text-danger',
                            'active');
                    }
                }
            }

            // Update Labels & Placeholders
            const previewBadge = document.getElementById('previewBadge');
            const previewNominal = document.getElementById('previewNominal');
            const simulasiWrap = document.getElementById('previewSimulasiWrap');

            if (isPemasukan) {
                sumberLabel.innerHTML =
                    '<i class="bi bi-tag text-success me-1"></i>Nama / Sumber Penerimaan Infaq <span class="text-danger">*</span>';
                sumberInput.placeholder =
                'Contoh: Infaq Kotak Jumat, Infaq Pembangunan Masjid, Donasi Transfer';
                if (previewBadge) {
                    previewBadge.className = 'badge bg-success text-white';
                    previewBadge.textContent = 'PEMASUKAN';
                }
                if (previewNominal) {
                    previewNominal.className = 'fw-bold mb-1 text-success';
                }
                if (simulasiWrap) {
                    simulasiWrap.className =
                        'd-flex justify-content-between py-2 mt-2 bg-success-subtle px-2 rounded-2';
                }
            } else {
                sumberLabel.innerHTML =
                    '<i class="bi bi-tag text-danger me-1"></i>Keperluan / Peruntukan Pengeluaran <span class="text-danger">*</span>';
                sumberInput.placeholder =
                    'Contoh: Pembayaran Listrik PLN & Air, Honor Khotib Jumat, Konsumsi Kajian';
                if (previewBadge) {
                    previewBadge.className = 'badge bg-danger text-white';
                    previewBadge.textContent = 'PENGELUARAN';
                }
                if (previewNominal) {
                    previewNominal.className = 'fw-bold mb-1 text-danger';
                }
                if (simulasiWrap) {
                    simulasiWrap.className =
                        'd-flex justify-content-between py-2 mt-2 bg-danger-subtle px-2 rounded-2';
                }
            }

            updateLivePreview();
        }

        categoryRadios.forEach(radio => {
            radio.addEventListener('change', updateCategoryUI);
        });

        // Date Shortcuts
        document.querySelectorAll('.date-shortcut').forEach(btn => {
            btn.addEventListener('click', function() {
                tanggalInput.value = this.getAttribute('data-date');
                updateLivePreview();
            });
        });

        // Nominal Chips
        document.querySelectorAll('.nominal-chip').forEach(btn => {
            btn.addEventListener('click', function() {
                const addVal = parseInt(this.getAttribute('data-nominal')) || 0;
                const currentVal = parseInt(nominalInput.value) || 0;
                nominalInput.value = currentVal + addVal;
                updateLivePreview();
            });
        });

        // Indonesian Terbilang Helper
        function terbilang(n) {
            if (isNaN(n) || n <= 0) return 'Nol Rupiah';
            const satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan',
                'Sepuluh', 'Sebelas'
            ];

            function kata(angka) {
                angka = Math.floor(angka);
                if (angka < 12) return satuan[angka];
                if (angka < 20) return kata(angka - 10) + ' Belas';
                if (angka < 100) return kata(Math.floor(angka / 10)) + ' Puluh ' + kata(angka % 10);
                if (angka < 200) return 'Seratus ' + kata(angka - 100);
                if (angka < 1000) return kata(Math.floor(angka / 100)) + ' Ratus ' + kata(angka % 100);
                if (angka < 2000) return 'Seribu ' + kata(angka - 1000);
                if (angka < 1000000) return kata(Math.floor(angka / 1000)) + ' Ribu ' + kata(angka % 1000);
                if (angka < 1000000000) return kata(Math.floor(angka / 1000000)) + ' Juta ' + kata(angka %
                    1000000);
                if (angka < 1000000000000) return kata(Math.floor(angka / 1000000000)) + ' Milyar ' + kata(
                    angka % 1000000000);
                return '';
            }
            return (kata(n) + ' Rupiah').replace(/\s+/g, ' ').trim();
        }

        // Live Preview Update
        function updateLivePreview() {
            const nominal = parseFloat(nominalInput.value) || 0;
            const selectedRadio = document.querySelector('.category-radio:checked');
            const isPemasukan = selectedRadio && selectedRadio.value === '1';

            // Formatted Nominal
            document.getElementById('previewNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');

            // Terbilang
            const terbilangStr = terbilang(nominal);
            document.getElementById('terbilangPreview').textContent = nominal > 0 ? terbilangStr : '';
            document.getElementById('previewTerbilang').textContent = terbilangStr;

            // Uraian
            const uraian = sumberInput.value.trim();
            document.getElementById('previewUraian').textContent = uraian || '-';

            // Tanggal
            if (tanggalInput.value) {
                const d = new Date(tanggalInput.value + 'T00:00:00');
                const options = {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                document.getElementById('previewTanggal').textContent = d.toLocaleDateString('id-ID', options);
            }

            // Donatur
            if (donaturSelect && donaturSelect.selectedIndex > 0) {
                document.getElementById('previewDonatur').textContent = donaturSelect.options[donaturSelect
                    .selectedIndex].text.split('(')[0].trim();
            } else {
                document.getElementById('previewDonatur').textContent = 'Hamba Allah';
            }

            // Kegiatan
            if (kegiatanSelect && kegiatanSelect.selectedIndex > 0) {
                document.getElementById('previewKegiatan').textContent = kegiatanSelect.options[kegiatanSelect
                    .selectedIndex].text.split('(')[0].trim();
            } else {
                document.getElementById('previewKegiatan').textContent = '-';
            }

            // Simulasi Saldo
            const newSaldo = isPemasukan ? (rawSaldo + nominal) : (rawSaldo - nominal);
            document.getElementById('previewSimulasiSaldo').textContent = 'Rp ' + newSaldo.toLocaleString(
                'id-ID');
        }

        // Bind event listeners
        nominalInput.addEventListener('input', updateLivePreview);
        sumberInput.addEventListener('input', updateLivePreview);
        tanggalInput.addEventListener('change', updateLivePreview);
        if (donaturSelect) donaturSelect.addEventListener('change', updateLivePreview);
        if (kegiatanSelect) kegiatanSelect.addEventListener('change', updateLivePreview);

        // Initial run
        updateCategoryUI();
    });
</script>
