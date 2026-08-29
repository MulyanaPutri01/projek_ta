<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilMasjid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilMasjidController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:profilmasjid-view')->only(['index']);
        $this->middleware('permission:profilmasjid-edit')->only(['update']);
    }

    /**
     * Menampilkan halaman profil & pengaturan informasi masjid tunggal.
     */
    public function index()
    {
        $profil = ProfilMasjid::with('takmir')->first();

        // Jika data belum ada, buat data default masjid
        if (!$profil) {
            $profil = ProfilMasjid::create([
                'nama_masjid' => 'Masjid Al-Ikhlas',
                'alamat' => 'Dukuh Semendot, Desa Karangmulya, Kec. Suradadi, Kab. Tegal',
                'telepon' => '08123456789',
                'sejarah' => 'Masjid Al-Ikhlas didirikan sebagai sarana ibadah dan pusat kegiatan keagamaan masyarakat.',
                'visi' => 'Menjadi pusat peribadatan dan pengembangan kemakmuran umat yang berakhlak mulia.',
                'misi' => "1. Menyelenggarakan kegiatan ibadah fardhu dan sunnah secara berjamaah.\n2. Menjalin ukhuwah islamiyah dan keterbukaan tata kelola masjid.",
                'takmir_id' => Auth::id() ?? 1,
            ]);
        }

        return view('profilmasjid.index', compact('profil'));
    }

    /**
     * Memperbarui profil masjid tunggal.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_masjid' => 'required|string|max:100',
            'telepon'     => 'nullable|string|max:20',
            'alamat'      => 'required|string|max:255',
            'sejarah'     => 'nullable|string',
            'visi'        => 'nullable|string',
            'misi'        => 'nullable|string',
            'foto_masjid' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'nama_masjid.required' => 'Nama masjid wajib diisi.',
            'alamat.required'      => 'Alamat masjid wajib diisi.',
            'foto_masjid.image'    => 'File background harus berupa gambar.',
            'foto_masjid.max'      => 'Ukuran gambar background maksimal 5MB.',
        ]);

        $profil = ProfilMasjid::findOrFail($id);
        $profil->nama_masjid = $request->nama_masjid;
        $profil->telepon     = $request->telepon;
        $profil->alamat      = $request->alamat;
        $profil->sejarah     = $request->sejarah;
        $profil->visi        = $request->visi;
        $profil->misi        = $request->misi;
        $profil->takmir_id   = Auth::id() ?? $profil->takmir_id;

        // Hapus foto jika dicentang
        if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            if ($profil->foto_masjid && Storage::disk('public')->exists($profil->foto_masjid)) {
                Storage::disk('public')->delete($profil->foto_masjid);
            }
            $profil->foto_masjid = null;
        }

        // Upload foto / background hero baru
        if ($request->hasFile('foto_masjid')) {
            if ($profil->foto_masjid && Storage::disk('public')->exists($profil->foto_masjid)) {
                Storage::disk('public')->delete($profil->foto_masjid);
            }
            $path = $request->file('foto_masjid')->store('profil', 'public');
            $profil->foto_masjid = $path;
        }

        $profil->save();

        return redirect()->route('profilmasjid.index')
            ->with('success', 'Informasi & Background Hero Profil Masjid berhasil diperbarui!');
    }
}
