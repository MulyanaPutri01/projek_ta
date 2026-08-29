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
                    if (!$row->tanggal_catatan) return '-';
                    $carbon = Carbon::parse($row->tanggal_catatan);
                    return '<div class="text-center"><span class="fw-semibold text-dark">' . $carbon->translatedFormat('d M Y') . '</span><small class="text-muted d-block">' . $carbon->diffForHumans() . '</small></div>';
                })
                ->addColumn('barang_name', function ($row) {
                    if (!$row->inventaris) return '<span class="text-muted">-</span>';
                    $lokasi = $row->inventaris->lokasi ? '<small class="text-muted d-block"><i class="bi bi-geo-alt me-1 text-danger"></i>' . e($row->inventaris->lokasi) . '</small>' : '';
                    return '<div><span class="fw-bold text-dark">' . e($row->inventaris->nama_barang) . '</span>' . $lokasi . '</div>';
                })
                ->addColumn('kondisi_name', function ($row) {
                    if (!$row->kondisi) return '-';
                    $namaKondisi = strtolower($row->kondisi->nama_kondisi);
                    
                    if (str_contains($namaKondisi, 'baik') || str_contains($namaKondisi, 'bagus') || str_contains($namaKondisi, 'normal')) {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1"><i class="bi bi-check-circle-fill me-1"></i>' . e($row->kondisi->nama_kondisi) . '</span>';
                    } elseif (str_contains($namaKondisi, 'rusak')) {
                        return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1"><i class="bi bi-x-circle-fill me-1"></i>' . e($row->kondisi->nama_kondisi) . '</span>';
                    } elseif (str_contains($namaKondisi, 'perbaikan') || str_contains($namaKondisi, 'servis') || str_contains($namaKondisi, 'kurang')) {
                        return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1"><i class="bi bi-wrench me-1"></i>' . e($row->kondisi->nama_kondisi) . '</span>';
                    }
                    return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1">' . e($row->kondisi->nama_kondisi) . '</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    if (!$row->takmir) return '<span class="text-muted">-</span>';
                    $initial = strtoupper(substr($row->takmir->nama_takmir, 0, 1));
                    return '
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.8rem; flex-shrink: 0;">
                                ' . $initial . '
                            </div>
                            <span class="fw-semibold text-dark small">' . e($row->takmir->nama_takmir) . '</span>
                        </div>
                    ';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('catatan.edit', $row->id);
                    $deleteUrl = route('catatan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Catatan"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus catatan kondisi ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Catatan"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['tanggal_catatan', 'barang_name', 'kondisi_name', 'takmir_name', 'action'])
                ->make(true);
        }

        $kondisis = Kondisi::all();
        $totalCatatan = Catatan::count();
        $bulanIni = Catatan::whereMonth('tanggal_catatan', Carbon::now()->month)->whereYear('tanggal_catatan', Carbon::now()->year)->count();
        $kondisiBaikId = Kondisi::where('nama_kondisi', 'like', '%baik%')->pluck('id');
        $totalBaik = Catatan::whereIn('kondisi_id', $kondisiBaikId)->count();

        return view('catatan.index', compact('kondisis', 'totalCatatan', 'bulanIni', 'totalBaik'));
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
            'inventaris_id'   => 'required|exists:inventaris,id',
            'tanggal_catatan' => 'required|date',
            'kondisi_id'      => 'required|exists:kondisi,id',
        ], [
            'inventaris_id.required'   => 'Silakan pilih barang inventaris yang diinspeksi.',
            'tanggal_catatan.required' => 'Tanggal pencatatan inspeksi wajib diisi.',
            'kondisi_id.required'      => 'Status kondisi barang wajib dipilih.',
        ]);

        $data = $request->only([
            'inventaris_id',
            'tanggal_catatan',
            'kondisi_id',
        ]);
        $data['takmir_id'] = auth()->id();

        Catatan::create($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan kondisi barang berhasil disimpan.');
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
            'inventaris_id'   => 'required|exists:inventaris,id',
            'tanggal_catatan' => 'required|date',
            'kondisi_id'      => 'required|exists:kondisi,id',
        ], [
            'inventaris_id.required'   => 'Silakan pilih barang inventaris yang diinspeksi.',
            'tanggal_catatan.required' => 'Tanggal pencatatan inspeksi wajib diisi.',
            'kondisi_id.required'      => 'Status kondisi barang wajib dipilih.',
        ]);

        $catatan = Catatan::findOrFail($id);
        $data = $request->only([
            'inventaris_id',
            'tanggal_catatan',
            'kondisi_id',
        ]);

        $catatan->update($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan kondisi barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $catatan = Catatan::findOrFail($id);
        $catatan->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan kondisi barang berhasil dihapus.');
    }
}

