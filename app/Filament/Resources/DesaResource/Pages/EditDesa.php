<?php

namespace App\Filament\Resources\DesaResource\Pages;

use App\Filament\Resources\DesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;

class EditDesa extends EditRecord
{
    protected static string $resource = DesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If admin_id changed, we'll handle the team association in the observer
        return $data;
    }

    protected function afterSave(): void
    {
        // Get the record and check if admin_id was changed
        $desa = $this->record;

        // The DesaObserver will handle team assignments when admin_id changes
    }
}
