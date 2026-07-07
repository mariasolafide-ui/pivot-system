<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pivot Cafe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', 'Helvetica', sans-serif; font-size: 10px; padding: 15px; color: #1e293b; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double #1b4332; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { font-size: 22px; color: #1b4332; letter-spacing: 2px; }
        .header p { font-size: 11px; color: #64748b; margin: 2px 0; }
        .header .subtitle { background: #1b4332; color: white; padding: 4px 20px; border-radius: 4px; font-size: 11px; font-weight: 700; display: inline-block; margin-top: 6px; text-transform: uppercase; letter-spacing: 1px; }
        .periode { text-align: center; font-weight: 600; font-size: 11px; color: #1b4332; margin: 8px 0 14px; }
        .section { margin-bottom: 14px; }
        .section-title { font-size: 13px; font-weight: 700; color: #1b4332; border-bottom: 2px solid #d4a373; padding-bottom: 4px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; font-size: 9px; margin-bottom: 8px; }
        th { background: #1b4332; color: white; padding: 5px 6px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #1b4332; }
        td { padding: 4px 6px; border: 1px solid #e5e7eb; vertical-align: middle; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-success { color: #16a34a; }
        .text-danger { color: #dc2626; }
        .text-warning { color: #f59e0b; }
        .badge { display: inline-block; padding: 1px 8px; border-radius: 10px; font-size: 7px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .stats-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 6px; margin-bottom: 12px; }
        .stat-box { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 4px; padding: 6px 8px; text-align: center; }
        .stat-box .label { font-size: 7px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; }
        .stat-box .value { font-size: 14px; font-weight: 700; color: #1b4332; }
        .footer { border-top: 2px solid #e5e7eb; padding-top: 10px; margin-top: 16px; text-align: center; font-size: 8px; color: #94a3b8; }
        .page-break { page-break-after: always; }
        @page { margin: 12mm; }
        @media print { body { padding: 0; } .page-break { page-break-after: always; } }
    </style>
</head>
<body>

<div class="header">
    <h1>☕ PIVOT CAFE</h1>
    <p>Sistem Informasi Manajemen & Akuntansi Operasional Retail</p>
    <p style="font-size:9px; color:#94a3b8;">Sleman, Daerah Istimewa Yogyakarta</p>
    <div class="subtitle">Laporan Analisis Penjualan</div>
</div>

<div class="periode">
    Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-box"><div class="label">Omzet</div><div class="value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div></div>
    <div class="stat-box"><div class="label">Total Pesanan</div><div class="value">{{ $totalOrders ?? 0 }}</div></div>
    <div class="stat-box"><div class="label">Rata-rata Harian</div><div class="value">Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</div></div>
    <div class="stat-box"><div class="label">✅ Selesai</div><div class="value" style="color:#16a34a;">{{ $orderStatuses['selesai'] ?? 0 }}</div></div>
    <div class="stat-box"><div class="label">❌ Dibatalkan</div><div class="value" style="color:#dc2626;">{{ $orderStatuses['dibatalkan'] ?? 0 }}</div></div>
    <div class="stat-box"><div class="label">⭐ Feedback</div><div class="value">{{ $feedbackStats['total'] ?? 0 }}</div></div>
</div>

{{-- MENU TERLARIS --}}
<div class="section">
    <div class="section-title">🔥 Top 10 Menu Terlaris</div>
    <table>
        <thead><tr><th style="width:30px;">#</th><th>Menu</th><th>Kategori</th><th class="text-center">Terjual</th><th class="text-right">Omzet</th></tr></thead>
        <tbody>
            @php $rank=1; @endphp
            @forelse($topMenus ?? [] as $menu)
            <tr><td class="text-center" style="font-weight:700; color:#d4a373;">{{ $rank++ }}</td><td>{{ $menu['name'] }}</td><td>{{ $menu['category'] }}</td><td class="text-center"><strong>{{ $menu['quantity'] }}</strong></td><td class="text-right"><strong>Rp {{ number_format($menu['revenue'], 0, ',', '.') }}</strong></td></tr>
            @empty
            <tr><td colspan="5" class="text-center" style="color:#94a3b8;">Belum ada data menu.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- KATEGORI --}}
<div class="section">
    <div class="section-title">📊 Performa Kategori</div>
    <table>
        <thead><tr><th style="width:30px;">#</th><th>Kategori</th><th class="text-center">Terjual</th><th class="text-right">Omzet</th><th class="text-center">Kontribusi</th></tr></thead>
        <tbody>
            @php $rank=1; $totalQty = $topCategories->sum('total_qty'); @endphp
            @forelse($topCategories ?? [] as $cat)
            <tr><td class="text-center" style="font-weight:700; color:#d4a373;">{{ $rank++ }}</td><td>{{ $cat->name }}</td><td class="text-center"><strong>{{ $cat->total_qty }}</strong></td><td class="text-right"><strong>Rp {{ number_format($cat->total_revenue, 0, ',', '.') }}</strong></td><td class="text-center">@php $persen = $totalQty > 0 ? round($cat->total_qty / $totalQty * 100, 1) : 0; @endphp <span class="badge badge-info">{{ $persen }}%</span></td></tr>
            @empty
            <tr><td colspan="5" class="text-center" style="color:#94a3b8;">Belum ada data kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="page-break"></div>

{{-- FEEDBACK --}}
<div class="section">
    <div class="section-title">⭐ Feedback Pelanggan</div>
    <table>
        <thead><tr><th style="width:70px;">Tanggal</th><th style="width:50px;">Order</th><th style="width:50px;text-align:center;">Rating</th><th>Komentar</th></tr></thead>
        <tbody>
            @forelse(($feedbacks ?? [])->take(20) as $fb)
            <tr><td>{{ $fb->created_at->format('d/m/Y') }}</td><td>#{{ $fb->order_id }}</td><td class="text-center"><span class="badge {{ $fb->rating >= 4 ? 'badge-success' : ($fb->rating >= 3 ? 'badge-warning' : 'badge-danger') }}">⭐ {{ $fb->rating }}</span></td><td>{{ $fb->comment ?: 'Tidak ada komentar' }}</td></tr>
            @empty
            <tr><td colspan="4" class="text-center" style="color:#94a3b8;">Belum ada feedback.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- RETAIL --}}
<div class="section">
    <div class="section-title">📦 Stok & Penjualan Retail</div>
    <table>
        <thead><tr><th style="width:30px;">#</th><th>Nama Produk</th><th class="text-center">Stok</th><th class="text-center">Terjual</th><th class="text-right">Harga</th><th class="text-right">Omzet</th></tr></thead>
        <tbody>
            @php $rank=1; @endphp
            @forelse($retailProducts ?? [] as $prod)
            <tr><td class="text-center">{{ $rank++ }}</td><td>{{ $prod->name }}</td><td class="text-center"><span class="badge {{ $prod->stock <= 3 ? 'badge-danger' : 'badge-success' }}">{{ $prod->stock }}</span></td><td class="text-center">{{ $prod->terjual ?? 0 }}</td><td class="text-right">Rp {{ number_format($prod->price, 0, ',', '.') }}</td><td class="text-right">Rp {{ number_format(($prod->terjual ?? 0) * $prod->price, 0, ',', '.') }}</td></tr>
            @empty
            <tr><td colspan="6" class="text-center" style="color:#94a3b8;">Belum ada produk retail.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- TRANSAKSI (Ringkas) --}}
<div class="section">
    <div class="section-title">📋 Daftar Transaksi</div>
    <table>
        <thead><tr><th style="width:40px;">ID</th><th style="width:70px;">Tanggal</th><th>Pelanggan</th><th style="width:50px;">Meja</th><th style="width:60px;text-align:center;">Status</th><th style="width:70px;text-align:right;">Total</th></tr></thead>
        <tbody>
            @forelse(($orders ?? [])->take(15) as $tx)
            <tr><td>#{{ $tx->id }}</td><td>{{ $tx->created_at->format('d/m/Y H:i') }}</td><td>{{ $tx->customer_name }}</td><td>M{{ $tx->table->number ?? '-' }}</td><td class="text-center"><span class="badge {{ $tx->payment_status === 'paid' ? 'badge-success' : 'badge-danger' }}">{{ $tx->payment_status === 'paid' ? 'Lunas' : 'Pending' }}</span></td><td class="text-right">Rp {{ number_format($tx->total, 0, ',', '.') }}</td></tr>
            @empty
            <tr><td colspan="6" class="text-center" style="color:#94a3b8;">Tidak ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if(($orders ?? [])->count() > 15)
    <p style="font-size:8px; color:#94a3b8; text-align:right; margin-top:4px;">* Menampilkan 15 dari {{ $orders->count() }} transaksi</p>
    @endif
</div>

<div class="footer">
    <p>Laporan ini dihasilkan secara otomatis oleh Sistem Pivot Cafe</p>
    <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
</div>

</body>
</html>