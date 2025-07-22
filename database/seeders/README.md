# Database Seeders

Direktori ini berisi semua seeder untuk aplikasi Desa Hub.

## Cara Menjalankan Semua Seeder

Untuk menjalankan semua seeder dalam sekali command, gunakan:

```bash
php artisan db:seed
```

Command ini akan menjalankan `DatabaseSeeder` yang secara otomatis memanggil semua seeder dalam urutan yang benar:

1. **RolesAndPermissionsSeeder** - Membuat roles dan permissions (harus pertama)
2. **DesaSeeder** - Membuat data desa (diperlukan untuk seeder lainnya)
3. **ProfilDesaSeeder** - Membuat profil desa (bergantung pada data desa)
4. **BerandaSeeder** - Membuat data beranda (bergantung pada data desa)
5. **SafeSeeder** - Safe seeder (terakhir)

## Menjalankan Seeder Spesifik

Jika Anda ingin menjalankan seeder tertentu saja:

```bash
php artisan db:seed --class=DesaSeeder
php artisan db:seed --class=BerandaSeeder
php artisan db:seed --class=ProfilDesaSeeder
php artisan db:seed --class=SafeSeeder
php artisan db:seed --class="Database\Seeders\Auth\RolesAndPermissionsSeeder"
```

## Catatan Penting

- Urutan seeder sangat penting karena ada dependensi antar seeder
- Pastikan database sudah di-migrate sebelum menjalankan seeder
- Gunakan `--force` flag jika menjalankan di production environment

## Reset dan Re-seed

Untuk reset database dan menjalankan ulang semua seeder:

```bash
php artisan migrate:fresh --seed
```