<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $subdistrict_code
 * @property string|null $village_code
 * @property string $uri
 * @property int|null $admin_id
 * @property int|null $team_id
 * @property string $font_family
 * @property string $primary_color
 * @property string $secondary_color
 * @property string|null $description
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $logo
 * @property string|null $banner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Complaint> $complaints
 * @property-read int|null $complaints_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GalleryImage> $galleryImages
 * @property-read int|null $gallery_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicService> $publicServices
 * @property-read int|null $public_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Publication> $publications
 * @property-read int|null $publications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SectoralData> $sectoralData
 * @property-read int|null $sectoral_data_count
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereFontFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereSecondaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereSubdistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereVillageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Village whereYoutube($value)
 * @mixin \Eloquent
 */
class Village extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'subdistrict_code',
        'village_code',
        'uri',
        'admin_id',
        'font_family',
        'primary_color',
        'secondary_color',
        'description',
        'address',
        'phone',
        'email',
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'logo',
        'banner'
    ];

    /**
     * Get the admin user of the village.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the team associated with the village.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Get the news items for the village.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * Get the public services for the village.
     */
    public function publicServices(): HasMany
    {
        return $this->hasMany(PublicService::class);
    }

    /**
     * Get the publications for the village.
     */
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * Get the sectoral data items for the village.
     */
    public function sectoralData(): HasMany
    {
        return $this->hasMany(SectoralData::class);
    }

    /**
     * Get the gallery images for the village.
     */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    /**
     * Get the complaints for the village.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the visits for the village.
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
