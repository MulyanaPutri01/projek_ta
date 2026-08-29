<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalPemasukan = Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id', 2)->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $keuangan = Keuangan::with(['kategori', 'donatur', 'kegiatan', 'takmir'])->orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.dashboard', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }
}
