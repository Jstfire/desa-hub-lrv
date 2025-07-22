<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property string $section
 * @property string|null $judul
 * @property array<array-key, mixed>|null $konten
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer section($section)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Footer extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'footer';

    protected $fillable = [
        'desa_id',
        'section',
        'judul',
        'konten',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'konten' => 'array', // untuk menyimpan data JSON
    ];

    /**
     * Get the desa that owns the footer.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Scope a query to only include active footer items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by section.
     */
    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_desa')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }
}
