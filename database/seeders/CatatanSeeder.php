<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatatanSeeder extends Seeder
{
    public function run()
    {
        $catatans = [
            [
                'id' => 1,
                'inventaris_id' => 1,
                'tanggal_catatan' => '2026-08-01',
                'kondisi_id' => 1,
                'takmir_id' => 3,
            ],
            [
                'id' => 2,
                'inventaris_id' => 2,
                'tanggal_catatan' => '2026-08-01',
                'kondisi_id' => 1,
                'takmir_id' => 3,
            ],
            [
                'id' => 3,
                'inventaris_id' => 3,
                'tanggal_catatan' => '2026-08-10',
                'kondisi_id' => 2,
                'takmir_id' => 3,
            ],
            [
                'id' => 4,
                'inventaris_id' => 4,
                'tanggal_catatan' => '2026-08-15',
                'kondisi_id' => 2,
                'takmir_id' => 3,
            ],
            [
                'id' => 5,
                'inventaris_id' => 5,
                'tanggal_catatan' => '2026-08-01',
                'kondisi_id' => 1,
                'takmir_id' => 3,
            ],
            [
                'id' => 6,
                'inventaris_id' => 6,
                'tanggal_catatan' => '2026-08-20',
                'kondisi_id' => 1,
                'takmir_id' => 3,
            ],
            [
                'id' => 7,
                'inventaris_id' => 7,
                'tanggal_catatan' => '2026-08-22',
                'kondisi_id' => 2,
                'takmir_id' => 3,
            ],
        ];

        foreach ($catatans as $catatan) {
            DB::table('catatan')->updateOrInsert(
                ['id' => $catatan['id']],
                $catatan
            );
        }
    }
}
