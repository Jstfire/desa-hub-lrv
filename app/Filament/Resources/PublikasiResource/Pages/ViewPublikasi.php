<?php

namespace App\Filament\Resources\PublikasiResource\Pages;

use App\Filament\Resources\PublikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPublikasi extends ViewRecord
{
    protected static string $resource = PublikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
