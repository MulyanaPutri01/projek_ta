<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan', 150);
            $table->date('tanggal');
            $table->time('mulai_kegiatan');
            $table->time('akhir_kegiatan');
            $table->string('nama_waktu', 50)->nullable();
            $table->string('pembicara', 100)->nullable();
            $table->string('nama_khotib', 100)->nullable();
            $table->string('nama_muadzin', 100)->nullable();
            $table->string('tempat', 100);
            $table->string('audience', 100)->nullable();
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
        Schema::dropIfExists('kegiatan');
    }
}
