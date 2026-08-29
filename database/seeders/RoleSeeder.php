<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('role')->insert([
          //  ['id_role' => '1', 'nama_role' => 'admin'],
            //['id_role' => '2', 'nama_role' => 'bendahara'],
            //['id_role' => '3', 'nama_role' => 'sekretaris'],
        //]);

        DB::table('role')->updateOrInsert(
            ['id_role' => '001'],
            ['nama_role' => 'admin']
        );
        DB::table('role')->updateOrInsert(
            ['id_role' => '002'],
            ['nama_role' => 'bendahara']
        );
        DB::table('role')->updateOrInsert(
            ['id_role' => '003'],
            ['nama_role' => 'sekretaris']
        );

    }
}
