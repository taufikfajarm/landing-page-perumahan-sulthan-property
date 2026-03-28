<?php

namespace App\Filament\Resources\Housings\Pages;

use App\Filament\Resources\Housings\HousingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHousing extends EditRecord
{
    protected static string $resource = HousingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
