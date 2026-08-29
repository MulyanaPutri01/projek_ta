<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['id' => 1, 'nama_kategori' => 'Pemasukan'],
            ['id' => 2, 'nama_kategori' => 'Pengeluaran'],
        ];

        foreach ($kategoris as $kategori) {
            DB::table('kategori')->updateOrInsert(
                ['id' => $kategori['id']],
                $kategori
            );
        }
    }
}
