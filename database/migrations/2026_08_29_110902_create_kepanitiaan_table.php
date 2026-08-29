<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepanitiaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepanitiaan', function (Blueprint $table) {
            $table->char('id_panitia', 3)->primary();
            $table->char('posisi_id_posisi', 2)->index('kepanitiaan_posisi_fk');
            $table->char('takmir_id_takmir', 3)->index('kepanitiaan_takmir_fk');
            $table->char('kegiatan_id_kegiatan', 2)->index('kepanitiaan_kegiatan_fk');
            $table->string('jobdesk', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kepanitiaan');
    }
}
