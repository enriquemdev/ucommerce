<?php

namespace App\Filament\Resources\VariationResource\Pages;

use App\Filament\Resources\VariationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVariation extends ViewRecord
{
    protected static string $resource = VariationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
