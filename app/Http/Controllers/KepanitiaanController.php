<?php

namespace App\Http\Controllers;

use App\Models\Kepanitiaan;
use App\Models\Posisi;
use App\Models\Kegiatan;
use App\Models\Takmir;
use App\Models\ProfilMasjid;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KepanitiaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kepanitiaan-list')->only(['index', 'show', 'skPdf']);
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
                    return $row->kegiatan ? '<span class="fw-semibold text-dark"><i class="bi bi-calendar-event me-1 text-primary"></i>' . e($row->kegiatan->nama_kegiatan) . '</span>' : '-';
                })
                ->addColumn('posisi_name', function ($row) {
                    if (!$row->posisi) return '-';
                    $namaPosisi = strtolower($row->posisi->nama_posisi);
                    $badgeClass = 'bg-primary-subtle text-primary border border-primary-subtle';
                    if (str_contains($namaPosisi, 'ketua')) {
                        $badgeClass = 'bg-success-subtle text-success border border-success-subtle fw-bold';
                    } elseif (str_contains($namaPosisi, 'sekretaris')) {
                        $badgeClass = 'bg-info-subtle text-info border border-info-subtle fw-semibold';
                    } elseif (str_contains($namaPosisi, 'bendahara')) {
                        $badgeClass = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-semibold';
                    }
                    return '<span class="badge ' . $badgeClass . '"><i class="bi bi-person-badge me-1"></i>' . e($row->posisi->nama_posisi) . '</span>';
                })
                ->addColumn('takmir_name', function ($row) {
                    if ($row->takmir) {
                        return '<div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                ' . strtoupper(substr($row->takmir->nama_takmir, 0, 1)) . '
                            </div>
                            <span class="fw-semibold text-dark">' . e($row->takmir->nama_takmir) . '</span>
                        </div>';
                    }
                    return '<span class="badge bg-light text-secondary border">Belum Ditentukan</span>';
                })
                ->addColumn('jobdesk', function ($row) {
                    return '<span class="text-secondary small">' . e($row->jobdesk) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('kepanitiaan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-warning btn-sm shadow-sm btn-edit" 
                                data-id="' . $row->id . '" 
                                data-kegiatan="' . $row->kegiatan_id . '" 
                                data-posisi="' . $row->posisi_id . '" 
                                data-takmir="' . $row->takmir_id . '"
                                data-jobdesk="' . e($row->jobdesk) . '"
                                title="Edit Panitia">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus anggota panitia ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Panitia"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['kegiatan_name', 'posisi_name', 'takmir_name', 'jobdesk', 'action'])
                ->make(true);
        }

        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();
        $posisis   = Posisi::all();
        $takmirs   = Takmir::all();

        // Selected active event for Visual Organigram view
        $selectedKegiatanId = $request->input('kegiatan_id', $kegiatans->first()?->id);
        $selectedKegiatan   = $selectedKegiatanId ? Kegiatan::find($selectedKegiatanId) : null;

        // Committee members of the selected event
        $panitiaList = $selectedKegiatanId
            ? Kepanitiaan::with(['posisi', 'takmir'])->where('kegiatan_id', $selectedKegiatanId)->get()
            : collect([]);

        // Group into Core Leadership vs Operational Sections
        $pimpinanInti = $panitiaList->filter(function($p) {
            $nama = strtolower($p->posisi?->nama_posisi ?? '');
            return str_contains($nama, 'ketua') || str_contains($nama, 'wakil') || str_contains($nama, 'sekretaris') || str_contains($nama, 'bendahara');
        })->sortBy(function($p) {
            $nama = strtolower($p->posisi?->nama_posisi ?? '');
            if (str_contains($nama, 'ketua') && !str_contains($nama, 'wakil')) return 1;
            if (str_contains($nama, 'wakil')) return 2;
            if (str_contains($nama, 'sekretaris')) return 3;
            if (str_contains($nama, 'bendahara')) return 4;
            return 5;
        });

        $seksiSeksi = $panitiaList->reject(function($p) use ($pimpinanInti) {
            return $pimpinanInti->contains('id', $p->id);
        })->groupBy('posisi_id');

        $totalPanitiaSemua = Kepanitiaan::count();
        $totalKegiatanAktif = $kegiatans->count();

        return view('kepanitiaan.index', compact(
            'kegiatans', 'posisis', 'takmirs', 
            'selectedKegiatanId', 'selectedKegiatan', 
            'panitiaList', 'pimpinanInti', 'seksiSeksi',
            'totalPanitiaSemua', 'totalKegiatanAktif'
        ));
    }

    public function create()
    {
        return redirect()->route('kepanitiaan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'posisi_id'   => 'required|exists:posisi,id',
            'takmir_id'   => 'nullable|exists:takmir,id',
            'jobdesk'     => 'required|string|max:255',
        ], [
            'kegiatan_id.required' => 'Silakan pilih agenda kegiatan masjid.',
            'posisi_id.required'   => 'Silakan tentukan posisi kepanitiaan.',
            'jobdesk.required'     => 'Uraian tugas / jobdesk wajib diisi.',
        ]);

        $data = $request->only([
            'kegiatan_id',
            'posisi_id',
            'jobdesk',
        ]);

        $data['takmir_id'] = $request->takmir_id ?: auth()->id();

        Kepanitiaan::create($data);

        return redirect()->route('kepanitiaan.index', ['kegiatan_id' => $request->kegiatan_id])
            ->with('success', 'Anggota panitia kegiatan berhasil ditambahkan ke susunan organisasi.');
    }

    public function show(Kepanitiaan $kepanitiaan)
    {
        return redirect()->route('kepanitiaan.index', ['kegiatan_id' => $kepanitiaan->kegiatan_id]);
    }

    public function edit($id)
    {
        $kepanitiaan = Kepanitiaan::findOrFail($id);
        return redirect()->route('kepanitiaan.index', ['kegiatan_id' => $kepanitiaan->kegiatan_id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'posisi_id'   => 'required|exists:posisi,id',
            'takmir_id'   => 'nullable|exists:takmir,id',
            'jobdesk'     => 'required|string|max:255',
        ], [
            'kegiatan_id.required' => 'Silakan pilih agenda kegiatan masjid.',
            'posisi_id.required'   => 'Silakan tentukan posisi kepanitiaan.',
            'jobdesk.required'     => 'Uraian tugas / jobdesk wajib diisi.',
        ]);

        $kepanitiaan = Kepanitiaan::findOrFail($id);

        $kepanitiaan->update([
            'kegiatan_id' => $request->kegiatan_id,
            'posisi_id'   => $request->posisi_id,
            'takmir_id'   => $request->takmir_id ?: $kepanitiaan->takmir_id,
            'jobdesk'     => $request->jobdesk,
        ]);

        return redirect()->route('kepanitiaan.index', ['kegiatan_id' => $request->kegiatan_id])
            ->with('success', 'Data kepanitiaan kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kepanitiaan = Kepanitiaan::findOrFail($id);
        $kegiatanId = $kepanitiaan->kegiatan_id;
        $kepanitiaan->delete();

        return redirect()->route('kepanitiaan.index', ['kegiatan_id' => $kegiatanId])
            ->with('success', 'Anggota panitia berhasil dihapus dari susunan organisasi.');
    }

    /**
     * Cetak Surat Keputusan (SK) Susunan Panitia Kegiatan ke PDF
     */
    public function skPdf(Request $request, $kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);
        $profil = ProfilMasjid::first();
        
        $ketuaTakmir = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'like', '%ketua%')->orWhere('nama_role', 'like', '%admin%');
        })->first() ?? Takmir::first();

        $panitiaList = Kepanitiaan::with(['posisi', 'takmir'])
            ->where('kegiatan_id', $kegiatan_id)
            ->get();

        $pimpinanInti = $panitiaList->filter(function($p) {
            $nama = strtolower($p->posisi?->nama_posisi ?? '');
            return str_contains($nama, 'ketua') || str_contains($nama, 'wakil') || str_contains($nama, 'sekretaris') || str_contains($nama, 'bendahara');
        })->sortBy(function($p) {
            $nama = strtolower($p->posisi?->nama_posisi ?? '');
            if (str_contains($nama, 'ketua') && !str_contains($nama, 'wakil')) return 1;
            if (str_contains($nama, 'wakil')) return 2;
            if (str_contains($nama, 'sekretaris')) return 3;
            if (str_contains($nama, 'bendahara')) return 4;
            return 5;
        });

        $seksiSeksi = $panitiaList->reject(function($p) use ($pimpinanInti) {
            return $pimpinanInti->contains('id', $p->id);
        })->groupBy('posisi_id');

        $paper = strtolower($request->get('paper', 'a4'));
        $orientation = strtolower($request->get('orientation', 'portrait'));

        if (!in_array($orientation, ['portrait', 'landscape'])) {
            $orientation = 'portrait';
        }

        $pdf = Pdf::loadView('kepanitiaan.sk_pdf', compact(
            'kegiatan', 'profil', 'ketuaTakmir', 'panitiaList', 'pimpinanInti', 'seksiSeksi',
            'paper', 'orientation'
        ));

        if ($paper === 'f4' || $paper === 'folio') {
            // Standar F4 / Folio Indonesia: 215mm x 330mm = 609.45pt x 935.43pt
            $pdf->setPaper([0, 0, 609.45, 935.43], $orientation);
        } else {
            $pdf->setPaper('a4', $orientation);
        }

        $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $kegiatan->nama_kegiatan);
        return $pdf->stream('SK_Panitia_' . $cleanTitle . '_' . $paper . '_' . $orientation . '.pdf');
    }
}
