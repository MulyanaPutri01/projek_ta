<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TakmirSeeder extends Seeder
{
    public function run()
    {
        $takmirs = [
            [
                'id' => 1,
                'username' => 'adminuser',
                'password' => bcrypt('adminpassword'),
                'status' => 'active',
                'role_id' => 1,
                'nama_takmir' => 'Admin User',
            ],
            [
                'id' => 2,
                'username' => 'bendaharauser',
                'password' => bcrypt('bendahara'),
                'status' => 'active',
                'role_id' => 2,
                'nama_takmir' => 'Bendahara User',
            ],
            [
                'id' => 3,
                'username' => 'sekretarisuser',
                'password' => bcrypt('sekretaris'),
                'status' => 'active',
                'role_id' => 3,
                'nama_takmir' => 'Sekretaris User',
            ],
        ];

        foreach ($takmirs as $takmir) {
            DB::table('takmir')->updateOrInsert(
                ['id' => $takmir['id']],
                $takmir
            );
        }
    }
}
