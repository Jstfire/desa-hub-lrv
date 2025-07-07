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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        // Process media uploads after update
        if (request()->hasFile('gambar')) {
            // Clear existing media in this collection
            $record->clearMediaCollection('gambar');

            // Add the new media
            $record->addMediaFromRequest('gambar')
                ->toMediaCollection('gambar');
        }

        if (request()->hasFile('lampiran')) {
            // For multiple files, we don't clear the collection first
            foreach (request()->file('lampiran') as $file) {
                $record->addMedia($file)
                    ->toMediaCollection('lampiran');
            }
        }

        return $record;
    }
}
