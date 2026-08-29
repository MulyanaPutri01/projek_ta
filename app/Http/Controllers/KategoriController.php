<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kategori-list')->only(['index']);
        $this->middleware('permission:kategori-manage')->only(['store', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Kategori::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_kategori', function ($row) {
                    return '<strong>' . e($row->nama_kategori) . '</strong>';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('kategori.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '" data-nama="' . e($row->nama_kategori) . '"><i class="bi bi-pencil"></i> Edit</button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_kategori', 'action'])
                ->make(true);
        }

        return view('kategori.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
