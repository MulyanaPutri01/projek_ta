<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTakmirTable extends Migration
{
    public function up()
    {
        Schema::table('takmir', function (Blueprint $table) {
            $table->foreign(['role_id'], 'takmir_role_fk')->references(['id'])->on('role')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('takmir', function (Blueprint $table) {
            $table->dropForeign('takmir_role_fk');
        });
    }
}
