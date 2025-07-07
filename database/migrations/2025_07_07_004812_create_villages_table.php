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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['desa', 'kelurahan'])->default('desa');
            $table->string('subdistrict_code')->nullable(); // Kode kecamatan
            $table->string('village_code')->nullable()->unique(); // Kode desa/kelurahan
            $table->string('uri')->unique(); // URI untuk mengakses situs desa/kelurahan
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->string('font_family')->default('Inter');
            $table->string('primary_color')->default('#4F46E5'); // Default: indigo-600
            $table->string('secondary_color')->default('#EC4899'); // Default: pink-500
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
