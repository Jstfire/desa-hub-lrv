<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan superadmin
        $superadmin = User::role('superadmin')->first();

        if (!$superadmin) {
            $this->command->error('User superadmin tidak ditemukan. Jalankan RolesAndPermissionsSeeder terlebih dahulu.');
            return;
        }

        // Mendapatkan admin desa dari seeder
        $adminDesa = User::where('email', 'admin@mail.id')->first();

        if (!$adminDesa) {
            $this->command->error('User admin desa tidak ditemukan. Jalankan RolesAndPermissionsSeeder terlebih dahulu.');
            return;
        }

        // Data desa
        $desa = [
            [
                'nama' => 'Bangun',
                'jenis' => 'desa',
                'kode_kecamatan' => '7401021',
                'kode_desa' => '7401021001',
                'uri' => 'bangun',
                'admin_id' => $adminDesa->id,
                'font_family' => 'Inter',
                'color_primary' => '#4B5563',
                'color_secondary' => '#1F2937',
                'alamat' => 'Jl. Desa Bangun No. 1, Kecamatan Batauga, Kabupaten Buton Selatan, Sulawesi Tenggara',
                'deskripsi' => 'Desa Bangun adalah desa yang terletak di Kecamatan Batauga, Kabupaten Buton Selatan, Provinsi Sulawesi Tenggara.',
                'is_active' => true,
            ],
            [
                'nama' => 'Matanauwe',
                'jenis' => 'kelurahan',
                'kode_kecamatan' => '7401021',
                'kode_desa' => '7401021002',
                'uri' => 'matanauwe',
                'admin_id' => $superadmin->id,
                'font_family' => 'Poppins',
                'color_primary' => '#3B82F6',
                'color_secondary' => '#1E40AF',
                'alamat' => 'Jl. Kelurahan Matanauwe No. 1, Kecamatan Batauga, Kabupaten Buton Selatan, Sulawesi Tenggara',
                'deskripsi' => 'Kelurahan Matanauwe adalah kelurahan yang terletak di Kecamatan Batauga, Kabupaten Buton Selatan, Provinsi Sulawesi Tenggara.',
                'is_active' => true,
            ],
        ];

        foreach ($desa as $desaData) {
            // Buat tim untuk desa
            $team = Team::create([
                'name' => $desaData['jenis'] . ' ' . $desaData['nama'],
                'user_id' => $superadmin->id,
                'personal_team' => false,
            ]);

            // Set team_id di data desa
            $desaData['team_id'] = $team->id;

            // Buat record desa
            $desaModel = Desa::create($desaData);

            // Tambahkan admin sebagai anggota tim
            $team->users()->attach($desaData['admin_id'], ['role' => 'admin']);

            $this->command->info($desaData['jenis'] . ' ' . $desaData['nama'] . ' berhasil dibuat.');
        }
    }
}
