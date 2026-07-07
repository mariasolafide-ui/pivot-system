@extends('layouts.customer')

@section('title', 'Beri Rating — Pivot Cafe')

@push('styles')
<style>
    .feedback-container {
        max-width: 600px;
        margin: 0 auto;
        padding-top: 120px;
        padding-bottom: 80px;
        padding-left: 20px;
        padding-right: 20px;
    }

    /* ── BACK LINK (SAMA SEPERTI HALAMAN LAIN) ── */
    .nav-back-feedback {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--text-light);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(0,0,0,0.04);
        margin-bottom: 16px;
    }

    .nav-back-feedback:hover {
        background: rgba(0,0,0,0.08);
        color: var(--primary);
        transform: translateX(-4px);
    }

    .nav-back-feedback i {
        font-size: 14px;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-feedback {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 24px;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .breadcrumb-feedback a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-feedback a:hover {
        color: var(--primary);
    }
    .breadcrumb-feedback .separator {
        color: #d1d5db;
    }
    .breadcrumb-feedback .current {
        color: var(--primary);
        font-weight: 600;
    }

    .feedback-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: var(--border);
        text-align: center;
    }

    .star-rating {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin: 30px 0;
    }

    .star-btn {
        font-size: 45px;
        cursor: pointer;
        background: none;
        border: none;
        color: #e5e7eb;
        padding: 0;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .star-btn:hover {
        transform: scale(1.2);
    }

    .star-btn.active {
        color: var(--accent);
        text-shadow: 0 0 15px rgba(212, 163, 115, 0.3);
    }

    .form-group-p {
        text-align: left;
        margin-bottom: 25px;
    }

    .form-label-p {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 10px;
    }

    .form-textarea-p {
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        border: var(--border);
        background: var(--bg);
        font-family: inherit;
        font-size: 15px;
        transition: all 0.3s;
        resize: none;
    }

    .form-textarea-p:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .feedback-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .feedback-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .feedback-header .sub {
        color: var(--text-light);
        font-size: 14px;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .feedback-container {
            padding-top: 100px;
            padding-left: 16px;
            padding-right: 16px;
        }
        .feedback-card {
            padding: 28px;
        }
        .feedback-header h1 {
            font-size: 2rem;
        }
        .star-btn {
            font-size: 36px;
        }
        .nav-back-feedback {
            font-size: 13px;
            padding: 6px 14px;
        }
        .breadcrumb-feedback {
            font-size: 12px;
            margin-bottom: 16px;
        }
    }

    @media (max-width: 480px) {
        .feedback-container {
            padding-top: 90px;
            padding-left: 14px;
            padding-right: 14px;
        }
        .feedback-card {
            padding: 20px;
        }
        .feedback-header h1 {
            font-size: 1.6rem;
        }
        .star-btn {
            font-size: 28px;
            gap: 10px;
        }
        .star-rating {
            gap: 10px;
            margin: 20px 0;
        }
        .form-textarea-p {
            padding: 14px;
            font-size: 13px;
        }
        .nav-back-feedback {
            font-size: 12px;
            padding: 5px 12px;
            margin-bottom: 12px;
        }
        .breadcrumb-feedback {
            font-size: 11px;
            margin-bottom: 12px;
        }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .feedback-card {
            background: #1f2937;
            border-color: #374151;
        }
        .feedback-header h1 {
            color: #f3f4f6;
        }
        .feedback-header .sub {
            color: #9ca3af;
        }
        .form-textarea-p {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }
        .form-textarea-p:focus {
            background: #1f2937;
            border-color: #d4a373;
        }
        .form-label-p {
            color: #e5e7eb;
        }
        .nav-back-feedback {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .nav-back-feedback:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-feedback {
            color: #9ca3af;
        }
        .breadcrumb-feedback a {
            color: #9ca3af;
        }
        .breadcrumb-feedback a:hover {
            color: #d4a373;
        }
        .breadcrumb-feedback .current {
            color: #d4a373;
        }
        .breadcrumb-feedback .separator {
            color: #4b5563;
        }
        .star-btn {
            color: #4b5563;
        }
        .star-btn.active {
            color: #d4a373;
        }
    }
</style>
@endpush

@section('content')
<div class="feedback-container">
    
    {{-- ── BACK LINK (SAMA SEPERTI HALAMAN LAIN) ── --}}
    <a href="{{ route('customer.status', $order->transaction_id) }}" class="nav-back-feedback">
        <i class="fas fa-arrow-left"></i> Kembali ke Status Pesanan
    </a>

    {{-- ── BREADCRUMB ── --}}
    <div class="breadcrumb-feedback">
        <a href="{{ route('customer.menu', $order->table->qr_token) }}">
            <i class="fas fa-home"></i> Menu
        </a>
        <span class="separator">/</span>
        <a href="{{ route('customer.status', $order->transaction_id) }}">
            Status Pesanan
        </a>
        <span class="separator">/</span>
        <span class="current">Beri Penilaian</span>
    </div>

    <div class="feedback-header">
        <h1>Beri Penilaian</h1>
        <p class="sub">Pesanan #{{ $order->transaction_id }}</p>
    </div>

    <div class="feedback-card fade-in-up">
        <form action="{{ route('customer.feedback.store', $order->transaction_id) }}" method="POST">
            @csrf
            
            <p style="font-weight: 600; color: var(--primary);">Bagaimana pengalaman kuliner Anda hari ini?</p>
            
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                <button type="button" class="star-btn" data-value="{{ $i }}" onclick="setRating({{ $i }})">
                    <i class="fas fa-star"></i>
                </button>
                @endfor
            </div>
            
            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}">
            @error('rating') <div style="color:var(--danger); font-size: 12px; margin-bottom: 20px;">{{ $message }}</div> @enderror

            <div class="form-group-p">
                <label class="form-label-p" for="comment">Saran & Kritik (Opsional)</label>
                <textarea id="comment" name="comment" rows="4" class="form-textarea-p"
                    placeholder="Apa yang bisa kami tingkatkan untuk kunjungan Anda berikutnya?">{{ old('comment') }}</textarea>
                @error('comment') <div style="color:var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 18px; border-radius: 12px; font-weight: 600;">
                <i class="fas fa-paper-plane"></i> Kirim Penilaian
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
        if (i < value) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

// Restore old value if any
document.addEventListener('DOMContentLoaded', function() {
    const oldVal = parseInt(document.getElementById('rating-input').value);
    if (oldVal > 0) setRating(oldVal);
});
</script>
@endpush