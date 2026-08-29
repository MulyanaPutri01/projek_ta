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
                    return '<strong>' . e($row->nama_barang) . '</strong>';
                })
                ->addColumn('kondisi_terakhir', function ($row) {
                    $latest = $row->catatans->sortByDesc('tanggal_catatan')->first();
                    if ($latest && $latest->kondisi) {
                        return '<span class="badge bg-info text-dark">' . e($latest->kondisi->nama_kondisi) . '</span>';
                    }
                    return '<span class="badge bg-success">Baik</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('inventaris.edit', $row->id);
                    $deleteUrl = route('inventaris.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus barang ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_barang', 'kondisi_terakhir', 'action'])
                ->make(true);
        }

        $totalInventaris = Inventaris::count();
        return view('inventaris.index', compact('totalInventaris'));
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
            'nama_barang' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'tahun_pembelian' => 'required|integer|digits:4',
            'lokasi' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Inventaris::create($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'tahun_pembelian' => 'required|integer|digits:4',
            'lokasi' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil dihapus.');
    }

    public function exportPdf()
    {
        $inventariss = Inventaris::with(['catatans.kondisi'])->get();
        $totalInventaris = $inventariss->count();

        $pdf = Pdf::loadView('inventaris.pdf', compact('inventariss', 'totalInventaris'));

        return $pdf->stream('inventaris.pdf');
    }
}
