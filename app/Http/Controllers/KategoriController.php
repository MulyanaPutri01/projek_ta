<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // Jika id_kategori di-generate otomatis oleh sistem (misal: K1, K2, dst):
        $lastId = Kategori::latest('id_kategori')->first();
        $newIdNumber = $lastId ? (int) substr($lastId->id_kategori, 1) + 1 : 1;
        $newId = 'K' . str_pad($newIdNumber, 1, '0', STR_PAD_LEFT); // Menghasilkan K1, K2, dst (sesuaikan ukuran char(2))

        $request->validate([
            'nama_kategori' => 'required|max:15',
        ]);

        Kategori::create([
            'id_kategori' => $newId,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|max:15',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id_kategori) // Sebelumnya tertulis $id_kegiatan, ini keliru
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

