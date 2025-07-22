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
 * @property string $kategori
 * @property string $tahun
 * @property string|null $deskripsi
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $download_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereUserId($value)
 * @mixin \Eloquent
 */
class Publikasi extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'publikasi';

    protected $fillable = [
        'desa_id',
        'user_id',
        'judul',
        'slug',
        'kategori',
        'tahun',
        'deskripsi',
        'is_published',
        'published_at',
        'download_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'download_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publikasi) {
            if (empty($publikasi->slug)) {
                $publikasi->slug = Str::slug($publikasi->judul) . '-' . time();
            }
        });
    }

    /**
     * Get the desa that owns the publikasi.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that created the publikasi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published publikasi.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('dokumen')
            ->useDisk('public')
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

        $this->addMediaCollection('thumbnail')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Custom file naming based on title
        $this->addMediaConversion('publikasi')
            ->performOnCollections('dokumen', 'thumbnail')
            ->nonQueued();
    }
}
