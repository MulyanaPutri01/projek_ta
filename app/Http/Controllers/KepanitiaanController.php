<?php

namespace App\Http\Controllers;

use App\Models\Kepanitiaan;
use App\Models\Posisi;
use App\Models\Kegiatan;
use App\Models\Takmir;
use Illuminate\Http\Request;

class KepanitiaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Ambil nilai pencarian atau kosong jika tidak ada.

        // Query utama untuk mengambil data kepanitiaan.
        $query = Kepanitiaan::query();

        // Filter pencarian jika ada.
        if (!empty($search)) {
            $query->where('jobdesk', 'LIKE', "%{$search}%")
                ->orWhereHas('posisi', function ($q) use ($search) {
                    $q->where('nama_posisi', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('kegiatan', function ($q) use ($search) {
                    $q->where('nama_kegiatan', 'LIKE', "%{$search}%");
                });
        }

        // Pagination
        $kepanitiaans = $query->with(['posisi', 'kegiatan'])->paginate(5);

        $kegiatans = Kegiatan::all();
        $posisis = Posisi::all();
        $takmirs = Takmir::all();


        return view('kepanitiaan.index', compact('kepanitiaans', 'kegiatans', 'posisis', 'takmirs'));
    }
    public function create()
    {
        $kegiatans = Kegiatan::all();
        $posisis = Posisi::all();
        $takmirs = Takmir::all(); // Jika diperlukan
        return view('kepanitiaan.create', compact('posisis', 'kegiatans', 'takmirs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
            'jobdesk' => 'required|string|max:100',
            'posisi_id_posisi' => 'required|exists:posisi,id_posisi',
            'takmir_id_takmir' => 'nullable|exists:takmir,id_takmir',
        ]);

        $data = $request->only([
            'kegiatan_id_kegiatan',
            'jobdesk',
            'posisi_id_posisi',
        ]);

        // Ambil `takmir_id_takmir` dari user login (autentikasi)
        $data['takmir_id_takmir'] = auth()->user()->id_takmir ?? $request->input('takmir_id_takmir');

        // Simpan data ke database
        Kepanitiaan::create($data);

        return redirect()->route('kepanitiaan.index')->with('success', 'Kepanitiaan berhasil ditambahkan.');
    }


    public function show(Kepanitiaan $kepanitiaan)
    {
        return view('kepanitiaan.show', compact('keuangan'));
    }
    public function edit($id_panitia)
    {
        // Ambil data berdasarkan ID
        $kepanitiaan = Kepanitiaan::findOrFail($id_panitia);
        $kegiatans = Kegiatan::all();
        $posisis = Posisi::all();
        $takmirs = Takmir::all(); // Jika diperlukan

        return view('kepanitiaan.edit', compact('kepanitiaan', 'kegiatans', 'posisis', 'takmirs'));
    }

    public function update(Request $request, $id_panitia)
    {
        // Validasi
        $validated = $request->validate([
            'kegiatan_id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
            'jobdesk' => 'required|string|max:100',
            'posisi_id_posisi' => 'required|exists:posisi,id_posisi',
            'takmir_id_takmir' => 'nullable|exists:takmir,id_takmir',
        ]);

        // Ambil data berdasarkan ID
        $kepanitiaan = Kepanitiaan::findOrFail($id_panitia);

        // Update data
        $kepanitiaan->update([
            'kegiatan_id_kegiatan' => $request->kegiatan_id_kegiatan,
            'jobdesk' => $request->jobdesk,
            'posisi_id_posisi' => $request->posisi_id_posisi,
            // Set takmir_id_takmir ke ID takmir yang login
            'takmir_id_takmir' => auth()->user()->id_takmir,  // Pastikan menggunakan ID takmir dari user login
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kepanitiaan.index')->with('success', 'Kepanitiaan berhasil diperbarui.');
    }



    public function destroy($id_panitia)
    {
        $kepanitiaan = Kepanitiaan::findOrFail($id_panitia);
        $kepanitiaan->delete();

        return redirect()->route('kepanitiaan.index');
    }
}
