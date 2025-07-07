<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $file
 * @property string|null $thumbnail
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property bool $is_active
 * @property int $download_count
 * @property int $village_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Village $village
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publication whereVillageId($value)
 * @mixin \Eloquent
 */
class Publication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'file',
        'thumbnail',
        'type',
        'published_at',
        'is_active',
        'village_id',
        'created_by',
        'download_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the village that owns the publication.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the user who created the publication.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
