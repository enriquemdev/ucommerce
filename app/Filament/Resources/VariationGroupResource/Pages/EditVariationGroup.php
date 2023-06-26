<?php

namespace App\Filament\Resources\VariationGroupResource\Pages;

use App\Filament\Resources\VariationGroupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVariationGroup extends EditRecord
{
    protected static string $resource = VariationGroupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
