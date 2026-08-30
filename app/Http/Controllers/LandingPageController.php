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

        $pemasukanBulanIni = Keuangan::where('kategori_id', 1)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        $pengeluaranBulanIni = Keuangan::where('kategori_id', 2)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        $currentYear = Carbon::now()->year;
        $chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($m = 1; $m <= 12; $m++) {
            $chartPemasukan[] = (float) Keuangan::where('kategori_id', 1)
                ->whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $m)
                ->sum('nominal');

            $chartPengeluaran[] = (float) Keuangan::where('kategori_id', 2)
                ->whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $m)
                ->sum('nominal');
        }

        $keuangan = Keuangan::with(['kategori', 'donatur', 'kegiatan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // 3. Agenda Kegiatan (Prioritaskan agenda mendatang)
        $kegiatans = Kegiatan::with(['kepanitiaans.takmir', 'kepanitiaans.posisi'])
            ->orderBy('tanggal', 'asc')
            ->where('tanggal', '>=', now()->toDateString())
            ->take(9)
            ->get();

        if ($kegiatans->isEmpty()) {
            $kegiatans = Kegiatan::with(['kepanitiaans.takmir', 'kepanitiaans.posisi'])
                ->orderBy('tanggal', 'desc')
                ->take(9)
                ->get();
        }

        $featuredKegiatan = $kegiatans->first();

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
            'featuredKegiatan',
            'pengurusList',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'chartMonths',
            'chartPemasukan',
            'chartPengeluaran',
            'currentYear',
            'totalKegiatan',
            'totalInventaris',
            'totalDonatur',
            'totalTakmir',
            'tanggal'
        ));
    }
}

