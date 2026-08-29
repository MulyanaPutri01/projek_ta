<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donatur;
use App\Models\Takmir;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // Hitung total pemasukan, pengeluaran, dan saldo dari seluruh data tanpa pagination.
        $totalPemasukan = Keuangan::where('kategori_id_kategori', 'K1')->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id_kategori', 'K2')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Ambil data keuangan dengan pagination
        $keuangan = Keuangan::with(['donatur', 'kegiatan', 'takmir'])->paginate(3);
        return view('admin.dashboard', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));

    }
}
