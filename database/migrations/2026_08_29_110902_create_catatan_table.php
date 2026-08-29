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
            $table->id();
            $table->unsignedBigInteger('inventaris_id')->index('catatan_inventaris_fk');
            $table->date('tanggal_catatan');
            $table->unsignedBigInteger('kondisi_id')->index('catatan_kondisi_fk');
            $table->unsignedBigInteger('takmir_id')->nullable()->index('catatan_takmir_fk');
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
        Schema::dropIfExists('catatan');
    }
}
