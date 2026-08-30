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
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // 1. Profil Masjid Tunggal
        $profil = ProfilMasjid::first();

        // 2. Keuangan Stats: Dihitung dalam 1 query agregasi SQL efisien (bebas N+1)
        $keuanganStats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran,
            SUM(CASE WHEN kategori_id = 1 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pemasukan_bulan_ini,
            SUM(CASE WHEN kategori_id = 2 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pengeluaran_bulan_ini
        ", [$currentYear, $currentMonth, $currentYear, $currentMonth])->first();

        $totalPemasukan      = (float) ($keuanganStats->total_pemasukan ?? 0);
        $totalPengeluaran    = (float) ($keuanganStats->total_pengeluaran ?? 0);
        $totalSaldo          = $totalPemasukan - $totalPengeluaran;
        $pemasukanBulanIni   = (float) ($keuanganStats->pemasukan_bulan_ini ?? 0);
        $pengeluaranBulanIni = (float) ($keuanganStats->pengeluaran_bulan_ini ?? 0);

        // 3. 12 Bulan Trend Chart: Ditarik dalam 1 query tunggal (menggantikan 24 query loop sebelumnya)
        $chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartPemasukan = array_fill(0, 12, 0.0);
        $chartPengeluaran = array_fill(0, 12, 0.0);

        $monthlyTotals = Keuangan::selectRaw("MONTH(tanggal) as bulan, kategori_id, SUM(nominal) as total")
            ->whereYear('tanggal', $currentYear)
            ->groupBy('bulan', 'kategori_id')
            ->get();

        foreach ($monthlyTotals as $row) {
            $monthIndex = (int) $row->bulan - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                if ($row->kategori_id == 1) {
                    $chartPemasukan[$monthIndex] = (float) $row->total;
                } elseif ($row->kategori_id == 2) {
                    $chartPengeluaran[$monthIndex] = (float) $row->total;
                }
            }
        }

        // 4. Transaksi Terkini (6 item) dengan Eager Loading
        $keuangan = Keuangan::with(['kategori:id,nama_kategori', 'donatur:id,nama_donatur', 'kegiatan:id,nama_kegiatan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // 5. Agenda Kegiatan (Prioritaskan agenda mendatang)
        $kegiatans = Kegiatan::with(['kepanitiaans.takmir:id,nama_takmir', 'kepanitiaans.posisi:id,nama_posisi'])
            ->orderBy('tanggal', 'asc')
            ->where('tanggal', '>=', now()->toDateString())
            ->take(9)
            ->get();

        if ($kegiatans->isEmpty()) {
            $kegiatans = Kegiatan::with(['kepanitiaans.takmir:id,nama_takmir', 'kepanitiaans.posisi:id,nama_posisi'])
                ->orderBy('tanggal', 'desc')
                ->take(9)
                ->get();
        }

        $featuredKegiatan = $kegiatans->first();

        // 6. Galeri Foto Dokumentasi (8 item terbaru)
        $galeri = Galeri::with(['kegiatan:id,nama_kegiatan', 'takmir:id,nama_takmir'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        // 7. Struktur Pengurus Takmir Aktif
        $pengurusList = Takmir::with('role:id,nama_role')
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->take(6)
            ->get();

        // 8. Ringkasan Statistik Masjid
        $totalKegiatan   = Kegiatan::count();
        $totalInventaris = Inventaris::count();
        $totalDonatur    = Donatur::count();
        $totalTakmir     = Takmir::where('status', 'active')->count();

        // 9. Tanggal Format Indonesia
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
