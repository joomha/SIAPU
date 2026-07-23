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
        Schema::table('jenis_surats', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_surats', 'jenis_validasi')) {
                $table->enum('jenis_validasi', ['langsung', 'tte_kades', 'basah'])->default('langsung')->after('template_konten');
            }
            if (!Schema::hasColumn('jenis_surats', 'kode_surat')) {
                $table->string('kode_surat', 50)->nullable()->after('jenis_validasi');
            }
            if (!Schema::hasColumn('jenis_surats', 'format_nomor')) {
                $table->string('format_nomor', 100)->nullable()->after('kode_surat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->dropColumn(['jenis_validasi', 'kode_surat', 'format_nomor']);
        });
    }
};
