<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kegiatan-list')->only(['index', 'show']);
        $this->middleware('permission:kegiatan-create')->only(['create', 'store']);
        $this->middleware('permission:kegiatan-edit')->only(['edit', 'update']);
        $this->middleware('permission:kegiatan-delete')->only(['destroy']);
        $this->middleware('permission:kegiatan-calendar')->only(['calendar']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Kegiatan::query();

            if ($request->filled('month')) {
                $query->whereMonth('tanggal', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal', $request->year);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama_kegiatan', function ($row) {
                    return '<strong>' . e($row->nama_kegiatan) . '</strong>';
                })
                ->editColumn('tanggal', function ($row) {
                    return $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-';
                })
                ->addColumn('waktu_acara', function ($row) {
                    $mulai = $row->mulai_kegiatan ? Carbon::parse($row->mulai_kegiatan)->format('H:i') : '-';
                    $akhir = $row->akhir_kegiatan ? Carbon::parse($row->akhir_kegiatan)->format('H:i') : '-';
                    return '<span class="badge bg-secondary">' . $mulai . ' - ' . $akhir . ' WIB</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('kegiatan.edit', $row->id);
                    $deleteUrl = route('kegiatan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus agenda kegiatan ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['nama_kegiatan', 'waktu_acara', 'action'])
                ->make(true);
        }

        return view('kegiatan.index');
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'mulai_kegiatan' => 'required',
            'akhir_kegiatan' => 'required',
            'nama_waktu' => 'nullable|max:50',
            'pembicara' => 'nullable|max:100',
            'nama_khotib' => 'nullable|max:100',
            'nama_muadzin' => 'nullable|max:100',
            'tempat' => 'required|max:100',
            'audience' => 'nullable|max:100',
        ]);

        Kegiatan::create($request->all());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'mulai_kegiatan' => 'required',
            'akhir_kegiatan' => 'required',
            'nama_waktu' => 'nullable|max:50',
            'pembicara' => 'nullable|max:100',
            'nama_khotib' => 'nullable|max:100',
            'nama_muadzin' => 'nullable|max:100',
            'tempat' => 'required|max:100',
            'audience' => 'nullable|max:100',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($request->all());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }

    public function getEvents()
    {
        $kegiatans = Kegiatan::all();
        $events = $kegiatans->map(function ($item) {
            $mulai = $item->mulai_kegiatan ? substr($item->mulai_kegiatan, 0, 5) : '00:00';
            $akhir = $item->akhir_kegiatan ? substr($item->akhir_kegiatan, 0, 5) : '23:59';
            return [
                'id' => $item->id,
                'title' => $item->nama_kegiatan . ($item->tempat ? ' (' . $item->tempat . ')' : ''),
                'start' => $item->tanggal . 'T' . $mulai . ':00',
                'end' => $item->tanggal . 'T' . $akhir . ':00',
            ];
        });
        return response()->json($events);
    }

    public function calendar()
    {
        return view('kegiatan.calendar');
    }
}
