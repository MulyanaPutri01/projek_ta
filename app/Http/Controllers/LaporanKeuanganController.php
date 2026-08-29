<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', ''); // Ambil nilai filter (tahunan, bulanan, periode).

        $tahun = null; // Default nilai tahun
        $bulan = null; // Default nilai bulan
        $namaBulan = null; // Tambahkan variabel untuk nama bulan
        $start = null; // Default nilai start_date
        $end = null;

        if ($filter === 'tahunan') {
            $tahun = $request->input('year');
            $keuangan = Keuangan::whereYear('tanggal', $tahun)->get();
        } elseif ($filter === 'bulanan') {
            $bulan = $request->input('month');
            $keuangan = Keuangan::whereMonth('tanggal', $bulan)->get();
            $namaBulan = \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
        } elseif ($filter === 'periode' && $request->has(['start_date', 'end_date'])) {
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            $keuangan = Keuangan::whereBetween('tanggal', [$start, $end])->get();
        } else {
            // Jika tidak ada filter, tampilkan semua data.
            $keuangan = Keuangan::all();
        }

        // Hitung total pemasukan, pengeluaran, dan saldo
        $totalPemasukan = $keuangan->where('kategori_id_kategori', 'K1')->sum('nominal');
        $totalPengeluaran = $keuangan->where('kategori_id_kategori', 'K2')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        return view('laporan.keuangan', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 'filter', 'tahun', 'bulan', 'namaBulan', 'start', 'end'));
    }


    public function pdf(Request $request)
    {
        $filter = $request->input('filter', ''); // Ambil nilai filter (tahunan, bulanan, periode).

        $tahun = null; // Default nilai tahun
        $bulan = null; // Default nilai bulan
        $start = null; // Default nilai start_date
        $end = null;

        if ($filter === 'tahunan') {
            $tahun = $request->input('year');
            $keuangan = Keuangan::whereYear('tanggal', $tahun)->get();
        } elseif ($filter === 'bulanan') {
            $bulan = $request->input('month');
            $keuangan = Keuangan::whereMonth('tanggal', $bulan)->get();
        } elseif ($filter === 'periode' && $request->has(['start_date', 'end_date'])) {
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            $keuangan = Keuangan::whereBetween('tanggal', [$start, $end])->get();
        } else {
            // Jika tidak ada filter, tampilkan semua data.
            $keuangan = Keuangan::all();
        }

        // Hitung total pemasukan, pengeluaran, dan saldo
        $totalPemasukan = $keuangan->where('kategori_id_kategori', 'K1')->sum('nominal');
        $totalPengeluaran = $keuangan->where('kategori_id_kategori', 'K2')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $pdf = \PDF::loadView('laporan.pdf', compact('keuangan', 'totalPemasukan',
        'totalPengeluaran', 'totalSaldo', 'filter','tahun', 'bulan', 'start','end'));
        return $pdf->download('laporan_keuangan.pdf');
    }
}
