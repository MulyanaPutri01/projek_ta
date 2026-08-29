<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .btn-print { margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Laporan Keuangan</h1>
    <h2>Pemasukan</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Sumber Keuangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasukanDetail as $detail)
                <tr>
                    <td>{{ $detail->tanggal }}</td>
                    <td>{{ $detail->sumber_keuangan }}</td>
                    <td>{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Pengeluaran</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Sumber Keuangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengeluaranDetail as $detail)
                <tr>
                    <td>{{ $detail->tanggal }}</td>
                    <td>{{ $detail->sumber_keuangan }}</td>
                    <td>{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Saldo: {{ $total_saldo }}</h3>

    <script type="text/javascript">
        window.print();
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>
</html>
