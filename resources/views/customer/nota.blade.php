<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota — {{ $order->transaction_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; font-size: 13px; color: #1a1a1a; padding: 20px; width: 300px; margin: 0 auto; }
        
        .header { text-align: center; margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 10px; }
        .header h1 { font-size: 18px; font-weight: 700; color: #0e6446; }
        
        /* Tampilan Tabel yang Rapi & Presisi */
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        
        .items-section { border-top: 1px dashed #ccc; border-bottom: 1px dashed #ccc; padding: 10px 0; margin: 10px 0; }
        .item-row td { padding: 3px 0; vertical-align: top; }
        
        .totals-section { width: 100%; }
        .totals-section td { padding: 2px 0; }
        .total-final { font-weight: 700; font-size: 15px; border-top: 1px solid #000; padding-top: 8px; margin-top: 5px; }
        
        .footer { text-align: center; margin-top: 15px; font-size: 11px; color: #6b7280; }
        
        .btn-box { margin-top: 20px; }
        .print-btn { display: block; width: 100%; padding: 10px; background: #0e6446; color: white; border: none; border-radius: 6px; cursor: pointer; text-align: center; text-decoration: none; font-weight: 600; margin-bottom: 10px; }
        
        @media print { .btn-box { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pivot Cafe</h1>
        <p>Nota Pembelian</p>
    </div>

    <table class="info-table">
        <tr><td width="35%">Transaksi</td><td>: {{ $order->transaction_id }}</td></tr>
        <tr><td>Meja</td><td>: Meja {{ $order->table->number }}</td></tr>
        <tr><td>Pelanggan</td><td>: {{ $order->customer_name }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Pembayaran</td><td>: {{ $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet' }}</td></tr>
    </table>

    <table class="items-section">
        @foreach($order->items as $item)
        <tr class="item-row">
            <td width="70%">
                {{ $item->quantity }}x {{ $item->menu->name }}
                @if($item->notes)
                <div style="font-size:10px;color:#6b7280;font-style:italic;padding-left:10px;">&bull; {{ $item->notes }}</div>
                @endif
            </td>
            <td align="right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <table class="totals-section">
        <tr><td>Subtotal</td><td align="right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td></tr>
        @if($order->discount > 0)
        <tr><td>Diskon</td><td align="right">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td></tr>
        @endif
        <tr class="total-final"><td>TOTAL</td><td align="right">Rp {{ number_format($order->total, 0, ',', '.') }}</td></tr>
    </table>

    <div class="footer">
        <p>Terima kasih telah berkunjung!</p>
        <p>Pivot Cafe</p>
    </div>

    @if(!isset($is_pdf))
    <div class="btn-box">
        <button class="print-btn" onclick="window.print()">Cetak Nota</button>
        <a href="{{ route('customer.nota.download', $order->transaction_id) }}" class="print-btn" style="background:#6b7280">Download PDF</a>
    </div>
    @endif
</body>
</html>