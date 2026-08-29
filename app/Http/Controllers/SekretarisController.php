<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Inventaris;
use App\Models\Kepanitiaan;

class SekretarisController extends Controller
{
    public function index()
    {
        $totalKegiatan = Kegiatan::count();
        $totalInventaris = Inventaris::count();
        $totalKepanitiaan = Kepanitiaan::count();
        $recentKegiatan = Kegiatan::orderBy('tanggal', 'desc')->take(5)->get();

        return view('sekretaris.dashboard', compact(
            'totalKegiatan',
            'totalInventaris',
            'totalKepanitiaan',
            'recentKegiatan'
        ));
    }
}
