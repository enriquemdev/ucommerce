<?php

namespace App\Filament\Resources\SpecificationResource\Pages;

use App\Filament\Resources\SpecificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpecification extends ViewRecord
{
    protected static string $resource = SpecificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
