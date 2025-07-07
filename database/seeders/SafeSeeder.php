<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SafeSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $roles = ['superadmin', 'admin_desa', 'operator_desa'];

        foreach ($roles as $roleName) {
            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName]);
            }
        }

        // Create superadmin user if doesn't exist
        if (!User::where('email', 'superadmin@desahub.com')->exists()) {
            $superadmin = User::create([
                'name' => 'Super Administrator',
                'email' => 'superadmin@desahub.com',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
                'is_superadmin' => true,
            ]);

            $superadmin->assignRole('superadmin');
        }

        // Create admin desa user if doesn't exist
        if (!User::where('email', 'admin@desahub.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin Desa',
                'email' => 'admin@desahub.com',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]);

            $admin->assignRole('admin_desa');
        }

        // Create operator desa user if doesn't exist
        if (!User::where('email', 'operator@desahub.com')->exists()) {
            $operator = User::create([
                'name' => 'Operator Desa',
                'email' => 'operator@desahub.com',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]);

            $operator->assignRole('operator_desa');
        }
    }
}
