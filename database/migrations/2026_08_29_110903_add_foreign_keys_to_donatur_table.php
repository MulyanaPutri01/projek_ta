<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDonaturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donatur', function (Blueprint $table) {
            $table->foreign(['takmir_id_takmir'], 'donatur_takmir_fk')->references(['id_takmir'])->on('takmir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donatur', function (Blueprint $table) {
            $table->dropForeign('donatur_takmir_fk');
        });
    }
}
