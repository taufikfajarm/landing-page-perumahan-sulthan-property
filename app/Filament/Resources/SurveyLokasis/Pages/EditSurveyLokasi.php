<?php

namespace App\Filament\Resources\SurveyLokasis\Pages;

use App\Filament\Resources\SurveyLokasis\SurveyLokasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyLokasi extends EditRecord
{
    protected static string $resource = SurveyLokasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
