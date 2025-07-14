<?php

namespace App\Filament\Resources\GaleriResource\Pages;

use App\Filament\Resources\GaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CreateGaleri extends CreateRecord
{
    protected static string $resource = GaleriResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        // Set current user as creator
        $data['user_id'] = $user->id;

        // Always use the User model's hasRole method which is PostgreSQL compatible
        $isSuperAdmin = $user->hasRole('superadmin');

        // If user is not superadmin and desa_id is not set, use their current team
        if ($user && !$isSuperAdmin && !isset($data['desa_id'])) {
            $data['desa_id'] = $user->currentTeam->id;
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $foto = $data['foto'] ?? [];
        unset($data['foto']);

        $record = static::getModel()::create($data);

        if (!empty($foto)) {
            foreach ($foto as $file) {
                $record->addMedia(storage_path('app/public/' . $file))
                    ->toMediaCollection($data['jenis'] === 'foto' ? 'foto' : 'video');
            }
        }

        return $record;
    }
}
