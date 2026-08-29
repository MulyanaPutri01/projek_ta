<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TakmirController extends Controller
{
    // Menampilkan daftar takmir
    public function index()
    {
        $takmirs = Takmir::with('role')->get();
        return view('admin.takmir.index', compact('takmirs'));
    }

    // Menampilkan form tambah takmir
    public function create()
    {
        $roles = Role::all();
        return view('admin.takmir.create', compact('roles'));
    }

    // Menyimpan data takmir baru
    public function store(Request $request)
    {
        // Validasi input termasuk konfirmasi password
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8|confirmed',
            'role_id_role' => 'required|exists:role,id_role',
            'nama_takmir' => 'required|string|max:30',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        // Generate id_takmir otomatis
        $lastTakmir = Takmir::orderBy('id_takmir', 'desc')->first();
        $lastId = $lastTakmir ? substr($lastTakmir->id_takmir, 1) : 0;
        $newId = 'T' . str_pad((int)$lastId + 1, 2, '0', STR_PAD_LEFT);

        // Simpan data ke database
        Takmir::create([
            'id_takmir' => $newId,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => 'active',
            'role_id_role' => $request->role_id_role,
            'nama_takmir' => $request->nama_takmir,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('takmir.index')->with('success', 'Takmir berhasil ditambahkan');
    }

    // Menampilkan form edit takmir
    public function edit($id_takmir)
    {
        $takmir = Takmir::findOrFail($id_takmir);
        $roles = Role::all();
        return view('admin.takmir.edit', compact('takmir', 'roles'));
    }

    // Memperbarui data takmir
    public function update(Request $request, $id_takmir)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username,' . $id_takmir . ',id_takmir',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id_role' => 'required|exists:role,id_role',
            'nama_takmir' => 'required|string|max:50',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'role_id_role.required' => 'Role wajib dipilih.',
            'nama_takmir.required' => 'Nama takmir wajib diisi.',
        ]);

        // Cari data takmir berdasarkan ID
        $takmir = Takmir::findOrFail($id_takmir);

        // Update username
        $takmir->username = $request->username;

        // Jika password diisi, lakukan hashing dan update
        if ($request->filled('password')) {
            $takmir->password = Hash::make($request->password);
        }

        // Update role dan nama takmir
        $takmir->role_id_role = $request->role_id_role;
        $takmir->nama_takmir = $request->nama_takmir;
        $takmir->save();

        // Redirect ke halaman index dan tampilkan pesan sukses
        return redirect()->route('takmir.index')->with('success', 'Data Takmir berhasil diperbarui.');
    }
    // Menghapus data takmir
    public function destroy($id_takmir)
    {
        $takmir = Takmir::findOrFail($id_takmir);
        $takmir->delete();

        return redirect()->route('takmir.index')->with('success', 'Takmir berhasil dihapus');
    }

    public function toggleStatus($id_takmir)
    {
        $takmir = Takmir::findOrFail($id_takmir);
        // Mengecek dan mengubah status
        if ($takmir->status == 'active') {
            $takmir->status = 'inactive'; // Jika aktif, maka diubah menjadi nonaktif

        } else {
            $takmir->status = 'active'; // Jika nonaktif, maka diubah menjadi aktif
        }

        $takmir->save();

        return redirect()->route('takmir.index')->with('success', 'Status takmir berhasil diubah');
    }

}
