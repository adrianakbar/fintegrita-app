<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use App\Support\FilamentKit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Digital Store';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentKit::relation('invoice_id', 'Invoice', 'invoice_number', 'Invoice'),
                Forms\Components\TextInput::make('payment_number')
                    ->label('No. Pembayaran')
                    ->default('PAY-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)))
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('payment_method')
                    ->label('Metode')
                    ->options([
                        'qris' => 'QRIS',
                        'bank_transfer' => 'Transfer Bank',
                        'va' => 'Virtual Account',
                        'credit_card' => 'Kartu Kredit',
                        'cash' => 'Tunai',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_gateway')
                    ->label('Gateway')
                    ->options(['manual' => 'Manual', 'midtrans' => 'Midtrans', 'xendit' => 'Xendit'])
                    ->default('manual')
                    ->required(),
                Forms\Components\TextInput::make('reference_id')->label('Referensi'),
                FilamentKit::money('amount', 'Jumlah'),
                FilamentKit::money('fee', 'Fee Gateway'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'failed' => 'Failed',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\DateTimePicker::make('paid_at')->label('Dibayar Pada')->default(now()),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_number')
                    ->label('No. Pembayaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice.customer.name')
                    ->label('Pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'credit_card' => 'Kartu Kredit',
                        default => ucfirst($state),
                    }),
                FilamentKit::moneyColumn('amount', 'Jumlah'),
                FilamentKit::statusColumn(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Dibayar Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'verified' => 'Verified', 'failed' => 'Failed']),
                Tables\Filters\SelectFilter::make('payment_gateway')
                    ->label('Gateway')
                    ->options(['manual' => 'Manual', 'midtrans' => 'Midtrans', 'xendit' => 'Xendit']),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalDescription('Verifikasi akan otomatis mencatat jurnal akuntansi dan meng-update status invoice.')
                    ->action(function (Payment $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Payment diverifikasi')
                            ->body("{$record->payment_number} — jurnal otomatis tercatat, invoice ter-update.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('paid_at', 'desc');
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
