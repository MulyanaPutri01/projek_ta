<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donatur;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DonaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:donatur-list')->only(['index', 'show']);
        $this->middleware('permission:donatur-create')->only(['create', 'store']);
        $this->middleware('permission:donatur-edit')->only(['edit', 'update']);
        $this->middleware('permission:donatur-delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Donatur::with(['takmir', 'keuangans'])->select('donatur.*');

            if ($request->filled('month')) {
                $query->whereMonth('tanggal', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal', $request->year);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-';
                })
                ->editColumn('nama_donatur', function ($row) {
                    return '<strong>' . e($row->nama_donatur) . '</strong>';
                })
                ->addColumn('nominal_formatted', function ($row) {
                    $total = $row->keuangans->sum('nominal');
                    return $total > 0
                        ? '<span class="text-success fw-bold">Rp ' . number_format($total, 0, ',', '.') . '</span>'
                        : '<span class="text-muted">-</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? e($row->takmir->nama_takmir) : '-';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('donatur.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');
                    $totalNominal = $row->keuangans->sum('nominal');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit" 
                                data-id="' . $row->id . '" 
                                data-nama="' . e($row->nama_donatur) . '" 
                                data-alamat="' . e($row->alamat) . '" 
                                data-nominal="' . $totalNominal . '"
                                data-tanggal="' . ($row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '') . '">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_donatur', 'nominal_formatted', 'action'])
                ->make(true);
        }

        return view('donatur.index');
    }

    public function create()
    {
        return view('donatur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'nama_donatur' => 'required|string|max:100',
            'alamat'       => 'required|string|max:255',
        ]);

        Donatur::create([
            'tanggal'      => $request->input('tanggal'),
            'nama_donatur' => $request->input('nama_donatur'),
            'alamat'       => $request->input('alamat'),
            'takmir_id'    => auth()->id(),
        ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil ditambahkan');
    }

    public function edit($id)
    {
        $donatur = Donatur::findOrFail($id);
        return view('donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'nama_donatur' => 'required|string|max:100',
            'alamat'       => 'required|string|max:255',
        ]);

        $donatur = Donatur::findOrFail($id);
        $donatur->update([
            'tanggal'      => $request->input('tanggal'),
            'nama_donatur' => $request->input('nama_donatur'),
            'alamat'       => $request->input('alamat'),
            'takmir_id'    => auth()->id(),
        ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil diperbarui');
    }

    public function destroy($id)
    {
        $donatur = Donatur::findOrFail($id);
        $donatur->delete();

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil dihapus');
    }
}
