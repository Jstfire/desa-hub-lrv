<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use App\Filament\Resources\BeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBerita extends EditRecord
{
    protected static string $resource = BeritaResource::class;

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
        $gambar_utama = $data['gambar_utama'] ?? null;
        
        // Remove file fields from data array
        unset($data['gambar_utama']);
        
        // Update the record
        $record->update($data);
        
        // Handle gambar_utama upload - hapus file lama jika ada file baru
        if ($gambar_utama) {
            $record->clearMediaCollection('gambar_utama');
            $record->addMediaFromDisk($gambar_utama, 'public')
                ->toMediaCollection('gambar_utama');
        }
        
        return $record;
    }
}
