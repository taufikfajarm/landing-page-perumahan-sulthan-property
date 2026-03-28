<?php

namespace App\Filament\Resources\ProsesAkads\Pages;

use App\Filament\Resources\ProsesAkads\ProsesAkadResource;
use Filament\Resources\Pages\ListRecords;

class ListProsesAkads extends ListRecords
{
    protected static string $resource = ProsesAkadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
