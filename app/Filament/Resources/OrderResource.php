<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Support\FilamentKit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Digital Store';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentKit::relation('customer_id', 'Customer', 'name', 'Pelanggan'),
                Forms\Components\TextInput::make('order_number')
                    ->label('No. Order')
                    ->default('ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)))
                    ->required()
                    ->unique(ignoreRecord: true),
                FilamentKit::money('total_amount', 'Total Sebelum Diskon'),
                FilamentKit::money('discount_amount', 'Diskon'),
                FilamentKit::money('tax_amount', 'Pajak'),
                FilamentKit::money('final_amount', 'Total Akhir'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\DateTimePicker::make('ordered_at')->label('Tanggal Order')->default(now())->required(),
                Forms\Components\Textarea::make('notes')->label('Catatan')->columnSpanFull(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                FilamentKit::moneyColumn('final_amount', 'Total Akhir'),
                FilamentKit::statusColumn(),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
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
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
