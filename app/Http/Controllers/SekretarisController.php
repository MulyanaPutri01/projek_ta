<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Inventaris;
use App\Models\Kepanitiaan;
use App\Models\Takmir;
use Carbon\Carbon;

class SekretarisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentYear = date('Y');

        $totalKegiatan    = Kegiatan::count();
        $totalInventaris  = Inventaris::count();
        $totalKepanitiaan = Kepanitiaan::count();
        $totalTakmir      = Takmir::count();

        // 1. 12 Bulan Agenda Kegiatan (Agregasi SQL instan)
        $chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartKegiatan = array_fill(0, 12, 0);

        $kegiatanMonthly = Kegiatan::whereYear('tanggal', $currentYear)
            ->selectRaw("MONTH(tanggal) as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->get();

        foreach ($kegiatanMonthly as $row) {
            $monthIndex = (int) $row->bulan - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $chartKegiatan[$monthIndex] = (int) $row->total;
            }
        }

        // 2. Kondisi Inventaris Breakdown
        $allInventaris = Inventaris::with(['catatans' => function($q) {
            $q->latest('tanggal_catatan')->with('kondisi:id,nama_kondisi');
        }])->get(['id']);

        $kondisiInventaris = ['Baik' => 0, 'Perbaikan' => 0, 'Rusak' => 0];
        foreach ($allInventaris as $item) {
            $latest = $item->catatans->first();
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

        $recentKegiatan = Kegiatan::orderBy('tanggal', 'desc')->take(5)->get();

        return view('sekretaris.dashboard', compact(
            'totalKegiatan',
            'totalInventaris',
            'totalKepanitiaan',
            'totalTakmir',
            'chartMonths',
            'chartKegiatan',
            'kondisiInventaris',
            'recentKegiatan',
            'currentYear'
        ));
    }
}
