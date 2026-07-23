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
            $table->string('file_akta_kelahiran')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('file_foto')->nullable();
            $table->string('file_ijazah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn([
                'file_akta_kelahiran', 
                'file_npwp', 
                'file_foto', 
                'file_ijazah'
            ]);
        });
    }
};
