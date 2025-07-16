<?php

namespace App\Filament\Resources\BerandaResource\Pages;

use App\Filament\Resources\BerandaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBeranda extends EditRecord
{
    protected static string $resource = BerandaResource::class;

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
        $banner_image = $data['banner_image'] ?? null;
        $gambar_struktur = $data['gambar_struktur'] ?? null;
        
        // Remove file fields from data array
        unset($data['banner_image'], $data['gambar_struktur']);
        
        // Update the record
        $record->update($data);
        
        // Handle banner_image upload - hapus file lama jika ada file baru
        if ($banner_image) {
            $record->clearMediaCollection('banner_image');
            $record->addMediaFromDisk($banner_image, 'public')
                ->toMediaCollection('banner_image');
        }
        
        // Handle gambar_struktur upload - hapus file lama jika ada file baru
        if ($gambar_struktur) {
            $record->clearMediaCollection('gambar_struktur');
            $record->addMediaFromDisk($gambar_struktur, 'public')
                ->toMediaCollection('gambar_struktur');
        }
        
        return $record;
    }
}
