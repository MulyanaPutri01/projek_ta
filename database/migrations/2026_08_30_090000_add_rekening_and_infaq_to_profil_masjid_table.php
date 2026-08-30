<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->string('nama_bank', 100)->nullable()->default('BANK SYARIAH INDONESIA (BSI)')->after('telepon');
            $table->string('nomor_rekening', 50)->nullable()->default('7145-8890-2101')->after('nama_bank');
            $table->string('atas_nama', 100)->nullable()->default('Takmir Masjid Jami Al-Ikhlas')->after('nomor_rekening');
            $table->string('judul_infaq', 150)->nullable()->default('Salurkan Infaq Terbaik Anda')->after('atas_nama');
            $table->text('deskripsi_infaq')->nullable()->after('judul_infaq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_masjid', function (Blueprint $table) {
            $table->dropColumn([
                'nama_bank',
                'nomor_rekening',
                'atas_nama',
                'judul_infaq',
                'deskripsi_infaq',
            ]);
        });
    }
};
