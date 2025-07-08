<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateFilamentResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:filament-resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all Filament resources to use the PostgreSQL-compatible helper';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating Filament resources to use PostgreSQL-compatible helper...');

        $resourcesPath = app_path('Filament/Resources');
        $resources = collect(File::files($resourcesPath))
            ->filter(fn($file) => str_ends_with($file->getFilename(), 'Resource.php'))
            ->map(fn($file) => $file->getPathname());

        $this->info("Found {$resources->count()} resource files to update");

        $replacementCount = 0;

        foreach ($resources as $resourcePath) {
            $filename = basename($resourcePath);
            $this->line("Processing $filename...");

            $content = File::get($resourcePath);

            // Check if this file has the getEloquentQuery method
            if (strpos($content, 'public static function getEloquentQuery()') !== false) {
                // Create the replacement pattern
                $originalPattern = '/public static function getEloquentQuery\(\): Builder\s*\{[^}]*?\\$query = parent::getEloquentQuery\(\);.*?return \\$query;\s*\}/s';
                $replacement = 'public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        return \App\Helpers\FilamentResourceHelper::getScopedResourceQuery($query);
    }';

                // Replace the code
                $updatedContent = preg_replace($originalPattern, $replacement, $content);

                // Check if replacement was successful
                if ($updatedContent !== $content) {
                    File::put($resourcePath, $updatedContent);
                    $this->info("  ✓ Updated $filename");
                    $replacementCount++;
                } else {
                    $this->warn("  ⚠ No changes made to $filename (pattern not matched)");
                }
            } else {
                $this->warn("  ⚠ No getEloquentQuery method found in $filename");
            }
        }

        $this->info("✅ Successfully updated $replacementCount resource files");

        return 0;
    }
}
