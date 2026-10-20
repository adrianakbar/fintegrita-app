<?php

namespace App\Filament\Resources\CashAccountResource\Pages;

use App\Filament\Resources\CashAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashAccounts extends ListRecords
{
    protected static string $resource = CashAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
