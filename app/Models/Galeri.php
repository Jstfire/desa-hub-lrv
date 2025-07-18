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
 * @property int $user_id
 * @property string $judul
 * @property string|null $deskripsi
 * @property string $jenis
 * @property string|null $kategori
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri type($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereViewCount($value)
 * @mixin \Eloquent
 */
class Galeri extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'galeri';

    protected $fillable = [
        'desa_id',
        'user_id',
        'judul',
        'deskripsi',
        'jenis', // 'foto', 'video'
        'kategori',
        'is_published',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    /**
     * Get the desa that owns the galeri.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that created the galeri.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published galeri.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to filter by jenis.
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
        $this->addMediaCollection('media');

        $this->addMediaCollection('foto')
            ->singleFile();

        $this->addMediaCollection('video')
            ->singleFile();

        $this->addMediaCollection('thumbnail')
            ->singleFile();
    }
}
