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
                ->addColumn('brosur_thumb', function ($row) {
                    if ($row->foto && file_exists(public_path('storage/' . $row->foto))) {
                        return '<a href="' . asset('storage/' . $row->foto) . '" target="_blank" title="Lihat Brosur Asli">
                            <img src="' . asset('storage/' . $row->foto) . '" alt="Brosur" class="rounded shadow-sm border" style="width: 50px; height: 50px; object-fit: cover;">
                        </a>';
                    }
                    return '<div class="rounded bg-light text-muted border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.2rem;">
                        <i class="bi bi-image"></i>
                    </div>';
                })
                ->editColumn('nama_kegiatan', function ($row) {
                    $penceramah = $row->pembicara ? '<br><small class="text-muted"><i class="bi bi-person-fill text-primary me-1"></i>' . e($row->pembicara) . '</small>' : '';
                    $khotib = $row->nama_khotib ? '<br><small class="text-muted"><i class="bi bi-mic-fill text-success me-1"></i>Khotib: ' . e($row->nama_khotib) . '</small>' : '';
                    return '<div><span class="fw-bold text-dark">' . e($row->nama_kegiatan) . '</span>' . $penceramah . $khotib . '</div>';
                })
                ->editColumn('tanggal', function ($row) {
                    if (!$row->tanggal) return '-';
                    $carbon = Carbon::parse($row->tanggal);
                    $isPast = $carbon->isPast() && !$carbon->isToday();
                    $badgeStatus = $isPast ? '<span class="badge bg-secondary-subtle text-secondary small d-block mt-1">Selesai</span>' : ($carbon->isToday() ? '<span class="badge bg-success-subtle text-success border border-success-subtle small d-block mt-1">Hari Ini</span>' : '<span class="badge bg-primary-subtle text-primary border border-primary-subtle small d-block mt-1">Mendatang</span>');
                    return '<div class="text-center"><span class="fw-semibold text-dark">' . $carbon->translatedFormat('d M Y') . '</span>' . $badgeStatus . '</div>';
                })
                ->addColumn('waktu_acara', function ($row) {
                    $mulai = $row->mulai_kegiatan ? Carbon::parse($row->mulai_kegiatan)->format('H:i') : '-';
                    $akhir = $row->akhir_kegiatan ? Carbon::parse($row->akhir_kegiatan)->format('H:i') : '-';
                    $periode = $row->nama_waktu ? '<small class="text-muted d-block">' . e($row->nama_waktu) . '</small>' : '';
                    return '<div class="text-center"><span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-clock me-1"></i>' . $mulai . ' - ' . $akhir . ' WIB</span>' . $periode . '</div>';
                })
                ->editColumn('tempat', function ($row) {
                    $audience = $row->audience ? '<br><small class="text-muted"><i class="bi bi-people me-1"></i>' . e($row->audience) . '</small>' : '';
                    return '<div><i class="bi bi-geo-alt-fill text-danger me-1"></i><span class="fw-semibold text-dark">' . e($row->tempat) . '</span>' . $audience . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('kegiatan.edit', $row->id);
                    $deleteUrl = route('kegiatan.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Kegiatan"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus agenda kegiatan ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Kegiatan"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['brosur_thumb', 'nama_kegiatan', 'tanggal', 'waktu_acara', 'tempat', 'action'])
                ->make(true);
        }

        $totalKegiatan = Kegiatan::count();
        $bulanIni = Kegiatan::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->count();
        $mendatang = Kegiatan::where('tanggal', '>=', Carbon::today()->toDateString())->count();

        return view('kegiatan.index', compact('totalKegiatan', 'bulanIni', 'mendatang'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'  => 'required|string|max:150',
            'tanggal'        => 'required|date',
            'mulai_kegiatan' => 'required',
            'akhir_kegiatan' => 'required',
            'nama_waktu'     => 'nullable|max:50',
            'pembicara'      => 'nullable|max:100',
            'nama_khotib'    => 'nullable|max:100',
            'nama_muadzin'   => 'nullable|max:100',
            'tempat'         => 'required|max:100',
            'audience'       => 'nullable|max:100',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
        ], [
            'nama_kegiatan.required'  => 'Nama agenda kegiatan wajib diisi.',
            'tanggal.required'        => 'Tanggal pelaksanaan kegiatan wajib ditentukan.',
            'mulai_kegiatan.required' => 'Waktu mulai acara wajib diisi.',
            'akhir_kegiatan.required' => 'Waktu selesai acara wajib diisi.',
            'tempat.required'         => 'Lokasi / tempat pelaksanaan wajib diisi.',
            'foto.image'              => 'File brosur / foto harus berupa gambar (JPG, PNG, WEBP).',
            'foto.max'                => 'Ukuran foto maksimal adalah 3 MB.',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destinationPath = public_path('storage/kegiatan');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $fileName);
            $data['foto'] = 'kegiatan/' . $fileName;
        }

        Kegiatan::create($data);

        return redirect()->route('kegiatan.index')->with('success', 'Agenda kegiatan beserta brosur berhasil ditambahkan ke jadwal.');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan'  => 'required|string|max:150',
            'tanggal'        => 'required|date',
            'mulai_kegiatan' => 'required',
            'akhir_kegiatan' => 'required',
            'nama_waktu'     => 'nullable|max:50',
            'pembicara'      => 'nullable|max:100',
            'nama_khotib'    => 'nullable|max:100',
            'nama_muadzin'   => 'nullable|max:100',
            'tempat'         => 'required|max:100',
            'audience'       => 'nullable|max:100',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
        ], [
            'nama_kegiatan.required'  => 'Nama agenda kegiatan wajib diisi.',
            'tanggal.required'        => 'Tanggal pelaksanaan kegiatan wajib ditentukan.',
            'mulai_kegiatan.required' => 'Waktu mulai acara wajib diisi.',
            'akhir_kegiatan.required' => 'Waktu selesai acara wajib diisi.',
            'tempat.required'         => 'Lokasi / tempat pelaksanaan wajib diisi.',
            'foto.image'              => 'File brosur / foto harus berupa gambar (JPG, PNG, WEBP).',
            'foto.max'                => 'Ukuran foto maksimal adalah 3 MB.',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if (!empty($kegiatan->foto) && file_exists(public_path('storage/' . $kegiatan->foto))) {
                @unlink(public_path('storage/' . $kegiatan->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destinationPath = public_path('storage/kegiatan');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $fileName);
            $data['foto'] = 'kegiatan/' . $fileName;
        }

        $kegiatan->update($data);

        return redirect()->route('kegiatan.index')->with('success', 'Jadwal agenda kegiatan dan brosur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if (!empty($kegiatan->foto) && file_exists(public_path('storage/' . $kegiatan->foto))) {
            @unlink(public_path('storage/' . $kegiatan->foto));
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Agenda kegiatan berhasil dihapus.');
    }

    public function getEvents()
    {
        $kegiatans = Kegiatan::all();
        $events = $kegiatans->map(function ($item) {
            $mulai = $item->mulai_kegiatan ? substr($item->mulai_kegiatan, 0, 5) : '00:00';
            $akhir = $item->akhir_kegiatan ? substr($item->akhir_kegiatan, 0, 5) : '23:59';
            
            $namaLower = strtolower($item->nama_kegiatan);
            $bgColor = '#059669'; // default emerald
            $borderColor = '#047857';

            if (str_contains($namaLower, 'jumat') || str_contains($namaLower, 'jum\'at')) {
                $bgColor = '#2563eb';
                $borderColor = '#1d4ed8';
            } elseif (str_contains($namaLower, 'maulid') || str_contains($namaLower, 'isra') || str_contains($namaLower, 'peringatan') || str_contains($namaLower, 'hari besar')) {
                $bgColor = '#d97706';
                $borderColor = '#b45309';
            } elseif (str_contains($namaLower, 'muslimah') || str_contains($namaLower, 'ibu')) {
                $bgColor = '#db2777';
                $borderColor = '#be185d';
            } elseif (str_contains($namaLower, 'remaja') || str_contains($namaLower, 'irma') || str_contains($namaLower, 'pemuda')) {
                $bgColor = '#7c3aed';
                $borderColor = '#6d28d9';
            } elseif (str_contains($namaLower, 'buka') || str_contains($namaLower, 'ramadhan') || str_contains($namaLower, 'tarawih')) {
                $bgColor = '#0891b2';
                $borderColor = '#0e7490';
            }

            $fotoUrl = ($item->foto && file_exists(public_path('storage/' . $item->foto)))
                ? asset('storage/' . $item->foto)
                : null;

            return [
                'id' => $item->id,
                'title' => $item->nama_kegiatan,
                'start' => $item->tanggal . 'T' . $mulai . ':00',
                'end' => $item->tanggal . 'T' . $akhir . ':00',
                'backgroundColor' => $bgColor,
                'borderColor' => $borderColor,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'tanggal_indo'  => Carbon::parse($item->tanggal)->translatedFormat('l, d F Y'),
                    'jam'           => $mulai . ' - ' . $akhir . ' WIB',
                    'nama_waktu'    => $item->nama_waktu ?? '',
                    'tempat'        => $item->tempat,
                    'pembicara'     => $item->pembicara ?? '',
                    'nama_khotib'   => $item->nama_khotib ?? '',
                    'nama_muadzin'  => $item->nama_muadzin ?? '',
                    'audience'      => $item->audience ?? 'Jamaah Umum',
                    'foto_url'      => $fotoUrl,
                    'edit_url'      => route('kegiatan.edit', $item->id),
                ]
            ];
        });
        return response()->json($events);
    }

    public function calendar()
    {
        $totalKegiatan = Kegiatan::count();
        $bulanIni = Kegiatan::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->count();
        $mendatang = Kegiatan::where('tanggal', '>=', Carbon::today()->toDateString())->count();

        return view('kegiatan.calendar', compact('totalKegiatan', 'bulanIni', 'mendatang'));
    }
}

