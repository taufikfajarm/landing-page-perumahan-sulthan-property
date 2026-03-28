<?php

namespace App\Filament\Resources\Housings\Pages;

use App\Filament\Resources\Housings\HousingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHousings extends ListRecords
{
    protected static string $resource = HousingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
