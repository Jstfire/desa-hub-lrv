<?php

namespace App\Models;

/**
 * Alias for Galeri model
 *
 * @property int $id
 * @property int $desa_id
 * @property int $user_id
 * @property string $judul
 * @property string|null $deskripsi
 * @property string $jenis
 * @property string|null $kategori
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage type($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GalleryImage whereViewCount($value)
 * @mixin \Eloquent
 */
class GalleryImage extends Galeri
{
    // This is just an alias class
}
