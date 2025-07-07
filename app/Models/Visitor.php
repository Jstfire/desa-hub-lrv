<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property string $ip_address
 * @property string|null $user_agent
 * @property string $halaman
 * @property string|null $referrer
 * @property int|null $content_id
 * @property string|null $content_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent|null $content
 * @property-read \App\Models\Desa $desa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor lastWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor thisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor today()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereHalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereReferrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor yesterday()
 * @mixin \Eloquent
 */
class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitor';

    protected $fillable = [
        'desa_id',
        'ip_address',
        'user_agent',
        'halaman',
        'referrer',
        'content_id',
        'content_type',
    ];

    /**
     * The "booted" method of the model.
     * This ensures the halaman field is always set, preventing Not Null violation errors.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Visitor $visitor) {
            // If halaman is not set, provide a default value
            if (empty($visitor->halaman)) {
                $visitor->halaman = request()->path() ?? 'unknown';
            }
        });
    }

    /**
     * Get the desa that owns the visitor record.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the content model that the visitor viewed.
     */
    public function content(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'content_type', 'content_id');
    }

    /**
     * Scope a query to only include today's visits.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope a query to only include yesterday's visits.
     */
    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', today()->subDay());
    }

    /**
     * Scope a query to only include this week's visits.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope a query to only include last week's visits.
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include this month's visits.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope a query to only include last month's visits.
     */
    public function scopeLastMonth($query)
    {
        return $query->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year);
    }
}
