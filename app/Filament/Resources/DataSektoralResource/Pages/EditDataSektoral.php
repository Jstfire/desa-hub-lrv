<?php

namespace App\Filament\Resources\DataSektoralResource\Pages;

use App\Filament\Resources\DataSektoralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditDataSektoral extends EditRecord
{
    protected static string $resource = DataSektoralResource::class;

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
        $thumbnail = $data['thumbnail'] ?? null;
        $dokumen = $data['dokumen'] ?? null;

        // Remove file fields from data array
        unset($data['thumbnail'], $data['dokumen']);

        // Update the record
        $record->update($data);

        // Handle thumbnail upload - hapus file lama jika ada file baru
        if ($thumbnail) {
            $record->clearMediaCollection('thumbnail');
            $record->addMediaFromDisk($thumbnail, 'public')
                ->toMediaCollection('thumbnail');
        }

        // Handle dokumen upload - hapus file lama jika ada file baru
        if ($dokumen) {
            $record->clearMediaCollection('dokumen');
            $record->addMediaFromDisk($dokumen, 'public')
                ->toMediaCollection('dokumen');
        }

        return $record;
    }
}
