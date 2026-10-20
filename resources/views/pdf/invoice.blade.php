<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>{{ $invoice->invoice_number }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; color: #250543; font-size: 12px; }
    .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #DF2C8B; padding-bottom: 16px; }
    .brand { font-size: 22px; font-weight: bold; color: #DF2C8B; letter-spacing: 2px; }
    .brand small { display: block; font-size: 9px; color: #630C66; letter-spacing: 1px; font-weight: normal; }
    .inv-meta { text-align: right; }
    .inv-meta h2 { color: #250543; font-size: 16px; margin-bottom: 4px; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 10px; color: #fff; background: #BD1874; }
    .status-paid { background: #059669; }
    .status-partial { background: #d97706; }
    .section { margin-top: 20px; }
    .section h3 { font-size: 10px; text-transform: uppercase; color: #630C66; margin-bottom: 6px; letter-spacing: 1px; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 8px; }
    table.items th { background: #250543; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
    table.items td { padding: 8px; border-bottom: 1px solid #F0E6F5; }
    .totals { margin-top: 16px; width: 260px; margin-left: auto; }
    .totals td { padding: 5px 8px; }
    .totals .grand td { background: #DF2C8B; color: #fff; font-weight: bold; font-size: 13px; }
    .footer { margin-top: 40px; border-top: 1px solid #F0E6F5; padding-top: 10px; font-size: 9px; color: #630C66; text-align: center; }
</style>
</head>
<body>
    <div class="header">
        <div class="brand">FINTEGRITA<small>PT Fintegrita Digital Indonesia</small></div>
        <div class="inv-meta">
            <h2>INVOICE</h2>
            <div><strong>{{ $invoice->invoice_number }}</strong></div>
            <div>Tanggal: {{ $invoice->issue_date?->format('d M Y') }}</div>
            <div>Jatuh Tempo: {{ $invoice->due_date?->format('d M Y') }}</div>
            <span class="badge status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
        </div>
    </div>

    <div class="section">
        <h3>Ditagihkan Kepada</h3>
        <div><strong>{{ $invoice->customer?->company_name ?? $invoice->customer?->name }}</strong></div>
        <div>{{ $invoice->customer?->email }}</div>
        <div>{{ $invoice->customer?->phone }}</div>
    </div>

    <div class="section">
        <h3>Rincian</h3>
        <table class="items">
            <thead>
                <tr><th>Deskripsi</th><th style="text-align:right">Jumlah</th></tr>
            </thead>
            <tbody>
                @forelse ($invoice->order?->items ?? [] as $item)
                    <tr><td>{{ $item->item_name ?? $item->name }} ({{ $item->quantity }}x)</td>
                        <td style="text-align:right">Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</td></tr>
                @empty
                    <tr><td>Tagihan {{ $invoice->invoice_number }}</td>
                        <td style="text-align:right">Rp {{ number_format((float) $invoice->subtotal, 0, ',', '.') }}</td></tr>
                @endforelse
            </tbody>
        </table>

        <table class="totals">
            <tr><td>Subtotal</td><td style="text-align:right">Rp {{ number_format((float) $invoice->subtotal, 0, ',', '.') }}</td></tr>
            <tr><td>Pajak</td><td style="text-align:right">Rp {{ number_format((float) $invoice->tax, 0, ',', '.') }}</td></tr>
            <tr class="grand"><td>TOTAL</td><td style="text-align:right">Rp {{ number_format((float) $invoice->total, 0, ',', '.') }}</td></tr>
            <tr><td>Sudah Dibayar</td><td style="text-align:right">Rp {{ number_format((float) $invoice->amount_paid, 0, ',', '.') }}</td></tr>
            <tr><td><strong>Sisa</strong></td><td style="text-align:right"><strong>Rp {{ number_format((float) $invoice->total - (float) $invoice->amount_paid, 0, ',', '.') }}</strong></td></tr>
        </table>
    </div>

    <div class="footer">
        Terima kasih atas kepercayaan Anda &mdash; fintegrita.com &bull; Invoice ini dibuat otomatis oleh sistem.
    </div>
</body>
</html>
