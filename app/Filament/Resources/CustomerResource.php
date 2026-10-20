<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'CRM & Pelanggan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Pelanggan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Profil')->schema([
                Forms\Components\TextInput::make('customer_number')
                    ->label('Nomor Pelanggan')
                    ->default('CUST-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)))
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')->label('Nama')->required(),
                Forms\Components\TextInput::make('company_name')->label('Perusahaan'),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'individual' => 'Individu',
                        'umkm' => 'UMKM',
                        'koperasi' => 'Koperasi',
                        'education' => 'Pendidikan',
                        'corporate' => 'Korporasi',
                    ])
                    ->default('individual')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Kontak')->schema([
                Forms\Components\TextInput::make('email')->label('Email')->email()->required(),
                Forms\Components\TextInput::make('phone')->label('Telepon')->tel(),
                Forms\Components\TextInput::make('whatsapp')->label('WhatsApp')->tel(),
                Forms\Components\Textarea::make('address')->label('Alamat')->columnSpanFull(),
                Forms\Components\TextInput::make('city')->label('Kota'),
                Forms\Components\TextInput::make('province')->label('Provinsi'),
                Forms\Components\TextInput::make('postal_code')->label('Kode Pos'),
                Forms\Components\TextInput::make('tax_number')->label('NPWP'),
                Forms\Components\Textarea::make('notes')->label('Catatan')->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_number')
                    ->label('No. Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->company_name),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon')->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->colors([
                        'active' => 'success',
                        'inactive' => 'gray',
                    ])
                    ->searchable(),
                Tables\Columns\IconColumn::make('portal')
                    ->label('Portal')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->user_id !== null),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive']),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'individual' => 'Individu',
                        'umkm' => 'UMKM',
                        'koperasi' => 'Koperasi',
                        'education' => 'Pendidikan',
                        'corporate' => 'Korporasi',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('createPortalAccount')
                    ->label('Buat Akun Portal')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->visible(fn ($record) => $record->user_id === null)
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('Password Awal')
                            ->default(Str::password(12, symbols: false))
                            ->required()
                            ->helperText('Catat dan kirimkan ke pelanggan via WhatsApp/email.'),
                    ])
                    ->action(function (array $data, $record) {
                        $user = User::create([
                            'name' => $record->company_name ?: $record->name,
                            'email' => $record->email,
                            'password' => $data['password'],
                            'role' => 'customer',
                            'status' => 'active',
                        ]);
                        $record->update(['user_id' => $user->id]);

                        Notification::make()
                            ->title('Akun portal dibuat')
                            ->body("Login: {$record->email} — password awal ada di form. Segera kirim ke pelanggan.")
                            ->success()
                            ->persistent()
                            ->send();
                    }),
                Tables\Actions\Action::make('resetPortalPassword')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->visible(fn ($record) => $record->user_id !== null)
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('Password Baru')
                            ->default(Str::password(12, symbols: false))
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        $record->user->update(['password' => $data['password']]);

                        Notification::make()
                            ->title('Password portal direset')
                            ->body("Password baru untuk {$record->email} sudah aktif.")
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
