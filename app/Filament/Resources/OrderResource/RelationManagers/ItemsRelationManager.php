<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Support\FilamentKit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'Item Order';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_name')->label('Nama Item')->required(),
                Forms\Components\TextInput::make('quantity')->label('Qty')->numeric()->default(1)->required(),
                FilamentKit::money('unit_price', 'Harga Satuan'),
                FilamentKit::money('subtotal', 'Subtotal'),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_name')
            ->columns([
                Tables\Columns\TextColumn::make('item_name')->label('Nama Item')->searchable(),
                Tables\Columns\TextColumn::make('quantity')->label('Qty'),
                FilamentKit::moneyColumn('unit_price', 'Harga Satuan'),
                FilamentKit::moneyColumn('subtotal', 'Subtotal'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
