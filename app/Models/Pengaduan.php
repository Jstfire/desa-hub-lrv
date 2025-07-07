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
 * @property string $email
 * @property string|null $telepon
 * @property string $judul
 * @property string $isi
 * @property string $status
 * @property string|null $respon
 * @property int|null $responder_id
 * @property \Illuminate\Support\Carbon|null $respon_at
 * @property string $token
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $responder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan status($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereIsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereRespon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereResponAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereResponderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaduan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pengaduan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'pengaduan';

    protected $fillable = [
        'desa_id',
        'nama',
        'email',
        'telepon',
        'judul',
        'isi',
        'status',
        'respon',
        'responder_id',
        'respon_at',
        'token',
        'is_public',
    ];

    protected $casts = [
        'respon_at' => 'datetime',
        'is_public' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            if (empty($pengaduan->token)) {
                $pengaduan->token = Str::random(32);
            }
        });
    }

    /**
     * Get the desa that owns the pengaduan.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the user that responded to the pengaduan.
     */
    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    /**
     * Scope a query to only include public pengaduan.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', 1);
    }

    /**
     * Scope a query to only include pengaduan with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lampiran');
    }
}
