<?php

namespace App\Filament\Resources\BankPartners\Pages;

use App\Filament\Resources\BankPartners\BankPartnerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBankPartner extends EditRecord
{
    protected static string $resource = BankPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
