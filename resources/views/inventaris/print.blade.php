@extends('inventaris.print-layout')

@section('title', 'Cetak Data Inventaris')

@section('content')
    <h1>Data Inventaris</h1>
    <table>
        <thead>
            <tr>
                <th>ID Inventaris</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tahun Pembelian</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventariss as $inventaris)
                                <tr>

                                    <td>{{ $inventaris->id_inventaris }}</td>
                                    <td>{{ $inventaris->nama_barang }}</td>
                                    <td>{{ $inventaris->jumlah }}</td>
                                    <td>{{ $inventaris->tahun_pembelian }}</td>
                                    <td>{{ $inventaris->lokasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('inventaris.index') }}" class="no-print">Kembali</a>
@endsection
