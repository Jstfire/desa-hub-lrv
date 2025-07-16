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
        // Handle file uploads
        $dokumen = $data['dokumen'] ?? null;
        $thumbnail = $data['thumbnail'] ?? null;
        
        // Remove file fields from data array
        unset($data['dokumen'], $data['thumbnail']);
        
        // Update the record
        $record->update($data);
        
        // Handle dokumen upload - hapus file lama jika ada file baru
        if ($dokumen) {
            $record->clearMediaCollection('dokumen');
            $record->addMediaFromDisk($dokumen, 'public')
                ->toMediaCollection('dokumen');
        }
        
        // Handle thumbnail upload - hapus file lama jika ada file baru
        if ($thumbnail) {
            $record->clearMediaCollection('thumbnail');
            $record->addMediaFromDisk($thumbnail, 'public')
                ->toMediaCollection('thumbnail');
        }
        
        return $record;
    }
}
