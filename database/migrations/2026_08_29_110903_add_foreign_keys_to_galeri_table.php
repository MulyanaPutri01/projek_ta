<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGaleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->foreign(['takmir_id_takmir'], 'galeri_takmir_fk')->references(['id_takmir'])->on('takmir');
            $table->foreign(['kegiatan_id_kegiatan'], 'galeri_kegiatan_fk')->references(['id_kegiatan'])->on('kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->dropForeign('galeri_takmir_fk');
            $table->dropForeign('galeri_kegiatan_fk');
        });
    }
}
