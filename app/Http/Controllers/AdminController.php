<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Takmir;
use App\Models\Donatur;
use App\Models\Kegiatan;
use App\Models\Inventaris;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
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

        // Stat Counter
        $countTakmir = Takmir::count();
        $countDonatur = Donatur::count();
        $countKegiatan = Kegiatan::count();
        $countInventaris = Inventaris::count();
        $countUser = User::count();

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

        // Komposisi Pengeluaran Terbanyak
        $topPengeluaran = Keuangan::where('kategori_id', 2)
            ->whereYear('tanggal', $currentYear)
            ->get()
            ->groupBy('sumber_keuangan')
            ->map(fn($group) => (int) $group->sum('nominal'))
            ->sortDesc()
            ->take(5);

        $pengeluaranLabels = $topPengeluaran->keys()->toArray();
        $pengeluaranValues = $topPengeluaran->values()->toArray();

        // Kondisi Inventaris Breakdown
        $allInventaris = Inventaris::with('catatans.kondisi')->get();
        $kondisiInventaris = ['Baik' => 0, 'Perbaikan' => 0, 'Rusak' => 0];
        foreach ($allInventaris as $item) {
            $latest = $item->catatans->sortByDesc('tanggal_catatan')->first();
            $kName = $latest && $latest->kondisi ? $latest->kondisi->nama_kondisi : 'Baik';
            $kLower = strtolower($kName);
            if (str_contains($kLower, 'rusak')) {
                $kondisiInventaris['Rusak']++;
            } elseif (str_contains($kLower, 'perbaikan') || str_contains($kLower, 'kurang') || str_contains($kLower, 'servis')) {
                $kondisiInventaris['Perbaikan']++;
            } else {
                $kondisiInventaris['Baik']++;
            }
        }

        $keuangan = Keuangan::with(['kategori', 'donatur', 'kegiatan', 'takmir'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.dashboard', compact(
            'keuangan',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'countTakmir',
            'countDonatur',
            'countKegiatan',
            'countInventaris',
            'countUser',
            'chartMonths',
            'chartPemasukan',
            'chartPengeluaran',
            'chartSaldo',
            'pengeluaranLabels',
            'pengeluaranValues',
            'kondisiInventaris',
            'currentYear'
        ));
    }
}
