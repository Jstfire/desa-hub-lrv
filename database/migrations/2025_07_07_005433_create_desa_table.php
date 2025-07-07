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
        Schema::create('desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis'); // 'desa' atau 'kelurahan'
            $table->string('kode_kecamatan')->nullable();
            $table->string('kode_desa')->nullable();
            $table->string('uri')->unique(); // untuk URL friendly /nama-desa
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('font_family')->default('Inter');
            $table->string('color_primary')->default('#4B5563');
            $table->string('color_secondary')->default('#1F2937');
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};
