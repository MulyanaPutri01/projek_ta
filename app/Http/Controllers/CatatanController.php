<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Ambil nilai pencarian atau kosong jika tidak ada.

        // Query utama menggunakan Query Builder
        $query = DB::table('catatan')
            ->join('inventaris', 'catatan.inventaris_id_inventaris', '=', 'inventaris.id_inventaris')
            ->join('kondisi', 'catatan.kondisi_id_kondisi', '=', 'kondisi.id_kondisi')
            ->join('takmir', 'catatan.takmir_id_takmir', '=', 'takmir.id_takmir')
            ->select(
                'catatan.*',
                'inventaris.nama_barang',
                'kondisi.nama_kondisi',
                'takmir.nama_takmir'
            );

        // Filter pencarian jika ada.
        if (!empty($search)) {
            $query->orWhere('inventaris.nama_barang', 'LIKE', "%{$search}%")
                ->orWhere('kondisi.nama_kondisi', 'LIKE', "%{$search}%");
                //->where('catatan.keterangan', 'LIKE', "%{$search}%")
        }

        // Pencarian berdasarkan bulan
        if ($request->has('month') && !empty($request->month)) {
            $query->whereRaw('MONTH(catatan.tanggal_catatan) = ?', [$request->input('month')]);
        }

        // Pencarian berdasarkan tahun
        if ($request->has('year') && !empty($request->year)) {
            $query->whereRaw('YEAR(catatan.tanggal_catatan) = ?', [$request->input('year')]);
        }

        // Ambil data dengan pagination.
        $catatan = $query->paginate(5); // Sesuaikan jumlah per halaman jika diperlukan.

        // Jumlah semua data.
        $totalCatatan = DB::table('catatan')->count();

        return view('catatan.index', compact('catatan', 'totalCatatan', 'search'));
    }

    public function create()
    {
        $kondisis = DB::table('kondisi')->get();
        $inventariss = DB::table('inventaris')->get();
        $takmirs = DB::table('takmir')->get();
        return view('catatan.create', compact('kondisis', 'inventariss', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventaris_id_inventaris' => 'required|exists:inventaris,id_inventaris',
            'tanggal_catatan' => 'required|date',
            'kondisi_id_kondisi' => 'required|exists:kondisi,id_kondisi',
            //'keterangan' => 'required|string|max:50',
        ]);

        // Ambil ID terakhir dan buat ID baru
        $lastId = DB::table('catatan')->orderBy('id_catatan', 'desc')->value('id_catatan');
        $newIdNumber = $lastId ? (int) substr($lastId, 1) + 1 : 1; // Increment dari ID terakhir
        $newId = 'C' . str_pad($newIdNumber, 2, '0', STR_PAD_LEFT); // Format ID baru, contoh: C01, C02, dst.

        // Data untuk insert
        $data = $request->only([
            'inventaris_id_inventaris',
            'tanggal_catatan',
            'kondisi_id_kondisi',
            //'keterangan',
        ]);
        $data['id_catatan'] = $newId; // Tambahkan ID ke data
        $data['takmir_id_takmir'] = auth()->user()->id_takmir;

        // Simpan data ke tabel
        DB::table('catatan')->insert($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function edit($id_catatan)
    {
        // Ambil data catatan berdasarkan ID
        $catatan = DB::table('catatan')->where('id_catatan', $id_catatan)->first();

        if (!$catatan) {
            return redirect()->route('catatan.index')->with('error', 'Catatan tidak ditemukan.');
        }

        // Ambil data tambahan untuk dropdown, jika diperlukan
        $kondisis = DB::table('kondisi')->get();
        $inventariss = DB::table('inventaris')->get();
        $takmirs = DB::table('takmir')->get();

        // Tampilkan view edit
        return view('catatan.edit', compact('catatan', 'kondisis', 'inventariss', 'takmirs'));
    }
    public function update(Request $request, $id_catatan)
    {
        $request->validate([
            'inventaris_id_inventaris' => 'required|exists:inventaris,id_inventaris',
            'tanggal_catatan' => 'required|date',
            'kondisi_id_kondisi' => 'required|exists:kondisi,id_kondisi',
            //'keterangan' => 'required|string|max:50',
        ]);

        // Cek apakah catatan dengan ID tersebut ada
        $catatan = DB::table('catatan')->where('id_catatan', $id_catatan)->first();
        if (!$catatan) {
            return redirect()->route('catatan.index')->with('error', 'Catatan tidak ditemukan.');
        }

        // Data untuk diupdate
        $data = $request->only([
            'inventaris_id_inventaris',
            'tanggal_catatan',
            'kondisi_id_kondisi',
            //'keterangan',
        ]);

        // Tambahkan informasi siapa yang mengedit
        $data['takmir_id_takmir'] = auth()->user()->id_takmir; // ID takmir yang sedang login

        // Update data
        DB::table('catatan')->where('id_catatan', $id_catatan)->update($data);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui.');
    }


    public function destroy($id_catatan)
    {
        // Hapus data menggunakan Query Builder
        DB::table('catatan')->where('id_catatan', $id_catatan)->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
