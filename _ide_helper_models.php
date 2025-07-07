<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property int $user_id
 * @property string $judul
 * @property string $slug
 * @property string $konten
 * @property string|null $kategori
 * @property string|null $tags
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property bool $is_highlight
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita highlighted()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereIsHighlight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereViewCount($value)
 * @mixin \Eloquent
 */
	class Berita extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
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
	class Complaint extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property int $user_id
 * @property string $judul
 * @property string $slug
 * @property string $sektor
 * @property string $tahun
 * @property string|null $deskripsi
 * @property array<array-key, mixed>|null $data
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $view_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereSektor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSektoral whereViewCount($value)
 * @mixin \Eloquent
 */
	class DataSektoral extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $jenis
 * @property string|null $kode_kecamatan
 * @property string|null $kode_desa
 * @property string $uri
 * @property int $team_id
 * @property int|null $admin_id
 * @property string $font_family
 * @property string $color_primary
 * @property string $color_secondary
 * @property string|null $alamat
 * @property string|null $deskripsi
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Berita> $berita
 * @property-read int|null $berita_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataSektoral> $dataSektoral
 * @property-read int|null $data_sektoral_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LayananPublik> $layananPublik
 * @property-read int|null $layanan_publik_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Metadata> $metadata
 * @property-read int|null $metadata_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pengaduan> $pengaduan
 * @property-read int|null $pengaduan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ppid> $ppid
 * @property-read int|null $ppid_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Publikasi> $publikasi
 * @property-read int|null $publikasi_count
 * @property-read \App\Models\Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Visitor> $visitor
 * @property-read int|null $visitor_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereColorPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereColorSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereFontFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereKodeDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereKodeKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Desa whereUri($value)
 * @mixin \Eloquent
 */
	class Desa extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property string $section
 * @property string|null $judul
 * @property array<array-key, mixed>|null $konten
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer section($section)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Footer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Footer extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri type($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereViewCount($value)
 * @mixin \Eloquent
 */
	class Galeri extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
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
	class GalleryImage extends \Eloquent {}
}

namespace App\Models{
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
	class LayananPublik extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereUserId($value)
 * @mixin \Eloquent
 */
	class Membership extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property string $jenis
 * @property string $judul
 * @property string $konten
 * @property bool $is_active
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata type($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereUrutan($value)
 * @mixin \Eloquent
 */
	class Metadata extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $excerpt
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string $status
 * @property int $view_count
 * @property int $village_id
 * @property int $user_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\NewsCategory|null $category
 * @property-read \App\Models\Village $village
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereVillageId($value)
 * @mixin \Eloquent
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $color
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read int|null $news_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class NewsCategory extends \Eloquent {}
}

namespace App\Models{
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
	class Pengaduan extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property int $user_id
 * @property string $judul
 * @property string $slug
 * @property string $kategori
 * @property string|null $deskripsi
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $download_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ppid whereUserId($value)
 * @mixin \Eloquent
 */
	class Ppid extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
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
	class PublicService extends \Eloquent {}
}

namespace App\Models{
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
	class Publication extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $desa_id
 * @property int $user_id
 * @property string $judul
 * @property string $slug
 * @property string $kategori
 * @property string $tahun
 * @property string|null $deskripsi
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $download_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDesaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publikasi whereUserId($value)
 * @mixin \Eloquent
 */
	class Publikasi extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
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
	class SectoralData extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TeamInvitation> $teamInvitations
 * @property-read int|null $team_invitations_count
 * @property-read \App\Models\Membership|null $membership
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team wherePersonalTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUserId($value)
 * @mixin \Eloquent
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $team_id
 * @property string $email
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamInvitation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class TeamInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * User model with authentication, permissions and team capabilities.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Membership|null $membership
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
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
	class Village extends \Eloquent {}
}

namespace App\Models{
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
	class Visit extends \Eloquent {}
}

namespace App\Models{
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
	class Visitor extends \Eloquent {}
}

