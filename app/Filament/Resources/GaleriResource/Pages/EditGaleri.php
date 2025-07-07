<?php

namespace App\Filament\Resources\GaleriResource\Pages;

use App\Filament\Resources\GaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGaleri extends EditRecord
{
    protected static string $resource = GaleriResource::class;

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
            // For multiple images, we don't clear the collection first
            foreach (request()->file('gambar') as $file) {
                $record->addMedia($file)
                    ->toMediaCollection('gambar');
            }
        }

        if (request()->hasFile('video')) {
            // For video, we clear first and then add the new one
            $record->clearMediaCollection('video');
            $record->addMediaFromRequest('video')
                ->toMediaCollection('video');
        }

        return $record;
    }
}
