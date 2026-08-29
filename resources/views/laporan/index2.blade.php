@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center fw-bold">Laporan Keuangan Masjid</h4>
    <form method="GET" action="{{ route('laporan.index') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="number" name="tahun" class="form-control" placeholder="Tahun">
            </div>
            <div class="col-md-3">
                <input type="number" name="bulan" class="form-control" placeholder="Bulan">
            </div>
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" placeholder="Sampai Tanggal">
            </div>
            <div class="col-md-3 mt-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.cetak', request()->all()) }}" class="btn btn-success">Cetak</a>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
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
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSaldo = 0;
            @endphp
            @foreach($keuangan as $key => $item)
                @php
                    $nominal = $item->kategori_id_kategori == 'D' ? $item->nominal : -$item->nominal;
                    $totalSaldo += $nominal;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->sumber_keuangan }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->nominal }}</td>
                    <td>{{ $item->donatur->nama_donatur ?? '-' }}</td>
                    <td>{{ $item->kegiatan->nama_kegiatan ?? '-' }}</td>
                    <td>{{ $item->kategori_id_kategori == 'D' ? $item->nominal : '-' }}</td>
                    <td>{{ $item->kategori_id_kategori == 'K' ? $item->nominal : '-' }}</td>
                    <td>{{ $totalSaldo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
