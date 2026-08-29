<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h4 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        .total-row td {
            font-weight: bold;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h4>Laporan Keuangan Masjid</h4>
    <p><strong>Periode:</strong>
        @if(request()->filled('periode'))
            @switch(request()->periode)
                @case('harian') Harian ({{ \Carbon\Carbon::today()->format('d-m-Y') }}) @break
                @case('bulanan') Bulanan ({{ \Carbon\Carbon::now()->format('F Y') }}) @break
                @case('tahunan') Tahunan ({{ \Carbon\Carbon::now()->year }}) @break
                @case('periode')
                    {{ request()->start_date }} s/d {{ request()->end_date }}
                    @break
                @default Semua Data
            @endswitch
        @else
            Semua Data
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber Keuangan</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Donatur</th>
                <th>Kegiatan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Total Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSaldo = 0; @endphp
            @foreach($keuangan as $item)
                @php
                    $saldo = ($item->kategori_id_kategori === 'D') ? $item->nominal : -$item->nominal;
                    $totalSaldo += $saldo;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->sumber_keuangan }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->donatur->nama_donatur ?? '-' }}</td>
                    <td>{{ $item->kegiatan->nama_kegiatan ?? '-' }}</td>
                    <td>{{ $item->kategori_id_kategori === 'D' ? number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td>{{ $item->kategori_id_kategori === 'K' ? number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td>{{ number_format($totalSaldo, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="9">Total Saldo Akhir</td>
                <td>{{ number_format($totalSaldo, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    </div>
</body>
</html>
