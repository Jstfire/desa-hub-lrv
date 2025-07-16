<?php

namespace App\Filament\Resources\OperatorResource\Pages;

use App\Filament\Resources\OperatorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOperator extends CreateRecord
{
    protected static string $resource = OperatorResource::class;

    protected function afterCreate(): void
    {
        // Assign the operator_desa role after creation
        $this->record->assignRole('operator_desa');
    }
}
