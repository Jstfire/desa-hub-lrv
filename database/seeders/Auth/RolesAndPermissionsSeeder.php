<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar cache de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin_desa = Role::firstOrCreate(['name' => 'admin_desa']);
        $operator_desa = Role::firstOrCreate(['name' => 'operator_desa']);

        // Crear usuario superadmin
        $superadminUser = User::firstOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password')
            ]
        );
        $superadminUser->assignRole($superadmin);

        // Crear usuario admin desa
        $adminDesaUser = User::firstOrCreate(
            ['email' => 'admin@mail.id'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password')
            ]
        );
        $adminDesaUser->assignRole($admin_desa);

        // Crear usuario operador desa
        $operatorDesaUser = User::firstOrCreate(
            ['email' => 'operator@mail.id'],
            [
                'name' => 'Operator Desa',
                'password' => Hash::make('password')
            ]
        );
        $operatorDesaUser->assignRole($operator_desa);
    }
}
