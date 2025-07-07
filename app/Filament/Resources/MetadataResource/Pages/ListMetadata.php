<?php

namespace App\Filament\Resources\MetadataResource\Pages;

use App\Filament\Resources\MetadataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetadata extends ListRecords
{
    protected static string $resource = MetadataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
