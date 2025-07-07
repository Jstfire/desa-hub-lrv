<?php

namespace App\Models;

/**
 * Alias for Pengaduan model
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint status($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereIsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereRespon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereResponAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereResponderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Complaint extends Pengaduan
{
    // This is just an alias class
}
