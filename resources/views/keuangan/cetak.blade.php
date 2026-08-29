<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan - {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #ffffff;
            margin: 20px;
        }
        .kop-surat {
            border-bottom: 3px double #065f46;
            padding-bottom: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
        .bismillah-text {
            font-size: 14px;
            color: #065f46;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .nama-masjid {
            font-size: 18px;
            font-weight: 800;
            color: #065f46;
            text-transform: uppercase;
        }
        .alamat-masjid {
            font-size: 11px;
            color: #475569;
        }
        .table-data thead th {
            background-color: #065f46 !important;
            color: #ffffff !important;
            text-align: center;
            vertical-align: middle;
            font-size: 11.5px;
        }
        .table-data tbody td {
            vertical-align: middle;
            font-size: 11.5px;
        }
        .stat-card {
            border-radius: 8px;
            padding: 10px 14px;
        }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="no-print mb-3 d-flex justify-content-between align-items-center bg-light p-2 rounded">
            <span class="text-muted"><i class="bi bi-info-circle me-1"></i> Mode Cetak Dokumen Laporan Keuangan</span>
            <div>
                <button onclick="window.print()" class="btn btn-success btn-sm me-1"><i class="bi bi-printer me-1"></i> Cetak Dokumen</button>
                <button onclick="window.close()" class="btn btn-secondary btn-sm"><i class="bi bi-x-circle me-1"></i> Tutup</button>
            </div>
        </div>

        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <div class="bismillah-text">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
            <div class="nama-masjid">PENGURUS TAKMIR {{ $profil->nama_masjid ?? 'MASJID AL-IKHLAS' }}</div>
            <div class="alamat-masjid">{{ $profil->alamat ?? 'Dukuh Semendot, Desa Karangmulya, Kec. Suradadi, Kab. Tegal, Jawa Tengah' }}</div>
            <div class="alamat-masjid">Telepon / WhatsApp: {{ $profil->telepon ?? '0812-3456-7890' }} | Sistem Informasi Manajemen Masjid (SIMAS)</div>
        </div>

        <div class="text-center mb-3">
            <h5 class="fw-bold text-dark text-uppercase mb-1" style="text-decoration: underline;">BUKU KAS UMUM & LAPORAN KEUANGAN MASJID</h5>
            <div class="text-secondary small fw-semibold">
                Periode:
                @if($filter === 'tahunan')
                    Tahun {{ $tahun }}
                @elseif($filter === 'bulanan')
                    Bulan {{ $namaBulan }} {{ $tahun ? 'Tahun ' . $tahun : '' }}
                @elseif($filter === 'periode')
                    {{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}
                @else
                    Seluruh Periode Pembukuan
                @endif
            </div>
        </div>

        <!-- Executive Summary Cards -->
        <div class="row g-2 mb-3">
            <div class="col-3">
                <div class="stat-card border border-success bg-success bg-opacity-10">
                    <small class="text-muted text-uppercase fw-bold">Total Pemasukan</small>
                    <h6 class="fw-bold text-success mb-0 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h6>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card border border-danger bg-danger bg-opacity-10">
                    <small class="text-muted text-uppercase fw-bold">Total Pengeluaran</small>
                    <h6 class="fw-bold text-danger mb-0 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h6>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card border border-info bg-info bg-opacity-10">
                    <small class="text-muted text-uppercase fw-bold">Saldo Kas Tersedia</small>
                    <h6 class="fw-bold text-primary mb-0 mt-1">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h6>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card border border-secondary bg-light">
                    <small class="text-muted text-uppercase fw-bold">Status Arus Kas</small>
                    <h6 class="fw-bold text-dark mb-0 mt-1">{{ $totalSaldo >= 0 ? 'SURPLUS KAS' : 'DEFISIT KAS' }}</h6>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-data align-middle">
            <thead>
                <tr>
                    <th style="width: 35px;">No</th>
                    <th style="width: 85px;">Tanggal</th>
                    <th style="width: 90px;">Jenis</th>
                    <th>Uraian / Keterangan Transaksi</th>
                    <th style="width: 130px;">Donatur</th>
                    <th style="width: 140px;">Kegiatan</th>
                    <th style="width: 110px;" class="text-end">Pemasukan (Rp)</th>
                    <th style="width: 110px;" class="text-end">Pengeluaran (Rp)</th>
                    <th style="width: 120px;" class="text-end">Saldo Kas (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keuangan as $i => $item)
                    @php
                        $isMasuk = $item->kategori_id == 1;
                        $uraian = $isMasuk ? ($item->sumber_keuangan ?? $item->keterangan) : ($item->keterangan ?? $item->sumber_keuangan);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($isMasuk)
                                <span class="badge bg-success">Pemasukan</span>
                            @else
                                <span class="badge bg-danger">Pengeluaran</span>
                            @endif
                        </td>
                        <td>{{ $uraian ?? '-' }}</td>
                        <td>{{ $item->donatur ? $item->donatur->nama_donatur : 'Hamba Allah' }}</td>
                        <td>{{ $item->kegiatan ? $item->kegiatan->nama_kegiatan : '—' }}</td>
                        <td class="text-end fw-semibold text-success">{{ $isMasuk ? number_format($item->nominal, 0, ',', '.') : '—' }}</td>
                        <td class="text-end fw-semibold text-danger">{{ !$isMasuk ? number_format($item->nominal, 0, ',', '.') : '—' }}</td>
                        <td class="text-end fw-bold text-dark">{{ number_format($item->saldo_berjalan ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">Tidak ada data transaksi keuangan pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="table-secondary fw-bold">
                <tr>
                    <td colspan="6" class="text-end">JUMLAH REKAPITULASI :</td>
                    <td class="text-end text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    <td class="text-end text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    <td class="text-end text-primary">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Lembar Tanda Tangan Takmir -->
        <div class="row mt-4 pt-2 text-center" style="page-break-inside: avoid;">
            <div class="col-6">
                <p class="mb-1">Mengetahui,</p>
                <strong>Ketua Takmir {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</strong>
                <div style="height: 60px;"></div>
                <p class="fw-bold text-decoration-underline mb-0">{{ $ketuaTakmir ? $ketuaTakmir->nama_takmir : 'H. Ahmad Syarifuddin, S.Pd.I' }}</p>
                <small class="text-muted">NIP: {{ $ketuaTakmir ? 'TMR-'.str_pad($ketuaTakmir->id, 4, '0', STR_PAD_LEFT) : 'TMR-0001' }}</small>
            </div>
            <div class="col-6">
                <p class="mb-1">Karangmulya, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <strong>Bendahara Kas Masjid</strong>
                <div style="height: 60px;"></div>
                <p class="fw-bold text-decoration-underline mb-0">{{ $bendahara ? $bendahara->nama_takmir : 'Ust. Muhammad Rizki, S.E' }}</p>
                <small class="text-muted">NIP: {{ $bendahara ? 'TMR-'.str_pad($bendahara->id, 4, '0', STR_PAD_LEFT) : 'TMR-0002' }}</small>
            </div>
        </div>

        <div class="text-center text-muted small mt-4 pt-2 border-top">
            <em>"Dan apa saja yang kamu infakkan, niscaya Dia akan menggantinya dan Dialah sebaik-baik pemberi rezeki." (QS. Saba: 39)</em><br>
            Dicetak secara otomatis melalui Sistem Informasi Manajemen Masjid (SIMAS) pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB.
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
