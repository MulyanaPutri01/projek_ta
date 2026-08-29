<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris Barang Masjid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 7px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Inventaris Masjid Al-Ikhlas</h2>
    <p class="subtitle">Desa Karangmulya, Kec. Suradadi, Kab. Tegal</p>

    <div class="summary">
        Total Jenis Barang: {{ $totalInventaris }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Barang</th>
                <th style="width: 50px;">Jumlah</th>
                <th style="width: 60px;">Tahun</th>
                <th>Lokasi</th>
                <th>Kondisi Terakhir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inventariss as $key => $item)
                @php
                    $latestCatatan = $item->catatans->sortByDesc('tanggal_catatan')->first();
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-center">{{ $item->tahun_pembelian }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td class="text-center">
                        @if($latestCatatan && $latestCatatan->kondisi)
                            {{ $latestCatatan->kondisi->nama_kondisi }}
                        @else
                            Baik
                        @endif
                    </td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data inventaris.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
