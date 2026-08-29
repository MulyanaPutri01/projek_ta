<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\Takmir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:galeri-list')->only(['index', 'show']);
        $this->middleware('permission:galeri-create')->only(['create', 'store']);
        $this->middleware('permission:galeri-edit')->only(['edit', 'update']);
        $this->middleware('permission:galeri-delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Galeri::with(['kegiatan', 'takmir'])->select('galeri.*');

            if ($request->filled('kegiatan_id')) {
                $query->where('kegiatan_id', $request->kegiatan_id);
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
                    return $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-';
                })
                ->addColumn('preview_gambar', function ($row) {
                    if ($row->gambar && file_exists(public_path('storage/' . $row->gambar))) {
                        return '<img src="' . asset('storage/' . $row->gambar) . '" alt="' . e($row->nama_foto) . '" class="img-thumbnail" style="max-height: 55px; border-radius: 6px;">';
                    }
                    return '<span class="badge bg-secondary">Tidak ada foto</span>';
                })
                ->editColumn('nama_foto', function ($row) {
                    return '<strong>' . e($row->nama_foto) . '</strong>';
                })
                ->addColumn('kegiatan_name', function ($row) {
                    return $row->kegiatan ? e($row->kegiatan->nama_kegiatan) : '-';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? e($row->takmir->nama_takmir) : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('galeri.edit', $row->id);
                    $deleteUrl = route('galeri.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus foto ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['preview_gambar', 'nama_foto', 'action'])
                ->make(true);
        }

        $kegiatans = Kegiatan::all();
        $totalGaleri = Galeri::count();

        return view('galeri.index', compact('kegiatans', 'totalGaleri'));
    }

    public function create()
    {
        $kegiatans = Kegiatan::all();
        $takmirs = Takmir::all();
        return view('galeri.create', compact('kegiatans', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_foto' => 'required|max:100',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ]);

        $filePath = null;
        if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $filePath = 'galeri_masjid/' . $fileName;
            $request->file('gambar')->move(public_path('storage/galeri_masjid'), $fileName);
        }

        Galeri::create([
            'tanggal' => $request->tanggal,
            'nama_foto' => $request->nama_foto,
            'gambar' => $filePath,
            'kegiatan_id' => $request->kegiatan_id,
            'takmir_id' => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function show($id)
    {
        $galeri = Galeri::with(['kegiatan', 'takmir'])->findOrFail($id);
        return view('galeri.show', compact('galeri'));
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $kegiatans = Kegiatan::all();

        return view('galeri.edit', compact('galeri', 'kegiatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_foto' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ]);

        $galeri = Galeri::findOrFail($id);
        $filePath = $galeri->gambar;

        if ($request->hasFile('gambar')) {
            if (!empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar))) {
                @unlink(public_path('storage/' . $galeri->gambar));
            }

            $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $filePath = 'galeri_masjid/' . $fileName;
            $request->file('gambar')->move(public_path('storage/galeri_masjid'), $fileName);
        }

        $galeri->update([
            'tanggal' => $request->tanggal,
            'nama_foto' => $request->nama_foto,
            'gambar' => $filePath,
            'kegiatan_id' => $request->kegiatan_id,
            'takmir_id' => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Data foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (!empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar))) {
            @unlink(public_path('storage/' . $galeri->gambar));
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Foto berhasil dihapus.');
    }
}
