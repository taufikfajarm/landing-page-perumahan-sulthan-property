<?php

namespace App\Filament\Resources\ProsesAkads\Pages;

use App\Filament\Resources\ProsesAkads\ProsesAkadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProsesAkad extends EditRecord
{
    protected static string $resource = ProsesAkadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
