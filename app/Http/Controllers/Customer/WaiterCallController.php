<?php
// app/Http/Controllers/Customer/WaiterCallController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\WaiterCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaiterCallController extends Controller
{
    /**
     * Customer memanggil pelayan
     */
    public function call(Request $request, $token)
    {
        try {
            Log::info('Waiter call attempt for token: ' . $token);
            
            // ── AUTO CLEANUP: Hapus data done > 24 jam ──
            WaiterCall::where('status', 'done')
                ->where('created_at', '<', now()->subDay())
                ->delete();
            
            $table = CafeTable::where('qr_token', $token)->first();
            
            if (!$table) {
                Log::warning('Table not found for token: ' . $token);
                return response()->json([
                    'error' => 'Meja tidak ditemukan'
                ], 404);
            }
            
            // Cek apakah ada panggilan aktif (pending)
            $activeCall = WaiterCall::where('table_id', $table->id)
                ->where('status', 'pending')
                ->first();

            if ($activeCall) {
                Log::info('Active call already exists for table: ' . $table->id);
                return response()->json([
                    'error' => 'Pelayan sudah dipanggil, mohon tunggu.'
                ], 400);
            }

            // Buat panggilan baru dengan status 'pending'
            $waiterCall = WaiterCall::create([
                'table_id' => $table->id,
                'status' => 'pending',
            ]);

            Log::info('Waiter call created: ' . $waiterCall->id . ' for table: ' . $table->id);

            return response()->json([
                'success' => true,
                'message' => 'Pelayan sedang menuju meja Anda.',
                'data' => [
                    'id' => $waiterCall->id,
                    'status' => $waiterCall->status,
                    'created_at' => $waiterCall->created_at->format('H:i'),
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Waiter call error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan, silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Customer membatalkan panggilan pelayan
     */
    public function cancel(Request $request, $token)
    {
        try {
            Log::info('Waiter call cancel attempt for token: ' . $token);
            
            $table = CafeTable::where('qr_token', $token)->first();
            
            if (!$table) {
                Log::warning('Table not found for token: ' . $token);
                return response()->json([
                    'error' => 'Meja tidak ditemukan'
                ], 404);
            }
            
            $waiterCall = WaiterCall::where('table_id', $table->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if (!$waiterCall) {
                Log::info('No pending call found for table: ' . $table->id);
                return response()->json([
                    'error' => 'Tidak ada panggilan yang bisa dibatalkan'
                ], 404);
            }

            // Hapus panggilan (karena tidak ada status 'dibatalkan')
            $waiterCall->delete();

            Log::info('Waiter call cancelled: ' . $waiterCall->id . ' for table: ' . $table->id);

            return response()->json([
                'success' => true,
                'message' => 'Panggilan pelayan berhasil dibatalkan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Waiter call cancel error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan, silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Cek status panggilan pelayan
     */
    public function status(Request $request, $token)
    {
        try {
            $table = CafeTable::where('qr_token', $token)->first();
            
            if (!$table) {
                return response()->json([
                    'error' => 'Meja tidak ditemukan'
                ], 404);
            }
            
            // Cari panggilan aktif (pending) terbaru
            $activeCall = WaiterCall::where('table_id', $table->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($activeCall) {
                // Hitung estimasi waktu tunggu (contoh: 2-5 menit)
                $createdAt = $activeCall->created_at;
                $now = now();
                $diffMinutes = $createdAt->diffInMinutes($now);
                
                // Estimasi selesai dalam 3 menit
                $estimatedMinutes = max(1, 3 - $diffMinutes);
                $progress = min(90, 30 + ($diffMinutes * 20));
                
                return response()->json([
                    'has_active' => true,
                    'id' => $activeCall->id,
                    'status' => $activeCall->status,
                    'status_label' => '⏳ Menunggu Konfirmasi',
                    'progress' => $progress,
                    'created_at' => $activeCall->created_at->format('H:i'),
                    'estimated_minutes' => $estimatedMinutes,
                ]);
            }

            // Cek apakah ada panggilan yang sudah selesai (done) baru-baru ini
            $recentDone = WaiterCall::where('table_id', $table->id)
                ->where('status', 'done')
                ->where('created_at', '>', now()->subMinutes(30))
                ->latest()
                ->first();

            if ($recentDone) {
                return response()->json([
                    'has_active' => true,
                    'id' => $recentDone->id,
                    'status' => $recentDone->status,
                    'status_label' => '✅ Pelayan Datang',
                    'progress' => 100,
                    'created_at' => $recentDone->created_at->format('H:i'),
                    'is_done' => true,
                ]);
            }

            return response()->json(['has_active' => false]);
            
        } catch (\Exception $e) {
            Log::error('Waiter status error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan, silakan coba lagi.'
            ], 500);
        }
    }
}