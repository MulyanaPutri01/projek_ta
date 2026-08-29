@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center fw-bold">LAPORAN KEUANGAN MASJID</h4>

    <form method="GET" action="{{ route('laporan.keuangan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="date" name="tanggal_mulai" class="form-control" placeholder="Tanggal Mulai">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_selesai" class="form-control" placeholder="Tanggal Selesai">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber Keuangan</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Total Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalPengeluaran = 0;
                $saldoAkhir = 0;
            @endphp
            @foreach ($keuangan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->sumber_keuangan }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>Rp{{ $item->kategori_id_kategori === 'D' ? number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td>Rp{{ $item->kategori_id_kategori === 'K' ? number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td>Rp{{ number_format($saldoAkhir += ($item->kategori_id_kategori === 'D' ? $item->nominal : -$item->nominal), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
