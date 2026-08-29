<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Menampilkan daftar peran (roles) dan jumlah hak akses.
     */
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Menampilkan form tambah peran baru.
     */
    public function create()
    {
        $permissionGroups = $this->getGroupedPermissions();
        return view('admin.roles.create', compact('permissionGroups'));
    }

    /**
     * Menyimpan peran baru beserta hak aksesnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'Nama peran wajib diisi.',
            'name.unique'   => 'Nama peran sudah digunakan.',
        ]);

        $role = Role::create([
            'name' => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Peran (Role) baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit peran dan atur hak akses.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissionGroups = $this->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }

    /**
     * Memperbarui peran dan hak akses.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $id . ',id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'Nama peran wajib diisi.',
            'name.unique'   => 'Nama peran sudah digunakan.',
        ]);

        $role->name = strtolower(trim($request->name));
        $role->save();

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Peran dan Hak Akses berhasil diperbarui.');
    }

    /**
     * Menghapus peran (kecuali peran sistem utama).
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array(strtolower($role->name), ['admin', 'bendahara', 'sekretaris'])) {
            return redirect()->route('roles.index')->with('error', 'Peran bawaan sistem tidak boleh dihapus.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Peran berhasil dihapus.');
    }

    /**
     * Mengelompokkan permissions ke modul-modul agar rapi di UI.
     */
    private function getGroupedPermissions()
    {
        return [
            'Manajemen Pengguna & Hak Akses' => [
                'user-list'   => 'Melihat Daftar Pengguna',
                'user-create' => 'Menambah Pengguna Baru',
                'user-edit'   => 'Mengubah Data Pengguna',
                'user-delete' => 'Menghapus Pengguna',
                'role-list'   => 'Melihat Daftar Peran',
                'role-create' => 'Menambah Peran Baru',
                'role-edit'   => 'Mengubah Hak Akses Peran',
                'role-delete' => 'Menghapus Peran',
            ],
            'Manajemen Keuangan & Donatur' => [
                'keuangan-list'   => 'Melihat Transaksi Keuangan',
                'keuangan-create' => 'Mencatat Pemasukan/Pengeluaran',
                'keuangan-edit'   => 'Mengubah Transaksi Kas',
                'keuangan-delete' => 'Menghapus Transaksi Kas',
                'laporan-view'    => 'Melihat Laporan Kas',
                'laporan-print'   => 'Mencetak / Unduh PDF Laporan',
                'donatur-list'    => 'Melihat Daftar Donatur',
                'donatur-create'  => 'Menambah Data Donatur',
                'donatur-edit'    => 'Mengubah Data Donatur',
                'donatur-delete'  => 'Menghapus Data Donatur',
                'kategori-list'   => 'Melihat Kategori Kas',
                'kategori-manage' => 'Kelola Kategori Kas',
            ],
            'Agenda Kegiatan & Kepanitiaan' => [
                'kegiatan-list'      => 'Melihat Jadwal Kegiatan',
                'kegiatan-create'    => 'Menambah Jadwal Kegiatan',
                'kegiatan-edit'      => 'Mengubah Jadwal Kegiatan',
                'kegiatan-delete'    => 'Menghapus Jadwal Kegiatan',
                'kegiatan-calendar'  => 'Akses Kalender Agenda',
                'kepanitiaan-list'   => 'Melihat Daftar Panitia',
                'kepanitiaan-manage' => 'Kelola Anggota Panitia',
                'posisi-manage'      => 'Kelola Master Posisi Panitia',
            ],
            'Inventaris & Catatan Kondisi' => [
                'inventaris-list'   => 'Melihat Daftar Inventaris',
                'inventaris-create' => 'Menambah Barang Baru',
                'inventaris-edit'   => 'Mengubah Barang Inventaris',
                'inventaris-delete' => 'Menghapus Barang Inventaris',
                'inventaris-pdf'    => 'Unduh Laporan Inventaris (PDF)',
                'catatan-list'      => 'Melihat Catatan Kondisi',
                'catatan-create'    => 'Menambah Catatan Kondisi',
                'catatan-edit'      => 'Mengubah Catatan Kondisi',
                'catatan-delete'    => 'Menghapus Catatan Kondisi',
                'kondisi-manage'    => 'Kelola Master Kondisi',
            ],
            'Profil Masjid & Galeri Dokumentasi' => [
                'profilmasjid-view' => 'Melihat Profil Masjid',
                'profilmasjid-edit' => 'Mengubah Profil & Kontak Masjid',
                'galeri-list'       => 'Melihat Galeri Foto',
                'galeri-create'     => 'Upload Foto Dokumentasi',
                'galeri-edit'       => 'Mengubah Data Galeri',
                'galeri-delete'     => 'Menghapus Foto Galeri',
            ],
        ];
    }
}
