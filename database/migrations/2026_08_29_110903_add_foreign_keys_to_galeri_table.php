<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGaleriTable extends Migration
{
    public function up()
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->foreign(['kegiatan_id'], 'galeri_kegiatan_fk')->references(['id'])->on('kegiatan')->onDelete('set null');
            $table->foreign(['takmir_id'], 'galeri_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->dropForeign('galeri_kegiatan_fk');
            $table->dropForeign('galeri_takmir_fk');
        });
    }
}
