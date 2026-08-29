<?php

namespace App\Http\Controllers;

use App\Models\Posisi;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Posisi::query();

        // Pencarian berdasarkan nama Posisi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('nama_posisi', 'LIKE', "%{$search}%");
        }


        // Pagination
        $posisis = $query->paginate(5); // Mengambil 10 Posisi per halaman

        // Jumlah semua data
        $totalPosisi = Posisi::count();


        return view('posisi.index', compact('posisis', 'totalPosisi', 'query'));
    }

    public function create()
    {
        return view('posisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posisi' => 'required|string|max:100',
        ]);

        Posisi::create([
            'nama_posisi' => $request->nama_posisi,
        ]);

        return redirect()->route('posisi.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    public function edit($id_posisi)
    {
        $posisi = Posisi::findOrFail($id_posisi);
        return view('posisi.edit', compact('posisi'));
    }

    public function update(Request $request, $id_posisi)
    {
        $request->validate([
            'nama_posisi' => 'required|string|max:100', // Sesuaikan dengan kebutuhan Anda
        ]);

        $posisi = Posisi::findOrFail($id_posisi);
        $posisi->update([
            'nama_posisi' => $request->nama_posisi,
        ]);

        return redirect()->route('posisi.index')->with('success', 'Posisi berhasil diperbarui');
    }


    public function destroy($id_posisi)
    {
        $posisi = Posisi::findOrFail($id_posisi);
        $posisi->delete();

        return redirect()->route('posisi.index');
    }
}

