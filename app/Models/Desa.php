<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Jetstream\Jetstream;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
class Desa extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'desa';

    protected $appends = ['nama_lengkap'];

    protected $fillable = [
        'nama',
        'jenis', // 'desa' atau 'kelurahan'
        'kode_kecamatan',
        'kode_desa',
        'uri',
        'team_id',
        'admin_id', // ID user yang menjadi admin desa
        'font_family',
        'color_primary',
        'color_secondary',
        'alamat',
        'deskripsi',
    ];

    public function getNamaLengkapAttribute(): string
    {
        return ucfirst($this->jenis) . ' ' . $this->nama;
    }

    /**
     * Get the user that administers the desa.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the user that operates the desa.
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    /**
     * Get the team that owns the desa.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the berita for the desa.
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Get the layanan for the desa.
     */
    public function layananPublik(): HasMany
    {
        return $this->hasMany(LayananPublik::class);
    }

    /**
     * Get the publikasi for the desa.
     */
    public function publikasi(): HasMany
    {
        return $this->hasMany(Publikasi::class);
    }

    /**
     * Get the data sektoral for the desa.
     */
    public function dataSektoral(): HasMany
    {
        return $this->hasMany(DataSektoral::class);
    }

    /**
     * Get the pengaduan for the desa.
     */
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class);
    }

    /**
     * Get the metadata for the desa.
     */
    public function metadata(): HasMany
    {
        return $this->hasMany(Metadata::class);
    }

    /**
     * Get the visitor for the desa.
     */
    public function visitor(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }

    /**
     * Get the ppid for the desa.
     */
    public function ppid(): HasMany
    {
        return $this->hasMany(Ppid::class);
    }

    /**
     * Get the beranda for the desa.
     */
    public function beranda(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Beranda::class);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();

        $this->addMediaCollection('banner')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }
}
