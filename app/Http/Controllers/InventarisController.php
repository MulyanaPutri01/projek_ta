<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Catatan;
use App\Models\Kondisi;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::query();


        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('tahun_pembelian', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
        }

        // Dapatkan hasil pencarian
        $inventaris = $query->get();


        // Pagination
        $inventariss = $query->paginate(10); // Mengambil 10 inventaris per halaman

        // Jumlah semua data
        $totalInventaris = Inventaris::count();

        return view('inventaris.index', compact('inventariss', 'totalInventaris', 'query'));
    }


    public function show($id_inventaris)
    {
        $inventaris = Inventaris::findOrFail($id_inventaris); // Ambil data berdasarkan ID
        return view('inventaris.show', compact('inventaris')); // Kirim data ke view
    }


    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:30',
            'jumlah' => 'required|integer',
            'tahun_pembelian' => 'required|integer|digits:4',
            'lokasi' => 'required|string|max:20',
            'keterangan' => 'required|string|max:225',
        ]);


        Inventaris::create($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil ditambahkan');
    }

    public function edit($id_inventaris)
    {
        $inventaris = Inventaris::findOrFail($id_inventaris);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id_inventaris)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:30',
            'jumlah' => 'required|integer',
            'tahun_pembelian' => 'required|integer|digits:4',
            'lokasi' => 'required|string|max:20',
            'keterangan' => 'required|string|max:225',
        ]);

        $inventaris = Inventaris::findOrFail($id_inventaris);
        $inventaris->update($request->all());

        return redirect()->route('inventaris.index');
    }

    public function destroy($id_inventaris)
    {
        $inventaris = Inventaris::findOrFail($id_inventaris);
        $inventaris->delete();

        return redirect()->route('inventaris.index');
    }



    public function exportPdf()
    {
        // Ambil semua data inventaris dengan relasi ke catatan (sorted) dan kondisi
        $inventariss = Inventaris::with(['catatans' => function ($query) {
            $query->orderBy('tanggal_catatan', 'desc');
        }, 'kondisi'])->get();

        // Hitung total inventaris
        $totalInventaris = $inventariss->count();


        // Buat PDF
        $pdf = Pdf::loadView('inventaris.pdf', compact('inventariss', 'totalInventaris'));

        // Tampilkan PDF di browser
        return $pdf->stream('inventaris.pdf');
    }



}

