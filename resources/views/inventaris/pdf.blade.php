<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris</title>
</head>
<body>
    <h1>Laporan Inventaris</h1>
    <p>Total Inventaris: {{ $totalInventaris }}</p>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Catatan Terbaru</th>
                <th>Keterangan</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventariss as $key => $inventaris)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $inventaris->nama_barang }}</td>
                    <td>
                        @if($inventaris->catatans->isNotEmpty())
                            {{ $inventaris->catatans->first()->tanggal_catatan }}
                        @else
                            Tidak Ada Catatan
                        @endif
                    </td>
                    <td>
                        @if($inventaris->catatans->isNotEmpty())
                            {{ $inventaris->catatans->first()->keterangan }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($inventaris->kondisis)
                            {{ $inventaris->kondisis->first()->nama_kondisi }}
                        @else
                            Tidak Ada Kondisi
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
