@push('styles')
<style>
/* ══════════════════════════════════════════════════════════════════════
   ADD CART MODAL — Premium Design, Mobile First
══════════════════════════════════════════════════════════════════════ */

dialog.custom-modal {
    display: none;
    border: none;
    padding: 0;
    background: white;
    border-radius: 28px 28px 0 0;
    box-shadow: 0 25px 80px rgba(0,0,0,0.25);
    width: 100%;
    max-width: 700px;
    max-height: 92vh;
    overflow: hidden;
    position: fixed !important;
    top: auto !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    margin: 0 !important;
    animation: modalSlideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalSlideUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

dialog.custom-modal[open] { display: flex !important; }
dialog.custom-modal::backdrop {
    background: rgba(0,0,0,0.55) !important;
    backdrop-filter: blur(8px);
}

@media (min-width: 600px) {
    dialog.custom-modal {
        border-radius: 28px;
        top: 50% !important;
        left: 50% !important;
        right: auto !important;
        bottom: auto !important;
        transform: translate(-50%, -50%);
        max-height: 90vh;
        max-width: 720px;
        animation: modalScaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes modalScaleIn {
        from { transform: translate(-50%, -50%) scale(0.9); opacity: 0; }
        to { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }
}

/* ── Layout utama ── */
.modal-grid-layout {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-height: 92vh;
    min-height: 0;
}
@media (min-width: 600px) {
    .modal-grid-layout { flex-direction: row; max-height: 90vh; }
}

/* ── Sisi gambar ── */
.modal-image-side {
    width: 100%;
    flex: 0 0 180px;
    height: 180px;
    position: relative;
    background: linear-gradient(135deg, #f5f0eb, #e8e0d8);
    overflow: hidden;
}
@media (min-width: 600px) {
    .modal-image-side {
        flex: 0 0 280px;
        height: auto;
        min-height: 100%;
        border-radius: 28px 0 0 28px;
    }
}
.modal-image-side img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}
.modal-image-side:hover img {
    transform: scale(1.05);
}
.modal-image-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,0.3) 0%,
        rgba(0,0,0,0) 45%,
        rgba(0,0,0,0.6) 100%
    );
    display: flex; flex-direction: column;
    justify-content: space-between;
    padding: 16px 18px;
    pointer-events: none;
}
.modal-badge-category {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(4px);
    color: #1b4332;
    font-size: 10px; font-weight: 700;
    padding: 5px 14px; border-radius: 50px;
    width: fit-content;
    text-transform: uppercase; letter-spacing: 0.8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
.modal-price-tag {
    color: white;
    font-size: 1.4rem; font-weight: 800;
    text-shadow: 0 4px 12px rgba(0,0,0,0.4);
    letter-spacing: -0.5px;
}

/* Tombol tutup */
.btn-close-modal-round {
    position: absolute; top: 12px; right: 12px;
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(4px);
    border: none;
    color: #1b4332;
    display: flex; align-items: center;
    justify-content: center; cursor: pointer; z-index: 10;
    box-shadow: 0 2px 12px rgba(0,0,0,0.12);
    transition: all 0.25s ease;
}
.btn-close-modal-round:hover {
    background: white;
    transform: rotate(90deg) scale(1.05);
    box-shadow: 0 4px 20px rgba(0,0,0,0.18);
}

/* ── Drag Handle (Mobile) ── */
.modal-drag-handle {
    display: block;
    width: 40px; height: 4px;
    background: rgba(0,0,0,0.12);
    border-radius: 99px;
    margin: 12px auto 6px;
    flex-shrink: 0;
}
@media (min-width: 600px) {
    .modal-drag-handle { display: none; }
}

/* ── Sisi form ── */
.modal-form-side {
    flex: 1; min-height: 0;
    display: flex; flex-direction: column;
    background: white;
}
@media (min-width: 600px) {
    .modal-form-side { border-radius: 0 28px 28px 0; }
}
.modal-form-side form {
    display: flex; flex-direction: column;
    height: 100%; min-height: 0; overflow: hidden;
}

/* Scrollable body */
.modal-body-scroll {
    padding: 16px 20px 10px;
    overflow-y: auto;
    flex: 1; min-height: 0;
    display: flex; flex-direction: column; gap: 14px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #d4a373 transparent;
}
.modal-body-scroll::-webkit-scrollbar { width: 4px; }
.modal-body-scroll::-webkit-scrollbar-thumb { background: #d4a373; border-radius: 4px; }

/* Sticky footer */
.modal-footer-sticky {
    flex-shrink: 0;
    padding: 12px 20px;
    padding-bottom: calc(14px + env(safe-area-inset-bottom));
    border-top: 1px solid #f1f5f9;
    background: #fff;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.04);
}

/* ── Judul & deskripsi ── */
.modal-menu-title {
    font-size: 1.3rem; color: #1b4332;
    margin: 0 0 4px; font-weight: 700; line-height: 1.3;
    font-family: 'Playfair Display', serif;
}
.modal-menu-desc {
    font-size: 13px; color: #64748b;
    margin: 0; line-height: 1.6;
}

/* ── Label section ── */
.section-label {
    display: flex; align-items: center; gap: 8px;
    font-weight: 700; font-size: 12px;
    color: #374151; margin-bottom: 8px;
    text-transform: uppercase; letter-spacing: 0.8px;
}
.section-label i { color: #d4a373; font-size: 13px; }

/* ── Grup label (nama grup varian) ── */
.variant-group-label {
    font-size: 11px; font-weight: 700;
    color: #6b7280; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 6px;
    padding: 5px 12px;
    background: #f8fafc;
    border-radius: 6px;
    border-left: 3px solid #d4a373;
    display: inline-block;
}

/* ── Option grid (varian & addon) ── */
.option-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}
@media (min-width: 400px) {
    .option-grid { grid-template-columns: repeat(2, 1fr); }
}
.option-card { position: relative; cursor: pointer; display: block; }
.option-card input[type="radio"],
.option-card input[type="checkbox"] {
    position: absolute; opacity: 0; width: 0; height: 0;
}
.option-card-box {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 3px; padding: 10px 8px;
    background: #f8fafc; border: 2px solid #e8ecf0;
    border-radius: 12px; font-size: 12.5px; font-weight: 600;
    color: #475569; transition: all 0.2s ease;
    text-align: center; line-height: 1.3;
    min-height: 54px;
}
.option-card:hover .option-card-box {
    border-color: #d4a373;
    background: #fdf8f3;
}
.option-card input:checked + .option-card-box {
    background: #f0fdf4; border-color: #10b981; color: #047857;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
}
.option-extra-price {
    font-size: 10.5px; font-weight: 400;
    color: #94a3b8; line-height: 1;
}
.option-card input:checked + .option-card-box .option-extra-price {
    color: #34d399;
}

/* ── Tipe pesanan ── */
.order-type-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.order-type-card { position: relative; cursor: pointer; display: block; }
.order-type-card input { position: absolute; opacity: 0; width: 0; height: 0; }
.order-type-box {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 6px; padding: 14px 8px;
    background: #f8fafc; border: 2px solid #e8ecf0;
    border-radius: 14px; transition: all 0.2s ease;
    text-align: center;
}
.order-type-box i { font-size: 18px; color: #94a3b8; transition: color 0.2s; }
.order-type-box span { font-size: 12px; font-weight: 700; color: #475569; transition: color 0.2s; }
.order-type-card:hover .order-type-box {
    border-color: #d4a373;
    background: #fdf8f3;
}
.order-type-card input:checked + .order-type-box {
    background: #ecfdf5; border-color: #1b4332;
    box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.08);
}
.order-type-card input:checked + .order-type-box i,
.order-type-card input:checked + .order-type-box span { color: #1b4332; }

/* ── Qty selector ── */
.qty-selector {
    display: inline-flex; align-items: center;
    border: 2px solid #e8ecf0; border-radius: 14px;
    overflow: hidden; background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.qty-selector button {
    width: 42px; height: 42px;
    border: none; background: #f8fafc;
    color: #1b4332; font-size: 14px;
    cursor: pointer; transition: all 0.2s ease;
    display: flex; align-items: center; justify-content: center;
}
.qty-selector button:hover { background: #ecfdf5; color: #1b4332; }
.qty-selector button:active { transform: scale(0.9); }
.qty-selector input[type="number"] {
    width: 50px; height: 42px;
    border: none; text-align: center;
    font-weight: 700; font-size: 16px;
    color: #1b4332; background: transparent;
    -moz-appearance: textfield;
}
.qty-selector input[type="number"]::-webkit-inner-spin-button,
.qty-selector input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }

/* ── Textarea catatan ── */
.modal-notes-input {
    width: 100%; padding: 12px 16px;
    border: 2px solid #e8ecf0; border-radius: 12px;
    background: #fafaf8; color: #1b4332;
    font-size: 13px; font-family: inherit;
    box-sizing: border-box; transition: all 0.2s;
    resize: none; line-height: 1.6;
}
.modal-notes-input::placeholder { color: #94a3b8; }
.modal-notes-input:focus {
    outline: none; border-color: #d4a373; 
    background: #fff;
    box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.08);
}

/* ── Total harga ── */
.modal-total-box {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #a7f3d0;
    border-radius: 14px;
    padding: 12px 18px;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-total-label { 
    font-size: 13px; font-weight: 600; color: #065f46; 
    display: flex; align-items: center; gap: 6px;
}
.modal-total-label i { color: #059669; }
.modal-total-value { 
    font-size: 18px; font-weight: 800; color: #065f46;
    letter-spacing: -0.5px;
}

/* ── Submit button ── */
.modal-submit-btn {
    width: 100%; display: flex;
    align-items: center; justify-content: center; gap: 10px;
    border-radius: 16px; font-weight: 700; padding: 16px;
    background: linear-gradient(135deg, #1b4332, #2d6a4f);
    color: white;
    border: none; cursor: pointer;
    font-size: 15px; transition: all 0.3s ease;
    font-family: inherit;
    box-shadow: 0 4px 16px rgba(27,67,50,0.25);
}
.modal-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(27,67,50,0.35);
}
.modal-submit-btn:active { transform: translateY(0) scale(0.98); }

/* ── Divider ── */
.modal-divider {
    border: 0; border-top: 1.5px dashed #e8ecf0; margin: 2px 0;
}

/* ── Loading skeleton ── */
.modal-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.2s ease-in-out infinite;
    border-radius: 10px; height: 48px;
}
@keyframes skeleton-loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Stok Retail ── */
.retail-stock-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: #fef3c7; color: #92400e;
    font-size: 11px; font-weight: 600;
    padding: 3px 12px; border-radius: 50px;
    border: 1px solid #fcd34d;
}

/* ── Responsive Mobile ── */
@media (max-width: 599px) {
    .modal-body-scroll { padding: 12px 16px 8px; gap: 12px; }
    .modal-footer-sticky { padding: 10px 16px calc(12px + env(safe-area-inset-bottom)); }
    .modal-menu-title { font-size: 1.1rem; }
    .modal-image-side { flex: 0 0 150px; height: 150px; }
    .option-grid { gap: 6px; }
    .option-card-box { padding: 8px 6px; min-height: 48px; font-size: 12px; }
    .order-type-box { padding: 12px 6px; }
    .modal-total-value { font-size: 16px; }
    .qty-selector button { width: 36px; height: 36px; }
    .qty-selector input { width: 44px; height: 36px; font-size: 14px; }
    .modal-submit-btn { padding: 14px; font-size: 14px; border-radius: 14px; }
}
</style>
@endpush

<dialog id="add-cart-dialog" class="custom-modal">
    <div class="modal-grid-layout">

        {{-- ── Sisi Gambar ─────────────────────────────────────────── --}}
        <div class="modal-image-side">
            <img id="modal-menu-image" src="" alt="" loading="lazy">
            <div class="modal-image-overlay">
                <span id="modal-menu-category" class="modal-badge-category">Kategori</span>
                <div id="modal-menu-price" class="modal-price-tag">Rp 0</div>
            </div>
            <button type="button" class="btn-close-modal-round" onclick="closeAddCartModal()">
                <i class="fas fa-times" style="font-size:12px"></i>
            </button>
            {{-- Stok Retail --}}
            <div id="modal-retail-stock" style="position:absolute;bottom:12px;right:12px;pointer-events:none;display:none;">
                <span class="retail-stock-badge"><i class="fas fa-box"></i> Stok: <span id="modal-retail-stock-count">0</span></span>
            </div>
        </div>

        {{-- ── Sisi Form ───────────────────────────────────────────── --}}
        <div class="modal-form-side">
            <div class="modal-drag-handle"></div>
            <form method="POST"
                  action="{{ route('customer.cart.add', $table->qr_token) }}"
                  id="add-cart-form">
                @csrf
                <input type="hidden" name="menu_id"         id="modal-menu-id"        value="">
                <input type="hidden" name="variant_id"      id="modal-variant-id"     value="">
                <input type="hidden" name="notes"           id="modal-combined-notes" value="">

                <div class="modal-body-scroll">

                    {{-- Nama & deskripsi --}}
                    <div>
                        <h3 id="modal-menu-name" class="modal-menu-title">Nama Menu</h3>
                        <p  id="modal-menu-desc" class="modal-menu-desc"></p>
                    </div>

                    <hr class="modal-divider">

                    {{-- Tipe pesanan --}}
                    <div id="modal-order-type-section">
                        <div class="section-label">
                            <i class="fas fa-store-alt"></i> Tipe Pesanan
                        </div>
                        <div class="order-type-grid">
                            <label class="order-type-card">
                                <input type="radio" name="order_type" value="dine_in" checked>
                                <div class="order-type-box">
                                    <i class="fas fa-utensils"></i>
                                    <span>Makan di Tempat</span>
                                </div>
                            </label>
                            <label class="order-type-card">
                                <input type="radio" name="order_type" value="takeaway">
                                <div class="order-type-box">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>Bawa Pulang</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Loading state --}}
                    <div id="modal-loading-state" style="display:none;">
                        <div class="modal-skeleton" style="margin-bottom:6px"></div>
                        <div class="modal-skeleton" style="height:36px"></div>
                    </div>

                    {{-- Varian per grup (dinamis dari JS) --}}
                    <div id="modal-variant-groups-container"></div>

                    {{-- Addon (dinamis dari JS) --}}
                    <div id="modal-addon-section" style="display:none;">
                        <hr class="modal-divider">
                        <div class="section-label" style="margin-top:4px">
                            <i class="fas fa-plus-circle"></i>
                            Tambahan
                            <span style="font-size:10px;font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0">(opsional)</span>
                        </div>
                        <div class="option-grid" id="modal-addon-options"></div>
                    </div>

                    {{-- Fallback suhu (minuman tanpa varian) --}}
                    <div id="modal-drink-options" style="display:none;">
                        <hr class="modal-divider">
                        <div class="section-label"><i class="fas fa-thermometer-half"></i> Pilih Suhu</div>
                        <div class="option-grid">
                            <label class="option-card">
                                <input type="radio" name="temp_option" value="Es" checked>
                                <div class="option-card-box">
                                    <i class="fas fa-snowflake" style="color:#3b82f6;font-size:16px"></i>
                                    <span>Dingin / Es</span>
                                </div>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="temp_option" value="Panas">
                                <div class="option-card-box">
                                    <i class="fas fa-fire" style="color:#ef4444;font-size:16px"></i>
                                    <span>Panas</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Fallback pedas (makanan tanpa varian) --}}
                    <div id="modal-food-options" style="display:none;">
                        <hr class="modal-divider">
                        <div class="section-label"><i class="fas fa-pepper-hot"></i> Level Pedas</div>
                        <div class="option-grid">
                            <label class="option-card">
                                <input type="radio" name="spicy_option" value="Tidak Pedas" checked>
                                <div class="option-card-box">
                                    <i class="fas fa-leaf" style="color:#10b981;font-size:16px"></i>
                                    <span>Tidak Pedas</span>
                                </div>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="spicy_option" value="Pedas">
                                <div class="option-card-box">
                                    <i class="fas fa-pepper-hot" style="color:#ef4444;font-size:16px"></i>
                                    <span>Pedas</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="modal-divider">

                    {{-- Total harga --}}
                    <div class="modal-total-box">
                        <span class="modal-total-label"><i class="fas fa-calculator"></i> Total Harga</span>
                        <span class="modal-total-value" id="modal-total-value">Rp 0</span>
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <div class="section-label"><i class="fas fa-hashtag"></i> Jumlah</div>
                        <div class="qty-selector">
                            <button type="button" onclick="changeModalQty(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" id="modal-quantity" value="1" min="1" readonly>
                            <button type="button" onclick="changeModalQty(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <div class="section-label"><i class="fas fa-pencil-alt"></i> Catatan</div>
                        <textarea id="modal-notes"
                                  rows="2"
                                  class="modal-notes-input"
                                  placeholder="Ada request khusus? Misal: es sedikit, tanpa gula, ekstra pedas..."></textarea>
                    </div>

                </div>{{-- /modal-body-scroll --}}

                {{-- Sticky footer --}}
                <div class="modal-footer-sticky">
                    <button type="submit" id="modal-submit-btn" class="modal-submit-btn">
                        <i class="fas fa-shopping-basket"></i>
                        Masukkan Keranjang
                    </button>
                </div>

            </form>
        </div>

    </div>
</dialog>

@push('scripts')
<script>
(function () {
    'use strict';

    const dialog             = document.getElementById('add-cart-dialog');
    const form               = document.getElementById('add-cart-form');
    const elCombinedNotes    = document.getElementById('modal-combined-notes');
    const elVariantGroupsCon = document.getElementById('modal-variant-groups-container');
    const elAddonSection     = document.getElementById('modal-addon-section');
    const elAddonOptions     = document.getElementById('modal-addon-options');
    const elDrinkOpts        = document.getElementById('modal-drink-options');
    const elFoodOpts         = document.getElementById('modal-food-options');
    const elLoading          = document.getElementById('modal-loading-state');
    const elTotalValue       = document.getElementById('modal-total-value');
    const elPriceTag         = document.getElementById('modal-menu-price');
    const elVariantId        = document.getElementById('modal-variant-id');
    const elQty              = document.getElementById('modal-quantity');
    const elRetailStock      = document.getElementById('modal-retail-stock');
    const elRetailStockCount = document.getElementById('modal-retail-stock-count');

    // State
    let basePrice    = 0;
    let variantPrices = {};
    let addonTotal   = 0;

    // ── Utilitas ──────────────────────────────────────────────────────
    function fmt(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function updateTotal() {
        const qty        = parseInt(elQty.value) || 1;
        const varExtra   = Object.values(variantPrices).reduce((a, b) => a + b, 0);
        const unitTotal  = basePrice + varExtra + addonTotal;
        elTotalValue.textContent = fmt(unitTotal * qty);
        elPriceTag.textContent   = fmt(unitTotal);
    }

    function hideAllSections() {
        elVariantGroupsCon.innerHTML = '';
        elAddonSection.style.display  = 'none';
        elAddonOptions.innerHTML      = '';
        elDrinkOpts.style.display     = 'none';
        elFoodOpts.style.display      = 'none';
        elLoading.style.display       = 'none';
        elRetailStock.style.display   = 'none';
    }

    // ── Render varian per grup ────────────────────────────────────────
    function renderVariantGroups(groups) {
        elVariantGroupsCon.innerHTML = '';
        variantPrices = {};

        if (!groups || groups.length === 0) return;

        groups.forEach(function (group) {
            if (!group.variants || group.variants.length === 0) return;

            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'margin-bottom:6px';

            const groupLabel = document.createElement('div');
            groupLabel.className   = 'variant-group-label';
            groupLabel.textContent = group.group_name;
            wrapper.appendChild(groupLabel);

            const grid = document.createElement('div');
            grid.className = 'option-grid';

            const defaultVariant = group.variants.find(v => v.is_default) || group.variants[0];
            variantPrices[group.group_id] = defaultVariant ? defaultVariant.extra_price : 0;

            group.variants.forEach(function (v, i) {
                const isDefault = v.is_default || (i === 0 && !group.variants.find(x => x.is_default));
                const extraText = v.extra_price > 0 ? '+' + fmt(v.extra_price) : '';
                const radioName = 'variant_group_' + group.group_id;

                const label = document.createElement('label');
                label.className = 'option-card';
                label.innerHTML = `
                    <input type="radio"
                           name="${radioName}"
                           value="${v.id}"
                           data-group-id="${group.group_id}"
                           data-extra="${v.extra_price}"
                           ${isDefault ? 'checked' : ''}>
                    <div class="option-card-box">
                        <span>${v.name}</span>
                        <span class="option-extra-price">${extraText}</span>
                    </div>
                `;

                label.querySelector('input').addEventListener('change', function () {
                    variantPrices[group.group_id] = parseFloat(this.dataset.extra) || 0;
                    if (groups.length === 1) elVariantId.value = this.value;
                    updateTotal();
                });

                grid.appendChild(label);
            });

            wrapper.appendChild(grid);
            elVariantGroupsCon.appendChild(wrapper);

            const divider = document.createElement('hr');
            divider.className = 'modal-divider';
            elVariantGroupsCon.appendChild(divider);
        });

        if (groups.length === 1 && groups[0].variants.length > 0) {
            const def = groups[0].variants.find(v => v.is_default) || groups[0].variants[0];
            elVariantId.value = def.id;
        }
    }

    // ── Render addon ──────────────────────────────────────────────────
    function renderAddons(addons) {
        if (!addons || addons.length === 0) return;

        elAddonOptions.innerHTML = '';
        addons.forEach(function (a) {
            const priceText = a.price > 0 ? '+' + fmt(a.price) : 'Gratis';
            const label = document.createElement('label');
            label.className = 'option-card';
            label.innerHTML = `
                <input type="checkbox"
                       name="addon_ids[]"
                       value="${a.id}"
                       data-price="${a.price}">
                <div class="option-card-box">
                    <span>${a.name}</span>
                    <span class="option-extra-price">${priceText}</span>
                </div>
            `;
            label.querySelector('input').addEventListener('change', function () {
                addonTotal = 0;
                document.querySelectorAll('input[name="addon_ids[]"]:checked').forEach(function (cb) {
                    addonTotal += parseFloat(cb.dataset.price) || 0;
                });
                updateTotal();
            });
            elAddonOptions.appendChild(label);
        });

        elAddonSection.style.display = 'block';
    }

    // ── Fallback suhu/pedas ───────────────────────────────────────────
    function showLegacyOptions(categoryName) {
        const cat     = (categoryName || '').toLowerCase();
        const isDrink = cat.includes('kopi') || cat.includes('minuman') || cat.includes('drink') || cat.includes('teh');
        const isFood  = cat.includes('makanan') || cat.includes('snack') || cat.includes('camilan') || cat.includes('nasi');
        if (isDrink)      elDrinkOpts.style.display = 'block';
        else if (isFood)  elFoodOpts.style.display  = 'block';
    }

    // ── Buka modal ────────────────────────────────────────────────────
    window.openAddCartModal = function (menuId, menuName, categoryName, imageUrl, priceFormatted, description, options) {
        options = options || {};
        const isRetail = options.isRetail || false;
        const stock    = options.stock    || null;

        // Reset state
        basePrice     = 0;
        variantPrices = {};
        addonTotal    = 0;

        // Isi data dasar
        document.getElementById('modal-menu-id').value          = menuId;
        document.getElementById('modal-menu-id').name           = isRetail ? 'retail_product_id' : 'menu_id';
        elVariantId.value                                        = '';
        document.getElementById('modal-menu-name').textContent  = menuName;
        document.getElementById('modal-menu-category').textContent = categoryName;
        document.getElementById('modal-menu-image').src         = imageUrl;
        document.getElementById('modal-menu-image').alt         = menuName;
        elPriceTag.textContent                                   = priceFormatted;
        elTotalValue.textContent                                 = priceFormatted;

        const safeDesc = description || '';
        document.getElementById('modal-menu-desc').textContent  =
            safeDesc.length > 110 ? safeDesc.substring(0, 110) + '...' : safeDesc;

        elQty.value = 1;
        document.getElementById('modal-notes').value          = '';
        elCombinedNotes.value                                 = '';

        // Reset tipe pesanan
        const defType = document.querySelector('input[name="order_type"][value="dine_in"]');
        if (defType) defType.checked = true;

        // Reset fallback radio
        const defTemp  = document.querySelector('input[name="temp_option"][value="Es"]');
        const defSpicy = document.querySelector('input[name="spicy_option"][value="Tidak Pedas"]');
        if (defTemp)  defTemp.checked  = true;
        if (defSpicy) defSpicy.checked = true;

        // Stok retail
        if (isRetail && stock !== null) {
            elQty.setAttribute('max', stock);
            elRetailStock.style.display = 'block';
            elRetailStockCount.textContent = stock;
        } else {
            elQty.removeAttribute('max');
            elRetailStock.style.display = 'none';
        }

        // Buka modal dulu
        dialog.showModal();

        if (isRetail) {
            hideAllSections();
            basePrice = parseFloat(priceFormatted.replace(/[^0-9]/g, '')) || 0;
            updateTotal();
            return;
        }

        // Tampilkan loading
        hideAllSections();
        elLoading.style.display = 'block';
        basePrice = parseFloat(priceFormatted.replace(/[^0-9]/g, '')) || 0;
        updateTotal();

        // Fetch varian & addon
        const token = document.querySelector('meta[name="qr-token"]')?.content || '{{ $table->qr_token }}';
        fetch(`/order/${token}/menu/${menuId}/options`)
            .then(function (res) { return res.json(); })
            .then(function (data) {
                elLoading.style.display = 'none';
                basePrice = data.base_price || 0;
                variantPrices = {};
                addonTotal    = 0;

                const groups = data.variant_groups || [];
                renderVariantGroups(groups);

                if (groups.length === 0) {
                    showLegacyOptions(categoryName);
                }

                renderAddons(data.addons || []);
                updateTotal();
            })
            .catch(function () {
                elLoading.style.display = 'none';
                showLegacyOptions(categoryName);
                updateTotal();
            });
    };

    window.closeAddCartModal = function () {
        dialog.close();
    };

    window.changeModalQty = function (delta) {
        let val = parseInt(elQty.value) || 1;
        val     = Math.max(1, val + delta);
        const max = elQty.getAttribute('max');
        if (max && val > parseInt(max)) val = parseInt(max);
        elQty.value = val;
        updateTotal();
    };

    // ── Gabung notes sebelum submit ───────────────────────────────────
    form.addEventListener('submit', function () {
        const parts = [];

        const selType = document.querySelector('input[name="order_type"]:checked');
        if (selType) {
            parts.push('Tipe: ' + (selType.value === 'takeaway' ? 'Bawa Pulang' : 'Makan di Tempat'));
        }

        document.querySelectorAll('[name^="variant_group_"]:checked').forEach(function (radio) {
            const labelEl = radio.closest('.option-card').querySelector('.option-card-box span:first-child');
            if (labelEl) parts.push('Varian: ' + labelEl.textContent.trim());
        });

        if (elDrinkOpts.style.display !== 'none') {
            const sel = document.querySelector('input[name="temp_option"]:checked');
            if (sel) parts.push('Suhu: ' + sel.value);
        }

        if (elFoodOpts.style.display !== 'none') {
            const sel = document.querySelector('input[name="spicy_option"]:checked');
            if (sel) parts.push('Level: ' + sel.value);
        }

        document.querySelectorAll('input[name="addon_ids[]"]:checked').forEach(function (cb) {
            const labelEl = cb.closest('.option-card').querySelector('.option-card-box span:first-child');
            if (labelEl) parts.push('Addon: ' + labelEl.textContent.trim());
        });

        const customText = document.getElementById('modal-notes').value.trim();
        if (customText) parts.push('Catatan: ' + customText);

        elCombinedNotes.value = parts.join(', ');
    });

    // ── Tutup dengan klik backdrop ────────────────────────────────────
    dialog.addEventListener('click', function (e) {
        if (e.target !== dialog) return;
        const r = dialog.getBoundingClientRect();
        const inside = r.top <= e.clientY && e.clientY <= r.top + r.height
                    && r.left <= e.clientX && e.clientX <= r.left + r.width;
        if (!inside) dialog.close();
    });

})();
</script>
@endpush