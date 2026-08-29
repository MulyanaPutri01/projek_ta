<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;

class KeuanganPemasukanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tanggal' => '2026-07-22', 'sumber_keuangan' => 'Sumbangan Hari Raya Idul Adha',    'keterangan' => '', 'nominal' => 7500000, 'kategori_id' => 1, 'donatur_id' => 5, 'kegiatan_id' => 3, 'takmir_id' => 2],
            ['tanggal' => '2026-07-25', 'sumber_keuangan' => 'Infak Jumat Minggu Keempat',        'keterangan' => '', 'nominal' => 2050000, 'kategori_id' => 1, 'donatur_id' => 2, 'kegiatan_id' => null, 'takmir_id' => 1],
            ['tanggal' => '2026-08-05', 'sumber_keuangan' => 'Donasi Sound System Masjid',        'keterangan' => '', 'nominal' => 4000000, 'kategori_id' => 1, 'donatur_id' => 4, 'kegiatan_id' => 4, 'takmir_id' => 3],
            ['tanggal' => '2026-08-08', 'sumber_keuangan' => 'Infak Jumat Minggu Kedua Agustus', 'keterangan' => '', 'nominal' => 2250000, 'kategori_id' => 1, 'donatur_id' => 5, 'kegiatan_id' => null, 'takmir_id' => 2],
        ];

        foreach ($data as $d) {
            Keuangan::create($d);
        }

        $this->command->info('Berhasil insert ' . count($data) . ' data pemasukan tambahan. Total: ' . Keuangan::count());
    }
}
