<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with(['order.table']);
        
        // ── Pencarian yang aman menggunakan Logical Grouping ──
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function ($mainQuery) use ($search) {
                $mainQuery->whereHas('order', function ($q) use ($search) {
                    $q->where('customer_name', 'LIKE', "%{$search}%")
                      ->orWhere('transaction_id', 'LIKE', "%{$search}%");
                })
                ->orWhere('comment', 'LIKE', "%{$search}%");
            });
        }
        
        // Memberikan nama tabel spesifik pada urutan terbaru agar tidak ambigu
        $feedbacks = $query->latest('feedbacks.created_at')->paginate(20);
        
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback berhasil dihapus.');
    }
}