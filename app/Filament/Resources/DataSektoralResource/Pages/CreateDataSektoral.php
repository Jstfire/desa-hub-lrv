<?php

namespace App\Filament\Resources\DataSektoralResource\Pages;

use App\Filament\Resources\DataSektoralResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDataSektoral extends CreateRecord
{
    protected static string $resource = DataSektoralResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
