<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\CourseEnrollmentResource\Pages;
use App\Filament\Portal\Resources\CourseEnrollmentResource\RelationManagers;
use App\Filament\Portal\Concerns\ScopedToCustomer;
use App\Models\CourseEnrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseEnrollmentResource extends Resource
{
    use ScopedToCustomer;

    protected static ?string $model = CourseEnrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Kelas & Pelatihan';
    protected static ?int $navigationSort = 4;





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('order_id')
                    ->numeric(),
                Forms\Components\TextInput::make('enrollment_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('registered'),
                Forms\Components\TextInput::make('progress_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DateTimePicker::make('certificate_issued_at'),
                Forms\Components\TextInput::make('certificate_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('certificate_url')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollment_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('progress_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate_issued_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('certificate_url')
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
            'index' => Pages\ListCourseEnrollments::route('/'),
        ];
    }

        public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
        if ($user && !in_array($user->role, ['super_admin', 'director'], true)) {
            $customerId = $user->customer?->id ?? 0;
            return $query->where('customer_id', $customerId);
        }
        return $query;
    }
}
