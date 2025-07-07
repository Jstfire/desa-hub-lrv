<?php

namespace App\Filament\Resources\PpidResource\Pages;

use App\Filament\Resources\PpidResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPpids extends ListRecords
{
    protected static string $resource = PpidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Dokumen PPID'),
        ];
    }
}
