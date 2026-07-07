<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index(Request $request)
    {
        // ── Query dengan pencarian ──
        $query = CafeTable::with(['orders' => function ($q) {
            $q->whereNotIn('order_status', ['selesai', 'dibatalkan'])
              ->latest()->limit(1);
        }]);
        
        // ── Cari berdasarkan nomor meja ──
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('number', 'LIKE', "%{$search}%")
                  ->orWhere('qr_token', 'LIKE', "%{$search}%");
        }
        
        $tables = $query->orderBy('number')->paginate(15);
        
        return view('admin.tables.index', compact('tables'));
    }

    public function store(Request $request)
    {
        // ── Validasi ──
        $request->validate([
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('cafe_tables', 'number'),
            ],
        ], [
            'number.required' => 'Nomor meja wajib diisi.',
            'number.integer' => 'Nomor meja harus berupa angka.',
            'number.min' => 'Nomor meja minimal 1.',
            'number.unique' => 'Nomor meja sudah terdaftar. Silakan gunakan nomor lain.',
        ]);
        
        // ── Buat QR Token ──
        $qrToken = uniqid('table_');
        
        CafeTable::create([
            'number' => $request->number,
            'qr_token' => $qrToken,
        ]);
        
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $request->number . ' berhasil ditambahkan.');
    }

    public function update(Request $request, CafeTable $table)
    {
        // ── Validasi ──
        $request->validate([
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('cafe_tables', 'number')->ignore($table->id),
            ],
        ], [
            'number.required' => 'Nomor meja wajib diisi.',
            'number.integer' => 'Nomor meja harus berupa angka.',
            'number.min' => 'Nomor meja minimal 1.',
            'number.unique' => 'Nomor meja sudah terdaftar. Silakan gunakan nomor lain.',
        ]);
        
        $oldNumber = $table->number;
        $table->update(['number' => $request->number]);
        
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $oldNumber . ' berhasil diperbarui menjadi Meja ' . $request->number . '.');
    }

    public function destroy(CafeTable $table)
    {
        $number = $table->number;
        
        // ── Cek apakah meja memiliki order aktif ──
        $activeOrders = $table->orders()
            ->whereNotIn('order_status', ['selesai', 'dibatalkan'])
            ->count();
        
        if ($activeOrders > 0) {
            return redirect()->route('admin.tables.index')
                ->with('error', 'Meja ' . $number . ' tidak dapat dihapus karena masih memiliki ' . $activeOrders . ' pesanan aktif. Selesaikan pesanan terlebih dahulu.');
        }
        
        // ── Hapus meja ──
        $table->delete();
        
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja ' . $number . ' berhasil dihapus.');
    }

    public function qr(CafeTable $table)
    {
        $url = route('customer.home', $table);
        $qrCode = QrCode::size(250)->generate($url);
        
        return view('admin.tables.qr', compact('table', 'qrCode', 'url'));
    }
}