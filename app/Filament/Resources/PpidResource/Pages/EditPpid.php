<?php

namespace App\Filament\Resources\PpidResource\Pages;

use App\Filament\Resources\PpidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPpid extends EditRecord
{
    protected static string $resource = PpidResource::class;

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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        // Handle file uploads
        if (request()->hasFile('dokumen')) {
            $record->clearMediaCollection('dokumen');
            $record->addMediaFromRequest('dokumen')
                ->toMediaCollection('dokumen');
        }

        if (request()->hasFile('thumbnail')) {
            $record->clearMediaCollection('thumbnail');
            $record->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        return $record;
    }
}
