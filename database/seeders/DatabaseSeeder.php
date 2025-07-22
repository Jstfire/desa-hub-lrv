<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan semua seeder dalam urutan yang benar
        // Urutan penting: roles & permissions -> desa -> profil desa -> beranda -> safe seeder
        $this->call([
            Auth\RolesAndPermissionsSeeder::class, // Roles dan permissions harus pertama
            DesaSeeder::class,                     // Data desa (diperlukan untuk seeder lainnya)
            ProfilDesaSeeder::class,               // Profil desa (bergantung pada data desa)
            BerandaSeeder::class,                  // Data beranda (bergantung pada data desa)
            SafeSeeder::class,                     // Safe seeder terakhir
        ]);

        // User::factory(10)->withPersonalTeam()->create();
    }
}
