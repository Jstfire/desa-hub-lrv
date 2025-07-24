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
        Schema::table('metadata', function (Blueprint $table) {
            $table->integer('download_count')->default(0)->after('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metadata', function (Blueprint $table) {
            $table->dropColumn('download_count');
        });
    }
};
