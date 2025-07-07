<?php

namespace App\Filament\Resources\PublikasiResource\Pages;

use App\Filament\Resources\PublikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublikasi extends ListRecords
{
    protected static string $resource = PublikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Publikasi'),
        ];
    }
}
