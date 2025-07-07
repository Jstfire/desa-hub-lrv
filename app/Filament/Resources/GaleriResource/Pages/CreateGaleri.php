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

        // Check if user is not superadmin, restrict to their desa
        $isSuperAdmin = Role::where('name', 'superadmin')
            ->whereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->exists();

        if ($user && !$isSuperAdmin && !isset($data['desa_id'])) {
            $data['desa_id'] = $user->currentTeam->id;
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        // Process media uploads after creation
        if (request()->hasFile('gambar')) {
            foreach (request()->file('gambar') as $file) {
                $record->addMedia($file)
                    ->toMediaCollection('gambar');
            }
        }

        if (request()->hasFile('video')) {
            $record->addMediaFromRequest('video')
                ->toMediaCollection('video');
        }

        return $record;
    }
}
