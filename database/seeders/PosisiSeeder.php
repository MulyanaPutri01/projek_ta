<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosisiSeeder extends Seeder
{
    public function run()
    {
        $posisis = [
            ['id' => 1, 'nama_posisi' => 'Ketua Panitia'],
            ['id' => 2, 'nama_posisi' => 'Sekretaris'],
            ['id' => 3, 'nama_posisi' => 'Bendahara'],
            ['id' => 4, 'nama_posisi' => 'Seksi Acara'],
            ['id' => 5, 'nama_posisi' => 'Seksi Konsumsi'],
            ['id' => 6, 'nama_posisi' => 'Perlengkapan'],
            ['id' => 7, 'nama_posisi' => 'Humas & Media'],
        ];

        foreach ($posisis as $posisi) {
            DB::table('posisi')->updateOrInsert(
                ['id' => $posisi['id']],
                $posisi
            );
        }
    }
}
