<?php

namespace App\Filament\Resources\BlogAds\Pages;

use App\Filament\Resources\BlogAds\BlogAdResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogAds extends ListRecords
{
    protected static string $resource = BlogAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
