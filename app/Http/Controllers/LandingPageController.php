<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Galeri;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    public function index()
    {
        // Hitung total pemasukan, pengeluaran, dan saldo
        $totalPemasukan = Keuangan::where('kategori_id_kategori', 'D')->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id_kategori', 'K')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Ambil 5 data terbaru
        $keuangan = Keuangan::latest('tanggal')->take(5)->get();
        $galeri = Galeri::all();
        $tanggal = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
        return view('landing-page', compact('keuangan', 'galeri', 'tanggal','totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }
}
