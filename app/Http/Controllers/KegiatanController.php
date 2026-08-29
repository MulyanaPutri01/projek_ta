<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function __construct(){
        $this->middleware('role:sekretaris');

    }
    public function index(Request $request)
    {
        $query = Kegiatan::query();

        // Pencarian berdasarkan nama kegiatan
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('nama_kegiatan', 'LIKE', "%{$search}%");
        }

        // Pencarian berdasarkan bulan
        if ($request->has('month') && !empty($request->month)) {
            $query->whereRaw('DATE_FORMAT(tanggal, "%m") = ?', [$request->input('month')]);
        }

        // Pencarian berdasarkan tahun
        if ($request->has('year') && !empty($request->year)) {
            $query->whereRaw('DATE_FORMAT(tanggal, "%Y") = ?', [$request->input('year')]);
        }
        // Pagination
        $kegiatans = $query->paginate(10); // Mengambil 10 kegiatan per halaman

        // Jumlah semua data
        $totalKegiatan = Kegiatan::count();

        return view('kegiatan.index', compact('kegiatans', 'totalKegiatan', 'query'));
    }


    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'mulai_kegiatan' => 'required|date_format:H:i',
            'akhir_kegiatan' => 'required|date_format:H:i',
            'nama_waktu' => 'required|max:30',
            'pembicara' => 'required|max:30',
            'tempat' => 'required|max:30',
            'audience' => 'required|max:30',
        ]);


        Kegiatan::create($request->all());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit($id_kegiatan)
    {
        $kegiatan = Kegiatan::findOrFail($id_kegiatan);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id_kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|max:20',
            'tanggal' => 'required|date',
            'mulai_kegiatan' => 'required|date_format:H:i',
            'akhir_kegiatan' => 'required|date_format:H:i',
            'nama_waktu' => 'required|max:30',
            'pembicara' => 'required|max:30',
            'tempat' => 'required|max:30',
            'audience' => 'required|max:30',
        ]);

        $kegiatan = Kegiatan::findOrFail($id_kegiatan);
        $kegiatan->update($request->all());

        return redirect()->route('kegiatan.index');
    }

    public function destroy($id_kegiatan)
    {
        $kegiatan = Kegiatan::findOrFail($id_kegiatan);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index');
    }
    public function getEvents()
    {
        $kegiatan = Kegiatan::select('id_kegiatan as id', 'nama_kegiatan as title', 'mulai_kegiatan as start', 'akhir_kegiatan as end')->get();
        return response()->json($kegiatan);
    }
    public function calendar()
    {
        return view('kegiatan.calendar');
    }


}

