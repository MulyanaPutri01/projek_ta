{{-- resources/views/inventaris/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Inventaris</title>
</head>
<body>
    <h1>Laporan Data Inventaris</h1>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tahun Pembelian</th>
                <th>Lokasi</th>
                <th>Tanggal Catatan</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventariss as $index => $inventaris)
                @foreach ($inventaris->catatans as $catatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $inventaris->nama_barang }}</td>
                        <td>{{ $inventaris->tahun_pembelian }}</td>
                        <td>{{ $inventaris->lokasi }}</td>
                        <td>{{ $catatan->tanggal_catatan }}</td>
                        <td>{{ $catatan->kondisi->nama_kondisi }}</td>
                        <td>{{ $catatan->keterangan }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <p>Total Data Inventaris: {{ $totalInventaris }}</p>
</body>
</html>
