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

        $totalKegiatan = Kegiatan::count();
        $totalInventaris = Inventaris::count();
        $totalKepanitiaan = Kepanitiaan::count();
        $totalTakmir = Takmir::count();

        // 12 Bulan Agenda Kegiatan
        $months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
        ];

        $kegiatanTahunIni = Kegiatan::whereYear('tanggal', $currentYear)->get();
        $chartMonths = array_values($months);
        $chartKegiatan = [];

        foreach ($months as $num => $label) {
            $count = $kegiatanTahunIni->filter(function($item) use ($num) {
                return Carbon::parse($item->tanggal)->format('m') === $num;
            })->count();

            $chartKegiatan[] = $count;
        }

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
