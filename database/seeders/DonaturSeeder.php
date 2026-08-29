<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonaturSeeder extends Seeder
{
    public function run()
    {
        $donaturs = [
            [
                'id' => 1,
                'tanggal' => '2026-08-01',
                'nama_donatur' => 'H. Ahmad Dahlan',
                'alamat' => 'Jl. Melati No. 12, Karangmulya',
                'takmir_id' => 2,
            ],
            [
                'id' => 2,
                'tanggal' => '2026-08-05',
                'nama_donatur' => 'Hj. Siti Aminah',
                'alamat' => 'Jl. Mawar No. 45, Suradadi',
                'takmir_id' => 2,
            ],
            [
                'id' => 3,
                'tanggal' => '2026-08-10',
                'nama_donatur' => 'Bpk. Bambang Pamungkas',
                'alamat' => 'Komplek Griya Indah Blok B3',
                'takmir_id' => 2,
            ],
            [
                'id' => 4,
                'tanggal' => '2026-08-15',
                'nama_donatur' => 'Ibu Hj. Khadijah',
                'alamat' => 'Jl. Kenanga No. 88, Tegal',
                'takmir_id' => 2,
            ],
            [
                'id' => 5,
                'tanggal' => '2026-08-20',
                'nama_donatur' => 'Hamba Allah (Anonim)',
                'alamat' => 'Desa Karangmulya, Suradadi',
                'takmir_id' => 2,
            ],
        ];

        foreach ($donaturs as $donatur) {
            DB::table('donatur')->updateOrInsert(
                ['id' => $donatur['id']],
                $donatur
            );
        }
    }
}
