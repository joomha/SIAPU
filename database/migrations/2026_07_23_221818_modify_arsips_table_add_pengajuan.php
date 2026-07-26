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
        Schema::table('arsips', function (Blueprint $table) {
            $table->foreignId('surat_id')->nullable()->change();
            $table->foreignId('pengajuan_surat_id')->nullable()->after('surat_id')->constrained('pengajuan_surats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsips', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_surat_id']);
            $table->dropColumn('pengajuan_surat_id');
            // Reverting surat_id to non-nullable might fail if there are null rows, so we leave it nullable or handle carefully.
            // Ideally: $table->foreignId('surat_id')->nullable(false)->change();
        });
    }
};
