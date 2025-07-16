<?php

namespace App\Filament\Resources\PublikasiResource\Pages;

use App\Filament\Resources\PublikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditPublikasi extends EditRecord
{
    protected static string $resource = PublikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Hapus file lama jika ada file baru yang diupload
        if (isset($data['files']) && !empty($data['files'])) {
            // Hapus semua media yang ada di collection 'dokumen'
            $record->clearMediaCollection('dokumen');
        }

        // Update record dengan data baru
        $record->update($data);

        // Handle file upload untuk Spatie MediaLibrary
        if (isset($data['files']) && !empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $record->addMediaFromDisk($file, 'public')
                    ->toMediaCollection('dokumen');
            }
        }

        return $record;
    }
}
