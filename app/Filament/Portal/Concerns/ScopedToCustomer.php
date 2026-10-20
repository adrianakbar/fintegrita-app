<?php

namespace App\Filament\Portal\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait ScopedToCustomer
{
    /** Portal read-only + hanya data milik customer yang login. */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $customerId = auth()->user()?->customer?->id;

        return $customerId
            ? $query->where($query->getModel()->getTable().'.customer_id', $customerId)
            : $query->whereRaw('1 = 0');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
