<?php

namespace App\Filament\Resources\FooterResource\Pages;

use App\Filament\Resources\FooterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CreateFooter extends CreateRecord
{
    protected static string $resource = FooterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        // Always use the User model's hasRole method which is PostgreSQL compatible
        $isSuperAdmin = $user->hasRole('superadmin');

        if ($user && !$isSuperAdmin && !isset($data['desa_id'])) {
            $data['desa_id'] = $user->currentTeam->id;
        }

        return $data;
    }
}
