<?php

namespace App\Http\Controllers;

use App\Models\Kepanitiaan;
use App\Models\Posisi;
use App\Models\Kegiatan;
use App\Models\Takmir;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KepanitiaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kepanitiaan-list')->only(['index', 'show']);
        $this->middleware('permission:kepanitiaan-manage')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Kepanitiaan::with(['posisi', 'kegiatan', 'takmir'])->select('kepanitiaan.*');

            if ($request->filled('kegiatan_id')) {
                $query->where('kegiatan_id', $request->kegiatan_id);
            }

            if ($request->filled('posisi_id')) {
                $query->where('posisi_id', $request->posisi_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kegiatan_name', function ($row) {
                    return $row->kegiatan ? '<strong>' . e($row->kegiatan->nama_kegiatan) . '</strong>' : '-';
                })
                ->addColumn('posisi_name', function ($row) {
                    return $row->posisi ? '<span class="badge bg-primary">' . e($row->posisi->nama_posisi) . '</span>' : '-';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? e($row->takmir->nama_takmir) : '-';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('kepanitiaan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit" 
                                data-id="' . $row->id . '" 
                                data-kegiatan="' . $row->kegiatan_id . '" 
                                data-posisi="' . $row->posisi_id . '" 
                                data-jobdesk="' . e($row->jobdesk) . '">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['kegiatan_name', 'posisi_name', 'action'])
                ->make(true);
        }

        $kegiatans = Kegiatan::all();
        $posisis = Posisi::all();
        $takmirs = Takmir::all();

        return view('kepanitiaan.index', compact('kegiatans', 'posisis', 'takmirs'));
    }

    public function create()
    {
        return redirect()->route('kepanitiaan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'jobdesk' => 'required|string|max:255',
            'posisi_id' => 'required|exists:posisi,id',
        ]);

        $data = $request->only([
            'kegiatan_id',
            'jobdesk',
            'posisi_id',
        ]);

        $data['takmir_id'] = auth()->id();

        Kepanitiaan::create($data);

        return redirect()->route('kepanitiaan.index')->with('success', 'Kepanitiaan berhasil ditambahkan.');
    }

    public function show(Kepanitiaan $kepanitiaan)
    {
        return redirect()->route('kepanitiaan.index');
    }

    public function edit($id)
    {
        $kepanitiaan = Kepanitiaan::findOrFail($id);
        $kegiatans = Kegiatan::all();
        $posisis = Posisi::all();
        $takmirs = Takmir::all();

        return view('kepanitiaan.index', compact('kepanitiaan', 'kegiatans', 'posisis', 'takmirs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'jobdesk' => 'required|string|max:255',
            'posisi_id' => 'required|exists:posisi,id',
        ]);

        $kepanitiaan = Kepanitiaan::findOrFail($id);

        $kepanitiaan->update([
            'kegiatan_id' => $request->kegiatan_id,
            'jobdesk' => $request->jobdesk,
            'posisi_id' => $request->posisi_id,
            'takmir_id' => auth()->id(),
        ]);

        return redirect()->route('kepanitiaan.index')->with('success', 'Kepanitiaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kepanitiaan = Kepanitiaan::findOrFail($id);
        $kepanitiaan->delete();

        return redirect()->route('kepanitiaan.index')->with('success', 'Kepanitiaan berhasil dihapus.');
    }
}
