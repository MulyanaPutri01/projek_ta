<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;

class KeuanganDummySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // PENGELUARAN (10 data)
            ['tanggal' => '2026-07-05', 'sumber_keuangan' => null, 'keterangan' => 'Pembelian Sajadah Baru 10 lembar', 'nominal' => 1200000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 1],
            ['tanggal' => '2026-07-09', 'sumber_keuangan' => null, 'keterangan' => 'Biaya Listrik dan Air Bulan Juli', 'nominal' => 450000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 2],
            ['tanggal' => '2026-07-13', 'sumber_keuangan' => null, 'keterangan' => 'Honor Imam dan Muadzin Juli', 'nominal' => 600000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 1],
            ['tanggal' => '2026-07-16', 'sumber_keuangan' => null, 'keterangan' => 'Perlengkapan Hewan Kurban Idul Adha', 'nominal' => 2800000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => 3, 'takmir_id' => 3],
            ['tanggal' => '2026-07-20', 'sumber_keuangan' => null, 'keterangan' => 'Pembelian Al-Quran 20 buah', 'nominal' => 800000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => 2, 'takmir_id' => 2],
            ['tanggal' => '2026-07-28', 'sumber_keuangan' => null, 'keterangan' => 'Biaya Kebersihan dan Perawatan Masjid', 'nominal' => 300000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 1],
            ['tanggal' => '2026-08-02', 'sumber_keuangan' => null, 'keterangan' => 'Biaya Listrik dan Air Bulan Agustus', 'nominal' => 475000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 2],
            ['tanggal' => '2026-08-06', 'sumber_keuangan' => null, 'keterangan' => 'Biaya Perbaikan Sound System', 'nominal' => 950000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => 4, 'takmir_id' => 3],
            ['tanggal' => '2026-08-10', 'sumber_keuangan' => null, 'keterangan' => 'Honor Imam dan Muadzin Agustus', 'nominal' => 600000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => null, 'takmir_id' => 1],
            ['tanggal' => '2026-08-12', 'sumber_keuangan' => null, 'keterangan' => 'Pembelian Perlengkapan Majelis Taklim', 'nominal' => 350000, 'kategori_id' => 2, 'donatur_id' => null, 'kegiatan_id' => 5, 'takmir_id' => 2],
        ];

        foreach ($data as $d) {
            Keuangan::create($d);
        }

        $this->command->info('Berhasil insert ' . count($data) . ' data pengeluaran. Total: ' . Keuangan::count());
    }
}
