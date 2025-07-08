<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * Helper class for Filament Resources to manage permissions and scoping
 */
class FilamentResourceHelper
{
    /**
     * Get the query scoped to the user's permissions in a PostgreSQL-compatible way
     * 
     * @param Builder $query The base eloquent query
     * @return Builder The filtered query
     */
    public static function getScopedResourceQuery(Builder $query): Builder
    {
        try {
            $user = Auth::user();

            // If no user is authenticated, return the base query
            if (!$user) {
                return $query;
            }

            // For PostgreSQL, use our custom hasRole method that avoids problematic queries
            if (config('database.default') === 'pgsql') {
                // Use the User model's overridden hasRole method that's PostgreSQL compatible
                if ($user->hasRole('superadmin')) {
                    return $query;
                }

                // Check if user is admin_desa or operator_desa
                $isDesaAdmin = $user->hasRole(['admin_desa', 'operator_desa']);
            } else {
                // For non-PostgreSQL databases, use direct query that doesn't use 'user_id'
                $isSuperAdmin = Role::where('name', 'superadmin')
                    ->whereExists(function ($subQuery) use ($user) {
                        $subQuery->select(DB::raw(1))
                            ->from('model_has_roles')
                            ->whereRaw('model_has_roles.role_id = roles.id')
                            ->where('model_has_roles.model_type', 'App\\Models\\User')
                            ->where('model_has_roles.model_id', $user->id);
                    })
                    ->exists();

                if ($isSuperAdmin) {
                    return $query;
                }

                // Check if user is admin_desa or operator_desa
                $isDesaAdmin = Role::whereIn('name', ['admin_desa', 'operator_desa'])
                    ->whereExists(function ($subQuery) use ($user) {
                        $subQuery->select(DB::raw(1))
                            ->from('model_has_roles')
                            ->whereRaw('model_has_roles.role_id = roles.id')
                            ->where('model_has_roles.model_type', 'App\\Models\\User')
                            ->where('model_has_roles.model_id', $user->id);
                    })
                    ->exists();
            }

            if ($isDesaAdmin) {
                // Get desa IDs for the user
                $desaIds = $user->ownedTeams->pluck('id')->merge(
                    $user->teams->pluck('id')
                )->unique()->toArray();

                // Return query filtered by desa
                if (method_exists($query->getModel(), 'desa') || in_array('desa_id', $query->getModel()->getFillable())) {
                    return $query->whereIn('desa_id', $desaIds);
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't crash
            \Illuminate\Support\Facades\Log::error('Error in FilamentResourceHelper: ' . $e->getMessage());
        }

        // Default fallback
        return $query;
    }
}
