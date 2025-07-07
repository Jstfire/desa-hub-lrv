<?php

namespace App\Models;

/**
 * Alias for Visitor model
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
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $content
 * @property-read \App\Models\Desa $desa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit lastWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit thisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit today()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereReferrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit yesterday()
 * @mixin \Eloquent
 */
class Visit extends Visitor
{
    // This is just an alias class
}
