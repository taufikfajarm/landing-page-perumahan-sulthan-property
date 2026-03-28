<?php

namespace App\Filament\Resources\HousingTypes\Pages;

use App\Filament\Resources\HousingTypes\HousingTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHousingTypes extends ListRecords
{
    protected static string $resource = HousingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
