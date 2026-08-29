<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan', function (Blueprint $table) {
            $table->char('id_catatan', 3)->primary();
            $table->char('inventaris_id_inventaris', 3)->index('catatan_inventaris_fk');
            $table->date('tanggal_catatan');
            $table->char('takmir_id_takmir', 3)->index('catatan_takmir_fk');
            $table->char('kondisi_id_kondisi', 2)->index('catatan_kondisi_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catatan');
    }
}
