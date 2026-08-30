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

        // 1. Ringkasan Keuangan Total dalam 1 query agregat
        $keuanganStats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran
        ")->first();

        $totalPemasukan   = (int) ($keuanganStats->total_pemasukan ?? 0);
        $totalPengeluaran = (int) ($keuanganStats->total_pengeluaran ?? 0);
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        // 2. Stat Counter
        $countTakmir     = Takmir::count();
        $countDonatur    = Donatur::count();
        $countKegiatan   = Kegiatan::count();
        $countInventaris = Inventaris::count();
        $countUser       = User::count();

        // 3. 12 Bulan Trend Chart Data (Agregasi SQL instan)
        $chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartPemasukan = array_fill(0, 12, 0);
        $chartPengeluaran = array_fill(0, 12, 0);
        $chartSaldo = array_fill(0, 12, 0);

        $monthlyTotals = Keuangan::selectRaw("MONTH(tanggal) as bulan, kategori_id, SUM(nominal) as total")
            ->whereYear('tanggal', $currentYear)
            ->groupBy('bulan', 'kategori_id')
            ->get();

        foreach ($monthlyTotals as $row) {
            $monthIndex = (int) $row->bulan - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                if ($row->kategori_id == 1) {
                    $chartPemasukan[$monthIndex] = (int) $row->total;
                } elseif ($row->kategori_id == 2) {
                    $chartPengeluaran[$monthIndex] = (int) $row->total;
                }
            }
        }

        for ($i = 0; $i < 12; $i++) {
            $chartSaldo[$i] = $chartPemasukan[$i] - $chartPengeluaran[$i];
        }

        // 4. Komposisi Pengeluaran Terbanyak (SQL Group By langsung)
        $topPengeluaran = Keuangan::where('kategori_id', 2)
            ->whereYear('tanggal', $currentYear)
            ->selectRaw("sumber_keuangan, SUM(nominal) as total")
            ->groupBy('sumber_keuangan')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'sumber_keuangan');

        $pengeluaranLabels = $topPengeluaran->keys()->toArray();
        $pengeluaranValues = $topPengeluaran->values()->map(fn($v) => (int)$v)->toArray();

        // 5. Kondisi Inventaris Breakdown
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

        // 6. Transaksi Terbaru dengan Eager Loading
        $keuangan = Keuangan::with(['kategori:id,nama_kategori', 'donatur:id,nama_donatur', 'kegiatan:id,nama_kegiatan', 'takmir:id,nama_takmir'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
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
