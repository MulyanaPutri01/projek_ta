<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTakmirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('takmir', function (Blueprint $table) {
            $table->foreign(['role_id_role'], 'takmir_role_fk')->references(['id_role'])->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('takmir', function (Blueprint $table) {
            $table->dropForeign('takmir_role_fk');
        });
    }
}
