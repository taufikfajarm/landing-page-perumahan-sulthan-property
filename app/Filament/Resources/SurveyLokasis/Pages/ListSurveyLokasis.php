<?php

namespace App\Filament\Resources\SurveyLokasis\Pages;

use App\Filament\Resources\SurveyLokasis\SurveyLokasiResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyLokasis extends ListRecords
{
    protected static string $resource = SurveyLokasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
