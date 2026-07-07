<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'items'])->latest();

        // =============== FILTER TANGGAL ===============
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // =============== FILTER STATUS ===============
        if ($request->filled('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }

        // =============== FILTER PENCARIAN ===============
        if ($request->filled('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%");
            });
        }

        // =============== FILTER PEMBAYARAN ===============
        if ($request->filled('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // =============== FILTER METODE PEMBAYARAN ===============
        if ($request->filled('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function monitor()
    {
        // 🔥 PERBAIKAN: eager-load 'items.retailProduct' juga,
        // karena satu order item bisa berasal dari menu utama ATAU produk retail (kopi instan).
        // Tanpa ini, blade yang manggil $item->retailProduct akan query berulang (N+1)
        // dan berpotensi bikin bingung saat $item->menu bernilai null.
        $orders = Order::with(['table', 'items.menu', 'items.retailProduct'])
            ->whereIn('order_status', ['menunggu', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.orders.monitor', compact('orders'));
    }

    public function show(Order $order)
    {
        // 🔥 PERBAIKAN: tambahkan 'items.retailProduct' agar halaman Detail Pesanan
        // tidak error saat ada item yang berasal dari produk retail (menu_id null).
        $order->load(['table', 'items.menu', 'items.retailProduct', 'promo', 'feedback']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        // QRIS tidak bisa dibatalkan
        if ($order->payment_method === 'qris' && $request->order_status === 'dibatalkan') {
            return back()->with('error', 'Pesanan dengan pembayaran QRIS tidak dapat dibatalkan.');
        }

        $data = ['order_status' => $request->order_status];

        // 🔥 PERBAIKAN: JANGAN update payment_status ke 'dibatalkan'
        // Karena ENUM hanya punya: pending, paid, failed
        // Cukup update order_status saja

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Konfirmasi pembayaran oleh admin — berlaku untuk tunai dan QRIS.
     * Saat dikonfirmasi: payment_status = paid, order_status = diproses
     * SEKALIGUS otomatis memotong stok produk retail (kopi instan/bungkusan) di MySQL.
     */
    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        $cashReceived = null;
        $changeAmount = null;

        if ($order->payment_method === 'cash') {
            $request->validate([
                'cash_received' => 'required|numeric|min:' . $order->total,
            ], [
                'cash_received.required' => 'Uang diterima wajib diisi.',
                'cash_received.numeric' => 'Uang diterima harus berupa angka.',
                'cash_received.min' => 'Uang diterima tidak boleh kurang dari total pembayaran.',
            ]);

            $cashReceived = (float) $request->cash_received;
            $changeAmount = $cashReceived - (float) $order->total;
        }

        // ================= LOGIKA POTONG STOK KOPI INSTAN =================
        $order->load('items');

        foreach ($order->items as $item) {
            if ($item->retail_product_id !== null) {
                $retailProduct = \App\Models\RetailProduct::find($item->retail_product_id);

                if ($retailProduct) {
                    $retailProduct->stock = $retailProduct->stock - $item->quantity;

                    if ($retailProduct->stock <= 0) {
                        $retailProduct->stock = 0;
                        $retailProduct->is_available = false;
                    }

                    $retailProduct->save();
                }
            }
        }
        // ==================================================================

        $order->update([
            'payment_status' => 'paid',
            'order_status'   => 'diproses',
        ]);

        $method = $order->payment_method === 'cash' ? 'Tunai' : 'QRIS';

        if ($order->payment_method === 'cash') {
            $receivedText = number_format($cashReceived, 0, ',', '.');
            $changeText = number_format($changeAmount, 0, ',', '.');
            return back()->with('success', "Pembayaran {$method} dikonfirmasi. Uang diterima Rp {$receivedText}, kembalian Rp {$changeText}. Stok produk kopi diperbarui & pesanan mulai diproses.");
        }

        return back()->with('success', "Pembayaran {$method} dikonfirmasi. Stok produk kopi diperbarui & pesanan mulai diproses.");
    }

    public function print(Order $order)
    {
        // 🔥 PERBAIKAN: tambahkan 'items.retailProduct' agar halaman Cetak Nota
        // tidak error saat ada item yang berasal dari produk retail (menu_id null).
        $order->load(['table', 'items.menu', 'items.retailProduct', 'promo']);
        return view('admin.orders.print', compact('order'));
    }
}