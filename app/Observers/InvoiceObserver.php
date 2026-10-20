<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Services\InvoicePdfService;

class InvoiceObserver
{
    public function created(Invoice $invoice): void
    {
        app(InvoicePdfService::class)->generate($invoice);
    }
}
