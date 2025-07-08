<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Filament\Resources\GaleriResource;
use App\Filament\Resources\DataSektoralResource;
use App\Filament\Resources\PublikasiResource;
use App\Filament\Resources\VisitorResource;
use App\Filament\Resources\PpidResource;
use App\Filament\Resources\FooterResource;
use App\Filament\Resources\MetadataResource;

class TestFilamentResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test all Filament resources for PostgreSQL compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Filament Resources PostgreSQL compatibility...');

        // Get superadmin user
        $superadmin = User::whereHas('roles', function ($q) {
            $q->where('name', 'superadmin');
        })->first();

        if (!$superadmin) {
            $this->error('Superadmin user not found');
            return 1;
        }

        $this->info("Found superadmin: {$superadmin->name} (ID: {$superadmin->id})");

        // Set the authenticated user
        $this->info('Setting authenticated user...');
        Auth::login($superadmin);

        // Test resources
        $resources = [
            GaleriResource::class,
            DataSektoralResource::class,
            MetadataResource::class,
            PublikasiResource::class,
            VisitorResource::class,
            PpidResource::class,
            FooterResource::class,
        ];

        $success = true;

        foreach ($resources as $resourceClass) {
            // Get short name
            $parts = explode('\\', $resourceClass);
            $shortName = end($parts);

            $this->info("Testing {$shortName}::getEloquentQuery()...");
            try {
                $query = $resourceClass::getEloquentQuery();
                $this->info("  ✓ Query built successfully: {$query->toSql()}");
            } catch (\Exception $e) {
                $this->error("  ✗ Error: {$e->getMessage()}");
                $this->error("  File: {$e->getFile()}:{$e->getLine()}");
                $success = false;
            }
        }

        if ($success) {
            $this->info('✅ All resource tests passed successfully!');
        } else {
            $this->error('❌ Some resource tests failed. Check the logs above.');
            return 1;
        }

        return 0;
    }
}
