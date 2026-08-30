<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SK Panitia - {{ $kegiatan->nama_kegiatan }}</title>
    <style>
        @page {
            @if(($orientation ?? 'portrait') === 'landscape')
                margin-top: 35pt;
                margin-bottom: 35pt;
                margin-left: 45pt;
                margin-right: 45pt;
            @else
                margin-top: 40pt;
                margin-bottom: 40pt;
                margin-left: 50pt;
                margin-right: 50pt;
            @endif
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: {{ ($orientation ?? 'portrait') === 'landscape' ? '8pt' : '8.5pt' }};
            color: #1e293b;
            line-height: 1.45;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }
        .print-wrapper {
            width: 100%;
        }

        /* ===== KOP SURAT RESMI ===== */
        .kop-surat {
            text-align: center;
            border-bottom: 2.5pt double #065f46;
            padding-bottom: 8pt;
            margin-bottom: 14pt;
        }
        .bismillah {
            font-size: 9pt;
            color: #065f46;
            font-weight: 700;
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
        }
        .alamat-masjid {
            font-size: 8pt;
            color: #475569;
            margin-top: 2px;
        }
        .kontak-masjid {
            font-size: 7.5pt;
            color: #64748b;
        }

        /* ===== JUDUL SK ===== */
        .judul-sk-container {
            text-align: center;
            margin-bottom: 12pt;
        }
        .judul-sk {
            font-size: 10.5pt;
            font-weight: 800;
            text-transform: uppercase;
            text-decoration: underline;
            color: #0f172a;
        }
        .nomor-sk {
            font-size: 8pt;
            font-weight: 600;
            color: #334155;
            margin-top: 2pt;
        }
        .tentang-sk {
            font-size: 9pt;
            font-weight: 700;
            color: #065f46;
            text-transform: uppercase;
            margin-top: 3pt;
        }

        /* ===== KONSIDERANS ===== */
        .konsiderans-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
            font-size: 8pt;
        }
        .konsiderans-table td {
            vertical-align: top;
            padding: 2pt 0;
        }
        .label-col {
            width: 90pt;
            font-weight: bold;
            color: #334155;
        }
        .colon-col {
            width: 12pt;
            font-weight: bold;
        }

        /* ===== MEMUTUSKAN ===== */
        .memutuskan-box {
            text-align: center;
            font-weight: 800;
            font-size: 9.5pt;
            margin: 8pt 0 6pt 0;
            color: #065f46;
            letter-spacing: 1px;
        }

        /* ===== TABEL SUSUNAN PANITIA ===== */
        .table-panitia {
            width: 100%;
            border-collapse: collapse;
            margin: 10pt 0 14pt 0;
        }
        .table-panitia thead th {
            background: #065f46;
            color: #ffffff;
            font-size: 7.5pt;
            font-weight: 700;
            padding: 5pt 6pt;
            border: 1px solid #044e3a;
            text-align: center;
        }
        .table-panitia tbody td {
            padding: 4.5pt 6pt;
            border: 1px solid #cbd5e1;
            font-size: 7.5pt;
            vertical-align: middle;
        }
        .table-panitia tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .section-header td {
            background: #e2e8f0 !important;
            font-weight: bold;
            color: #0f172a;
            font-size: 7.5pt;
            padding: 4pt 6pt;
            border: 1px solid #94a3b8;
        }
        .badge-posisi {
            display: inline-block;
            padding: 1.5pt 5pt;
            border-radius: 2pt;
            font-size: 7pt;
            font-weight: 700;
            background: #e0f2fe;
            color: #0369a1;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-box {
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

        /* ===== FOOTER ===== */
        .doc-footer {
            margin-top: 18pt;
            padding-top: 6pt;
            border-top: 1px dashed #cbd5e1;
            font-size: 6.8pt;
            color: #94a3b8;
            text-align: center;
        }
        .text-center { text-align: center; }
    </style>
</head>
<body>
<div class="print-wrapper">

    <!-- Kop Surat Resmi -->
    <div class="kop-surat">
        <div class="bismillah">BISMILLAHIRRAHMANIRRAHIM</div>
        <div class="nama-masjid">PENGURUS TAKMIR {{ $profil->nama_masjid ?? 'MASJID AL-IKHLAS' }}</div>
        <div class="alamat-masjid">{{ $profil->alamat ?? 'Dukuh Semendot, Desa Karangmulya, Kec. Suradadi, Kab. Tegal' }}</div>
        <div class="kontak-masjid">Telepon / WhatsApp: {{ $profil->telepon ?? '0812-3456-7890' }} | Sistem Informasi Manajemen Masjid</div>
    </div>

    <!-- Judul SK -->
    <div class="judul-sk-container">
        <div class="judul-sk">SURAT KEPUTUSAN KETUA TAKMIR</div>
        <div class="nomor-sk">Nomor: SK-PAN/{{ date('Y') }}/{{ str_pad($kegiatan->id, 3, '0', STR_PAD_LEFT) }}</div>
        <div class="tentang-sk">TENTANG<br>PEMBENTUKAN DAN PENETAPAN SUSUNAN PANITIA PELAKSANA<br>{{ strtoupper($kegiatan->nama_kegiatan) }}</div>
    </div>

    <!-- Konsiderans -->
    <table class="konsiderans-table">
        <tr>
            <td class="label-col">Menimbang</td>
            <td class="colon-col">:</td>
            <td>
                Bahwa demi kelancaran, ketertiban, dan kesuksesan pelaksanaan kegiatan <strong>{{ $kegiatan->nama_kegiatan }}</strong> yang diselenggarakan pada tanggal <strong>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}</strong>, maka dipandang perlu untuk membentuk dan menetapkan Susunan Panitia Pelaksana.
            </td>
        </tr>
        <tr>
            <td class="label-col">Mengingat</td>
            <td class="colon-col">:</td>
            <td>
                1. Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART) {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}.<br>
                2. Program Kerja Bidang Dakwah & PHBI Pengurus Takmir Tahun {{ date('Y') }}.
            </td>
        </tr>
        <tr>
            <td class="label-col">Memperhatikan</td>
            <td class="colon-col">:</td>
            <td>
                Hasil musyawarah mufakat Pengurus Takmir dan Jamaah Masjid tentang persiapan agenda kegiatan {{ $kegiatan->nama_kegiatan }}.
            </td>
        </tr>
    </table>

    <div class="memutuskan-box">MEMUTUSKAN</div>

    <table class="konsiderans-table">
        <tr>
            <td class="label-col">Menetapkan</td>
            <td class="colon-col">:</td>
            <td><strong>SUSUNAN PANITIA PELAKSANA KEGIATAN {{ strtoupper($kegiatan->nama_kegiatan) }} SEBAGAIMANA TERCANTUM DALAM LAMPIRAN KEPUTUSAN INI.</strong></td>
        </tr>
        <tr>
            <td class="label-col">Pertama</td>
            <td class="colon-col">:</td>
            <td>Mengangkat dan menugaskan saudara-saudara yang namanya tercantum dalam lampiran untuk melaksanakan tugas dan amanah kepanitiaan dengan penuh tanggung jawab.</td>
        </tr>
        <tr>
            <td class="label-col">Kedua</td>
            <td class="colon-col">:</td>
            <td>Keputusan ini berlaku sejak tanggal ditetapkan sampai dengan berakhirnya laporan pertanggungjawaban kegiatan.</td>
        </tr>
    </table>

    <!-- Tabel Susunan Panitia -->
    <table class="table-panitia">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 140px;">Posisi / Jabatan</th>
                <th style="width: 170px;">Nama Takmir / Relawan</th>
                <th>Uraian Tugas / Jobdesk</th>
            </tr>
        </thead>
        <tbody>
            @if($pimpinanInti->isNotEmpty())
                <tr class="section-header">
                    <td colspan="4">A. PIMPINAN INTI / KOORDINATOR UTAMA</td>
                </tr>
                @foreach($pimpinanInti as $idx => $p)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td><span class="badge-posisi">{{ $p->posisi ? $p->posisi->nama_posisi : '-' }}</span></td>
                        <td><strong>{{ $p->takmir ? $p->takmir->nama_takmir : 'Petugas Takmir' }}</strong></td>
                        <td>{{ $p->jobdesk ?? '-' }}</td>
                    </tr>
                @endforeach
            @endif

            @if($seksiSeksi->isNotEmpty())
                <tr class="section-header">
                    <td colspan="4">B. DIVISI / SEKSI-SEKSI LAPANGAN</td>
                </tr>
                @php $seksiIdx = 1; @endphp
                @foreach($seksiSeksi as $posisiId => $items)
                    @foreach($items as $p)
                        <tr>
                            <td class="text-center">{{ $seksiIdx++ }}</td>
                            <td><span class="badge-posisi">{{ $p->posisi ? $p->posisi->nama_posisi : '-' }}</span></td>
                            <td>{{ $p->takmir ? $p->takmir->nama_takmir : 'Petugas Takmir' }}</td>
                            <td>{{ $p->jobdesk ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif

            @if($panitiaList->isEmpty())
                <tr>
                    <td colspan="4" class="text-center" style="padding: 15px; color: #94a3b8;">Belum ada susunan panitia yang terdaftar pada agenda kegiatan ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Lembar Tanda Tangan -->
    <div class="ttd-box">
        <table class="ttd-table">
            <tr>
                <td style="width: 50%;">
                    Mengetahui,<br>
                    <strong>Ketua Panitia Pelaksana</strong>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">
                        {{ $pimpinanInti->first()?->takmir?->nama_takmir ?? 'Ketua Panitia' }}
                    </div>
                    <div style="font-size: 7.5pt; color: #64748b;">Panitia {{ $kegiatan->nama_kegiatan }}</div>
                </td>
                <td style="width: 50%;">
                    Ditetapkan di: Karangmulya<br>
                    Pada tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    <strong>Ketua Takmir {{ $profil->nama_masjid ?? 'Masjid Al-Ikhlas' }}</strong>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">{{ $ketuaTakmir ? $ketuaTakmir->nama_takmir : 'H. Ahmad Syarifuddin, S.Pd.I' }}</div>
                    <div style="font-size: 7.5pt; color: #64748b;">NIP: {{ $ketuaTakmir ? 'TMR-'.str_pad($ketuaTakmir->id, 4, '0', STR_PAD_LEFT) : 'TMR-0001' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="doc-footer">
        Dokumen Surat Keputusan Resmi ini diterbitkan melalui Sistem Informasi Manajemen Masjid (SIMAS).
    </div>

</div>
</body>
</html>
