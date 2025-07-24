<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Conversion;
use Illuminate\Support\Str;

/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property string $jenis
 * @property string $judul
 * @property string $konten
 * @property bool $is_active
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata type($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereUrutan($value)
 * @mixin \Eloquent
 */
class Metadata extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'desa_id',
        'jenis',
        'judul',
        'tahun',
        'konten',
        'is_active',
        'urutan',
        'download_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'download_count' => 'integer',
        'tahun' => 'integer',
    ];

    /**
     * Get the desa that owns the metadata.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Scope a query to only include active metadata.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include metadata of a specific type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('jenis', $type);
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('dokumen')
            ->useDisk('public')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Custom file naming based on title
        $this->addMediaConversion('metadata')
            ->performOnCollections('dokumen')
            ->nonQueued();
    }
}
