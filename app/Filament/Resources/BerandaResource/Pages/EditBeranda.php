<?php

namespace App\Filament\Resources\BerandaResource\Pages;

use App\Filament\Resources\BerandaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeranda extends EditRecord
{
    protected static string $resource = BerandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
