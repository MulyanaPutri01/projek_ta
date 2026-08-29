<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilMasjid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProfilMasjidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('role:admin');

    }
    public function index()
    {
        $profil = ProfilMasjid::all();
        return view('profilmasjid.index', compact('profil'));
    }

    public function create()
    {
        return view('profilmasjid.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           
            'nama_masjid' => 'nullable|max:50',
            'sejarah' => 'nullable',
            'visi' => 'nullable',
            'misi' => 'nullable',
            'alamat' => 'nullable',
            'telepon' => 'nullable|max:15',
            
        ]);
        do {
            $idProfil = strtoupper(Str::random(3));
        } while (ProfilMasjid::where('id_profil', $idProfil)->exists());

        $takmirId = Auth::user()->id_takmir;

        ProfilMasjid::create([
            'id_profil'        => $idProfil,
            'nama_masjid'      => $request->nama_masjid,
            'sejarah'          => $request->sejarah,
            'visi'             => $request->visi,
            'misi'             => $request->misi,
            'alamat'           => $request->alamat,
            'telepon'          => $request->telepon,
            'takmir_id_takmir' => $takmirId,
        ]);
        

        return redirect()->route('profilmasjid.index')
            ->with('success', 'Profil Masjid berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profil = ProfilMasjid::findOrFail($id);
        return view('profilmasjid.edit', compact('profil'));
    }

    public function update(Request $request, $id_profil)
    {
        $request->validate([
            'nama_masjid' => 'nullable|max:50',
            'sejarah' => 'nullable',
            'visi' => 'nullable',
            'misi' => 'nullable',
            'alamat' => 'nullable',
            'telepon' => 'nullable|max:15',
            
        ]);

        $profil = ProfilMasjid::findOrFail($id_profil);
        $profil->update($request->all());

        return redirect()->route('profilmasjid.index')
            ->with('success', 'Profil Masjid berhasil diperbarui.');
    }

    public function destroy($id_profil)
    {
        $profil = ProfilMasjid::findOrFail($id_profil);
        $profil->delete();

        return redirect()->route('profilmasjid.index')
            ->with('success', 'Profil Masjid berhasil dihapus.');
    }
}
