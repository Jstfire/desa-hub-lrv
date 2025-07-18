<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Beranda extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'berandas';

    protected $fillable = [
        'desa_id',
        'judul_welcome',
        'deskripsi_welcome',
        'banner_image',
        'show_berita',
        'judul_berita',
        'jumlah_berita',
        'show_lokasi',
        'judul_lokasi',
        'embed_map',
        'show_struktur',
        'judul_struktur',
        'gambar_struktur',
        'show_penduduk',
        'judul_penduduk',
        'total_penduduk',
        'penduduk_laki',
        'penduduk_perempuan',
        'tanggal_data_penduduk',
        'show_apbdes',
        'judul_apbdes',
        'pendapatan_desa',
        'belanja_desa',
        'target_pendapatan',
        'target_belanja',
        'show_galeri',
        'judul_galeri',
        'jumlah_galeri',
    ];

    protected $casts = [
        'show_berita' => 'boolean',
        'show_lokasi' => 'boolean',
        'show_struktur' => 'boolean',
        'show_penduduk' => 'boolean',
        'show_apbdes' => 'boolean',
        'show_galeri' => 'boolean',
        'tanggal_data_penduduk' => 'date',
    ];

    /**
     * Get the desa that owns the beranda.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->singleFile();

        $this->addMediaCollection('struktur')
            ->singleFile();
    }
}
