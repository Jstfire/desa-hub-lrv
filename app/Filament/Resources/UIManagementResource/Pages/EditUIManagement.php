<?php

namespace App\Filament\Resources\UIManagementResource\Pages;

use App\Filament\Resources\UIManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUIManagement extends EditRecord
{
    protected static string $resource = UIManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
