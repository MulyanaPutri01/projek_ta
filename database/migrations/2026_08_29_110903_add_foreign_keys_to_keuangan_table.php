<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToKeuanganTable extends Migration
{
    public function up()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreign(['kategori_id'], 'keuangan_kategori_fk')->references(['id'])->on('kategori')->onDelete('cascade');
            $table->foreign(['takmir_id'], 'keuangan_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
            $table->foreign(['donatur_id'], 'keuangan_donatur_fk')->references(['id'])->on('donatur')->onDelete('set null');
            $table->foreign(['kegiatan_id'], 'keuangan_kegiatan_fk')->references(['id'])->on('kegiatan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropForeign('keuangan_kategori_fk');
            $table->dropForeign('keuangan_takmir_fk');
            $table->dropForeign('keuangan_donatur_fk');
            $table->dropForeign('keuangan_kegiatan_fk');
        });
    }
}
