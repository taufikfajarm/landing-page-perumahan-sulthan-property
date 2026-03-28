<?php

namespace App\Filament\Resources\BlogAds\Pages;

use App\Filament\Resources\BlogAds\BlogAdResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogAd extends EditRecord
{
    protected static string $resource = BlogAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
