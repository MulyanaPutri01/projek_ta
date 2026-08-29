<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilMasjidSeeder extends Seeder
{
    public function run()
    {
        DB::table('profil_masjid')->updateOrInsert(
            ['id' => 1],
            [
                'id' => 1,
                'nama_masjid' => 'Masjid Jami Al-Ikhlas',
                'sejarah' => 'Masjid Al-Ikhlas didirikan pada tahun 1985 oleh para tokoh masyarakat Desa Karangmulya sebagai pusat ibadah, pendidikan Al-Quran, dan silaturahmi warga. Seiring berjalannya waktu, masjid terus mengalami renovasi dan perluasan fisik demi menampung jamaah sholat berjamaah dan kegiatan keagamaan yang semakin aktif.',
                'visi' => 'Menjadikan Masjid Al-Ikhlas sebagai pusat pembinaan keimanan, pendidikan islami, dan pemberdayaan ekonomi umat yang makmur, mandiri, dan penuh berkah.',
                'misi' => "1. Menyelenggarakan ibadah sholat lima waktu dan sholat jumat secara tertib, nyaman, dan khusyuk.\n2. Mengadakan kajian keislaman tematik serta pembinaan TPQ bagi generasi muda.\n3. Mengelola keuangan masjid, infaq, dan shodaqoh secara transparan dan akuntabel.\n4. Membangun solidaritas sosial kemasyarakatan dan kepedulian terhadap kaum dhuafa.",
                'alamat' => 'Jl. Raya Karangmulya RT 02 / RW 01, Kec. Suradadi, Kab. Tegal, Jawa Tengah',
                'telepon' => '081234567890',
                'takmir_id' => 1,
            ]
        );
    }
}
