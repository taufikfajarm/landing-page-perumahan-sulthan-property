<?php

namespace App\Filament\Resources\ProsesAkads;

use App\Filament\Resources\ProsesAkads\Pages\CreateProsesAkad;
use App\Filament\Resources\ProsesAkads\Pages\EditProsesAkad;
use App\Filament\Resources\ProsesAkads\Pages\ListProsesAkads;
use App\Filament\Resources\ProsesAkads\Schemas\ProsesAkadForm;
use App\Filament\Resources\ProsesAkads\Tables\ProsesAkadsTable;
use App\Models\ProsesAkad;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProsesAkadResource extends Resource
{
    protected static ?string $model = ProsesAkad::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Proses Akad';

    protected static ?string $modelLabel = 'Proses Akad';

    protected static ?string $pluralModelLabel = 'Proses Akad';

    public static function form(Schema $schema): Schema
    {
        return ProsesAkadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProsesAkadsTable::configure($table);
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
            'index' => ListProsesAkads::route('/'),
            'create' => CreateProsesAkad::route('/create'),
            'edit' => EditProsesAkad::route('/{record}/edit'),
        ];
    }
}
