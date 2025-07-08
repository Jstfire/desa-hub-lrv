<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProfilDesa extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'profil_desa';

    protected $fillable = [
        'desa_id',
        'jenis', // 'tentang', 'visi_misi', 'struktur', 'monografi'
        'judul',
        'konten',
        'is_published',
        'urutan',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get the desa that owns the profil.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Scope a query to only include published items.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to filter by jenis.
     */
    public function scopeType($query, $type)
    {
        return $query->where('jenis', $type);
    }

    /**
     * Get the media collection name for documents.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }
}
