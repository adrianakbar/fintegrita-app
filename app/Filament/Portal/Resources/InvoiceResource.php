<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\InvoiceResource\Pages;
use App\Filament\Portal\Resources\InvoiceResource\RelationManagers;
use App\Filament\Portal\Concerns\ScopedToCustomer;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    use ScopedToCustomer;

    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Invoice & Tagihan';
    protected static ?int $navigationSort = 2;





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->numeric(),
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('invoice_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('issue_date')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('tax')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('amount_paid')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('unpaid'),
                Forms\Components\TextInput::make('pdf_path')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pdf_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListInvoices::route('/'),
        ];
    }

}
