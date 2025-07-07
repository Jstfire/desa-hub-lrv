<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Drop the existing enum column and recreate it with correct values
            $table->dropColumn('status');
        });

        Schema::table('pengaduan', function (Blueprint $table) {
            // Add the status column back with the correct enum values
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pengaduan', function (Blueprint $table) {
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru');
        });
    }
};
