<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Inventaris;
use App\Models\Kondisi;
use App\Models\Takmir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CatatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:catatan-list')->only(['index', 'show']);
        $this->middleware('permission:catatan-create')->only(['create', 'store']);
        $this->middleware('permission:catatan-edit')->only(['edit', 'update']);
        $this->middleware('permission:catatan-delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Catatan::with(['inventaris', 'kondisi', 'takmir'])->select('catatan.*');

            if ($request->filled('kondisi_id')) {
                $query->where('kondisi_id', $request->kondisi_id);
            }

            if ($request->filled('month')) {
                $query->whereMonth('tanggal_catatan', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal_catatan', $request->year);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal_catatan', function ($row) {
                    return $row->tanggal_catatan ? Carbon::parse($row->tanggal_catatan)->format('d-m-Y') : '-';
                })
                ->addColumn('barang_name', function ($row) {
                    return $row->inventaris ? '<strong>' . e($row->inventaris->nama_barang) . '</strong>' : '-';
                })
                ->addColumn('kondisi_name', function ($row) {
                    return $row->kondisi ? '<span class="badge bg-info text-dark">' . e($row->kondisi->nama_kondisi) . '</span>' : '-';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? e($row->takmir->nama_takmir) : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('catatan.edit', $row->id);
                    $deleteUrl = route('catatan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus catatan ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['barang_name', 'kondisi_name', 'action'])
                ->make(true);
        }

        $kondisis = Kondisi::all();
        $totalCatatan = Catatan::count();

        return view('catatan.index', compact('kondisis', 'totalCatatan'));
    }

    public function create()
    {
        $kondisis = Kondisi::all();
        $inventariss = Inventaris::all();
        $takmirs = Takmir::all();
        return view('catatan.create', compact('kondisis', 'inventariss', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventaris_id' => 'required|exists:inventaris,id',
            'tanggal_catatan' => 'required|date',
            'kondisi_id' => 'required|exists:kondisi,id',
        ]);

        $data = $request->only([
            'inventaris_id',
            'tanggal_catatan',
            'kondisi_id',
        ]);
        $data['takmir_id'] = auth()->id();

        Catatan::create($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catatan = Catatan::findOrFail($id);
        $kondisis = Kondisi::all();
        $inventariss = Inventaris::all();
        $takmirs = Takmir::all();

        return view('catatan.edit', compact('catatan', 'kondisis', 'inventariss', 'takmirs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'inventaris_id' => 'required|exists:inventaris,id',
            'tanggal_catatan' => 'required|date',
            'kondisi_id' => 'required|exists:kondisi,id',
        ]);

        $catatan = Catatan::findOrFail($id);
        $data = $request->only([
            'inventaris_id',
            'tanggal_catatan',
            'kondisi_id',
        ]);
        $data['takmir_id'] = auth()->id();

        $catatan->update($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $catatan = Catatan::findOrFail($id);
        $catatan->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
