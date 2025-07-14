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
        $foto = $data['foto'] ?? [];
        unset($data['foto']);

        $record->update($data);

        if (!empty($foto)) {
            $collectionName = $data['jenis'] === 'foto' ? 'foto' : 'video';

            // If it's a single file upload (video), clear the collection first.
            if ($data['jenis'] === 'video') {
                $record->clearMediaCollection($collectionName);
            }

            foreach ($foto as $file) {
                // The file path is relative to the storage/app/public directory
                if (is_string($file) && str_starts_with($file, 'galeri/')) {
                     $record->addMedia(storage_path('app/public/' . $file))
                        ->toMediaCollection($collectionName);
                }
            }
        }

        return $record;
    }
}
