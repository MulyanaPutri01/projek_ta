<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDonaturTable extends Migration
{
    public function up()
    {
        Schema::table('donatur', function (Blueprint $table) {
            $table->foreign(['takmir_id'], 'donatur_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('donatur', function (Blueprint $table) {
            $table->dropForeign('donatur_takmir_fk');
        });
    }
}
