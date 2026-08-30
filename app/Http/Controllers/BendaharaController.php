<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Donatur;
use App\Models\Kategori;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentYear = date('Y');

        // 1. Ringkasan Keuangan Total dalam 1 query agregat efisien
        $stats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran,
            COUNT(CASE WHEN kategori_id = 1 THEN 1 END) as count_masuk,
            COUNT(CASE WHEN kategori_id = 2 THEN 1 END) as count_keluar
        ")->first();

        $totalPemasukan       = (int) ($stats->total_pemasukan ?? 0);
        $totalPengeluaran     = (int) ($stats->total_pengeluaran ?? 0);
        $totalSaldo           = $totalPemasukan - $totalPengeluaran;
        $countTransaksiMasuk  = (int) ($stats->count_masuk ?? 0);
        $countTransaksiKeluar = (int) ($stats->count_keluar ?? 0);
        $countDonatur         = Donatur::count();

        // 2. 12 Bulan Trend Chart Data (Agregasi SQL instan)
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

        // 3. Komposisi Sumber Pemasukan Terbanyak (SQL Group By langsung)
        $topPemasukan = Keuangan::where('kategori_id', 1)
            ->whereYear('tanggal', $currentYear)
            ->selectRaw("sumber_keuangan, SUM(nominal) as total")
            ->groupBy('sumber_keuangan')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'sumber_keuangan');

        $pemasukanLabels = $topPemasukan->keys()->toArray();
        $pemasukanValues = $topPemasukan->values()->map(fn($v) => (int)$v)->toArray();

        // 4. Komposisi Alokasi Pengeluaran Terbanyak (SQL Group By langsung)
        $topPengeluaran = Keuangan::where('kategori_id', 2)
            ->whereYear('tanggal', $currentYear)
            ->selectRaw("sumber_keuangan, SUM(nominal) as total")
            ->groupBy('sumber_keuangan')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'sumber_keuangan');

        $pengeluaranLabels = $topPengeluaran->keys()->toArray();
        $pengeluaranValues = $topPengeluaran->values()->map(fn($v) => (int)$v)->toArray();

        // 5. Transaksi Kas Terbaru dengan Eager Loading
        $keuangan = Keuangan::with(['kategori:id,nama_kategori', 'donatur:id,nama_donatur', 'kegiatan:id,nama_kegiatan', 'takmir:id,nama_takmir'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('bendahara.dashboard', compact(
            'keuangan',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'countTransaksiMasuk',
            'countTransaksiKeluar',
            'countDonatur',
            'chartMonths',
            'chartPemasukan',
            'chartPengeluaran',
            'chartSaldo',
            'pemasukanLabels',
            'pemasukanValues',
            'pengeluaranLabels',
            'pengeluaranValues',
            'currentYear'
        ));
    }
}
