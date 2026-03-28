<?php

namespace App\Filament\Resources\BankPartners;

use App\Filament\Resources\BankPartners\Pages\CreateBankPartner;
use App\Filament\Resources\BankPartners\Pages\EditBankPartner;
use App\Filament\Resources\BankPartners\Pages\ListBankPartners;
use App\Filament\Resources\BankPartners\Schemas\BankPartnerForm;
use App\Filament\Resources\BankPartners\Tables\BankPartnersTable;
use App\Models\BankPartner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BankPartnerResource extends Resource
{
    protected static ?string $model = BankPartner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BankPartnerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BankPartnersTable::configure($table);
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
            'index' => ListBankPartners::route('/'),
            'create' => CreateBankPartner::route('/create'),
            'edit' => EditBankPartner::route('/{record}/edit'),
        ];
    }
}
