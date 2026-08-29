<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->char('id_galeri', 3)->primary();
            $table->date('tanggal');
            $table->string('nama_foto', 50);
            $table->string('gambar', 20);
            $table->char('takmir_id_takmir', 3)->index('galeri_takmir_fk');
            $table->char('kegiatan_id_kegiatan', 2)->index('galeri_kegiatan_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galeri');
    }
}
