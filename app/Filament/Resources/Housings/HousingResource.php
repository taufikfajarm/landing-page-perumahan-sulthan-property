<?php

namespace App\Filament\Resources\Housings;

use App\Filament\Resources\Housings\Pages\CreateHousing;
use App\Filament\Resources\Housings\Pages\EditHousing;
use App\Filament\Resources\Housings\Pages\ListHousings;
use App\Filament\Resources\Housings\Schemas\HousingForm;
use App\Filament\Resources\Housings\Tables\HousingsTable;
use App\Models\Housing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HousingResource extends Resource
{
    protected static ?string $model = Housing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return HousingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HousingsTable::configure($table);
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
            'index' => ListHousings::route('/'),
            'create' => CreateHousing::route('/create'),
            'edit' => EditHousing::route('/{record}/edit'),
        ];
    }
}
