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
        Schema::table('wargas', function (Blueprint $table) {
            $table->string('file_ktp')->nullable()->after('status_perkawinan');
            $table->string('file_kk')->nullable()->after('file_ktp');
        });

        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->json('persyaratan_dokumen')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn(['file_ktp', 'file_kk']);
        });

        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->dropColumn('persyaratan_dokumen');
        });
    }
};
