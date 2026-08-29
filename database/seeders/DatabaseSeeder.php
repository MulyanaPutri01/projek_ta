<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            TakmirSeeder::class,
            KategoriSeeder::class,
            PosisiSeeder::class,
            KondisiSeeder::class,
            ProfilMasjidSeeder::class,
            DonaturSeeder::class,
            KegiatanSeeder::class,
            KepanitiaanSeeder::class,
            KeuanganSeeder::class,
            InventarisSeeder::class,
            CatatanSeeder::class,
            GaleriSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
