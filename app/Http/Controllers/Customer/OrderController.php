<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\Order;
use App\Models\WaiterCall;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function status(string $transactionId)
    {
        $order = Order::with(['table', 'items.menu', 'promo', 'feedback'])
            ->where('transaction_id', $transactionId)
            ->firstOrFail();

        return view('customer.status', compact('order'));
    }

    public function statusPeek(string $transactionId)
    {
        $order = Order::with(['table', 'feedback'])
            ->where('transaction_id', $transactionId)
            ->firstOrFail();

        return response()->json([
            'transaction_id' => $order->transaction_id,
            'table_number' => $order->table?->number,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'has_feedback' => $order->feedback !== null,
        ]);
    }

    public function cancel(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $transactionId = session('last_transaction_id');

        if (!$transactionId) {
            return redirect()->route('customer.menu', $qrToken)
                ->with('error', 'Tidak ada pesanan aktif.');
        }

        $order = Order::where('transaction_id', $transactionId)
            ->where('table_id', $table->id)
            ->where('order_status', 'menunggu')
            ->first();

        if (!$order) {
            return redirect()->route('customer.status', $transactionId)
                ->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        if ($order->payment_method !== 'cash') {
            return redirect()->route('customer.status', $transactionId)
                ->with('error', 'Pesanan dengan pembayaran e-wallet tidak dapat dibatalkan.');
        }

        $order->update(['order_status' => 'dibatalkan']);

        return redirect()->route('customer.status', $transactionId)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function callWaiter(string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();

        WaiterCall::create([
            'table_id' => $table->id,
            'status'   => 'pending',
        ]);

        return back()->with('waiter_called', 'Pelayan sedang dipanggil. Mohon tunggu sebentar.');
    }
public function showNota(string $transactionId)
    {
        $order = Order::with(['table', 'items.menu'])
            ->where('transaction_id', $transactionId)
            ->firstOrFail();

        // Tampilan web biasa
        return view('customer.nota', compact('order'));
    }

public function downloadNota(string $transactionId)
{
    $order = Order::with(['table', 'items.menu'])
        ->where('transaction_id', $transactionId)
        ->firstOrFail();

    $pdf = Pdf::loadView('customer.nota', [
        'order' => $order,
        'is_pdf' => true
    ]);

    // setPaper([kiri, atas, lebar, tinggi])
    // Angka 340.16 setara dengan 120mm (lebar nota yang sudah dirampingkan)
    return $pdf->setPaper([0, 0, 340.16, 600], 'portrait')
               ->download('Nota_'.$order->transaction_id.'.pdf');
}
}
