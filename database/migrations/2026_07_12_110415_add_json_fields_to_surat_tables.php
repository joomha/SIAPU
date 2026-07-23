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
            if (!Schema::hasColumn('jenis_surats', 'form_isian')) {
                $table->json('form_isian')->nullable()->after('deskripsi');
            }
        });
        
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_surats', 'data_isian')) {
                $table->json('data_isian')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->dropColumn('form_isian');
        });
        
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn('data_isian');
        });
    }
};
