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
        Schema::create('berandas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');

            // Section 1: Welcome
            $table->string('judul_welcome');
            $table->text('deskripsi_welcome');
            $table->string('banner_image')->nullable();

            // Section 2: Berita
            $table->boolean('show_berita')->default(true);
            $table->string('judul_berita')->default('Berita Terbaru');
            $table->integer('jumlah_berita')->default(6);

            // Section 3: Lokasi
            $table->boolean('show_lokasi')->default(true);
            $table->string('judul_lokasi')->default('Lokasi Desa');
            $table->text('embed_map');

            // Section 4: Struktur
            $table->boolean('show_struktur')->default(true);
            $table->string('judul_struktur')->default('Struktur Organisasi');
            $table->string('gambar_struktur')->nullable();

            // Section 5: Penduduk
            $table->boolean('show_penduduk')->default(true);
            $table->string('judul_penduduk')->default('Jumlah Penduduk');
            $table->integer('total_penduduk')->default(0);
            $table->integer('penduduk_laki')->default(0);
            $table->integer('penduduk_perempuan')->default(0);
            $table->date('tanggal_data_penduduk')->default(now());

            // Section 6: APBDes
            $table->boolean('show_apbdes')->default(true);
            $table->string('judul_apbdes')->default('APBDesa 2025');
            $table->bigInteger('pendapatan_desa')->default(0);
            $table->bigInteger('belanja_desa')->default(0);
            $table->bigInteger('target_pendapatan')->default(0);
            $table->bigInteger('target_belanja')->default(0);

            // Section 7: Galeri
            $table->boolean('show_galeri')->default(true);
            $table->string('judul_galeri')->default('Galeri Desa');
            $table->integer('jumlah_galeri')->default(6);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berandas');
    }
};
