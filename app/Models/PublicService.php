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
 * @property string $content
 * @property string|null $icon
 * @property string|null $image
 * @property array<array-key, mixed>|null $requirements
 * @property array<array-key, mixed>|null $flow
 * @property string|null $service_time
 * @property string|null $cost
 * @property string|null $contact_person
 * @property bool $is_active
 * @property int $village_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Village $village
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereFlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereServiceTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PublicService whereVillageId($value)
 * @mixin \Eloquent
 */
class PublicService extends Model
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
        'content',
        'icon',
        'image',
        'requirements',
        'flow',
        'service_time',
        'cost',
        'contact_person',
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
        'requirements' => 'array',
        'flow' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the village that owns the public service.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the user who created the public service.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
