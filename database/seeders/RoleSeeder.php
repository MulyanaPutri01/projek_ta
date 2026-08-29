<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['id' => 1, 'nama_role' => 'admin'],
            ['id' => 2, 'nama_role' => 'bendahara'],
            ['id' => 3, 'nama_role' => 'sekretaris'],
        ];

        foreach ($roles as $role) {
            DB::table('role')->updateOrInsert(
                ['id' => $role['id']],
                $role
            );
        }
    }
}
