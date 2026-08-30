<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donatur;
use App\Models\Takmir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class KeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:keuangan-list')->only(['index', 'show']);
        $this->middleware('permission:keuangan-create')->only(['create', 'store']);
        $this->middleware('permission:keuangan-edit')->only(['edit', 'update']);
        $this->middleware('permission:keuangan-delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Keuangan::with([
                'kategori:id,nama_kategori',
                'donatur:id,nama_donatur',
                'kegiatan:id,nama_kegiatan',
                'takmir:id,nama_takmir'
            ])->select('keuangan.*')->orderBy('tanggal', 'asc');

            // dd($query);
            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }

            if ($request->filled('month')) {
                $query->whereMonth('tanggal', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal', $request->year);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return $row->tanggal ? Carbon::parse($row->tanggal)->translatedFormat('d F Y') : '-';
                })
                ->addColumn('nominal_pemasukan', function ($row) {
                    return $row->kategori_id == 1 ? '<span class="text-success fw-bold">Rp' . number_format($row->nominal, 0, ',', '.') . '</span>' : '-';
                })
                ->addColumn('nominal_pengeluaran', function ($row) {
                    return $row->kategori_id == 2 ? '<span class="text-danger fw-bold">Rp' . number_format($row->nominal, 0, ',', '.') . '</span>' : '-';
                })
                ->addColumn('donatur_name', function ($row) {
                    return $row->donatur ? '<span class="badge bg-success-subtle text-success-emphasis border border-success-subtle"><i class="bi bi-person-heart me-1"></i>' . e($row->donatur->nama_donatur) . '</span>' : '<span class="badge bg-light text-secondary border">Hamba Allah</span>';
                })
                ->addColumn('kegiatan_name', function ($row) {
                    return $row->kegiatan ? '<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle"><i class="bi bi-calendar-check me-1"></i>' . e($row->kegiatan->nama_kegiatan) . '</span>' : '<span class="text-muted">—</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? '<span class="text-dark small"><i class="bi bi-person-circle me-1 text-muted"></i>' . e($row->takmir->nama_takmir) . '</span>' : '<span class="text-muted">—</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('keuangan.edit', $row->id);
                    $deleteUrl = route('keuangan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    $isOwnerOrAdmin = (auth()->user()?->hasRole('admin') || $row->takmir_id == auth()->id());

                    if ($isOwnerOrAdmin) {
                        return '
                            <div class="d-flex justify-content-center gap-1">
                                <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Transaksi"><i class="bi bi-pencil"></i></a>
                                <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus transaksi ini?\')">
                                    ' . $csrf . '
                                    ' . $deleteMethod . '
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Transaksi"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        ';
                    }

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-secondary btn-sm shadow-sm opacity-50" disabled title="Hanya pencatat (' . e($row->takmir->nama_takmir ?? 'Pencatat Asli') . ') yang dapat mengedit/menghapus">
                                <i class="bi bi-lock-fill"></i>
                            </button>
                        </div>
                    ';
                })
                ->filterColumn('donatur_name', function ($query, $keyword) {
                    $query->whereHas('donatur', function ($q) use ($keyword) {
                        $q->where('nama_donatur', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('kegiatan_name', function ($query, $keyword) {
                    $query->whereHas('kegiatan', function ($q) use ($keyword) {
                        $q->where('nama_kegiatan', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['nominal_pemasukan', 'nominal_pengeluaran', 'donatur_name', 'kegiatan_name', 'takmir_name', 'action'])
                ->make(true);
        }

        // Summary cards calculation: 1 single SQL conditional aggregation (8 queries -> 1 query)
        $today = now()->toDateString();
        $thisMonth = (int) now()->month;
        $thisYear = (int) now()->year;

        $summary = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran,
            SUM(CASE WHEN kategori_id = 1 AND tanggal = ? THEN nominal ELSE 0 END) as pemasukan_hari_ini,
            SUM(CASE WHEN kategori_id = 2 AND tanggal = ? THEN nominal ELSE 0 END) as pengeluaran_hari_ini,
            SUM(CASE WHEN kategori_id = 1 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pemasukan_bulan_ini,
            SUM(CASE WHEN kategori_id = 2 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pengeluaran_bulan_ini,
            SUM(CASE WHEN kategori_id = 1 AND YEAR(tanggal) = ? THEN nominal ELSE 0 END) as pemasukan_tahun_ini,
            SUM(CASE WHEN kategori_id = 2 AND YEAR(tanggal) = ? THEN nominal ELSE 0 END) as pengeluaran_tahun_ini
        ", [$today, $today, $thisYear, $thisMonth, $thisYear, $thisMonth, $thisYear, $thisYear])->first();

        $totalPemasukan      = (float) ($summary->total_pemasukan ?? 0);
        $totalPengeluaran    = (float) ($summary->total_pengeluaran ?? 0);
        $totalSaldo          = $totalPemasukan - $totalPengeluaran;
        $pemasukanHariIni    = (float) ($summary->pemasukan_hari_ini ?? 0);
        $pengeluaranHariIni  = (float) ($summary->pengeluaran_hari_ini ?? 0);
        $pemasukanBulanIni   = (float) ($summary->pemasukan_bulan_ini ?? 0);
        $pengeluaranBulanIni = (float) ($summary->pengeluaran_bulan_ini ?? 0);
        $pemasukanTahunIni   = (float) ($summary->pemasukan_tahun_ini ?? 0);
        $pengeluaranTahunIni = (float) ($summary->pengeluaran_tahun_ini ?? 0);

        $kategoris = Kategori::all();

        return view('keuangan.index', compact(
            'kategoris',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'pemasukanTahunIni',
            'pengeluaranHariIni',
            'pengeluaranBulanIni',
            'pengeluaranTahunIni'
        ));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $donaturs = Donatur::orderBy('nama_donatur', 'asc')->get();
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();

        $stats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran
        ")->first();

        $totalPemasukan   = (float) ($stats->total_pemasukan ?? 0);
        $totalPengeluaran = (float) ($stats->total_pengeluaran ?? 0);
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.create', compact('kategoris', 'donaturs', 'kegiatans', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'         => 'required|date',
            'sumber_keuangan' => 'required|string|max:255',
            'keterangan'      => 'nullable|string|max:255',
            'nominal'         => 'required|numeric|min:1',
            'kategori_id'     => 'required|exists:kategori,id',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'kegiatan_id'     => 'nullable|exists:kegiatan,id',
        ], [
            'tanggal.required'         => 'Tanggal transaksi wajib diisi.',
            'sumber_keuangan.required' => 'Nama transaksi / sumber dana wajib diisi.',
            'nominal.required'         => 'Nominal transaksi wajib diisi.',
            'nominal.min'              => 'Nominal minimal Rp 1.',
            'kategori_id.required'     => 'Jenis kategori transaksi wajib dipilih.',
        ]);

        $data = $request->all();
        $data['takmir_id']   = auth()->id() ?? 1;
        $data['keterangan']  = $request->keterangan ?: $request->sumber_keuangan;
        $data['donatur_id']  = $request->donatur_id ?: null;
        $data['kegiatan_id'] = $request->kegiatan_id ?: null;

        Keuangan::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil dicatat ke sistem.');
    }

    public function show(Keuangan $keuangan)
    {
        return view('keuangan.show', compact('keuangan'));
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        if ($keuangan->takmir_id && $keuangan->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('keuangan.index')->with('error', 'Akses ditolak: Anda hanya dapat mengubah transaksi kas yang Anda catat sendiri.');
        }

        $kategoris = Kategori::all();
        $donaturs = Donatur::orderBy('nama_donatur', 'asc')->get();
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();

        $stats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran
        ")->first();

        $totalPemasukan   = (float) ($stats->total_pemasukan ?? 0);
        $totalPengeluaran = (float) ($stats->total_pengeluaran ?? 0);
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.edit', compact('keuangan', 'kategoris', 'donaturs', 'kegiatans', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::findOrFail($id);

        if ($keuangan->takmir_id && $keuangan->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('keuangan.index')->with('error', 'Akses ditolak: Anda hanya dapat mengubah transaksi kas yang Anda catat sendiri.');
        }

        $request->validate([
            'tanggal'         => 'required|date',
            'sumber_keuangan' => 'required|string|max:255',
            'keterangan'      => 'nullable|string|max:255',
            'nominal'         => 'required|numeric|min:1',
            'kategori_id'     => 'required|exists:kategori,id',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'kegiatan_id'     => 'nullable|exists:kegiatan,id',
        ], [
            'tanggal.required'         => 'Tanggal transaksi wajib diisi.',
            'sumber_keuangan.required' => 'Nama transaksi / sumber dana wajib diisi.',
            'nominal.required'         => 'Nominal transaksi wajib diisi.',
            'kategori_id.required'     => 'Jenis kategori transaksi wajib dipilih.',
        ]);

        $data = $request->all();
        $data['takmir_id']   = $keuangan->takmir_id ?: auth()->id();
        $data['keterangan']  = $request->keterangan ?: $request->sumber_keuangan;
        $data['donatur_id']  = $request->donatur_id ?: null;
        $data['kegiatan_id'] = $request->kegiatan_id ?: null;

        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        if ($keuangan->takmir_id && $keuangan->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('keuangan.index')->with('error', 'Akses ditolak: Anda hanya dapat menghapus transaksi kas yang Anda catat sendiri.');
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}
