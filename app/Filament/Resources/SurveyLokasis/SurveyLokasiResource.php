<?php

namespace App\Filament\Resources\SurveyLokasis;

use App\Filament\Resources\SurveyLokasis\Pages\CreateSurveyLokasi;
use App\Filament\Resources\SurveyLokasis\Pages\EditSurveyLokasi;
use App\Filament\Resources\SurveyLokasis\Pages\ListSurveyLokasis;
use App\Filament\Resources\SurveyLokasis\Schemas\SurveyLokasiForm;
use App\Filament\Resources\SurveyLokasis\Tables\SurveyLokasisTable;
use App\Models\SurveyLokasi;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SurveyLokasiResource extends Resource
{
    protected static ?string $model = SurveyLokasi::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Survey Lokasi';

    protected static ?string $modelLabel = 'Survey Lokasi';

    protected static ?string $pluralModelLabel = 'Survey Lokasi';

    public static function form(Schema $schema): Schema
    {
        return SurveyLokasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyLokasisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSurveyLokasis::route('/'),
            'create' => CreateSurveyLokasi::route('/create'),
            'edit' => EditSurveyLokasi::route('/{record}/edit'),
        ];
    }
}
