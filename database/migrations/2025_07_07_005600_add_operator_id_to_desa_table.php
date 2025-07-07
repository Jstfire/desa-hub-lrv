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
        Schema::table('desa', function (Blueprint $table) {
            if (!Schema::hasColumn('desa', 'operator_id')) {
                $table->foreignId('operator_id')->nullable()->after('admin_id')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desa', function (Blueprint $table) {
            if (Schema::hasColumn('desa', 'operator_id')) {
                $table->dropForeign(['operator_id']);
                $table->dropColumn('operator_id');
            }
        });
    }
};
