<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSettingResource\Pages\CreateAboutSetting;
use App\Filament\Resources\AboutSettingResource\Pages\EditAboutSetting;
use App\Filament\Resources\AboutSettingResource\Pages\ListAboutSettings;
use App\Filament\Resources\AboutSettingResource\Schemas\AboutSettingForm;
use App\Filament\Resources\AboutSettingResource\Tables\AboutSettingsTable;
use App\Models\AboutSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AboutSettingResource extends Resource
{
    protected static ?string $model = AboutSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AboutSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutSettingsTable::configure($table);
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
            'index' => ListAboutSettings::route('/'),
            'create' => CreateAboutSetting::route('/create'),
            'edit' => EditAboutSetting::route('/{record}/edit'),
        ];
    }
}
