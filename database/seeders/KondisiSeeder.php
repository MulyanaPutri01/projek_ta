<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KondisiSeeder extends Seeder
{
    public function run()
    {
        $kondisis = [
            ['id' => 1, 'nama_kondisi' => 'Sangat Baik'],
            ['id' => 2, 'nama_kondisi' => 'Baik'],
            ['id' => 3, 'nama_kondisi' => 'Rusak Ringan'],
            ['id' => 4, 'nama_kondisi' => 'Rusak Berat'],
        ];

        foreach ($kondisis as $kondisi) {
            DB::table('kondisi')->updateOrInsert(
                ['id' => $kondisi['id']],
                $kondisi
            );
        }
    }
}
