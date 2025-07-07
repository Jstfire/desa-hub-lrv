<?php

namespace App\Filament\Resources\LayananPublikResource\Pages;

use App\Filament\Resources\LayananPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLayananPublik extends EditRecord
{
    protected static string $resource = LayananPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
