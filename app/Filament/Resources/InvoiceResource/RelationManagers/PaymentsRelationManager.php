<?php

namespace App\Filament\Resources\InvoiceResource\RelationManagers;

use App\Support\FilamentKit;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $title = 'Pembayaran';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_number')
            ->columns([
                Tables\Columns\TextColumn::make('payment_number')->label('No. Pembayaran')->searchable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Metode')->badge(),
                FilamentKit::moneyColumn('amount', 'Jumlah'),
                FilamentKit::moneyColumn('fee', 'Fee'),
                FilamentKit::statusColumn(),
                Tables\Columns\TextColumn::make('paid_at')->label('Dibayar')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
