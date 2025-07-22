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
 * @property int $user_id
 * @property string $judul
 * @property string $slug
 * @property string $konten
 * @property string|null $kategori
 * @property string|null $tags
 * @property string $status
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $tanggal_publikasi
 * @property bool $is_highlight
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita highlighted()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereIsHighlight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereTanggalPublikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereViewCount($value)
 * @mixin \Eloquent
 */
class Berita extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'berita';

    protected $fillable = [
        'desa_id',
        'user_id',
        'judul',
        'slug',
        'konten',
        'kategori',
        'tags',
        'status',
        'tanggal_publikasi',
        'is_published',
        'published_at',
        'is_highlight',
        'view_count',
    ];

    protected $appends = ['gambar_utama'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tanggal_publikasi' => 'datetime',
        'is_highlight' => 'boolean',
        'view_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul) . '-' . time();
            }

            // Set default status if not provided
            if (empty($berita->status)) {
                $berita->status = $berita->is_published ? 'published' : 'draft';
            }

            // Set tanggal_publikasi to published_at for backwards compatibility
            if ($berita->published_at && empty($berita->tanggal_publikasi)) {
                $berita->tanggal_publikasi = $berita->published_at;
            }
        });

        static::saving(function ($berita) {
            // Keep tanggal_publikasi and published_at in sync
            if ($berita->isDirty('published_at') && !$berita->isDirty('tanggal_publikasi')) {
                $berita->tanggal_publikasi = $berita->published_at;
            }
            if ($berita->isDirty('tanggal_publikasi') && !$berita->isDirty('published_at')) {
                $berita->published_at = $berita->tanggal_publikasi;
            }

            // Keep status and is_published in sync
            if ($berita->isDirty('status') && !$berita->isDirty('is_published')) {
                $berita->is_published = ($berita->status === 'published');
            }
            if ($berita->isDirty('is_published') && !$berita->isDirty('status')) {
                $berita->status = $berita->is_published ? 'published' : 'draft';
            }
        });
    }

    /**
     * Get the desa that owns the berita.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that created the berita.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published berita.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include highlighted berita.
     */
    public function scopeHighlighted($query)
    {
        return $query->where('is_highlight', true);
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->useDisk('public');

        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Custom file naming based on slug
        $this->addMediaConversion('berita')
            ->performOnCollections('thumbnail', 'gallery')
            ->nonQueued();
    }

    public function getGambarUtamaAttribute()
    {
        return $this->getFirstMediaUrl('thumbnail');
    }
}
