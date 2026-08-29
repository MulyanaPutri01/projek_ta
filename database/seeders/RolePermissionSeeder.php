<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Takmir;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Daftar Permissions Terstruktur per Modul
        $permissions = [
            // Modul Manajemen Pengguna & Hak Akses
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',

            // Modul Keuangan & Donatur
            'keuangan-list', 'keuangan-create', 'keuangan-edit', 'keuangan-delete',
            'laporan-view', 'laporan-print',
            'donatur-list', 'donatur-create', 'donatur-edit', 'donatur-delete',
            'kategori-list', 'kategori-manage',

            // Modul Kegiatan & Kepanitiaan
            'kegiatan-list', 'kegiatan-create', 'kegiatan-edit', 'kegiatan-delete', 'kegiatan-calendar',
            'kepanitiaan-list', 'kepanitiaan-manage', 'posisi-manage',

            // Modul Inventaris & Catatan
            'inventaris-list', 'inventaris-create', 'inventaris-edit', 'inventaris-delete', 'inventaris-pdf',
            'catatan-list', 'catatan-create', 'catatan-edit', 'catatan-delete', 'kondisi-manage',

            // Modul Profil Masjid & Galeri
            'profilmasjid-view', 'profilmasjid-edit',
            'galeri-list', 'galeri-create', 'galeri-edit', 'galeri-delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2. Buat / Update Role Spatie
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $bendaharaRole = Role::firstOrCreate(['name' => 'bendahara', 'guard_name' => 'web']);
        $sekretarisRole = Role::firstOrCreate(['name' => 'sekretaris', 'guard_name' => 'web']);

        // Admin: Mendapatkan Seluruh Permissions
        $adminRole->syncPermissions(Permission::all());

        // Bendahara: Modul Keuangan & Donatur
        $bendaharaRole->syncPermissions([
            'keuangan-list', 'keuangan-create', 'keuangan-edit', 'keuangan-delete',
            'laporan-view', 'laporan-print',
            'donatur-list', 'donatur-create', 'donatur-edit', 'donatur-delete',
            'kategori-list', 'kategori-manage',
        ]);

        // Sekretaris: Modul Kegiatan, Kepanitiaan, Inventaris, Catatan
        $sekretarisRole->syncPermissions([
            'kegiatan-list', 'kegiatan-create', 'kegiatan-edit', 'kegiatan-delete', 'kegiatan-calendar',
            'kepanitiaan-list', 'kepanitiaan-manage', 'posisi-manage',
            'inventaris-list', 'inventaris-create', 'inventaris-edit', 'inventaris-delete', 'inventaris-pdf',
            'catatan-list', 'catatan-create', 'catatan-edit', 'catatan-delete', 'kondisi-manage',
        ]);

        // 3. Sinkronisasi Data Takmir yang Ada
        $takmirs = Takmir::all();
        foreach ($takmirs as $takmir) {
            $roleName = 'admin';
            if ($takmir->role && in_array(strtolower($takmir->role->nama_role), ['admin', 'bendahara', 'sekretaris'])) {
                $roleName = strtolower($takmir->role->nama_role);
            } elseif (in_array(strtolower($takmir->username), ['admin', 'bendahara', 'sekretaris'])) {
                $roleName = strtolower($takmir->username);
            }
            $takmir->syncRoles([$roleName]);
        }
    }
}
