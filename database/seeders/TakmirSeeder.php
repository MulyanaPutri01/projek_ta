<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Takmir;

class TakmirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Takmir::updateOrInsert(
            ['id_takmir' => 'T01'],
            [
                'username' => 'adminuser',
                'password' => bcrypt('adminpassword'),
                'status' => 'active',
                'role_id_role' => '001',
                'nama_takmir' => 'Admin User',
            ]
        );

        Takmir::updateOrInsert(
            ['id_takmir' => 'T02'],
            [
                'username' => 'bendaharauser',
                'password' => bcrypt('bendahara'),
                'status' => 'active',
                'role_id_role' => '002',
                'nama_takmir' => 'Bendahara User',
            ]
        );

        Takmir::updateOrInsert(
            ['id_takmir' => 'T03'],
            [
                'username' => 'sekretarisuser',
                'password' => bcrypt('sekretaris'),
                'status' => 'active',
                'role_id_role' => '003',
                'nama_takmir' => 'Sekretaris User',
            ]
        );
    }
}
