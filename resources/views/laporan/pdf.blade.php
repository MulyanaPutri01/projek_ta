<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</title>
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

        /* ===== RINGKASAN EKSEKUTIF (SUMMARY CARDS) ===== */
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
        .stat-card.income {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3.5pt solid #16a34a;
        }
        .stat-card.expense {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 3.5pt solid #dc2626;
        }
        .stat-card.balance {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-left: 3.5pt solid #0d9488;
        }
        .stat-card.status {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3.5pt solid #64748b;
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
        .stat-card.income .stat-value { color: #15803d; }
        .stat-card.expense .stat-value { color: #b91c1c; }
        .stat-card.balance .stat-value { color: #0f766e; }
        .stat-card.status .stat-value { color: #334155; }
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
        .table-data tbody tr.row-income {
            background-color: #fafffc;
        }
        .table-data tbody tr.row-expense {
            background-color: #fffafa;
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
        .badge-masuk {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-keluar {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .badge-activity {
            background: #e0f2fe;
            color: #0369a1;
            padding: 1pt 4pt;
            border-radius: 2pt;
            font-size: 6.5pt;
        }

        /* Helpers */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-income { color: #16a34a; font-weight: 700; }
        .text-expense { color: #dc2626; font-weight: 700; }
        .text-balance { color: #0f766e; font-weight: 700; }
        .text-muted { color: #64748b; }

        /* Total Footer Row */
        .table-data tfoot td {
            background: #e2e8f0;
            border: 1.5px solid #94a3b8;
            font-weight: 800;
            padding: 5.5pt 6pt;
            font-size: 8pt;
        }

        /* ===== TANDA TANGAN & PENGESAHAN ===== */
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
                    <div class="bismillah-text">BISMILLAHIRRAHMANIRRAHIM</div>
                    <div class="nama-masjid">PENGURUS TAKMIR {{ $profil->nama_masjid ?? 'MASJID AL-IKHLAS' }}</div>
                    <div class="alamat-masjid">{{ $profil->alamat ?? 'Dukuh Semendot, Desa Karangmulya, Kec. Suradadi, Kab. Tegal, Jawa Tengah' }}</div>
                    <div class="kontak-masjid">Nomor Telepon / WhatsApp: {{ $profil->telepon ?? '0812-3456-7890' }} &nbsp;|&nbsp; Website Resmi SIMAS</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ================= JUDUL LAPORAN ================= --}}
    <div class="judul-laporan-container">
        <div class="judul-laporan">BUKU KAS UMUM & LAPORAN KEUANGAN MASJID</div>
        <div class="periode-laporan">
            Periode:
            @if($filter === 'tahunan')
                Tahun {{ $tahun }}
            @elseif($filter === 'bulanan')
                Bulan {{ $namaBulan }} {{ $tahun ? 'Tahun '.$tahun : '' }}
            @elseif($filter === 'periode')
                {{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}
            @else
                Seluruh Periode Pembukuan
            @endif
        </div>
    </div>

    {{-- ================= RINGKASAN EKSEKUTIF (CARDS) ================= --}}
    <table class="stat-table">
        <tr>
            <td class="stat-card income" style="width: 25%;">
                <div class="stat-title">Total Pemasukan</div>
                <div class="stat-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                <div class="stat-sub">{{ $countPemasukan ?? $keuangan->where('kategori_id', 1)->count() }} Transaksi Masuk</div>
            </td>
            <td class="stat-card expense" style="width: 25%;">
                <div class="stat-title">Total Pengeluaran</div>
                <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                <div class="stat-sub">{{ $countPengeluaran ?? $keuangan->where('kategori_id', 2)->count() }} Transaksi Keluar</div>
            </td>
            <td class="stat-card balance" style="width: 25%;">
                <div class="stat-title">Saldo Kas Akhir</div>
                <div class="stat-value">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</div>
                <div class="stat-sub">Sisa Saldo Kas Tersedia</div>
            </td>
            <td class="stat-card status" style="width: 25%;">
                <div class="stat-title">Status Arus Kas</div>
                <div class="stat-value" style="color: {{ $totalSaldo >= 0 ? '#15803d' : '#b91c1c' }};">
                    {{ $totalSaldo > 0 ? 'SURPLUS KAS' : ($totalSaldo == 0 ? 'SEIMBANG' : 'DEFISIT KAS') }}
                </div>
                <div class="stat-sub">Total {{ $keuangan->count() }} Mutasi Transaksi</div>
            </td>
        </tr>
    </table>

    {{-- ================= TABEL MUTASI KAS KRONOLOGIS ================= --}}
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 75px;">Tanggal</th>
                <th style="width: 80px;">Jenis</th>
                <th>Uraian / Keterangan Transaksi</th>
                <th style="width: 120px;">Donatur / Sumber</th>
                <th style="width: 130px;">Terkait Kegiatan</th>
                <th style="width: 100px;">Pemasukan (Rp)</th>
                <th style="width: 100px;">Pengeluaran (Rp)</th>
                <th style="width: 110px;">Saldo Kas (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $i => $item)
                @php
                    $isMasuk = $item->kategori_id == 1;
                    $uraian = $isMasuk ? ($item->sumber_keuangan ?? $item->keterangan) : ($item->keterangan ?? $item->sumber_keuangan);
                @endphp
                <tr class="{{ $isMasuk ? 'row-income' : 'row-expense' }}">
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($isMasuk)
                            <span class="badge badge-masuk">Pemasukan</span>
                        @else
                            <span class="badge badge-keluar">Pengeluaran</span>
                        @endif
                    </td>
                    <td>{{ $uraian ?? '-' }}</td>
                    <td>{{ $item->donatur ? $item->donatur->nama_donatur : 'Hamba Allah' }}</td>
                    <td>
                        @if($item->kegiatan)
                            <span class="badge-activity">{{ $item->kegiatan->nama_kegiatan }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-right text-income">
                        {{ $isMasuk ? number_format($item->nominal, 0, ',', '.') : '—' }}
                    </td>
                    <td class="text-right text-expense">
                        {{ !$isMasuk ? number_format($item->nominal, 0, ',', '.') : '—' }}
                    </td>
                    <td class="text-right text-balance">
                        {{ number_format($item->saldo_berjalan ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="no-data">Belum ada catatan mutasi transaksi keuangan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right fw-bold">JUMLAH REKAPITULASI :</td>
                <td class="text-right text-income">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="text-right text-expense">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td class="text-right text-balance">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</td>
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
                    <strong>Bendahara Kas Masjid</strong>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">{{ $bendahara ? $bendahara->nama_takmir : 'Ust. Muhammad Rizki, S.E' }}</div>
                    <div class="ttd-role">NIP/Takmir ID: {{ $bendahara ? 'TMR-'.str_pad($bendahara->id, 4, '0', STR_PAD_LEFT) : 'TMR-0002' }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ================= FOOTER DOKUMEN ================= --}}
    <div class="doc-footer">
        <em>"Dan apa saja yang kamu infakkan, niscaya Dia akan menggantinya dan Dialah sebaik-baik pemberi rezeki." (QS. Saba: 39)</em><br>
        Dokumen ini diterbitkan secara resmi melalui Sistem Informasi Manajemen Masjid (SIMAS) pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }} WIB.
    </div>

</div>
</body>
</html>
