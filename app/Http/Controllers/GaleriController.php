<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function __construct(){
        $this->middleware('role:admin');

    }

    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = DB::table('galeri')
            ->join('kegiatan', 'galeri.kegiatan_id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->join('takmir', 'galeri.takmir_id_takmir', '=', 'takmir.id_takmir')
            ->select('galeri.*', 'kegiatan.nama_kegiatan','takmir.nama_takmir');

        if (!empty($search)) {
            $query->where('galeri.nama_foto', 'LIKE', "%{$search}%")
                ->orWhere('kegiatan.nama_kegiatan', 'LIKE', "%{$search}%");
        }

        if ($request->has('month') && !empty($request->month)) {
            $query->whereRaw('DATE_FORMAT(galeri.tanggal, "%m") = ?', [$request->month]);
        }

        if ($request->has('year') && !empty($request->year)) {
            $query->whereRaw('DATE_FORMAT(galeri.tanggal, "%Y") = ?', [$request->year]);
        }

        $galeri = $query->paginate(5);
        $totalGaleri = DB::table('galeri')->count();

        return view('galeri.index', compact('galeri', 'totalGaleri', 'search'));
    }

    public function create()
    {
        $kegiatans = DB::table('kegiatan')->get();
        $takmirs = DB::table('takmir')->get();
        return view('galeri.create', compact('kegiatans', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_foto' => 'required|max:50',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kegiatan_id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
        ]);

        $lastId = DB::table('galeri')->latest('id_galeri')->first();
        $newId = $lastId ? 'G' . str_pad((int) substr($lastId->id_galeri, 1) + 1, 2, '0', STR_PAD_LEFT) : 'G01';

        // Upload gambar
        $filePath = null; // Default nilai untuk path file
        if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $filePath = 'galeri_masjid/' . $fileName;

            // Simpan file ke folder public/storage/galeri_masjid
            $request->file('gambar')->move(public_path('storage/galeri_masjid'), $fileName);
        }
        DB::table('galeri')->insert([
            'id_galeri' => $newId,
            'tanggal' => $request->tanggal,
            'nama_foto' => $request->nama_foto,
            'gambar' => $filePath,
            'kegiatan_id_kegiatan' => $request->kegiatan_id_kegiatan,
            'takmir_id_takmir' => auth()->user()->id_takmir,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function show($id_galeri)
    {
        $galeri = DB::table('galeri')
            ->join('kegiatan', 'galeri.kegiatan_id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->select('galeri.*', 'kegiatan.nama_kegiatan')
            ->where('galeri.id_galeri', $id_galeri)
            ->first();

        return view('galeri.show', compact('galeri'));
    }

    public function edit($id_galeri)
    {
        $galeri = DB::table('galeri')->where('id_galeri', $id_galeri)->first();
        $kegiatans = DB::table('kegiatan')->get();

        return view('galeri.edit', compact('galeri', 'kegiatans'));
    }

    public function update(Request $request, $id_galeri)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_foto' => 'required|max:50',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'kegiatan_id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
        ]);

        // 1. Ambil data galeri lama
    $galeri = DB::table('galeri')->where('id_galeri', $id_galeri)->first();

    // 2. Set default $filePath menggunakan nama gambar yang lama
    $filePath = $galeri->gambar;

    // 3. Jika ada file gambar baru yang diunggah
    if ($request->hasFile('gambar')) {
        // Hapus file gambar lama dari server jika ada
        if (!empty($galeri->gambar) && file_exists(public_path('storage/' . $galeri->gambar))) {
            unlink(public_path('storage/' . $galeri->gambar));
        }

        // Upload gambar baru
        $fileName = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $filePath = 'galeri_masjid/' . $fileName;
        $request->file('gambar')->move(public_path('storage/galeri_masjid'), $fileName);
    }

    // 4. Update database
    DB::table('galeri')->where('id_galeri', $id_galeri)->update([
        'tanggal' => $request->tanggal,
        'nama_foto' => $request->nama_foto,
        'gambar' => $filePath, // Tetap memakai nama lama jika tidak ada unggahan baru
        'kegiatan_id_kegiatan' => $request->kegiatan_id_kegiatan,
        'takmir_id_takmir' => auth()->user()->id_takmir,
    ]);

    return redirect()->route('galeri.index')->with('success', 'data foto berhasil diperbarui.');
    }

    public function destroy($id_galeri)
    {
        $galeri = DB::table('galeri')->where('id_galeri', $id_galeri)->first();

        if ($galeri && !empty($galeri->gambar) && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        DB::table('galeri')->where('id_galeri', $id_galeri)->delete();

        return redirect()->route('galeri.index')->with('success', 'Foto berhasil dihapus.');
    }
}
