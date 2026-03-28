<?php

namespace App\Filament\Resources\HousingTypes;

use App\Filament\Resources\HousingTypes\Pages\CreateHousingType;
use App\Filament\Resources\HousingTypes\Pages\EditHousingType;
use App\Filament\Resources\HousingTypes\Pages\ListHousingTypes;
use App\Filament\Resources\HousingTypes\Schemas\HousingTypeForm;
use App\Filament\Resources\HousingTypes\Tables\HousingTypesTable;
use App\Models\HousingType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HousingTypeResource extends Resource
{
    protected static ?string $model = HousingType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return HousingTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HousingTypesTable::configure($table);
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
            'index' => ListHousingTypes::route('/'),
            'create' => CreateHousingType::route('/create'),
            'edit' => EditHousingType::route('/{record}/edit'),
        ];
    }
}
