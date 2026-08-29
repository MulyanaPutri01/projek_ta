<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        $barangs = [
            [
                'id' => 1,
                'nama_barang' => 'Sound System & Mixer Audio',
                'jumlah' => 2,
                'tahun_pembelian' => 2023,
                'lokasi' => 'Ruang Audio',
                'keterangan' => 'Paket mixer audio 8 channel dan speaker aktif masjid',
            ],
            [
                'id' => 2,
                'nama_barang' => 'Karpet Sajadah Turki',
                'jumlah' => 15,
                'tahun_pembelian' => 2024,
                'lokasi' => 'Ruang Utama',
                'keterangan' => 'Karpet sajadah premium tebal warna hijau motif kubah',
            ],
            [
                'id' => 3,
                'nama_barang' => 'AC Split Daikin 2 PK',
                'jumlah' => 4,
                'tahun_pembelian' => 2023,
                'lokasi' => 'Ruang Utama',
                'keterangan' => 'Pendingin ruangan inverter hemat listrik untuk kenyamanan ibadah',
            ],
            [
                'id' => 4,
                'nama_barang' => 'Kipas Angin Dinding',
                'jumlah' => 6,
                'tahun_pembelian' => 2022,
                'lokasi' => 'Serambi Samping',
                'keterangan' => 'Kipas angin tornado putar 18 inci',
            ],
            [
                'id' => 5,
                'nama_barang' => 'Mimbar Khutbah Jati',
                'jumlah' => 1,
                'tahun_pembelian' => 2021,
                'lokasi' => 'Mihrab Utama',
                'keterangan' => 'Mimbar kayu jati asli dengan ukiran kaligrafi Jepara',
            ],
            [
                'id' => 6,
                'nama_barang' => 'Jam Digital Waktu Sholat',
                'jumlah' => 1,
                'tahun_pembelian' => 2024,
                'lokasi' => 'Dinding Depan',
                'keterangan' => 'Display jadwal sholat otomatis dilengkapi alarm waktu adzan dan tartil',
            ],
            [
                'id' => 7,
                'nama_barang' => 'Proyektor & Layar Gantung',
                'jumlah' => 1,
                'tahun_pembelian' => 2023,
                'lokasi' => 'Ruang TPQ',
                'keterangan' => 'Proyektor resolusi HD dan layar 84 inci untuk kegiatan taklim',
            ],
        ];

        foreach ($barangs as $barang) {
            DB::table('inventaris')->updateOrInsert(
                ['id' => $barang['id']],
                $barang
            );
        }
    }
}
