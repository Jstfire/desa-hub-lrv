<?php

namespace App\Filament\Resources\FooterResource\Pages;

use App\Filament\Resources\FooterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditFooter extends EditRecord
{
    protected static string $resource = FooterResource::class;

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
        // Handle nested file uploads in konten array
        $logo = null;
        if (isset($data['konten']['logo'])) {
            $logo = $data['konten']['logo'];
            unset($data['konten']['logo']);
        }

        // Update the record
        $record->update($data);

        // Handle logo upload - hapus file lama jika ada file baru
        if ($logo) {
            $record->clearMediaCollection('logo');
            $record->addMediaFromDisk($logo, 'public')
                ->toMediaCollection('logo');
        }

        return $record;
    }
}
