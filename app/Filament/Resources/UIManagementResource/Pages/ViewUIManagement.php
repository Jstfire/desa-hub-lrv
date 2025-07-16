<?php

namespace App\Filament\Resources\UIManagementResource\Pages;

use App\Filament\Resources\UIManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUIManagement extends ViewRecord
{
    protected static string $resource = UIManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
