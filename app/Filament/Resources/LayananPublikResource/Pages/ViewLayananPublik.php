<?php

namespace App\Filament\Resources\LayananPublikResource\Pages;

use App\Filament\Resources\LayananPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLayananPublik extends ViewRecord
{
    protected static string $resource = LayananPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
