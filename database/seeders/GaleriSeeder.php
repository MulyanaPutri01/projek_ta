<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run()
    {
        $galeris = [
            [
                'id' => 1,
                'tanggal' => '2026-08-15',
                'nama_foto' => 'Kajian Rutin Ahad Pagi',
                'gambar' => 'galeri_kajian.jpg',
                'kegiatan_id' => 1,
                'takmir_id' => 1,
            ],
            [
                'id' => 2,
                'tanggal' => '2026-08-20',
                'nama_foto' => 'Sholat Jumat Berjamaah',
                'gambar' => 'galeri_jumat.jpg',
                'kegiatan_id' => 2,
                'takmir_id' => 1,
            ],
            [
                'id' => 3,
                'tanggal' => '2026-08-25',
                'nama_foto' => 'Persiapan Maulid Nabi Muhammad SAW',
                'gambar' => 'galeri_maulid.jpg',
                'kegiatan_id' => 3,
                'takmir_id' => 1,
            ],
        ];

        foreach ($galeris as $galeri) {
            DB::table('galeri')->updateOrInsert(
                ['id' => $galeri['id']],
                $galeri
            );
        }
    }
}
