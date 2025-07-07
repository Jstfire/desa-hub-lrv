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
 * @property string $sektor
 * @property string $tahun
 * @property string|null $deskripsi
 * @property array<array-key, mixed>|null $data
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereSektor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereViewCount($value)
 * @mixin \Eloquent
 */
class DataSektoral extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'data_sektoral';

    protected $fillable = [
        'desa_id',
        'user_id',
        'judul',
        'slug',
        'sektor',
        'tahun',
        'deskripsi',
        'data',
        'is_published',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (empty($data->slug)) {
                $data->slug = Str::slug($data->judul) . '-' . time();
            }
        });
    }

    /**
     * Get the desa that owns the data.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that created the data.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published data.
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
