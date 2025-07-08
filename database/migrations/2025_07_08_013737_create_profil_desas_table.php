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
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('jenis'); // 'tentang', 'visi_misi', 'struktur', 'monografi'
            $table->string('judul');
            $table->longText('konten');
            $table->boolean('is_published')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index(['desa_id', 'jenis', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
