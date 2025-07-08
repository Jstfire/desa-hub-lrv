<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Filament\Resources\GaleriResource;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test:galeri', function () {
    try {
        $this->info('Testing GaleriResource PostgreSQL compatibility...');

        // Get superadmin user
        $superadmin = User::whereHas('roles', function ($q) {
            $q->where('name', 'superadmin');
        })->first();

        if (!$superadmin) {
            $this->error('Superadmin user not found');
            return;
        }

        $this->info("Found superadmin: {$superadmin->name} (ID: {$superadmin->id})");

        // Set the authenticated user
        $this->info('Setting authenticated user...');
        \Illuminate\Support\Facades\Auth::login($superadmin);

        // Test the getEloquentQuery method
        $this->info('Testing GaleriResource::getEloquentQuery()...');
        $query = GaleriResource::getEloquentQuery();

        $this->info('Query built successfully without errors!');
        $this->info('SQL: ' . $query->toSql());

        $this->info('All tests passed successfully!');
    } catch (\Exception $e) {
        $this->error('Test failed: ' . $e->getMessage());
        $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
    }
})->purpose('Test GaleriResource PostgreSQL compatibility');
