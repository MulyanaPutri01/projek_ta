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
            $table->char('id_keuangan', 5)->primary();
            $table->date('tanggal');
            $table->string('sumber_keuangan', 225)->nullable();
            $table->string('keterangan', 100);
            $table->integer('nominal');
            $table->char('takmir_id_takmir', 3)->index('keuangan_takmir_fk');
            $table->char('kategori_id_kategori', 2)->index('keuangan_kategori_fk');
            $table->char('donatur_id_donatur', 5)->nullable()->index('keuangan_donatur_fk');
            $table->char('kegiatan_id_kegiatan', 2)->nullable()->index('keuangan_kegiatan_fk');
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
