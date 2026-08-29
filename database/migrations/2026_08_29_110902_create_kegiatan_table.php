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
            $table->char('id_kegiatan', 2)->primary();
            $table->string('nama_kegiatan', 20);
            $table->date('tanggal');
            $table->time('mulai_kegiatan');
            $table->time('akhir_kegiatan');
            $table->string('nama_waktu', 30);
            $table->string('pembicara', 30);
            $table->string('nama_khotib', 30);
            $table->string('nama_muadzin', 30);
            $table->string('tempat', 30);
            $table->string('audience', 30);
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
