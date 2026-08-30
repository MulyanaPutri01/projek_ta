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
                    if (!$row->tanggal) return '-';
                    $carbon = Carbon::parse($row->tanggal);
                    return '<div class="text-center"><span class="fw-semibold text-dark">' . $carbon->translatedFormat('d M Y') . '</span><small class="text-muted d-block">' . $carbon->diffForHumans() . '</small></div>';
                })
                ->addColumn('preview_gambar', function ($row) {
                    if ($row->gambar && file_exists(public_path('storage/' . $row->gambar))) {
                        $url = asset('storage/' . $row->gambar);
                        return '
                            <div class="text-center">
                                <a href="' . $url . '" target="_blank" title="Klik untuk memperbesar">
                                    <img src="' . $url . '" alt="' . e($row->nama_foto) . '" class="img-thumbnail rounded-3 shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                                </a>
                            </div>
                        ';
                    }
                    return '<div class="text-center"><span class="badge bg-secondary-subtle text-secondary border">No Image</span></div>';
                })
                ->editColumn('nama_foto', function ($row) {
                    return '<div><span class="fw-bold text-dark fs-6">' . e($row->nama_foto) . '</span></div>';
                })
                ->addColumn('kegiatan_name', function ($row) {
                    if (!$row->kegiatan) return '<span class="text-muted small">Umum / Tidak Terikat</span>';
                    return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fw-semibold"><i class="bi bi-calendar-event me-1"></i>' . e($row->kegiatan->nama_kegiatan) . '</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    if (!$row->takmir) return '<span class="text-muted">-</span>';
                    $initial = strtoupper(substr($row->takmir->nama_takmir, 0, 1));
                    return '
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.8rem; flex-shrink: 0;">
                                ' . $initial . '
                            </div>
                            <span class="fw-semibold text-dark small">' . e($row->takmir->nama_takmir) . '</span>
                        </div>
                    ';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('galeri.edit', $row->id);
                    $deleteUrl = route('galeri.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Foto"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus foto dokumentasi ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Foto"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['preview_gambar', 'nama_foto', 'tanggal', 'kegiatan_name', 'takmir_name', 'action'])
                ->make(true);
        }

        $kegiatans = Kegiatan::all();
        $totalGaleri = Galeri::count();
        $bulanIni = Galeri::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->count();
        $totalKegiatanDoc = Galeri::distinct('kegiatan_id')->whereNotNull('kegiatan_id')->count('kegiatan_id');

        return view('galeri.index', compact('kegiatans', 'totalGaleri', 'bulanIni', 'totalKegiatanDoc'));
    }

    public function create()
    {
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();
        $takmirs = Takmir::all();
        return view('galeri.create', compact('kegiatans', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'nama_foto'   => 'required|string|max:100',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ], [
            'tanggal.required'     => 'Tanggal dokumentasi foto wajib diisi.',
            'nama_foto.required'   => 'Judul atau nama foto dokumentasi wajib diisi.',
            'gambar.required'      => 'File foto dokumentasi wajib dipilih dan diunggah.',
            'gambar.image'         => 'File yang diunggah harus berupa gambar (JPG, PNG, WEBP).',
            'gambar.max'           => 'Ukuran foto maksimal adalah 3 MB.',
            'kegiatan_id.required' => 'Silakan pilih agenda kegiatan terkait.',
        ]);

        $filePath = null;
        if ($request->hasFile('gambar')) {
            $destinationPath = public_path('storage/galeri_masjid');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $filePath = 'galeri_masjid/' . $fileName;
            $request->file('gambar')->move($destinationPath, $fileName);
        }

        Galeri::create([
            'tanggal'     => $request->tanggal,
            'nama_foto'   => $request->nama_foto,
            'gambar'      => $filePath,
            'kegiatan_id' => $request->kegiatan_id,
            'takmir_id'   => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto dokumentasi berhasil disimpan dan dipublikasikan.');
    }

    public function show($id)
    {
        $galeri = Galeri::with(['kegiatan', 'takmir'])->findOrFail($id);
        return view('galeri.show', compact('galeri'));
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();

        return view('galeri.edit', compact('galeri', 'kegiatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'nama_foto'   => 'required|string|max:100',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ], [
            'tanggal.required'     => 'Tanggal dokumentasi foto wajib diisi.',
            'nama_foto.required'   => 'Judul atau nama foto dokumentasi wajib diisi.',
            'gambar.image'         => 'File yang diunggah harus berupa gambar (JPG, PNG, WEBP).',
            'gambar.max'           => 'Ukuran foto maksimal adalah 3 MB.',
            'kegiatan_id.required' => 'Silakan pilih agenda kegiatan terkait.',
        ]);

        $galeri = Galeri::findOrFail($id);
        $filePath = $galeri->gambar;

        if ($request->hasFile('gambar')) {
            if (!empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar))) {
                @unlink(public_path('storage/' . $galeri->gambar));
            }

            $destinationPath = public_path('storage/galeri_masjid');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $filePath = 'galeri_masjid/' . $fileName;
            $request->file('gambar')->move($destinationPath, $fileName);
        }

        $galeri->update([
            'tanggal'     => $request->tanggal,
            'nama_foto'   => $request->nama_foto,
            'gambar'      => $filePath,
            'kegiatan_id' => $request->kegiatan_id,
            'takmir_id'   => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto dokumentasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (!empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar))) {
            @unlink(public_path('storage/' . $galeri->gambar));
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}

