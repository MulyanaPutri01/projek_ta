<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Keuangan Masjid Al-Ikhlas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .table {
                border-collapse: collapse; /* Menghilangkan sekat antar elemen tabel */
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }
            .table th, .table td {
                padding: 1; /* Menghilangkan padding */
                border: 1.5px solid #dee2e6; /* Memberikan garis pada tabel */
                text-align: center;
            }
            .table-bordered {
                border: 1px solid #dee2e6;
            }
            .text-center {
                text-align: center;
            }
            .fw-bold {
                font-weight: bold;
            }
            th.border-bottom {
                border-bottom: 3px solid #dee2e6;
            }
            th.text-start {
            text-align: left;
            }
            th.text-end {
                text-align: right;
            }


        </style>
    </head>
<body>
    <div class="container">
        <h4 class="text-center fw-bold mb-0">RINCIAN KEUANGAN MASJID AL-IKHLAS</h4>
        <h5 class="text-center mb-0">
            DUKUH SEMENDOT PERIODE
            @if($filter === 'tahunan')
                DI TAHUN {{ $tahun }}
            @elseif($filter === 'bulanan')
                DI BULAN {{ strtoupper($bulan) }}
            @elseif($filter === 'periode')
                DI PERIODE {{ strtoupper(\Carbon\Carbon::parse($start)->translatedFormat('d F Y')) }} - {{ strtoupper(\Carbon\Carbon::parse($end)->translatedFormat('d F Y')) }}
            @else
                Semua Data
            @endif
        </h5>

        <table class="table table-bordered">
            <!-- Pemasukan -->
            <thead>
                <tr>
                    <th colspan="8" class="text-start border-bottom">A. Keuangan Pemasukan</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Sumber Keuangan</th>
                    <th>Donatur</th>
                    <th>Kegiatan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Total Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php $pemasukanIndex = 1; @endphp <!-- Inisialisasi variabel untuk pemasukan -->
                @foreach($keuangan as $item)
                    @if($item->kategori_id_kategori == 'K1') <!-- Pemasukan -->
                        <tr>
                            <td>{{ $pemasukanIndex++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->sumber_keuangan }}</td>
                            <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                            <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                            <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}.-</td>
                            <td>-</td>
                            <td></td>

                        </tr>
                    @endif
                @endforeach
            </tbody>

            <!-- Pengeluaran -->
            <thead>
                <tr>
                    <th colspan="8" class="text-start border-bottom">B. Keuangan Pengeluaran</th>
                </tr>
                <!--<tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keperluan</th>
                    <th>Donatur</th>
                    <th>Kegiatan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Total Saldo</th>
                </tr>-->
            </thead>
            <tbody>
                @php $pengeluaranIndex = 1; @endphp <!-- Inisialisasi variabel untuk pengeluaran -->
                @foreach($keuangan as $item)
                    @if($item->kategori_id_kategori == 'K2') <!-- Pengeluaran -->
                        <tr>
                            <td>{{ $pengeluaranIndex++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                            <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                            <td>-</td>
                            <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}.-</td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                <!-- Total Keseluruhan -->
                <tr>
                    <td colspan="5" class="text-center fw-bold">JUMLAH KESELURUHAN</td>
                    <td class="fw-bold">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</td>
                    <td class="fw-bold">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</td>
                    <td class="fw-bold">Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</td>
                </tr>
            </tbody>
        </table>

    <br>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="6" class="text-start"> Saldo Awal</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-start">Total Pemasukan</td>
                    <td>Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-start">Total Pengeluaran</td>
                    <td>Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-start">Saldo Akhir</td>
                    <td>Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</td>
                </tr>
            </tbody>
        </table>

        <p class="text-center fw-bold">Terima Kasih Atas Kerjasama Anda</p>
        <p class="text-center fw-bold">Semoga Allah SWT Meridhoi Setiap Kegiatan Kita</p>
    </div>
</body>
</html>
