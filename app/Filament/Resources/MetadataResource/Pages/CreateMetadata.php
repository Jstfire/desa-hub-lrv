<?php

namespace App\Filament\Resources\MetadataResource\Pages;

use App\Filament\Resources\MetadataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateMetadata extends CreateRecord
{
    protected static string $resource = MetadataResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // SpatieMediaLibraryFileUpload handles media uploads automatically
    // No need for manual handling

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If user is not superadmin, restrict to their desa
        $user = Auth::user();

        // Always use the User model's hasRole method which is PostgreSQL compatible
        $isSuperAdmin = $user->hasRole('superadmin');

        if ($user && !$isSuperAdmin && !isset($data['desa_id'])) {
            $data['desa_id'] = $user->currentTeam->id;
        }

        return $data;
    }
}
