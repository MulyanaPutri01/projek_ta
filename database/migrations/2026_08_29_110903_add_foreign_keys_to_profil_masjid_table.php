<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProfilMasjidTable extends Migration
{
    public function up()
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->foreign(['takmir_id'], 'profil_masjid_takmir_fk')->references(['id'])->on('takmir')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->dropForeign('profil_masjid_takmir_fk');
        });
    }
}
