<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereUserId($value)
 * @mixin \Eloquent
 */
class Ppid extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'ppid';

    protected $fillable = [
        'desa_id',
        'user_id',
        'judul',
        'slug',
        'kategori',
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

        static::creating(function ($ppid) {
            if (empty($ppid->slug)) {
                $ppid->slug = Str::slug($ppid->judul) . '-' . time();
            }
        });
    }

    /**
     * Get the desa that owns the ppid.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that created the ppid.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published ppid.
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
            ->singleFile();

        $this->addMediaCollection('thumbnail')
            ->singleFile();
    }
}
