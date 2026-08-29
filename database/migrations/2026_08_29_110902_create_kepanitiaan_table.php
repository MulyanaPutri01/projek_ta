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
            $table->id();
            $table->unsignedBigInteger('kegiatan_id')->index('kepanitiaan_kegiatan_fk');
            $table->unsignedBigInteger('posisi_id')->index('kepanitiaan_posisi_fk');
            $table->unsignedBigInteger('takmir_id')->nullable()->index('kepanitiaan_takmir_fk');
            $table->string('jobdesk', 255);
            $table->timestamps();
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
