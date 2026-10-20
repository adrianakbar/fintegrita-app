<?php

namespace App\Support;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

/**
 * Helper kolom/form standar Fintegrita admin.
 * ponytail: pabrik kecil, tanpa dependensi baru.
 */
class FilamentKit
{
    /** Select relasi dengan pencarian (mengganti input angka customer_id dsb). */
    public static function relation(string $name, string $model, string $titleColumn, ?string $label = null): Select
    {
        return Select::make($name)
            ->label($label ?? str($name)->replace('_id', '')->title())
            ->relationship($name, $titleColumn)
            ->searchable()
            ->preload()
            ->required();
    }

    /** Input uang dengan prefix Rp. */
    public static function money(string $name, ?string $label = null, bool $required = true): TextInput
    {
        return TextInput::make($name)
            ->label($label ?? str($name)->title())
            ->numeric()
            ->prefix('Rp')
            ->default(0)
            ->required($required);
    }

    /** Kolom uang di tabel. */
    public static function moneyColumn(string $name, ?string $label = null): TextColumn
    {
        return TextColumn::make($name)
            ->label($label ?? str($name)->title())
            ->money('IDR', divideBy: 1)
            ->sortable();
    }

    /** Badge status dengan warna semantik. */
    public static function statusColumn(string $name = 'status', array $colors = []): TextColumn
    {
        return TextColumn::make($name)
            ->badge()
            ->colors($colors + [
                'draft' => 'gray',
                'pending' => 'warning',
                'sent' => 'info',
                'partial' => 'warning',
                'paid' => 'success',
                'verified' => 'success',
                'confirmed' => 'info',
                'completed' => 'success',
                'cancelled' => 'danger',
                'failed' => 'danger',
                'active' => 'success',
                'inactive' => 'gray',
            ])
            ->searchable();
    }

    public static function dateTime(string $name, ?string $label = null): DateTimePicker
    {
        return DateTimePicker::make($name)->label($label ?? str($name)->title());
    }
}
