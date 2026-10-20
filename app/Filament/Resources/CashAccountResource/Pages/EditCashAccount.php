<?php

namespace App\Filament\Resources\CashAccountResource\Pages;

use App\Filament\Resources\CashAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCashAccount extends EditRecord
{
    protected static string $resource = CashAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
