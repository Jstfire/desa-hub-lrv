<?php

namespace App\Filament\Resources\BerandaResource\Pages;

use App\Filament\Resources\BerandaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBeranda extends ViewRecord
{
    protected static string $resource = BerandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
