<?php

namespace App\Filament\Resources\DataSektoralResource\Pages;

use App\Filament\Resources\DataSektoralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataSektoral extends EditRecord
{
    protected static string $resource = DataSektoralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
