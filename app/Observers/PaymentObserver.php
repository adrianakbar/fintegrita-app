<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    // ponytail: hanya status verified yang dijurnal; reversal saat payment batal belum ada
    public function saved(Payment $payment): void
    {
        if ($payment->status !== 'verified') {
            return;
        }

        DB::transaction(function () use ($payment) {
            $already = JournalEntry::where('reference_type', Payment::class)
                ->where('reference_id', $payment->id)
                ->exists();

            if (! $already) {
                $this->postJournal($payment);
            }

            $this->syncInvoice($payment);
        });
    }

    protected function postJournal(Payment $payment): void
    {
        $bank = Account::where('code', '1-1002')->first();
        $receivable = Account::where('code', '1-1100')->first();
        $feeExpense = Account::where('code', '5-2000')->first();

        if (! $bank || ! $receivable || ! $feeExpense) {
            return;
        }

        $amount = round((float) $payment->amount, 2);
        $fee = round((float) $payment->fee, 2);
        $net = round($amount - $fee, 2);

        $entry = JournalEntry::create([
            'entry_number' => $this->nextEntryNumber(),
            'entry_date' => ($payment->paid_at ?? now())->toDateString(),
            'reference_type' => Payment::class,
            'reference_id' => $payment->id,
            'reference_number' => $payment->payment_number,
            'description' => 'Penerimaan pembayaran '.$payment->payment_number,
            'total_debit' => $amount,
            'total_credit' => $amount,
            'is_posted' => true,
            'posted_at' => now(),
            'created_by' => $payment->verified_by ?? auth()->id(),
        ]);

        $lines = [
            ['account_id' => $bank->id, 'description' => 'Kas masuk (net)', 'debit' => $net, 'credit' => 0],
            ['account_id' => $receivable->id, 'description' => 'Pelunasan piutang', 'debit' => 0, 'credit' => $amount],
        ];

        if ($fee > 0) {
            $lines[] = ['account_id' => $feeExpense->id, 'description' => 'Biaya payment gateway', 'debit' => $fee, 'credit' => 0];
        }

        foreach ($lines as $i => $line) {
            $entry->lines()->create($line + ['line_order' => $i + 1]);
        }
    }

    protected function syncInvoice(Payment $payment): void
    {
        $invoice = Invoice::find($payment->invoice_id);

        if (! $invoice) {
            return;
        }

        $paid = (float) $invoice->payments()
            ->where('status', 'verified')
            ->sum('amount');

        $invoice->forceFill([
            'amount_paid' => $paid,
            'status' => $paid >= (float) $invoice->total ? 'paid' : ($paid > 0 ? 'partial' : $invoice->status),
        ])->saveQuietly();
    }

    protected function nextEntryNumber(): string
    {
        $prefix = 'JE-'.now()->format('Ym').'-';
        $last = JournalEntry::where('entry_number', 'like', $prefix.'%')
            ->orderByDesc('entry_number')
            ->value('entry_number');

        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix.str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }
}
