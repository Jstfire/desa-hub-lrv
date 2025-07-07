<?php

namespace App\Filament\Resources\DesaResource\Pages;

use App\Filament\Resources\DesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDesa extends ViewRecord
{
    protected static string $resource = DesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
