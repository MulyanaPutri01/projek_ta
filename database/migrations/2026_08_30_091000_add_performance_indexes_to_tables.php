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
        // 1. Indexes on Keuangan table for fast date filtering, trends, and financial reports
        Schema::table('keuangan', function (Blueprint $table) {
            $table->index('tanggal', 'keuangan_tanggal_idx');
            $table->index(['kategori_id', 'tanggal'], 'keuangan_kategori_tanggal_idx');
        });

        // 2. Index on Kegiatan table for agenda timeline and calendar queries
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->index('tanggal', 'kegiatan_tanggal_idx');
        });

        // 3. Index on Catatan table for fast latest condition lookups
        Schema::table('catatan', function (Blueprint $table) {
            $table->index(['inventaris_id', 'tanggal_catatan'], 'catatan_inv_tanggal_idx');
        });

        // 4. Index on Donatur table for date filtering
        Schema::table('donatur', function (Blueprint $table) {
            $table->index('tanggal', 'donatur_tanggal_idx');
        });

        // 5. Index on Galeri table for timeline ordering
        Schema::table('galeri', function (Blueprint $table) {
            $table->index('tanggal', 'galeri_tanggal_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropIndex('keuangan_tanggal_idx');
            $table->dropIndex('keuangan_kategori_tanggal_idx');
        });

        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropIndex('kegiatan_tanggal_idx');
        });

        Schema::table('catatan', function (Blueprint $table) {
            $table->dropIndex('catatan_inv_tanggal_idx');
        });

        Schema::table('donatur', function (Blueprint $table) {
            $table->dropIndex('donatur_tanggal_idx');
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->dropIndex('galeri_tanggal_idx');
        });
    }
};
