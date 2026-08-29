<h1>Detail Inventaris</h1>
<table>
    <tr>
        <th>ID Inventaris</th>
        <td>{{ $inventaris->id_inventaris }}</td>
    </tr>
    <tr>
        <th>Nama Barang</th>
        <td>{{ $inventaris->nama_barang }}</td>
    </tr>
    <tr>
        <th>Jumlah</th>
        <td>{{ $inventaris->jumlah }}</td>
    </tr>
    <tr>
        <th>Tahun Pembelian</th>
        <td>{{ $inventaris->tahun_pembelian }}</td>
    </tr>
    <tr>
        <th>Lokasi</th>
        <td>{{ $inventaris->lokasi }}</td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <td>{{ $inventaris->keterangan }}</td>
    </tr>
</table>

<a href="{{ route('inventaris.index') }}" class="btn btn-primary">Kembali</a>
