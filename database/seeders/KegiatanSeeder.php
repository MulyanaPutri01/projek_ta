<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        $kegiatans = [
            [
                'id' => 1,
                'nama_kegiatan' => 'Kajian Ahad Pagi',
                'tanggal' => '2026-09-06',
                'mulai_kegiatan' => '06:00:00',
                'akhir_kegiatan' => '07:30:00',
                'nama_waktu' => 'Pagi',
                'pembicara' => 'Ust. Abdul Somad, Lc',
                'nama_khotib' => '-',
                'nama_muadzin' => 'Bilal Hasan',
                'tempat' => 'Ruang Utama Masjid',
                'audience' => 'Jamaah Umum',
            ],
            [
                'id' => 2,
                'nama_kegiatan' => 'Sholat Jumat & Khutbah',
                'tanggal' => '2026-09-04',
                'mulai_kegiatan' => '11:45:00',
                'akhir_kegiatan' => '12:45:00',
                'nama_waktu' => 'Siang',
                'pembicara' => 'K.H. Mustofa Bisri',
                'nama_khotib' => 'K.H. Mustofa Bisri',
                'nama_muadzin' => 'Ust. Ridwan',
                'tempat' => 'Masjid Al-Ikhlas',
                'audience' => 'Kaum Muslimin',
            ],
            [
                'id' => 3,
                'nama_kegiatan' => 'Peringatan Maulid Nabi Muhammad SAW',
                'tanggal' => '2026-09-15',
                'mulai_kegiatan' => '19:30:00',
                'akhir_kegiatan' => '22:30:00',
                'nama_waktu' => 'Malam',
                'pembicara' => 'Habib Syech Assegaf',
                'nama_khotib' => '-',
                'nama_muadzin' => '-',
                'tempat' => 'Halaman Masjid',
                'audience' => 'Masyarakat Luas',
            ],
            [
                'id' => 4,
                'nama_kegiatan' => 'Santunan Anak Yatim & Dhuafa',
                'tanggal' => '2026-09-20',
                'mulai_kegiatan' => '08:30:00',
                'akhir_kegiatan' => '11:30:00',
                'nama_waktu' => 'Pagi',
                'pembicara' => 'Ust. Fadlan Garamatan',
                'nama_khotib' => '-',
                'nama_muadzin' => '-',
                'tempat' => 'Serambi Masjid',
                'audience' => 'Anak Yatim & Dhuafa',
            ],
            [
                'id' => 5,
                'nama_kegiatan' => 'Bimbingan TPQ & Tahsin Al-Quran',
                'tanggal' => '2026-09-07',
                'mulai_kegiatan' => '16:00:00',
                'akhir_kegiatan' => '17:30:00',
                'nama_waktu' => 'Sore',
                'pembicara' => 'Ustadzah Fatimah',
                'nama_khotib' => '-',
                'nama_muadzin' => '-',
                'tempat' => 'Ruang TPQ',
                'audience' => 'Santri TPQ',
            ],
        ];

        foreach ($kegiatans as $kegiatan) {
            DB::table('kegiatan')->updateOrInsert(
                ['id' => $kegiatan['id']],
                $kegiatan
            );
        }
    }
}
