<?php

namespace App\Http\Controllers;

use App\Models\Kondisi;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Kondisi::query();

        // Pencarian berdasarkan nama Kondisi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('nama_kondisi', 'LIKE', "%{$search}%");
        }


        // Pagination
        $kondisis = $query->paginate(5); // Mengambil 10 Kondisi per halaman

        // Jumlah semua data
        $totalKondisi = Kondisi::count();


        return view('kondisi.index', compact('kondisis', 'totalKondisi', 'query'));
    }

    public function create()
    {
        return view('kondisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:100',
        ]);

        Kondisi::create([
            'nama_kondisi' => $request->nama_kondisi,
        ]);

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil ditambahkan');
    }

    public function edit($id_Kondisi)
    {
        $kondisi = Kondisi::findOrFail($id_kondisi);
        return view('kondisi.edit', compact('kondisi'));
    }

    public function update(Request $request, $id_kondisi)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:100', // Sesuaikan dengan kebutuhan Anda
        ]);

        $kondisi = Kondisi::findOrFail($id_kondisi);
        $kondisi->update([
            'nama_kondisi' => $request->nama_kondisi,
        ]);

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil diperbarui');
    }


    public function destroy($id_kondisi)
    {
        $kondisi = Kondisi::findOrFail($id_kondisi);
        $kondisi->delete();

        return redirect()->route('kondisi.index');
    }
}

