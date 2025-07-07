<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * PostgreSQL compatibility fixes for Spatie Laravel Permission
 */
class SpatiePermissionHelper
{
    /**
     * Provides a PostgreSQL-compatible version of the hasRole check
     * 
     * @param string $role Role name to check
     * @param int $userId User ID to check against
     * @return bool Whether the user has the given role
     */
    public static function hasRole($role, $userId)
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            // For non-PostgreSQL databases, use the default implementation
            return Role::where('name', $role)
                ->whereExists(function ($query) use ($userId) {
                    $query->select(DB::raw(1))
                        ->from('model_has_roles')
                        ->whereRaw('model_has_roles.role_id = roles.id')
                        ->where('model_has_roles.model_id', $userId)
                        ->where('model_has_roles.model_type', \App\Models\User::class);
                })
                ->exists();
        }

        try {
            // Use direct table query for PostgreSQL with fully qualified columns
            return DB::table('roles')
                ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', $role)
                ->where('model_has_roles.model_id', $userId)
                ->where('model_has_roles.model_type', 'App\\Models\\User')
                ->exists();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("PostgreSQL hasRole query failed: " . $e->getMessage());

            // Fall back to raw SQL with proper quoting if the query builder approach fails
            try {
                return DB::select(
                    'SELECT EXISTS(
                        SELECT * FROM "roles" 
                        WHERE "name" = ? 
                        AND EXISTS (
                            SELECT * FROM "users" 
                            INNER JOIN "model_has_roles" ON "users"."id" = "model_has_roles"."model_id"
                            WHERE "roles"."id" = "model_has_roles"."role_id" 
                            AND "model_has_roles"."model_type" = ? 
                            AND "users"."id" = ?
                        )
                    ) as "exists"',
                    [$role, 'App\\Models\\User', $userId]
                )[0]->exists;
            } catch (\Exception $e2) {
                \Illuminate\Support\Facades\Log::error("PostgreSQL raw SQL hasRole query also failed: " . $e2->getMessage());
                return false;
            }
        }
    }
}
