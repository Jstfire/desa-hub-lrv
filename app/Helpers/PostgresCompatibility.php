<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Grammars\PostgresGrammar as BasePostgresGrammar;
use Illuminate\Database\Query\Grammars\PostgresGrammar as BaseQueryGrammar;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Helper to fix PostgreSQL compatibility issues with quote handling
 */
class PostgresCompatibility
{
    /**
     * Register fixes for PostgreSQL compatibility
     */
    public static function fixQuoting()
    {
        // This is a placeholder for potential fixes
        // In a real implementation, you'd extend the PostgresGrammar class to fix quoting issues
    }

    /**
     * Fix raw SQL queries that use single quotes for column names
     */
    public static function fixRawQuery($sql)
    {
        // Replace single quotes around column names with double quotes
        // Be careful with this as it's a simple fix and might cause issues with more complex queries
        $pattern = "/'([a-zA-Z0-9_]+)'/";
        $replacement = '"$1"';
        return preg_replace($pattern, $replacement, $sql);
    }

    /**
     * Run a fixed query
     */
    public static function runFixedQuery($sql, $bindings = [])
    {
        $fixedSql = self::fixRawQuery($sql);
        return DB::select($fixedSql, $bindings);
    }
}
