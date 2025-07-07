<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Village|null $village
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectoralData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SectoralData extends Model
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
        'data',
        'category',
        'chart_type',
        'is_active',
        'village_id',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the village that owns the sectoral data.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the user who created the sectoral data.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
