<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignUserRoles extends Command
{
    /**
     * El nombre y firma del comando.
     *
     * @var string
     */
    protected $signature = 'users:assign-roles';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Asigna roles a usuarios existentes para integrar Jetstream con Filament';

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        $this->info('Iniciando asignación de roles...');

        // Asegurarse de que los roles existen
        $this->createRolesIfNotExist();

        // Asignar rol de superadmin
        $superadmin = User::where('email', 'superadmin@mail.com')->first();
        if ($superadmin) {
            $superadmin->assignRole('superadmin');
            $this->info("Rol 'superadmin' asignado a {$superadmin->email}");
        } else {
            $this->warn("Usuario superadmin@mail.com no encontrado");
        }

        // Asignar rol de admin_desa
        $adminDesa = User::where('email', 'admin@mail.id')->first();
        if ($adminDesa) {
            $adminDesa->assignRole('admin_desa');
            $this->info("Rol 'admin_desa' asignado a {$adminDesa->email}");
        } else {
            $this->warn("Usuario admin@mail.id no encontrado");
        }

        // Asignar rol de operator_desa
        $operatorDesa = User::where('email', 'operator@mail.id')->first();
        if ($operatorDesa) {
            $operatorDesa->assignRole('operator_desa');
            $this->info("Rol 'operator_desa' asignado a {$operatorDesa->email}");
        } else {
            $this->warn("Usuario operator@mail.id no encontrado");
        }

        $this->info('Asignación de roles completada');
        return Command::SUCCESS;
    }

    /**
     * Crear roles si no existen
     */
    private function createRolesIfNotExist(): void
    {
        $roles = ['superadmin', 'admin_desa', 'operator_desa'];

        foreach ($roles as $roleName) {
            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName]);
                $this->info("Rol '$roleName' creado");
            }
        }
    }
}
