<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Catatan;
use App\Models\Kondisi;
use Yajra\DataTables\Facades\DataTables;

class InventarisController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inventaris-list')->only(['index', 'show']);
        $this->middleware('permission:inventaris-create')->only(['create', 'store']);
        $this->middleware('permission:inventaris-edit')->only(['edit', 'update']);
        $this->middleware('permission:inventaris-delete')->only(['destroy']);
        $this->middleware('permission:inventaris-pdf')->only(['exportPdf']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Inventaris::with(['catatans.kondisi'])->select('inventaris.*');

            if ($request->filled('lokasi')) {
                $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
            }

            if ($request->filled('tahun')) {
                $query->where('tahun_pembelian', $request->tahun);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_barang', function ($row) {
                    $kode = '<small class="text-muted d-block"><i class="bi bi-upc-scan me-1"></i>INV-' . str_pad($row->id, 4, '0', STR_PAD_LEFT) . '</small>';
                    return '<div><span class="fw-bold text-dark">' . e($row->nama_barang) . '</span>' . $kode . '</div>';
                })
                ->editColumn('jumlah', function ($row) {
                    return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fw-bold">' . $row->jumlah . ' Unit</span>';
                })
                ->editColumn('tahun_pembelian', function ($row) {
                    return '<span class="badge bg-light text-dark border">' . $row->tahun_pembelian . '</span>';
                })
                ->editColumn('lokasi', function ($row) {
                    return '<div><i class="bi bi-geo-alt-fill text-danger me-1"></i><span class="fw-semibold text-dark">' . e($row->lokasi) . '</span></div>';
                })
                ->addColumn('kondisi_terakhir', function ($row) {
                    $latest = $row->catatans->sortByDesc('tanggal_catatan')->first();
                    if ($latest && $latest->kondisi) {
                        $kondisiName = strtolower($latest->kondisi->nama_kondisi);
                        if (str_contains($kondisiName, 'baik') || str_contains($kondisiName, 'bagus') || str_contains($kondisiName, 'normal')) {
                            return '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>' . e($latest->kondisi->nama_kondisi) . '</span>';
                        } elseif (str_contains($kondisiName, 'rusak')) {
                            return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-exclamation-triangle me-1"></i>' . e($latest->kondisi->nama_kondisi) . '</span>';
                        }
                        return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">' . e($latest->kondisi->nama_kondisi) . '</span>';
                    }
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i> Baik / Siap Pakai</span>';
                })
                ->editColumn('keterangan', function ($row) {
                    return $row->keterangan ? '<small class="text-muted">' . e($row->keterangan) . '</small>' : '<span class="text-muted small">-</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('inventaris.edit', $row->id);
                    $deleteUrl = route('inventaris.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Barang"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus data barang inventaris ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Barang"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_barang', 'jumlah', 'tahun_pembelian', 'lokasi', 'kondisi_terakhir', 'keterangan', 'action'])
                ->make(true);
        }

        $totalJenis = Inventaris::count();
        $totalUnit = Inventaris::sum('jumlah');
        $lokasiList = Inventaris::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');

        return view('inventaris.index', compact('totalJenis', 'totalUnit', 'lokasiList'));
    }

    public function show($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.show', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'     => 'required|string|max:100',
            'jumlah'          => 'required|integer|min:1',
            'tahun_pembelian' => 'required|integer|digits:4|min:1900|max:' . (date('Y') + 1),
            'lokasi'          => 'required|string|max:100',
            'keterangan'      => 'nullable|string|max:255',
        ], [
            'nama_barang.required'     => 'Nama barang inventaris wajib diisi.',
            'jumlah.required'          => 'Jumlah atau unit barang wajib diisi minimal 1.',
            'jumlah.min'               => 'Jumlah barang minimal 1 unit.',
            'tahun_pembelian.required' => 'Tahun pembelian / perolehan barang wajib diisi.',
            'tahun_pembelian.digits'   => 'Tahun pembelian harus berupa 4 digit angka (contoh: 2024).',
            'lokasi.required'          => 'Lokasi penyimpanan barang wajib ditentukan.',
        ]);

        Inventaris::create($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'     => 'required|string|max:100',
            'jumlah'          => 'required|integer|min:1',
            'tahun_pembelian' => 'required|integer|digits:4|min:1900|max:' . (date('Y') + 1),
            'lokasi'          => 'required|string|max:100',
            'keterangan'      => 'nullable|string|max:255',
        ], [
            'nama_barang.required'     => 'Nama barang inventaris wajib diisi.',
            'jumlah.required'          => 'Jumlah atau unit barang wajib diisi minimal 1.',
            'jumlah.min'               => 'Jumlah barang minimal 1 unit.',
            'tahun_pembelian.required' => 'Tahun pembelian / perolehan barang wajib diisi.',
            'tahun_pembelian.digits'   => 'Tahun pembelian harus berupa 4 digit angka (contoh: 2024).',
            'lokasi.required'          => 'Lokasi penyimpanan barang wajib ditentukan.',
        ]);

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Data barang inventaris berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Inventaris::with(['catatans.kondisi']);

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_pembelian', $request->tahun);
        }

        $inventariss = $query->get();
        $totalJenis = $inventariss->count();
        $totalUnit = $inventariss->sum('jumlah');

        $profil = \App\Models\ProfilMasjid::first();
        $ketuaTakmir = \App\Models\Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%ketua%')->orWhere('nama_role', 'like', '%admin%');
        })->first() ?? \App\Models\Takmir::first();

        $sekretaris = \App\Models\Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%sekretaris%');
        })->first() ?? \App\Models\Takmir::skip(1)->first() ?? $ketuaTakmir;

        $paper = strtolower($request->get('paper', 'a4'));
        $orientation = strtolower($request->get('orientation', 'landscape'));

        if (!in_array($orientation, ['portrait', 'landscape'])) {
            $orientation = 'landscape';
        }

        $pdf = Pdf::loadView('inventaris.pdf', compact(
            'inventariss', 'totalJenis', 'totalUnit', 'profil', 'ketuaTakmir', 'sekretaris',
            'paper', 'orientation'
        ));

        if ($paper === 'f4' || $paper === 'folio') {
            // Standar F4 / Folio Indonesia: 215mm x 330mm = 609.45pt x 935.43pt
            $pdf->setPaper([0, 0, 609.45, 935.43], $orientation);
        } else {
            $pdf->setPaper('a4', $orientation);
        }

        $namaFile = 'Laporan_Inventaris_' . ($profil->nama_masjid ? str_replace(' ', '_', $profil->nama_masjid) : 'Masjid') . '_' . $paper . '_' . $orientation . '_' . date('Ymd_His') . '.pdf';

        return $pdf->stream($namaFile);
    }
}

