<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToKepanitiaanTable extends Migration
{
    public function up()
    {
        Schema::table('kepanitiaan', function (Blueprint $table) {
            $table->foreign(['kegiatan_id'], 'kepanitiaan_kegiatan_fk')->references(['id'])->on('kegiatan')->onDelete('cascade');
            $table->foreign(['posisi_id'], 'kepanitiaan_posisi_fk')->references(['id'])->on('posisi')->onDelete('cascade');
            $table->foreign(['takmir_id'], 'kepanitiaan_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('kepanitiaan', function (Blueprint $table) {
            $table->dropForeign('kepanitiaan_kegiatan_fk');
            $table->dropForeign('kepanitiaan_posisi_fk');
            $table->dropForeign('kepanitiaan_takmir_fk');
        });
    }
}
