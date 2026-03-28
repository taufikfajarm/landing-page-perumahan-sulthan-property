<?php

namespace App\Filament\Resources\BlogAds\Pages;

use App\Filament\Resources\BlogAds\BlogAdResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogAd extends CreateRecord
{
    protected static string $resource = BlogAdResource::class;
}
