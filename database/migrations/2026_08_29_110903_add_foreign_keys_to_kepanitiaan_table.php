<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToKepanitiaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepanitiaan', function (Blueprint $table) {
            $table->foreign(['posisi_id_posisi'], 'kepanitiaan_posisi_fk')->references(['id_posisi'])->on('posisi');
            $table->foreign(['kegiatan_id_kegiatan'], 'kepanitiaan_kegiatan_fk')->references(['id_kegiatan'])->on('kegiatan');
            $table->foreign(['takmir_id_takmir'], 'kepanitiaan_takmir_fk')->references(['id_takmir'])->on('takmir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepanitiaan', function (Blueprint $table) {
            $table->dropForeign('kepanitiaan_posisi_fk');
            $table->dropForeign('kepanitiaan_kegiatan_fk');
            $table->dropForeign('kepanitiaan_takmir_fk');
        });
    }
}
