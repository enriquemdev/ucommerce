<?php

namespace App\Filament\Resources\CompanyBranchResource\Pages;

use App\Filament\Resources\CompanyBranchResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCompanyBranch extends ViewRecord
{
    protected static string $resource = CompanyBranchResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
