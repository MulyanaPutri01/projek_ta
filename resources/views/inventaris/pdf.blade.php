<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Barang {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</title>
    <style>
        @page {
            @if(($orientation ?? 'landscape') === 'portrait')
                margin-top: 40pt;
                margin-bottom: 40pt;
                margin-left: 50pt;
                margin-right: 50pt;
            @else
                margin-top: 35pt;
                margin-bottom: 35pt;
                margin-left: 45pt;
                margin-right: 45pt;
            @endif
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: {{ ($orientation ?? 'landscape') === 'portrait' ? '7.5pt' : '8pt' }};
            color: #1e293b;
            background: #ffffff;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .print-wrapper {
            width: 100%;
        }

        /* ===== KOP SURAT RESMI ===== */
        .kop-surat {
            width: 100%;
            margin-bottom: 14pt;
            border-bottom: 2.5pt double #065f46;
            padding-bottom: 8pt;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .bismillah-text {
            font-size: 9pt;
            color: #065f46;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2pt;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .nama-masjid {
            font-size: 13pt;
            font-weight: 800;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .alamat-masjid {
            font-size: 8pt;
            color: #475569;
            text-align: center;
            margin-top: 2px;
        }
        .kontak-masjid {
            font-size: 7.5pt;
            color: #64748b;
            text-align: center;
            margin-top: 1px;
        }

        /* ===== JUDUL LAPORAN ===== */
        .judul-laporan-container {
            text-align: center;
            margin-bottom: 12pt;
        }
        .judul-laporan {
            font-size: 10.5pt;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: underline;
        }
        .periode-laporan {
            font-size: 8pt;
            color: #334155;
            font-weight: 600;
            margin-top: 2pt;
        }

        /* ===== RINGKASAN EKSEKUTIF ===== */
        .stat-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8pt 0;
            margin-bottom: 14pt;
        }
        .stat-card {
            padding: 8pt 10pt;
            border-radius: 4pt;
            vertical-align: middle;
        }
        .stat-card.jenis {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 3.5pt solid #2563eb;
        }
        .stat-card.unit {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3.5pt solid #16a34a;
        }
        .stat-card.status {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3.5pt solid #065f46;
        }
        .stat-title {
            font-size: 6.8pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
        }
        .stat-value {
            font-size: 10pt;
            font-weight: 800;
            margin-top: 2pt;
        }
        .stat-card.jenis .stat-value { color: #1d4ed8; }
        .stat-card.unit .stat-value { color: #15803d; }
        .stat-card.status .stat-value { color: #065f46; }
        .stat-sub {
            font-size: 6.2pt;
            color: #94a3b8;
            margin-top: 1pt;
        }

        /* ===== TABEL DATA UTAMA ===== */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14pt;
        }
        .table-data thead th {
            background: #065f46;
            color: #ffffff;
            font-size: 7.5pt;
            font-weight: 700;
            padding: 5pt 6pt;
            border: 1px solid #044e3a;
            text-align: center;
            letter-spacing: 0.3px;
        }
        .table-data tbody tr td {
            padding: 4.5pt 6pt;
            border: 1px solid #cbd5e1;
            font-size: 7.5pt;
            vertical-align: middle;
        }
        .table-data tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 1.5pt 5pt;
            border-radius: 3pt;
            font-size: 6.5pt;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-baik {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-rusak {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .badge-perbaikan {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .badge-qty {
            background: #e0f2fe;
            color: #0369a1;
            padding: 1pt 4pt;
            border-radius: 2pt;
            font-size: 6.5pt;
            font-weight: bold;
        }

        /* Helpers */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #64748b; }

        /* Total Footer Row */
        .table-data tfoot td {
            background: #e2e8f0;
            border: 1.5px solid #94a3b8;
            font-weight: 800;
            padding: 5.5pt 6pt;
            font-size: 8pt;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-container {
            width: 100%;
            margin-top: 18pt;
            page-break-inside: avoid;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-table td {
            vertical-align: top;
            text-align: center;
            font-size: 8pt;
        }
        .ttd-space {
            height: 50pt;
        }
        .ttd-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }
        .ttd-role {
            font-size: 7.5pt;
            color: #475569;
        }

        /* ===== FOOTER DOKUMEN ===== */
        .doc-footer {
            margin-top: 16pt;
            padding-top: 6pt;
            border-top: 1px dashed #cbd5e1;
            font-size: 6.8pt;
            color: #94a3b8;
            text-align: center;
        }
        .no-data {
            text-align: center;
            color: #94a3b8;
            padding: 15pt;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="print-wrapper">

    {{-- ================= KOP SURAT RESMI ================= --}}
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td style="text-align: center;">
                    <div class="bismillah-text">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
                    <div class="nama-masjid">PENGURUS TAKMIR {{ $profil->nama_masjid ?? 'MASJID AL-IKHLAS' }}</div>
                    <div class="alamat-masjid">{{ $profil->alamat ?? 'Dukuh Semendot, Desa Karangmulya, Kec. Suradadi, Kab. Tegal, Jawa Tengah' }}</div>
                    <div class="kontak-masjid">Nomor Telepon / WhatsApp: {{ $profil->telepon ?? '0812-3456-7890' }} &nbsp;|&nbsp; Sistem Informasi Manajemen Masjid</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ================= JUDUL LAPORAN ================= --}}
    <div class="judul-laporan-container">
        <div class="judul-laporan">BUKU INDUK INVENTARIS & ASET FISIK MASJID</div>
        <div class="periode-laporan">
            Per Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- ================= RINGKASAN EKSEKUTIF (CARDS) ================= --}}
    <table class="stat-table">
        <tr>
            <td class="stat-card jenis" style="width: 33.3%;">
                <div class="stat-title">Total Jenis Aset</div>
                <div class="stat-value">{{ $totalJenis }} Item</div>
                <div class="stat-sub">Kategori Barang Terdaftar</div>
            </td>
            <td class="stat-card unit" style="width: 33.3%;">
                <div class="stat-title">Total Kuantitas Fisik</div>
                <div class="stat-value">{{ $totalUnit }} Unit / Set</div>
                <div class="stat-sub">Seluruh Fasilitas Masjid</div>
            </td>
            <td class="stat-card status" style="width: 33.3%;">
                <div class="stat-title">Status Dokumentasi</div>
                <div class="stat-value">TERVERIFIKASI</div>
                <div class="stat-sub">Sistem Manajemen Inventaris</div>
            </td>
        </tr>
    </table>

    {{-- ================= TABEL DATA INVENTARIS ================= --}}
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 75px;">Kode Aset</th>
                <th>Nama Barang Inventaris</th>
                <th style="width: 65px;">Kuantitas</th>
                <th style="width: 60px;">Tahun</th>
                <th style="width: 140px;">Lokasi Penempatan</th>
                <th style="width: 110px;">Kondisi Terakhir</th>
                <th style="width: 160px;">Sumber / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventariss as $i => $item)
                @php
                    $latestCatatan = $item->catatans->sortByDesc('tanggal_catatan')->first();
                    $namaKondisi = $latestCatatan && $latestCatatan->kondisi ? $latestCatatan->kondisi->nama_kondisi : 'Baik';
                    $namaKondisiLower = strtolower($namaKondisi);

                    $badgeClass = 'badge-baik';
                    if (str_contains($namaKondisiLower, 'rusak')) {
                        $badgeClass = 'badge-rusak';
                    } elseif (str_contains($namaKondisiLower, 'perbaikan') || str_contains($namaKondisiLower, 'kurang') || str_contains($namaKondisiLower, 'servis')) {
                        $badgeClass = 'badge-perbaikan';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center" style="font-family: monospace; font-weight: bold; color: #475569;">
                        INV-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td class="text-center"><span class="badge-qty">{{ $item->jumlah }} Unit</span></td>
                    <td class="text-center">{{ $item->tahun_pembelian }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td class="text-center">
                        <span class="badge {{ $badgeClass }}">{{ $namaKondisi }}</span>
                    </td>
                    <td>{{ $item->keterangan ?: 'Pembelian Kas Masjid' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">Belum ada data barang inventaris yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right fw-bold">TOTAL REKAPITULASI ASET :</td>
                <td class="text-center fw-bold" style="color: #15803d;">{{ $totalUnit }} Unit</td>
                <td colspan="4" class="text-muted" style="font-size: 7.5pt;">Total {{ $totalJenis }} Item Barang Terdaftar</td>
            </tr>
        </tfoot>
    </table>

    {{-- ================= LEMBAR PENGESAHAN TAKMIR ================= --}}
    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td style="width: 50%;">
                    Mengetahui,<br>
                    <strong>Ketua Takmir {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</strong>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">{{ $ketuaTakmir ? $ketuaTakmir->nama_takmir : 'H. Ahmad Syarifuddin, S.Pd.I' }}</div>
                    <div class="ttd-role">NIP/Takmir ID: {{ $ketuaTakmir ? 'TMR-'.str_pad($ketuaTakmir->id, 4, '0', STR_PAD_LEFT) : 'TMR-0001' }}</div>
                </td>
                <td style="width: 50%;">
                    Karangmulya, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    <strong>Sekretaris / Pengelola Aset</strong>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">{{ $sekretaris ? $sekretaris->nama_takmir : 'Ust. Muhammad Rizki, S.E' }}</div>
                    <div class="ttd-role">NIP/Takmir ID: {{ $sekretaris ? 'TMR-'.str_pad($sekretaris->id, 4, '0', STR_PAD_LEFT) : 'TMR-0002' }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ================= FOOTER DOKUMEN ================= --}}
    <div class="doc-footer">
        Dokumen Laporan Inventaris ini diterbitkan secara resmi melalui Sistem Informasi Manajemen Masjid (SIMAS) pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }} WIB.
    </div>

</div>
</body>
</html>
