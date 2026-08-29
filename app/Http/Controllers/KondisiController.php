<?php

namespace App\Http\Controllers;

use App\Models\Kondisi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KondisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kondisi-manage');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Kondisi::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_kondisi', function ($row) {
                    return '<strong>' . e($row->nama_kondisi) . '</strong>';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('kondisi.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '" data-nama="' . e($row->nama_kondisi) . '"><i class="bi bi-pencil"></i> Edit</button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_kondisi', 'action'])
                ->make(true);
        }

        return view('kondisi.index');
    }

    public function create()
    {
        return view('kondisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:100',
        ]);

        Kondisi::create([
            'nama_kondisi' => $request->nama_kondisi,
        ]);

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kondisi = Kondisi::findOrFail($id);
        return view('kondisi.edit', compact('kondisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:100',
        ]);

        $kondisi = Kondisi::findOrFail($id);
        $kondisi->update([
            'nama_kondisi' => $request->nama_kondisi,
        ]);

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kondisi = Kondisi::findOrFail($id);
        $kondisi->delete();

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil dihapus');
    }
}
