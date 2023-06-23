<?php

namespace App\Filament\Resources\SpecificationResource\Pages;

use App\Filament\Resources\SpecificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecification extends EditRecord
{
    protected static string $resource = SpecificationResource::class;

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
