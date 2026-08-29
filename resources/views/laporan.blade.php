@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan Keuangan</h1>

    <form action="{{ route('keuangan.laporan') }}" method="GET">
        <div class="form-group">
            <label for="periode">Periode:</label>
            <select name="periode" id="periode" class="form-control">
                <option value="tahun">Tahun</option>
                <option value="bulan">Bulan</option>
                <option value="tanggal">Tanggal</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="text" name="tahun" id="tahun" class="form-control" value="{{ $tahun }}">
        </div>
        <div class="form-group">
            <label for="bulan">Bulan:</label>
            <input type="text" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
        </div>
        <div class="form-group">
            <label for="tanggal_awal">Tanggal Awal:</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $tanggal_awal }}">
        </div>
        <div class="form-group">
            <label for="tanggal_akhir">Tanggal Akhir:</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
    </form>

    <h2>Laporan Pemasukan</h2>
    <p>Total Pemasukan: {{ $pemasukan }}</p>
    <ul>
        @foreach($pemasukanDetail as $detail)
            <li>{{ $detail->tanggal }} - {{ $detail->sumber_keuangan }}: {{ $detail->jumlah }}</li>
        @endforeach
    </ul>

    <h2>Laporan Pengeluaran</h2>
    <p>Total Pengeluaran: {{ $pengeluaran }}</p>
    <ul>
        @foreach($pengeluaranDetail as $detail)
            <li>{{ $detail->tanggal }} - {{ $detail->sumber_keuangan }}: {{ $detail->jumlah }}</li>
        @endforeach
    </ul>

    <h3>Total Saldo: {{ $total_saldo }}</h3>

    <a href="{{ route('keuangan.cetak', ['periode' => $periode, 'tahun' => $tahun, 'bulan' => $bulan, 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]) }}" class="btn btn-danger">Cetak Laporan</a>
    <a href="{{ route('keuangan.exportPdf', ['periode' => $periode, 'tahun' => $tahun, 'bulan' => $bulan, 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]) }}" class="btn btn-success">Ekspor ke PDF</a>

</div>
@endsection
