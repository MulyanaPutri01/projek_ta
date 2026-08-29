<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCatatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catatan', function (Blueprint $table) {
            $table->foreign(['kondisi_id_kondisi'], 'catatan_kondisi_fk')->references(['id_kondisi'])->on('kondisi');
            $table->foreign(['inventaris_id_inventaris'], 'catatan_inventaris_fk')->references(['id_inventaris'])->on('inventaris');
            $table->foreign(['takmir_id_takmir'], 'catatan_takmir_fk')->references(['id_takmir'])->on('takmir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catatan', function (Blueprint $table) {
            $table->dropForeign('catatan_kondisi_fk');
            $table->dropForeign('catatan_inventaris_fk');
            $table->dropForeign('catatan_takmir_fk');
        });
    }
}
