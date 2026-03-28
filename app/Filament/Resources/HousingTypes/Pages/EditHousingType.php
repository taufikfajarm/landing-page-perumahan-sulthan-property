<?php

namespace App\Filament\Resources\HousingTypes\Pages;

use App\Filament\Resources\HousingTypes\HousingTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHousingType extends EditRecord
{
    protected static string $resource = HousingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
