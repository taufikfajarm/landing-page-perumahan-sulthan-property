<?php

namespace App\Filament\Resources\BlogAds;

use App\Filament\Resources\BlogAds\Pages\CreateBlogAd;
use App\Filament\Resources\BlogAds\Pages\EditBlogAd;
use App\Filament\Resources\BlogAds\Pages\ListBlogAds;
use App\Filament\Resources\BlogAds\Schemas\BlogAdForm;
use App\Filament\Resources\BlogAds\Tables\BlogAdsTable;
use App\Models\BlogAd;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogAdResource extends Resource
{
    protected static ?string $model = BlogAd::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BlogAdForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogAdsTable::configure($table);
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
            'index' => ListBlogAds::route('/'),
            'create' => CreateBlogAd::route('/create'),
            'edit' => EditBlogAd::route('/{record}/edit'),
        ];
    }
}
