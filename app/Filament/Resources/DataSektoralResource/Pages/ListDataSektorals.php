<?php

namespace App\Filament\Resources\DataSektoralResource\Pages;

use App\Filament\Resources\DataSektoralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataSektorals extends ListRecords
{
    protected static string $resource = DataSektoralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Sektoral'),
        ];
    }
}
