<?php

namespace App\Filament\Resources\VariationGroupResource\Pages;

use App\Filament\Resources\VariationGroupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariationGroups extends ListRecords
{
    protected static string $resource = VariationGroupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
