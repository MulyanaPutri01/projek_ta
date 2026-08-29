<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCatatanTable extends Migration
{
    public function up()
    {
        Schema::table('catatan', function (Blueprint $table) {
            $table->foreign(['inventaris_id'], 'catatan_inventaris_fk')->references(['id'])->on('inventaris')->onDelete('cascade');
            $table->foreign(['kondisi_id'], 'catatan_kondisi_fk')->references(['id'])->on('kondisi')->onDelete('cascade');
            $table->foreign(['takmir_id'], 'catatan_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('catatan', function (Blueprint $table) {
            $table->dropForeign('catatan_inventaris_fk');
            $table->dropForeign('catatan_kondisi_fk');
            $table->dropForeign('catatan_takmir_fk');
        });
    }
}
