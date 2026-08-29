<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakmirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takmir', function (Blueprint $table) {
            $table->char('id_takmir', 3)->primary();
            $table->string('username', 30);
            $table->string('password', 225);
            $table->string('status', 10);
            $table->char('role_id_role', 3)->index('takmir_role_fk');
            $table->string('nama_takmir', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('takmir');
    }
}
