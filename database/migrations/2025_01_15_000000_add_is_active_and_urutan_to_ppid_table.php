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
        Schema::table('ppid', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('is_published');
            $table->integer('urutan')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppid', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'urutan']);
        });
    }
};