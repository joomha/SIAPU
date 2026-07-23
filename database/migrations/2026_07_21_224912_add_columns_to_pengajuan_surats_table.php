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
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_surats', 'nomor_surat')) {
                $table->string('nomor_surat')->nullable()->after('tanggal_pengajuan');
            }
            if (!Schema::hasColumn('pengajuan_surats', 'file_persyaratan')) {
                $table->json('file_persyaratan')->nullable()->after('nomor_surat');
            }
            if (Schema::hasColumn('pengajuan_surats', 'catatan')) {
                $table->renameColumn('catatan', 'catatan_admin');
            } elseif (!Schema::hasColumn('pengajuan_surats', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable();
            }
            
            // Alter enum status using raw DB statement because DBAL might have issues with enums
            \DB::statement("ALTER TABLE pengajuan_surats MODIFY COLUMN status VARCHAR(255) DEFAULT 'Menunggu'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'file_persyaratan']);
            if (Schema::hasColumn('pengajuan_surats', 'catatan_admin')) {
                $table->renameColumn('catatan_admin', 'catatan');
            }
        });
    }
};
