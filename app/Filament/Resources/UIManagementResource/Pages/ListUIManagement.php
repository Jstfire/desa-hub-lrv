<?php

namespace App\Filament\Resources\UIManagementResource\Pages;

use App\Filament\Resources\UIManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUIManagement extends ListRecords
{
    protected static string $resource = UIManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action since we manage existing villages
        ];
    }
}