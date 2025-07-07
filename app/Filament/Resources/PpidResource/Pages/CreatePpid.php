<?php

namespace App\Filament\Resources\PpidResource\Pages;

use App\Filament\Resources\PpidResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreatePpid extends CreateRecord
{
    protected static string $resource = PpidResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = Auth::id();

        $record = static::getModel()::create($data);

        // Handle file uploads
        if (request()->hasFile('dokumen')) {
            $record->addMediaFromRequest('dokumen')
                ->toMediaCollection('dokumen');
        }

        if (request()->hasFile('thumbnail')) {
            $record->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        return $record;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set user_id to current user
        $data['user_id'] = Auth::id();

        // Set default values if not provided
        if (!isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
