<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donatur;
use App\Models\Keuangan;
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
                    return $row->tanggal ? Carbon::parse($row->tanggal)->translatedFormat('d M Y') : '-';
                })
                ->editColumn('nama_donatur', function ($row) {
                    $sub = [];
                    if ($row->telepon) {
                        $sub[] = '<i class="bi bi-telephone text-success me-1"></i>' . e($row->telepon);
                    }
                    if ($row->alamat) {
                        $sub[] = '<i class="bi bi-geo-alt text-danger me-1"></i>' . e($row->alamat);
                    }
                    $subText = !empty($sub) ? '<div class="small text-muted mt-0.5">' . implode(' &bull; ', $sub) . '</div>' : '';
                    return '<div class="fw-bold text-dark fs-6">' . e($row->nama_donatur) . '</div>' . $subText;
                })
                ->addColumn('nominal_formatted', function ($row) {
                    $total = $row->keuangans->sum('nominal');
                    return $total > 0
                        ? '<span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2.5 py-1 fs-6 fw-bold">Rp ' . number_format($total, 0, ',', '.') . '</span>'
                        : '<span class="badge bg-light text-secondary border px-2 py-1">Rp 0</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    return $row->takmir ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle"><i class="bi bi-person me-1"></i>' . e($row->takmir->nama_takmir) . '</span>' : '<span class="text-muted">-</span>';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('donatur.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');
                    $totalNominal = $row->keuangans->sum('nominal');

                    $isOwnerOrAdmin = (auth()->user()?->hasRole('admin') || $row->takmir_id == auth()->id());

                    if ($isOwnerOrAdmin) {
                        return '
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-warning btn-sm btn-edit shadow-sm" 
                                    data-id="' . $row->id . '" 
                                    data-nama="' . e($row->nama_donatur) . '" 
                                    data-alamat="' . e($row->alamat) . '" 
                                    data-telepon="' . e($row->telepon ?? '') . '" 
                                    data-nominal="' . $totalNominal . '"
                                    data-tanggal="' . ($row->tanggal ? Carbon::parse($row->tanggal)->format('Y-m-d') : '') . '">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data donatur ini?\')">
                                    ' . $csrf . '
                                    ' . $deleteMethod . '
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        ';
                    }

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-secondary btn-sm shadow-sm opacity-50" disabled title="Hanya pencatat (' . e($row->takmir->nama_takmir ?? 'Pencatat Asli') . ') yang dapat mengedit/menghapus">
                                <i class="bi bi-lock-fill"></i> Terkunci
                            </button>
                        </div>
                    ';
                })
                ->filterColumn('nama_donatur', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('nama_donatur', 'like', "%{$keyword}%")
                          ->orWhere('alamat', 'like', "%{$keyword}%")
                          ->orWhere('telepon', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('takmir_name', function ($query, $keyword) {
                    $query->whereHas('takmir', function ($q) use ($keyword) {
                        $q->where('nama_takmir', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['nama_donatur', 'nominal_formatted', 'takmir_name', 'action'])
                ->make(true);
        }

        $totalDonatur = Donatur::count();
        $totalInfaqDonatur = Keuangan::whereNotNull('donatur_id')->where('kategori_id', 1)->sum('nominal');
        $donaturBulanIni = Donatur::whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count();

        return view('donatur.index', compact('totalDonatur', 'totalInfaqDonatur', 'donaturBulanIni'));
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
            'telepon'      => 'nullable|string|max:25',
        ], [
            'tanggal.required'      => 'Tanggal pencatatan donatur wajib diisi.',
            'nama_donatur.required' => 'Nama donatur wajib diisi.',
            'alamat.required'       => 'Alamat donatur wajib diisi.',
        ]);

        Donatur::create([
            'tanggal'      => $request->input('tanggal'),
            'nama_donatur' => $request->input('nama_donatur'),
            'alamat'       => $request->input('alamat'),
            'telepon'      => $request->input('telepon'),
            'takmir_id'    => auth()->id(),
        ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $donatur = Donatur::findOrFail($id);

        if ($donatur->takmir_id && $donatur->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('donatur.index')->with('error', 'Akses ditolak: Anda hanya dapat mengubah data donatur yang Anda daftarkan sendiri.');
        }

        return view('donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $id)
    {
        $donatur = Donatur::findOrFail($id);

        if ($donatur->takmir_id && $donatur->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('donatur.index')->with('error', 'Akses ditolak: Anda hanya dapat mengubah data donatur yang Anda daftarkan sendiri.');
        }

        $request->validate([
            'tanggal'      => 'required|date',
            'nama_donatur' => 'required|string|max:100',
            'alamat'       => 'required|string|max:255',
            'telepon'      => 'nullable|string|max:25',
        ], [
            'tanggal.required'      => 'Tanggal pencatatan donatur wajib diisi.',
            'nama_donatur.required' => 'Nama donatur wajib diisi.',
            'alamat.required'       => 'Alamat donatur wajib diisi.',
        ]);

        $donatur->update([
            'tanggal'      => $request->input('tanggal'),
            'nama_donatur' => $request->input('nama_donatur'),
            'alamat'       => $request->input('alamat'),
            'telepon'      => $request->input('telepon'),
            'takmir_id'    => $donatur->takmir_id ?: auth()->id(),
        ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $donatur = Donatur::findOrFail($id);

        if ($donatur->takmir_id && $donatur->takmir_id != auth()->id() && !auth()->user()?->hasRole('admin')) {
            return redirect()->route('donatur.index')->with('error', 'Akses ditolak: Anda hanya dapat menghapus data donatur yang Anda daftarkan sendiri.');
        }

        $donatur->delete();

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil dihapus.');
    }
}
