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
        // Ejecutar el seeder de roles y permisos primero
        $this->call([
            Auth\RolesAndPermissionsSeeder::class,
            DesaSeeder::class, // Seeder untuk data desa
            BerandaSeeder::class, // Seeder untuk data beranda
            KontenSeeder::class, // Seeder untuk konten (berita, publikasi, data sektoral)
        ]);

        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
