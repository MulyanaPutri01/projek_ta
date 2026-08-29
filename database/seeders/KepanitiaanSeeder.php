<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepanitiaanSeeder extends Seeder
{
    public function run()
    {
        $panitias = [
            [
                'id' => 1,
                'kegiatan_id' => 3,
                'jobdesk' => 'Mengkoordinasikan seluruh panitia dan jalannya peringatan Maulid Nabi',
                'posisi_id' => 1,
                'takmir_id' => 3,
            ],
            [
                'id' => 2,
                'kegiatan_id' => 3,
                'jobdesk' => 'Menyiapkan surat undangan, proposal, dan daftar hadir jamaah',
                'posisi_id' => 2,
                'takmir_id' => 3,
            ],
            [
                'id' => 3,
                'kegiatan_id' => 3,
                'jobdesk' => 'Mencatat donasi masuk dan mengelola pengeluaran acara maulid',
                'posisi_id' => 3,
                'takmir_id' => 3,
            ],
            [
                'id' => 4,
                'kegiatan_id' => 3,
                'jobdesk' => 'Menyusun rundown acara dan mendampingi penceramah tamu',
                'posisi_id' => 4,
                'takmir_id' => 3,
            ],
            [
                'id' => 5,
                'kegiatan_id' => 4,
                'jobdesk' => 'Mempersiapkan paket sembako dan santunan tunai untuk dhuafa',
                'posisi_id' => 5,
                'takmir_id' => 3,
            ],
            [
                'id' => 6,
                'kegiatan_id' => 4,
                'jobdesk' => 'Menyiapkan tenda, sound system, kursi, dan panggung santunan',
                'posisi_id' => 6,
                'takmir_id' => 3,
            ],
        ];

        foreach ($panitias as $panitia) {
            DB::table('kepanitiaan')->updateOrInsert(
                ['id' => $panitia['id']],
                $panitia
            );
        }
    }
}
