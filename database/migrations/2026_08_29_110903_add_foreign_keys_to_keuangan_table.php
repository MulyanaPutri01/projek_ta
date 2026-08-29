<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreign(['kategori_id_kategori'], 'keuangan_kategori_fk')->references(['id_kategori'])->on('kategori');
            $table->foreign(['takmir_id_takmir'], 'keuangan_takmir_fk')->references(['id_takmir'])->on('takmir');
            $table->foreign(['donatur_id_donatur'], 'keuangan_donatur_fk')->references(['id_donatur'])->on('donatur');
            $table->foreign(['kegiatan_id_kegiatan'], 'keuangan_kegiatan_fk')->references(['id_kegiatan'])->on('kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
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
