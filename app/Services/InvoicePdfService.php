<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoicePdfService
{
    public function generate(Invoice $invoice): string
    {
        $invoice->load(['customer', 'order.items', 'payments']);

        $pdf = Pdf::loadView('pdf.invoice', ['invoice' => $invoice])
            ->setPaper('a4');

        $path = "invoices/{$invoice->invoice_number}.pdf";
        Storage::disk('public')->put($path, $pdf->output());

        $invoice->forceFill(['pdf_path' => $path])->saveQuietly();

        return $path;
    }

    public function download(Invoice $invoice)
    {
        if (! $invoice->pdf_path || ! Storage::disk('public')->exists($invoice->pdf_path)) {
            $this->generate($invoice);
        }

        return Storage::disk('public')->download($invoice->pdf_path, $invoice->invoice_number.'.pdf');
    }
}
