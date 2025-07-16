<?php

namespace App\Filament\Resources\LayananPublikResource\Pages;

use App\Filament\Resources\LayananPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLayananPublik extends EditRecord
{
    protected static string $resource = LayananPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Handle file uploads
        $icon = $data['icon'] ?? null;
        
        // Remove file fields from data array
        unset($data['icon']);
        
        // Update the record
        $record->update($data);
        
        // Handle icon upload - hapus file lama jika ada file baru
        if ($icon) {
            $record->clearMediaCollection('icon');
            $record->addMediaFromDisk($icon, 'public')
                ->toMediaCollection('icon');
        }
        
        return $record;
    }
}
