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
        // Handle file uploads
        $gambar = $data['gambar'] ?? null;
        $lampiran = $data['lampiran'] ?? null;
        
        // Remove file fields from data array
        unset($data['gambar'], $data['lampiran']);
        
        // Update the record
        $record->update($data);
        
        // Handle gambar upload - hapus file lama jika ada file baru
        if ($gambar) {
            $record->clearMediaCollection('gambar');
            $record->addMediaFromDisk($gambar, 'public')
                ->toMediaCollection('gambar');
        }
        
        // Handle lampiran upload - hapus file lama jika ada file baru
        if ($lampiran) {
            $record->clearMediaCollection('lampiran');
            $record->addMediaFromDisk($lampiran, 'public')
                ->toMediaCollection('lampiran');
        }
        
        return $record;
    }
}
