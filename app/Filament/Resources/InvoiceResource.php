<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use App\Services\InvoicePdfService;
use App\Support\FilamentKit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Digital Store';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Invoice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentKit::relation('customer_id', 'Customer', 'name', 'Pelanggan'),
                FilamentKit::relation('order_id', 'Order', 'order_number', 'Order (opsional)')
                    ->required(false),
                Forms\Components\TextInput::make('invoice_number')
                    ->label('No. Invoice')
                    ->default('INV-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)))
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('issue_date')->label('Tanggal Terbit')->default(now())->required(),
                Forms\Components\DatePicker::make('due_date')->label('Jatuh Tempo')->default(now()->addDays(14))->required(),
                FilamentKit::money('subtotal', 'Subtotal'),
                FilamentKit::money('tax', 'Pajak'),
                FilamentKit::money('total', 'Total'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'void' => 'Void',
                    ])
                    ->default('sent')
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                FilamentKit::moneyColumn('total', 'Total'),
                FilamentKit::moneyColumn('amount_paid', 'Dibayar'),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->due_date->isPast() && ! in_array($record->status, ['paid', 'void'])
                        ? 'danger' : 'gray')
                    ->sortable(),
                FilamentKit::statusColumn(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'void' => 'Void',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(fn (Invoice $record) => app(InvoicePdfService::class)->download($record)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('issue_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
