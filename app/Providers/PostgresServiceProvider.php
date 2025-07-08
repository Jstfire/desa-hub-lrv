<?php

namespace App\Providers;

use App\Helpers\PostgresCompatibility;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostgresServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only apply fixes if using PostgreSQL
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Convert boolean values to integers in queries for PostgreSQL
            DB::beforeExecuting(function ($query, $bindings = []) {
                // Convert bindings for where clauses
                foreach ($bindings as $key => $value) {
                    if (is_bool($value)) {
                        $bindings[$key] = (int)$value;
                    }
                }
                return [$query, $bindings];
            });

            // Fix specific queries by rewriting them
            DB::beforeExecuting(function ($query, $bindings = []) {
                // Fix Spatie Permission queries for PostgreSQL
                if (
                    strpos($query, 'select exists(select * from "roles"') !== false &&
                    strpos($query, 'model_has_roles') !== false &&
                    strpos($query, '"user_id"') !== false
                ) {
                    // Replace unqualified user_id with proper model_id reference
                    $query = str_replace('"user_id"', '"model_has_roles"."model_id"', $query);
                    Log::info('Fixed Spatie Permission query user_id reference: ' . $query);
                }

                // Fix other model_has_roles user_id references
                if (strpos($query, '"user_id" = ?') !== false && strpos($query, 'model_has_roles') !== false) {
                    $query = str_replace('"user_id" = ?', '"model_has_roles"."model_id" = ?', $query);
                    Log::info('Fixed model_has_roles user_id reference: ' . $query);
                }

                return [$query, $bindings];
            });

            // Log and monitor database queries to help diagnose issues
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $time = $query->time;

                // Check for potential issues with PostgreSQL quoting
                if (
                    str_contains($sql, "'desa_id'") ||
                    str_contains($sql, "'status'") ||
                    str_contains($sql, "'is_active'") ||
                    str_contains($sql, "'is_published'") ||
                    str_contains($sql, '"user_id"') && str_contains($sql, '"model_has_roles"') ||
                    (str_contains($sql, 'model_has_roles') && str_contains($sql, 'roles') && str_contains($sql, 'exists'))
                ) {
                    // Log the problematic query for debugging
                    Log::warning("PostgreSQL quoting issue detected: {$sql}", [
                        'bindings' => $bindings,
                        'time' => $time
                    ]);

                    // Attempt to fix common issues with model_has_roles queries
                    if (str_contains($sql, '"user_id"') && str_contains($sql, '"model_has_roles"')) {
                        // This is a rough fix - in a real app we'd need more sophisticated query rewriting
                        $sql = str_replace('"user_id"', '"users"."id"', $sql);
                    }
                }
            });
        }
    }
}
