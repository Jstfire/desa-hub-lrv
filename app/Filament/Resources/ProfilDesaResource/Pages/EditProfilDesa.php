<?php

namespace App\Filament\Resources\ProfilDesaResource\Pages;

use App\Filament\Resources\ProfilDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProfilDesa extends EditRecord
{
    protected static string $resource = ProfilDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Handle file uploads
        $documents = $data['documents'] ?? null;
        
        // Remove file fields from data array
        unset($data['documents']);
        
        // Update the record
        $record->update($data);
        
        // Handle documents upload - hapus file lama jika ada file baru
        if ($documents) {
            $record->clearMediaCollection('documents');
            foreach ($documents as $document) {
                $record->addMediaFromDisk($document, 'public')
                    ->toMediaCollection('documents');
            }
        }
        
        return $record;
    }
}
