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
 * @property string $nama
 * @property string $slug
 * @property string $deskripsi
 * @property string|null $persyaratan
 * @property string|null $prosedur
 * @property string|null $waktu_layanan
 * @property string|null $biaya
 * @property bool $is_active
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik wherePersyaratan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereProsedur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereUrutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPublik whereWaktuLayanan($value)
 * @mixin \Eloquent
 */
class LayananPublik extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'layanan_publik';

    protected $fillable = [
        'desa_id',
        'nama',
        'slug',
        'deskripsi',
        'persyaratan',
        'prosedur',
        'waktu_layanan',
        'biaya',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            if (empty($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama) . '-' . time();
            }
        });
    }

    /**
     * Get the desa that owns the layanan publik.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Scope a query to only include active layanan.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')
            ->singleFile();

        $this->addMediaCollection('gambar')
            ->singleFile();
    }
}
