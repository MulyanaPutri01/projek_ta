<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        $transaksis = [
            [
                'id' => 1,
                'tanggal' => '2026-08-01',
                'sumber_keuangan' => 'Infaq Kotak Jumat',
                'keterangan' => 'Infaq jamaah sholat jumat pekan ke-1 bulan Agustus',
                'nominal' => 3500000,
                'kategori_id' => 1,
                'donatur_id' => null,
                'kegiatan_id' => 2,
                'takmir_id' => 2,
            ],
            [
                'id' => 2,
                'tanggal' => '2026-08-05',
                'sumber_keuangan' => 'Donasi Infaq Karpet',
                'keterangan' => 'Sumbangan pengadaan karpet sajadah utama dari donatur',
                'nominal' => 5000000,
                'kategori_id' => 1,
                'donatur_id' => 1,
                'kegiatan_id' => null,
                'takmir_id' => 2,
            ],
            [
                'id' => 3,
                'tanggal' => '2026-08-07',
                'sumber_keuangan' => 'Kas Operasional',
                'keterangan' => 'Pembayaran tagihan listrik PLN dan air PDAM bulan berjalan',
                'nominal' => 850000,
                'kategori_id' => 2,
                'donatur_id' => null,
                'kegiatan_id' => null,
                'takmir_id' => 2,
            ],
            [
                'id' => 4,
                'tanggal' => '2026-08-10',
                'sumber_keuangan' => 'Infaq Donatur Tetap',
                'keterangan' => 'Infaq rutin bulanan donatur tetap',
                'nominal' => 2000000,
                'kategori_id' => 1,
                'donatur_id' => 2,
                'kegiatan_id' => null,
                'takmir_id' => 2,
            ],
            [
                'id' => 5,
                'tanggal' => '2026-08-12',
                'sumber_keuangan' => 'Kas Pendidikan',
                'keterangan' => 'Honorarium dan bisyarah ustadz/ustadzah pengajar TPQ',
                'nominal' => 1500000,
                'kategori_id' => 2,
                'donatur_id' => null,
                'kegiatan_id' => 5,
                'takmir_id' => 2,
            ],
            [
                'id' => 6,
                'tanggal' => '2026-08-15',
                'sumber_keuangan' => 'Infaq Peringatan Maulid',
                'keterangan' => 'Donasi khusus warga untuk penyelenggaraan Maulid Nabi',
                'nominal' => 4000000,
                'kategori_id' => 1,
                'donatur_id' => 4,
                'kegiatan_id' => 3,
                'takmir_id' => 2,
            ],
            [
                'id' => 7,
                'tanggal' => '2026-08-18',
                'sumber_keuangan' => 'Kas Kebersihan',
                'keterangan' => 'Pembelian peralatan kebersihan, sabun, dan pengharum ruangan',
                'nominal' => 350000,
                'kategori_id' => 2,
                'donatur_id' => null,
                'kegiatan_id' => null,
                'takmir_id' => 2,
            ],
            [
                'id' => 8,
                'tanggal' => '2026-08-20',
                'sumber_keuangan' => 'Sedekah Pembangunan Kanopi',
                'keterangan' => 'Infaq hamba Allah untuk penambahan kanopi serambi samping',
                'nominal' => 2500000,
                'kategori_id' => 1,
                'donatur_id' => 5,
                'kegiatan_id' => null,
                'takmir_id' => 2,
            ],
            [
                'id' => 9,
                'tanggal' => '2026-08-22',
                'sumber_keuangan' => 'Kas Acara Maulid',
                'keterangan' => 'Pembayaran uang muka (DP) sewa tenda dan panggung maulid',
                'nominal' => 1200000,
                'kategori_id' => 2,
                'donatur_id' => null,
                'kegiatan_id' => 3,
                'takmir_id' => 2,
            ],
            [
                'id' => 10,
                'tanggal' => '2026-08-28',
                'sumber_keuangan' => 'Infaq Kotak Jumat',
                'keterangan' => 'Infaq jamaah sholat jumat pekan ke-4 bulan Agustus',
                'nominal' => 3800000,
                'kategori_id' => 1,
                'donatur_id' => null,
                'kegiatan_id' => 2,
                'takmir_id' => 2,
            ],
        ];

        foreach ($transaksis as $transaksi) {
            DB::table('keuangan')->updateOrInsert(
                ['id' => $transaksi['id']],
                $transaksi
            );
        }
    }
}
