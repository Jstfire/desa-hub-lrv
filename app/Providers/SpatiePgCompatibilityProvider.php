<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class SpatiePgCompatibilityProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        // Fix for hasRole queries in Spatie Permission package
        if (class_exists(\Spatie\Permission\PermissionRegistrar::class)) {
            // We can't disable teams directly as the property might not be accessible

            // Register a global query modification to intercept problematic queries
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;

                // Check for the problematic query pattern with unqualified "user_id" column
                if (
                    strpos($sql, '"model_has_roles"."model_type" = ?') !== false &&
                    strpos($sql, '"user_id" = ?') !== false &&
                    count($bindings) >= 3 &&
                    ($bindings[0] === 'superadmin' || $bindings[0] === 'admin_desa' || $bindings[0] === 'operator_desa')
                ) {

                    // Log the issue for debugging
                    \Illuminate\Support\Facades\Log::info('Intercepted problematic Spatie hasRole query', [
                        'sql' => $sql,
                        'role' => $bindings[0],
                        'userId' => $bindings[2] ?? 'unknown'
                    ]);

                    // Note: The actual query execution can't be intercepted here,
                    // but we can detect when this occurs and log it
                }
            });
        }

        // Add macros to the Role class to fix PostgreSQL compatibility issues
        if (class_exists(Role::class)) {
            Role::macro('fixHasRoleQuery', function ($roleName, $id) {
                // Force proper column qualification in the query
                return DB::table('roles')
                    ->where('roles.name', $roleName)
                    ->whereExists(function ($query) use ($id) {
                        $query->select(DB::raw(1))
                            ->from('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->whereRaw('roles.id = model_has_roles.role_id')
                            ->where('model_has_roles.model_type', 'App\\Models\\User')
                            ->where('users.id', $id);
                    })
                    ->exists();
            });
        }
    }
}
