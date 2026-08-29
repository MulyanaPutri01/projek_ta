<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Galeri;
use App\Models\ProfilMasjid;
use App\Models\Kegiatan;
use App\Models\Takmir;
use App\Models\Inventaris;
use App\Models\Donatur;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    public function index()
    {
        // 1. Profil Masjid
        $profil = ProfilMasjid::first();

        // 2. Keuangan Stats & Recent Transactions
        $totalPemasukan = Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id', 2)->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $keuangan = Keuangan::with(['kategori', 'donatur', 'kegiatan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 3. Agenda Kegiatan (Prioritaskan agenda mendatang)
        $kegiatans = Kegiatan::orderBy('tanggal', 'asc')
            ->where('tanggal', '>=', now()->toDateString())
            ->take(6)
            ->get();

        if ($kegiatans->isEmpty()) {
            $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->take(6)->get();
        }

        // 4. Galeri Foto Dokumentasi
        $galeri = Galeri::with(['kegiatan', 'takmir'])
            ->orderBy('tanggal', 'desc')
            ->take(8)
            ->get();

        // 5. Struktur Pengurus Takmir Aktif
        $pengurusList = Takmir::with('role')
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->take(6)
            ->get();

        // 6. Ringkasan Statistik Masjid
        $totalKegiatan = Kegiatan::count();
        $totalInventaris = Inventaris::count();
        $totalDonatur = Donatur::count();
        $totalTakmir = Takmir::where('status', 'active')->count();

        // 7. Tanggal Indonesia
        $tanggal = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        return view('landing-page', compact(
            'profil',
            'keuangan',
            'galeri',
            'kegiatans',
            'pengurusList',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'totalKegiatan',
            'totalInventaris',
            'totalDonatur',
            'totalTakmir',
            'tanggal'
        ));
    }
}

