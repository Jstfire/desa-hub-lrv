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
}
