<?php

namespace App\Filament\Resources\PublikasiResource\Pages;

use App\Filament\Resources\PublikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublikasi extends EditRecord
{
    protected static string $resource = PublikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
