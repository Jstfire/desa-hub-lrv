<?php

namespace App\Filament\Resources\DesaResource\Pages;

use App\Filament\Resources\DesaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class CreateDesa extends CreateRecord
{
    protected static string $resource = DesaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no team_id is provided, create a new team
        if (!isset($data['team_id']) || empty($data['team_id'])) {
            $user = Auth::user();
            $team = $user->ownedTeams()->create([
                'name' => $data['nama'] . ' Team',
                'personal_team' => false,
            ]);
            $data['team_id'] = $team->id;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Get the created record
        $desa = $this->record;

        // If we have both an admin and a team, ensure the admin is added to the team
        if ($desa->admin_id && $desa->team_id) {
            $team = Team::find($desa->team_id);
            $adminId = $desa->admin_id;

            if ($team && !$team->users()->where('user_id', $adminId)->exists()) {
                $team->users()->attach($adminId, ['role' => 'admin']);
            }
        }
    }
}
