<?php

namespace App\Http\Controllers;

use App\Models\Posisi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PosisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:posisi-manage');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Posisi::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_posisi', function ($row) {
                    return '<strong>' . e($row->nama_posisi) . '</strong>';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('posisi.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '" data-nama="' . e($row->nama_posisi) . '"><i class="bi bi-pencil"></i> Edit</button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_posisi', 'action'])
                ->make(true);
        }

        return view('posisi.index');
    }

    public function create()
    {
        return view('posisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posisi' => 'required|string|max:100',
        ]);

        Posisi::create([
            'nama_posisi' => $request->nama_posisi,
        ]);

        return redirect()->route('posisi.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $posisi = Posisi::findOrFail($id);
        return view('posisi.edit', compact('posisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_posisi' => 'required|string|max:100',
        ]);

        $posisi = Posisi::findOrFail($id);
        $posisi->update([
            'nama_posisi' => $request->nama_posisi,
        ]);

        return redirect()->route('posisi.index')->with('success', 'Posisi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $posisi = Posisi::findOrFail($id);

        // Cegah hapus jika posisi masih digunakan oleh anggota kepanitiaan
        if ($posisi->kepanitiaans()->exists()) {
            return redirect()->route('posisi.index')
                ->with('error', 'Posisi tidak dapat dihapus karena masih digunakan pada data kepanitiaan.');
        }

        $posisi->delete();

        return redirect()->route('posisi.index')->with('success', 'Posisi berhasil dihapus');
    }
}
