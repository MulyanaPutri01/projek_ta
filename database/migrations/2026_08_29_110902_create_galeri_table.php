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
            $table->id();
            $table->date('tanggal');
            $table->string('nama_foto', 100);
            $table->string('gambar', 255);
            $table->unsignedBigInteger('kegiatan_id')->nullable()->index('galeri_kegiatan_fk');
            $table->unsignedBigInteger('takmir_id')->nullable()->index('galeri_takmir_fk');
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
        Schema::dropIfExists('galeri');
    }
}
