<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\ProfilMasjid;
use App\Models\Takmir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan-view')->only(['index', 'datatables']);
        $this->middleware('permission:laporan-print')->only(['cetak', 'pdf']);
    }

    /**
     * Terapkan filter berdasarkan request ke query builder.
     */
    private function applyFilter($query, Request $request): array
    {
        $filter    = $request->input('filter', '');
        $tahun     = null;
        $bulan     = null;
        $namaBulan = null;
        $start     = null;
        $end       = null;

        if ($filter === 'tahunan' && $request->filled('year')) {
            $tahun = $request->input('year');
            $query->whereYear('tanggal', $tahun);
        } elseif ($filter === 'bulanan' && $request->filled('month')) {
            $bulan = $request->input('month');
            $query->whereMonth('tanggal', $bulan);
            if ($request->filled('year')) {
                $tahun = $request->input('year');
                $query->whereYear('tanggal', $tahun);
            }
            $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
        } elseif ($filter === 'periode' && $request->filled('start_date') && $request->filled('end_date')) {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');
            $query->whereBetween('tanggal', [$start, $end]);
        }

        return compact('filter', 'tahun', 'bulan', 'namaBulan', 'start', 'end');
    }

    /**
     * Halaman utama laporan keuangan dengan stat cards & DataTables.
     */
    public function index(Request $request)
    {
        // Hitung summary stats dengan satu query agregat (hindari N+1)
        $statsQuery = Keuangan::query();
        $meta = $this->applyFilter($statsQuery, $request);

        $stats = $statsQuery->selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran,
            COUNT(*) as total_transaksi,
            COUNT(CASE WHEN kategori_id = 1 THEN 1 END) as jumlah_pemasukan,
            COUNT(CASE WHEN kategori_id = 2 THEN 1 END) as jumlah_pengeluaran
        ")->first();

        $totalSaldo = ($stats->total_pemasukan ?? 0) - ($stats->total_pengeluaran ?? 0);

        extract($meta);
        return view('laporan.keuangan', compact(
            'stats', 'totalSaldo', 'filter', 'tahun', 'bulan', 'namaBulan', 'start', 'end'
        ));
    }

    /**
     * DataTables server-side endpoint - bebas N+1 dengan eager loading + select.
     */
    public function datatables(Request $request)
    {
        $query = Keuangan::with([
            'kategori:id,nama_kategori',
            'donatur:id,nama_donatur',
            'kegiatan:id,nama_kegiatan',
            'takmir:id,nama_takmir',
        ])->select('keuangan.*');

        $this->applyFilter($query, $request);
        $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc');

        // Hitung running saldo untuk seluruh dataset yang difilter (satu query)
        $allData = (clone $query)->get(['keuangan.id', 'nominal', 'kategori_id']);
        $runningMap = [];
        $saldo = 0;
        $totalP = 0;
        $totalE = 0;
        foreach ($allData as $row) {
            if ($row->kategori_id == 1) {
                $saldo += $row->nominal;
                $totalP += $row->nominal;
            } else {
                $saldo -= $row->nominal;
                $totalE += $row->nominal;
            }
            $runningMap[$row->id] = $saldo;
        }

        $summary = [
            'total_pemasukan'  => number_format($totalP, 0, ',', '.'),
            'total_pengeluaran'=> number_format($totalE, 0, ',', '.'),
            'saldo'            => number_format($totalP - $totalE, 0, ',', '.'),
        ];

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('tanggal', fn($row) => \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y'))
            ->addColumn('jenis_badge', function ($row) {
                if ($row->kategori_id == 1) {
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small fw-semibold">
                                <i class="bi bi-arrow-up-circle-fill me-1"></i>Pemasukan
                            </span>';
                }
                return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill small fw-semibold">
                            <i class="bi bi-arrow-down-circle-fill me-1"></i>Pengeluaran
                        </span>';
            })
            ->addColumn('keterangan_display', function ($row) {
                $text = $row->kategori_id == 1 ? $row->sumber_keuangan : $row->keterangan;
                return '<span class="fw-semibold">' . e($text) . '</span>';
            })
            ->addColumn('donatur_display', function ($row) {
                if ($row->donatur) {
                    return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 small">'
                        . e($row->donatur->nama_donatur) . '</span>';
                }
                return '<span class="text-muted">—</span>';
            })
            ->addColumn('kegiatan_display', function ($row) {
                if ($row->kegiatan) {
                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 small">'
                        . e($row->kegiatan->nama_kegiatan) . '</span>';
                }
                return '<span class="text-muted">—</span>';
            })
            ->addColumn('nominal_pemasukan', function ($row) {
                if ($row->kategori_id == 1) {
                    return '<span class="text-success fw-bold">Rp&nbsp;' . number_format($row->nominal, 0, ',', '.') . '</span>';
                }
                return '<span class="text-muted">—</span>';
            })
            ->addColumn('nominal_pengeluaran', function ($row) {
                if ($row->kategori_id == 2) {
                    return '<span class="text-danger fw-bold">Rp&nbsp;' . number_format($row->nominal, 0, ',', '.') . '</span>';
                }
                return '<span class="text-muted">—</span>';
            })
            ->addColumn('saldo_berjalan', function ($row) use ($runningMap) {
                $s = $runningMap[$row->id] ?? 0;
                $color = $s >= 0 ? 'text-primary' : 'text-danger';
                return '<span class="fw-bold ' . $color . '">Rp&nbsp;' . number_format($s, 0, ',', '.') . '</span>';
            })
            ->filterColumn('keterangan_display', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('sumber_keuangan', 'like', "%{$keyword}%")
                      ->orWhere('keterangan', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['jenis_badge', 'keterangan_display', 'donatur_display', 'kegiatan_display', 'nominal_pemasukan', 'nominal_pengeluaran', 'saldo_berjalan'])
            ->with('summary', $summary)
            ->make(true);
    }

    /**
     * Cetak laporan (tampilan browser-print).
     */
    public function cetak(Request $request)
    {
        $query = Keuangan::with([
            'kategori:id,nama_kategori',
            'donatur:id,nama_donatur',
            'kegiatan:id,nama_kegiatan',
        ])->orderBy('tanggal', 'asc')->orderBy('id', 'asc');

        $meta = $this->applyFilter($query, $request);
        $keuangan = $query->get();

        $totalPemasukan   = $keuangan->where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = $keuangan->where('kategori_id', 2)->sum('nominal');
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        $runningBalance = 0;
        foreach ($keuangan as $row) {
            if ($row->kategori_id == 1) {
                $runningBalance += $row->nominal;
            } else {
                $runningBalance -= $row->nominal;
            }
            $row->saldo_berjalan = $runningBalance;
        }

        $profil = ProfilMasjid::first();
        $ketuaTakmir = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%ketua%')->orWhere('nama_role', 'like', '%admin%');
        })->first() ?? Takmir::first();

        $bendahara = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%bendahara%');
        })->first() ?? Takmir::skip(1)->first() ?? $ketuaTakmir;

        extract($meta);
        return view('keuangan.cetak', compact(
            'keuangan', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo',
            'filter', 'tahun', 'bulan', 'namaBulan', 'start', 'end',
            'profil', 'ketuaTakmir', 'bendahara'
        ));
    }

    /**
     * Export laporan ke PDF.
     */
    public function pdf(Request $request)
    {
        $query = Keuangan::with([
            'kategori:id,nama_kategori',
            'donatur:id,nama_donatur',
            'kegiatan:id,nama_kegiatan',
        ])->orderBy('tanggal', 'asc')->orderBy('id', 'asc');

        $meta = $this->applyFilter($query, $request);
        $keuangan = $query->get();

        $totalPemasukan   = $keuangan->where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = $keuangan->where('kategori_id', 2)->sum('nominal');
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        $runningBalance = 0;
        foreach ($keuangan as $row) {
            if ($row->kategori_id == 1) {
                $runningBalance += $row->nominal;
            } else {
                $runningBalance -= $row->nominal;
            }
            $row->saldo_berjalan = $runningBalance;
        }

        $profil = ProfilMasjid::first();
        $ketuaTakmir = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%ketua%')->orWhere('nama_role', 'like', '%admin%');
        })->first() ?? Takmir::first();

        $bendahara = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%bendahara%');
        })->first() ?? Takmir::skip(1)->first() ?? $ketuaTakmir;

        // Hitung statistik tambahan
        $countPemasukan = $keuangan->where('kategori_id', 1)->count();
        $countPengeluaran = $keuangan->where('kategori_id', 2)->count();

        extract($meta);

        $paper = strtolower($request->get('paper', 'a4'));
        $orientation = strtolower($request->get('orientation', 'landscape'));

        if (!in_array($orientation, ['portrait', 'landscape'])) {
            $orientation = 'landscape';
        }

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'keuangan', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo',
            'filter', 'tahun', 'bulan', 'namaBulan', 'start', 'end',
            'profil', 'ketuaTakmir', 'bendahara', 'countPemasukan', 'countPengeluaran',
            'paper', 'orientation'
        ));

        if ($paper === 'f4' || $paper === 'folio') {
            // Standar F4 / Folio Indonesia: 215mm x 330mm = 609.45pt x 935.43pt
            $pdf->setPaper([0, 0, 609.45, 935.43], $orientation);
        } else {
            $pdf->setPaper('a4', $orientation);
        }

        $namaFile = 'Laporan_Keuangan_' . ($profil->nama_masjid ? str_replace(' ', '_', $profil->nama_masjid) : 'Masjid') . '_' . $paper . '_' . $orientation . '_' . date('Ymd_His') . '.pdf';

        return $pdf->stream($namaFile);
    }
}
