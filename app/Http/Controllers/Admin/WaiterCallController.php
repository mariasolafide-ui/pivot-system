<?php
// app/Http/Controllers/Admin/WaiterCallController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaiterCall;
use Illuminate\Http\Request;

class WaiterCallController extends Controller
{
    public function index()
    {
        // ── AUTO CLEANUP: Hapus data done > 24 jam ──
        WaiterCall::where('status', 'done')
            ->where('created_at', '<', now()->subDay())
            ->delete();

        // ── Ambil data dengan filter status ──
        $calls = WaiterCall::with('table')
            ->when(request('status'), function($q) {
                return $q->where('status', request('status'));
            })
            ->latest()
            ->paginate(20);

        return view('admin.waiter-calls.index', compact('calls'));
    }

    public function done(WaiterCall $waiterCall)
    {
        if ($waiterCall->status === 'done') {
            return back()->with('error', 'Panggilan sudah selesai.');
        }

        $waiterCall->update(['status' => 'done']);
        
        return redirect()->route('admin.waiter-calls.index')
            ->with('success', 'Panggilan pelayan dari Meja ' . $waiterCall->table->number . ' telah selesai.');
    }

    public function destroy(WaiterCall $waiterCall)
    {
        $tableNumber = $waiterCall->table->number;
        $waiterCall->delete();
        
        return redirect()->route('admin.waiter-calls.index')
            ->with('success', 'Panggilan dari Meja ' . $tableNumber . ' berhasil dihapus.');
    }
}