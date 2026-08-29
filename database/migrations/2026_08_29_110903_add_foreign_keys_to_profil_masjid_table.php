<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProfilMasjidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->foreign(['takmir_id_takmir'], 'profil_masjid_takmir_fk')->references(['id_takmir'])->on('takmir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->dropForeign('profil_masjid_takmir_fk');
        });
    }
}
