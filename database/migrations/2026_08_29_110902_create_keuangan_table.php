<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('sumber_keuangan', 255)->nullable();
            $table->string('keterangan', 255);
            $table->bigInteger('nominal');
            $table->unsignedBigInteger('kategori_id')->index('keuangan_kategori_fk');
            $table->unsignedBigInteger('donatur_id')->nullable()->index('keuangan_donatur_fk');
            $table->unsignedBigInteger('kegiatan_id')->nullable()->index('keuangan_kegiatan_fk');
            $table->unsignedBigInteger('takmir_id')->nullable()->index('keuangan_takmir_fk');
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
        Schema::dropIfExists('keuangan');
    }
}
