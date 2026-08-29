<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Takmir;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $query = DB::table('donatur')
                ->select('donatur.*', DB::raw('IFNULL(takmir.nama_takmir, "Unknown") as nama_takmir'))
                ->leftJoin('takmir', 'donatur.takmir_id_takmir', '=', 'takmir.id_takmir');


        // Pencarian berdasarkan nama donatur
        if ($request->has('search') && !empty($request->search)) {
            $query->where('donatur.nama_donatur', 'LIKE', "%{$search}%");
        }

        // Pencarian berdasarkan bulan
        if ($request->has('month') && !empty($request->month)) {
            $query->whereRaw('DATE_FORMAT(donatur.tanggal, "%m") = ?', [$request->input('month')]);
        }

        // Pencarian berdasarkan tahun
        if ($request->has('year') && !empty($request->year)) {
            $query->whereRaw('DATE_FORMAT(donatur.tanggal, "%Y") = ?', [$request->input('year')]);
        }

        // Total semua data
        $totalDonatur = DB::table('donatur')->count();

        // Paginate hasil query
        $donaturs = $query->paginate(3);



        return view('donatur.index', compact('donaturs', 'totalDonatur', 'search'));
    }

    public function create()
    {
        return view('donatur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|max:50',
            'alamat' => 'required|max:225',
        ]);

        // Generate ID otomatis
        $lastDonatur = DB::table('donatur')->orderBy('id_donatur', 'desc')->first();
        $newId = $lastDonatur
            ? 'D' . str_pad((int) substr($lastDonatur->id_donatur, 1) + 1, 4, '0', STR_PAD_LEFT)
            : 'D0001';

        // Insert data
        DB::table('donatur')->insert([
            'id_donatur' => $newId,
            'tanggal' => $request->input('tanggal'),
            'nama_donatur' => $request->input('nama_donatur'),
            'alamat' => $request->input('alamat'),
            'takmir_id_takmir' => auth()->user()->id_takmir,
        ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil ditambahkan');
    }

    public function edit($id_donatur)
    {
        $donatur = DB::table('donatur')->where('id_donatur', $id_donatur)->first();
        return view('donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $id_donatur)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|max:50',
            'alamat' => 'required|max:225',
        ]);

        // Update data
        DB::table('donatur')
            ->where('id_donatur', $id_donatur)
            ->update([
                'tanggal' => $request->input('tanggal'),
                'nama_donatur' => $request->input('nama_donatur'),
                'alamat' => $request->input('alamat'),
                'takmir_id_takmir' => auth()->user()->id_takmir,
            ]);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil diperbarui');
    }

    public function destroy($id_donatur)
    {
        DB::table('donatur')->where('id_donatur', $id_donatur)->delete();
        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil dihapus');
    }
}
