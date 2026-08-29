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
            $query = Keuangan::with(['kategori', 'donatur', 'kegiatan', 'takmir'])->select('keuangan.*');

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
                })
                ->rawColumns(['nominal_pemasukan', 'nominal_pengeluaran', 'donatur_name', 'kegiatan_name', 'takmir_name', 'action'])
                ->make(true);
        }

        // Summary cards calculation
        $today = now()->format('Y-m-d');
        $thisYear = now()->format('Y');

        $pemasukanHariIni = Keuangan::where('kategori_id', 1)->whereDate('tanggal', $today)->sum('nominal');
        $pemasukanBulanIni = Keuangan::where('kategori_id', 1)->whereYear('tanggal', now()->year)->whereMonth('tanggal', now()->month)->sum('nominal');
        $pemasukanTahunIni = Keuangan::where('kategori_id', 1)->whereYear('tanggal', $thisYear)->sum('nominal');

        $pengeluaranHariIni = Keuangan::where('kategori_id', 2)->whereDate('tanggal', $today)->sum('nominal');
        $pengeluaranBulanIni = Keuangan::where('kategori_id', 2)->whereYear('tanggal', now()->year)->whereMonth('tanggal', now()->month)->sum('nominal');
        $pengeluaranTahunIni = Keuangan::where('kategori_id', 2)->whereYear('tanggal', $thisYear)->sum('nominal');

        $totalPemasukan = Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id', 2)->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

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
        
        $totalPemasukan   = Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id', 2)->sum('nominal');
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
        $kategoris = Kategori::all();
        $donaturs = Donatur::orderBy('nama_donatur', 'asc')->get();
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();

        $totalPemasukan   = Keuangan::where('kategori_id', 1)->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id', 2)->sum('nominal');
        $totalSaldo       = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.edit', compact('keuangan', 'kategoris', 'donaturs', 'kegiatans', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }

    public function update(Request $request, $id)
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

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Keuangan berhasil dihapus.');
    }
}
