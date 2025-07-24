<?php

namespace App\Filament\Resources\MetadataResource\Pages;

use App\Filament\Resources\MetadataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMetadata extends EditRecord
{
    protected static string $resource = MetadataResource::class;

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
