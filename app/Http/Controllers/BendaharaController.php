<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Donatur;
use App\Models\Kategori;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentYear = date('Y');

        // Ringkasan Keuangan Total
        $totalPemasukan = (int) Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = (int) Keuangan::where('kategori_id', 2)->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $countTransaksiMasuk = Keuangan::where('kategori_id', 1)->count();
        $countTransaksiKeluar = Keuangan::where('kategori_id', 2)->count();
        $countDonatur = Donatur::count();

        // 12 Bulan Trend Chart Data
        $months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
        ];

        $transaksiTahunIni = Keuangan::whereYear('tanggal', $currentYear)->get();
        $chartMonths = array_values($months);
        $chartPemasukan = [];
        $chartPengeluaran = [];
        $chartSaldo = [];

        foreach ($months as $num => $label) {
            $masuk = (int) $transaksiTahunIni->filter(function($item) use ($num) {
                return Carbon::parse($item->tanggal)->format('m') === $num && $item->kategori_id == 1;
            })->sum('nominal');

            $keluar = (int) $transaksiTahunIni->filter(function($item) use ($num) {
                return Carbon::parse($item->tanggal)->format('m') === $num && $item->kategori_id == 2;
            })->sum('nominal');

            $chartPemasukan[] = $masuk;
            $chartPengeluaran[] = $keluar;
            $chartSaldo[] = ($masuk - $keluar);
        }

        // Komposisi Sumber Pemasukan
        $topPemasukan = Keuangan::where('kategori_id', 1)
            ->whereYear('tanggal', $currentYear)
            ->get()
            ->groupBy('sumber_keuangan')
            ->map(fn($group) => (int) $group->sum('nominal'))
            ->sortDesc()
            ->take(5);

        $pemasukanLabels = $topPemasukan->keys()->toArray();
        $pemasukanValues = $topPemasukan->values()->toArray();

        // Komposisi Alokasi Pengeluaran
        $topPengeluaran = Keuangan::where('kategori_id', 2)
            ->whereYear('tanggal', $currentYear)
            ->get()
            ->groupBy('sumber_keuangan')
            ->map(fn($group) => (int) $group->sum('nominal'))
            ->sortDesc()
            ->take(5);

        $pengeluaranLabels = $topPengeluaran->keys()->toArray();
        $pengeluaranValues = $topPengeluaran->values()->toArray();

        $keuangan = Keuangan::with(['kategori', 'donatur', 'kegiatan', 'takmir'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('bendahara.dashboard', compact(
            'keuangan',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'countTransaksiMasuk',
            'countTransaksiKeluar',
            'countDonatur',
            'chartMonths',
            'chartPemasukan',
            'chartPengeluaran',
            'chartSaldo',
            'pemasukanLabels',
            'pemasukanValues',
            'pengeluaranLabels',
            'pengeluaranValues',
            'currentYear'
        ));
    }
}
