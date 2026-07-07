@extends('layouts.admin')
@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')

<style>
    /* ── BREADCRUMB ── */
    .breadcrumb-admin {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 16px;
        flex-wrap: wrap;
        padding: 4px 0;
    }
    .breadcrumb-admin a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-admin a:hover {
        color: #1b4332;
    }
    .breadcrumb-admin .separator {
        color: #d1d5db;
    }
    .breadcrumb-admin .current {
        color: #1b4332;
        font-weight: 600;
    }

    .nav-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(0,0,0,0.04);
        margin-bottom: 12px;
    }
    .nav-back:hover {
        background: rgba(0,0,0,0.08);
        color: #1b4332;
        transform: translateX(-4px);
    }
    .nav-back i {
        font-size: 14px;
    }

    /* ── BUTTON BULAT ── */
    .btn-edit {
        background: #3b82f6;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        color: white;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        color: white;
    }

    .btn-toggle-on {
        background: #f59e0b;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-toggle-on:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
        color: white;
    }

    .btn-toggle-off {
        background: #16a34a;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-toggle-off:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
        color: white;
    }

    .btn-variant {
        background: #1b4332;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-variant:hover {
        background: #2d6a4f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
        color: white;
    }

    .btn-addon {
        background: #d4a373;
        color: #1b4332;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-addon:hover {
        background: #bc8a5f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 163, 115, 0.35);
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
    }
    .action-buttons .btn {
        flex: 1;
        min-width: 0;
        font-size: 11px;
        padding: 6px 8px;
        border-radius: 30px !important;
        font-weight: 500;
        white-space: nowrap;
        height: 32px;
    }
    .action-buttons .btn i {
        font-size: 12px;
    }

    /* ── VALIDASI ── */
    .form-group .field-error {
        font-size: 12px;
        margin-top: 4px;
        display: none;
        align-items: center;
        gap: 4px;
    }
    .form-group .field-error.show {
        display: flex;
    }
    .form-group .field-error.danger {
        color: #dc2626;
    }
    .form-group .field-error.danger i {
        color: #dc2626;
    }
    .form-group .field-success {
        font-size: 12px;
        color: #16a34a;
        margin-top: 4px;
        display: none;
        align-items: center;
        gap: 4px;
    }
    .form-group .field-success.show {
        display: flex;
    }
    .form-group input.is-invalid,
    .form-group select.is-invalid,
    .form-group textarea.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }
    .form-group input.is-valid,
    .form-group select.is-valid,
    .form-group textarea.is-valid {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .action-buttons {
            flex-wrap: wrap;
        }
        .action-buttons .btn {
            flex: 1 1 calc(50% - 4px);
            min-width: 70px;
            font-size: 10px;
            padding: 4px 6px;
            height: 28px;
        }
        .breadcrumb-admin {
            font-size: 12px;
        }
        .nav-back {
            font-size: 13px;
            padding: 6px 14px;
        }
    }

    @media (max-width: 480px) {
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        .action-buttons .btn {
            width: 100%;
            flex: none;
            font-size: 10px;
            padding: 5px 8px;
            height: 30px;
            justify-content: center;
        }
        .breadcrumb-admin {
            font-size: 11px;
        }
        .nav-back {
            font-size: 12px;
            padding: 5px 12px;
        }
    }

    @media (prefers-color-scheme: dark) {
        .nav-back {
            color: #9ca3af;
            background: rgba(255,255,255,0.06);
        }
        .nav-back:hover {
            background: rgba(255,255,255,0.1);
            color: #d4a373;
        }
        .breadcrumb-admin {
            color: #9ca3af;
        }
        .breadcrumb-admin a {
            color: #9ca3af;
        }
        .breadcrumb-admin a:hover {
            color: #d4a373;
        }
        .breadcrumb-admin .current {
            color: #d4a373;
        }
        .breadcrumb-admin .separator {
            color: #4b5563;
        }
        .form-group input.is-invalid,
        .form-group select.is-invalid,
        .form-group textarea.is-invalid {
            border-color: #dc2626;
            background: #1f1414;
        }
        .form-group input.is-valid,
        .form-group select.is-valid,
        .form-group textarea.is-valid {
            border-color: #16a34a;
            background: #064e3b;
        }
        .form-group .field-error.danger {
            color: #f87171;
        }
        .form-group .field-error.danger i {
            color: #f87171;
        }
    }

    /* ── MODAL DELETE ── */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .modal-backdrop.open {
        display: flex;
    }
    .modal {
        background: white;
        border-radius: 12px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        width: 95%;
        max-width: 480px;
    }
    .modal-sm {
        max-width: 400px;
    }
    .modal-body {
        padding: 24px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
    }
    .btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .btn-primary {
        background: #1b4332;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
        border-radius: 30px !important;
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: #2d6a4f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
        color: white;
    }
    .btn-sm {
        padding: 6px 14px;
        font-size: 12px;
        height: 32px;
        border-radius: 30px !important;
        cursor: pointer;
    }
</style>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-utensils" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Kelola Menu</span>
</div>

{{-- ── STATS CARD ── --}}
<div class="stats-grid" style="margin-bottom:24px">
    @php
    $cards = [
        ['label' => 'Menu Terlaris',    'data' => $topMenuOverall, 'sub' => $topMenuOverall?->menu?->category?->name ?? ''],
        ['label' => 'Kopi Terlaris',    'data' => $topKopi,        'sub' => 'Kategori Kopi'],
        ['label' => 'Makanan Terlaris', 'data' => $topMakanan,     'sub' => 'Kategori Makanan'],
        ['label' => 'Minuman Terlaris', 'data' => $topMinuman,     'sub' => 'Non-Kopi / Minuman Dingin'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="stat-card">
        <div class="stat-label">{{ $card['label'] }}</div>
        @if($card['data'])
            <div class="stat-value" style="font-size:22px;line-height:1.2;margin-top:6px">
                {{ $card['data']->menu->name }}
            </div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px">{{ $card['sub'] }}</div>
            <div style="margin-top:6px;font-size:13px;font-weight:600;color:#0e6446">
                {{ number_format($card['data']->total_qty, 0, ',', '.') }}
                <span style="font-weight:400;color:#9ca3af">terjual</span>
            </div>
        @else
            <div style="font-size:13px;color:#9ca3af;margin-top:10px">Belum ada data</div>
        @endif
    </div>
    @endforeach
</div>

{{-- ── TABEL MENU ── --}}
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <div class="card-title" style="margin:0">Daftar Menu</div>
        
        <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:6px; margin:0;">
                <div style="position:relative; display:flex; align-items:center;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..." 
                           style="padding:6px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; width:220px; outline:none;">
                    @if(request('search'))
                        <a href="{{ url()->current() }}" style="position:absolute; right:10px; color:#9ca3af; text-decoration:none; font-size:16px; font-weight:bold;">&times;</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-secondary" style="padding:7px 12px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div style="display:flex; gap:8px;">
                <a href="{{ route('admin.variant-groups.index') }}" class="btn btn-sm btn-variant">
                    <i class="fas fa-layer-group"></i> Grup Varian
                </a>
                <a href="{{ route('admin.addons.index') }}" class="btn btn-sm btn-addon">
                    <i class="fas fa-plus-circle"></i> Addon
                </a>
                <button type="button" class="btn btn-primary btn-sm" onclick="openCreateMenu()">
                    <i class="fas fa-plus"></i> Tambah Menu
                </button>
            </div>
        </div>
    </div>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:60px">Gambar</th>
                    <th>Nama & Deskripsi</th>
                    <th>Kategori</th>
                    <th>Harga Dasar</th>
                    <th>Varian & Addon</th>
                    <th>Status</th>
                    <th class="no-sort" style="min-width:280px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}"
                             style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7" loading="lazy">
                    </td>
                    <td>
                        <div style="font-weight:500; color:#111827">{{ $menu->name }}</div>
                        <div style="font-size:12px;color:#6b7280">{{ Str::limit($menu->short_description ?? $menu->description, 55) }}</div>
                    </td>
                    <td><span class="badge" style="background:#f3f4f6; color:#374151">{{ $menu->category->name }}</span></td>
                    <td style="font-weight:500">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        <div style="font-size:12px; color:#4b5563">
                            <div>📦 <strong>{{ $menu->variantGroups->count() }}</strong> Grup Varian</div>
                            <div>➕ <strong>{{ $menu->addons->count() }}</strong> Addon</div>
                        </div>
                    </td>
                    <td>
                        @if($menu->is_available)
                            <span class="badge badge-success">Tersedia</span>
                        @else
                            <span class="badge badge-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <form action="{{ route('admin.menus.toggle', $menu) }}" method="POST" style="display:inline; flex:1;">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm {{ $menu->is_available ? 'btn-toggle-on' : 'btn-toggle-off' }}">
                                    <i class="fas {{ $menu->is_available ? 'fa-pause' : 'fa-play' }}"></i>
                                    {{ $menu->is_available ? 'Nonaktif' : 'Aktif' }}
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-sm btn-edit"
                                onclick="openEditMenu(
                                    {{ $menu->id }},
                                    '{{ addslashes($menu->name) }}',
                                    {{ $menu->category_id }},
                                    '{{ addslashes($menu->description ?? '') }}',
                                    '{{ addslashes($menu->short_description ?? '') }}',
                                    {{ $menu->price }},
                                    {{ $menu->is_available ? 'true' : 'false' }},
                                    '{{ $menu->image_url }}'
                                )">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            
                            <button type="button" class="btn btn-sm btn-delete"
                                onclick="confirmDeleteMenu(
                                    '{{ route('admin.menus.destroy', $menu) }}',
                                    '{{ addslashes($menu->name) }}',
                                    {{ $menu->variantGroups->count() }},
                                    {{ $menu->addons->count() }}
                                )">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#6b7280;padding:32px">
                        {{ request('search') ? 'Menu yang Anda cari tidak ditemukan.' : 'Belum ada data menu.' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        {{ $menus->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>

{{-- ── MODAL CREATE ── --}}
<div class="modal-backdrop" id="modal-create-menu">
    <div class="modal modal-lg" style="max-width:950px;">
        <div class="modal-header">
            <div class="modal-title">Tambah Menu Baru</div>
            <button class="modal-close" onclick="closeModal('modal-create-menu')">×</button>
        </div>

        <form id="form-create-menu" action="{{ route('admin.menus.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body" style="max-height:calc(100vh - 200px); overflow-y:auto">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

                    {{-- KIRI --}}
                    <div style="border-right:1px dashed #e5e7eb; padding-right:20px;">
                        <h4 style="font-size:13px;font-weight:700;color:#374151;margin-bottom:12px;text-transform:uppercase">
                            📋 Informasi Utama Menu
                        </h4>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label>Nama Menu <span style="color:#dc2626">*</span></label>
                            <input type="text" name="name" id="create-menu-name" 
                                   placeholder="Contoh: Es Kopi Susu Gula Aren" required>
                            <div class="field-error danger" id="create-menu-name-error">
                                <i class="fas fa-exclamation-circle"></i> Nama menu wajib diisi
                            </div>
                            <div class="field-error danger" id="create-menu-name-unique-error" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> Nama menu <strong id="create-duplicate-name"></strong> sudah terdaftar
                            </div>
                            <div class="field-success" id="create-menu-name-valid" style="display:none;">
                                <i class="fas fa-check-circle"></i> Nama menu tersedia
                            </div>
                        </div>

                        {{-- Kategori & Harga --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div class="form-group">
                                <label>Kategori <span style="color:#dc2626">*</span></label>
                                <select name="category_id" id="create-menu-category" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="field-error danger" id="create-menu-category-error">
                                    <i class="fas fa-exclamation-circle"></i> Kategori wajib dipilih
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Harga Dasar (Rp) <span style="color:#dc2626">*</span></label>
                                <input type="number" name="price" id="create-menu-price" min="0" step="500" placeholder="18000" required>
                                <div class="field-error danger" id="create-menu-price-error">
                                    <i class="fas fa-exclamation-circle"></i> Harga minimal Rp 0
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi Singkat --}}
                        <div class="form-group">
                            <label>Deskripsi Singkat (Maks 150 Karakter) <span style="color:#dc2626">*</span></label>
                            <input type="text" name="short_description" id="create-menu-short-desc" 
                                   placeholder="Ditampilkan di card katalog..." maxlength="150" required>
                            <div class="field-error danger" id="create-menu-short-desc-error">
                                <i class="fas fa-exclamation-circle"></i> Deskripsi singkat wajib diisi (maks 150 karakter)
                            </div>
                        </div>

                        {{-- Deskripsi Lengkap --}}
                        <div class="form-group">
                            <label>Deskripsi Lengkap <span style="color:#dc2626">*</span></label>
                            <textarea name="description" id="create-menu-desc" rows="2" 
                                      placeholder="Detail komposisi atau info produk..." required></textarea>
                            <div class="field-error danger" id="create-menu-desc-error">
                                <i class="fas fa-exclamation-circle"></i> Deskripsi lengkap wajib diisi
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div class="form-group">
                            <label>Gambar Menu <span style="color:#dc2626">*</span></label>
                            <input type="file" name="image" id="create-menu-image" accept=".jpg,.jpeg,.png"
                                   onchange="previewImage(this, 'preview-create')" required>
                            <div class="field-error danger" id="create-menu-image-error">
                                <i class="fas fa-exclamation-circle"></i> Gambar menu wajib diunggah (JPG/PNG)
                            </div>
                            <img id="preview-create" src=""
                                 style="display:none;margin-top:8px;width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                        </div>

                        {{-- Status --}}
                        <div class="form-group" style="display:flex;align-items:center;gap:10px;margin-top:10px">
                            <input type="checkbox" name="is_available" value="1" checked style="width:auto" id="create-available">
                            <label for="create-available" style="margin:0;cursor:pointer">Menu langsung aktif (Tersedia)</label>
                        </div>
                    </div>

                    {{-- KANAN --}}
                    <div>
                        <h4 style="font-size:13px;font-weight:700;color:#1b4332;margin-bottom:10px;text-transform:uppercase">
                            📦 Pilih Grup Varian (Opsional)
                        </h4>
                        @if($variantGroups->isEmpty())
                            <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:6px;padding:12px;font-size:12px;color:#92400e;margin-bottom:16px;">
                                ⚠️ Belum ada grup varian. 
                                <a href="{{ route('admin.variant-groups.index') }}" target="_blank" style="color:#0e6446;font-weight:600;">Buat dulu di sini →</a>
                            </div>
                        @else
                            <div style="max-height:200px; overflow-y:auto; border:1px solid #e5e7eb; border-radius:8px; padding:10px; background:#fff; margin-bottom:16px;">
                                @foreach($variantGroups as $group)
                                <label style="display:flex; align-items:flex-start; gap:10px; padding:8px; border-radius:6px; cursor:pointer; transition:background .15s;"
                                       onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background=''">
                                    <input type="checkbox" name="variant_group_ids[]" value="{{ $group->id }}"
                                           style="width:auto; margin-top:2px; accent-color:#0e6446;">
                                    <div>
                                        <div style="font-weight:600; font-size:13px; color:#111827;">{{ $group->name }}</div>
                                        <div style="font-size:11px; color:#6b7280; margin-top:2px;">
                                            {{ $group->variants->count() }} opsi:
                                            {{ $group->variants->pluck('name')->implode(', ') ?: 'Belum ada opsi' }}
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif

                        <h4 style="font-size:13px;font-weight:700;color:#1b4332;margin-bottom:10px;text-transform:uppercase">
                            ➕ Pilih Addon / Topping (Opsional)
                        </h4>
                        @if($addons->isEmpty())
                            <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:6px;padding:12px;font-size:12px;color:#92400e;">
                                ⚠️ Belum ada addon. 
                                <a href="{{ route('admin.addons.index') }}" target="_blank" style="color:#0e6446;font-weight:600;">Buat dulu di sini →</a>
                            </div>
                        @else
                            <div style="max-height:200px; overflow-y:auto; border:1px solid #e5e7eb; border-radius:8px; padding:10px; background:#fff;">
                                @foreach($addons as $addon)
                                <label style="display:flex; align-items:center; gap:10px; padding:8px; border-radius:6px; cursor:pointer; transition:background .15s;"
                                       onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background=''">
                                    <input type="checkbox" name="addon_ids[]" value="{{ $addon->id }}"
                                           style="width:auto; accent-color:#0e6446;">
                                    <div>
                                        <span style="font-weight:600; font-size:13px; color:#111827;">{{ $addon->name }}</span>
                                        <span style="font-size:11px; color:#6b7280; margin-left:6px;">+Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-menu')">Batal</button>
                <button type="submit" class="btn btn-success" style="background:#0e6446;border-color:#0e6446;padding:0 20px;" id="btn-create-menu">
                   <i class="fas fa-save"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div class="modal-backdrop" id="modal-edit-menu">
    <div class="modal modal-lg" style="max-width:950px;">
        <div class="modal-header">
            <div class="modal-title">Edit Menu</div>
            <button class="modal-close" onclick="closeModal('modal-edit-menu')">×</button>
        </div>

        <form id="edit-menu-form" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body" style="max-height:calc(100vh - 200px); overflow-y:auto">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

                    {{-- KIRI --}}
                    <div style="border-right:1px dashed #e5e7eb; padding-right:20px;">
                        <h4 style="font-size:13px;font-weight:700;color:#374151;margin-bottom:12px;text-transform:uppercase">
                            📝 Informasi Utama Menu
                        </h4>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label>Nama Menu <span style="color:#dc2626">*</span></label>
                            <input type="text" name="name" id="edit-menu-name" required>
                            <div class="field-error danger" id="edit-menu-name-error">
                                <i class="fas fa-exclamation-circle"></i> Nama menu wajib diisi
                            </div>
                            <div class="field-error danger" id="edit-menu-name-unique-error" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> Nama menu <strong id="edit-duplicate-name"></strong> sudah terdaftar
                            </div>
                            <div class="field-success" id="edit-menu-name-valid" style="display:none;">
                                <i class="fas fa-check-circle"></i> Nama menu tersedia
                            </div>
                        </div>

                        {{-- Kategori & Harga --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div class="form-group">
                                <label>Kategori <span style="color:#dc2626">*</span></label>
                                <select name="category_id" id="edit-menu-category" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="field-error danger" id="edit-menu-category-error">
                                    <i class="fas fa-exclamation-circle"></i> Kategori wajib dipilih
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Harga Dasar (Rp) <span style="color:#dc2626">*</span></label>
                                <input type="number" name="price" id="edit-menu-price" min="0" step="500" required>
                                <div class="field-error danger" id="edit-menu-price-error">
                                    <i class="fas fa-exclamation-circle"></i> Harga minimal Rp 0
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi Singkat --}}
                        <div class="form-group">
                            <label>Deskripsi Singkat (Maks 150 Karakter) <span style="color:#dc2626">*</span></label>
                            <input type="text" name="short_description" id="edit-menu-short-desc" maxlength="150" required>
                            <div class="field-error danger" id="edit-menu-short-desc-error">
                                <i class="fas fa-exclamation-circle"></i> Deskripsi singkat wajib diisi (maks 150 karakter)
                            </div>
                        </div>

                        {{-- Deskripsi Lengkap --}}
                        <div class="form-group">
                            <label>Deskripsi Lengkap <span style="color:#dc2626">*</span></label>
                            <textarea name="description" id="edit-menu-desc" rows="2" required></textarea>
                            <div class="field-error danger" id="edit-menu-desc-error">
                                <i class="fas fa-exclamation-circle"></i> Deskripsi lengkap wajib diisi
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div class="form-group">
                            <label>Gambar Menu</label>
                            <div style="display:flex;gap:10px;align-items:center">
                                <img id="edit-current-img" src=""
                                     style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #d7d7d7" loading="lazy">
                                <input type="file" name="image" id="edit-menu-image" accept=".jpg,.jpeg,.png"
                                       onchange="previewImage(this, 'preview-edit')">
                            </div>
                            <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                                <i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah gambar
                            </div>
                            <img id="preview-edit" src=""
                                 style="display:none;margin-top:8px;width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #d7d7d7">
                        </div>

                        {{-- Status --}}
                        <div class="form-group" style="display:flex;align-items:center;gap:10px;margin-top:10px">
                            <input type="checkbox" name="is_available" value="1" style="width:auto" id="edit-menu-available">
                            <label for="edit-menu-available" style="margin:0;cursor:pointer">Menu Tersedia untuk Dipesan</label>
                        </div>
                    </div>

                    {{-- KANAN --}}
                    <div>
                        <h4 style="font-size:13px;font-weight:700;color:#1b4332;margin-bottom:10px;text-transform:uppercase">
                            📦 Pilih Grup Varian (Opsional)
                        </h4>
                        @if($variantGroups->isEmpty())
                            <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:6px;padding:12px;font-size:12px;color:#92400e;margin-bottom:16px;">
                                ⚠️ Belum ada grup varian.
                                <a href="{{ route('admin.variant-groups.index') }}" target="_blank" style="color:#0e6446;font-weight:600;">Buat dulu di sini →</a>
                            </div>
                        @else
                            <div id="edit-variant-group-list"
                                 style="max-height:200px; overflow-y:auto; border:1px solid #e5e7eb; border-radius:8px; padding:10px; background:#fff; margin-bottom:16px;">
                                @foreach($variantGroups as $group)
                                <label style="display:flex;align-items:flex-start;gap:10px;padding:8px;border-radius:6px;cursor:pointer;transition:background .15s;"
                                       onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background=''">
                                    <input type="checkbox"
                                           name="variant_group_ids[]"
                                           value="{{ $group->id }}"
                                           class="edit-vg-checkbox"
                                           data-group-id="{{ $group->id }}"
                                           style="width:auto;margin-top:2px;accent-color:#0e6446;">
                                    <div>
                                        <div style="font-weight:600;font-size:13px;color:#111827;">{{ $group->name }}</div>
                                        <div style="font-size:11px;color:#6b7280;margin-top:2px;">
                                            {{ $group->variants->count() }} opsi:
                                            {{ $group->variants->pluck('name')->implode(', ') ?: 'Belum ada opsi' }}
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif

                        <h4 style="font-size:13px;font-weight:700;color:#1b4332;margin-bottom:10px;text-transform:uppercase">
                            ➕ Pilih Addon / Topping (Opsional)
                        </h4>
                        @if($addons->isEmpty())
                            <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:6px;padding:12px;font-size:12px;color:#92400e;">
                                ⚠️ Belum ada addon.
                                <a href="{{ route('admin.addons.index') }}" target="_blank" style="color:#0e6446;font-weight:600;">Buat dulu di sini →</a>
                            </div>
                        @else
                            <div id="edit-addon-list"
                                 style="max-height:200px; overflow-y:auto; border:1px solid #e5e7eb; border-radius:8px; padding:10px; background:#fff;">
                                @foreach($addons as $addon)
                                <label style="display:flex;align-items:center;gap:10px;padding:8px;border-radius:6px;cursor:pointer;transition:background .15s;"
                                       onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background=''">
                                    <input type="checkbox"
                                           name="addon_ids[]"
                                           value="{{ $addon->id }}"
                                           class="edit-addon-checkbox"
                                           data-addon-id="{{ $addon->id }}"
                                           style="width:auto;accent-color:#0e6446;">
                                    <div>
                                        <span style="font-weight:600;font-size:13px;color:#111827;">{{ $addon->name }}</span>
                                        <span style="font-size:11px;color:#6b7280;margin-left:6px;">+Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-menu')">Batal</button>
                <button type="submit" class="btn btn-primary" style="padding:0 20px;" id="btn-edit-menu">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE (KHUSUS UNTUK MENU, SEPERTI DI KATEGORI) ── --}}
<div class="modal-backdrop" id="modal-delete-menu">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Menu?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus menu <strong id="delete-menu-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;" id="delete-menu-warning"></span>
            </div>
            <form id="delete-menu-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-menu')">Batal</button>
                <button type="submit" class="btn btn-delete btn-sm">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

{{-- ── JAVASCRIPT ── --}}
@push('scripts')
<script>
// ── DATA MENU EXISTING ──
const menuData = @json($menus->map(fn($m) => ['id' => $m->id, 'name' => strtolower($m->name)])->toArray() ?? []);

// ── MODAL FUNCTIONS ──
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ── FUNGSI CEK DUPLIKAT ──
function checkMenuName(input, editId = null) {
    const name = input.value.trim();
    const nameLower = name.toLowerCase();

    const errorRequired = document.getElementById(input.id + '-error');
    const errorUnique = document.getElementById(input.id + '-unique-error');
    const successMsg = document.getElementById(input.id + '-valid');
    const duplicateNameSpan = errorUnique ? errorUnique.querySelector('strong') : null;

    input.classList.remove('is-invalid', 'is-valid');
    if (errorRequired) errorRequired.classList.remove('show');
    if (errorUnique) errorUnique.style.display = 'none';
    if (successMsg) successMsg.classList.remove('show');

    if (!name) {
        if (errorRequired) errorRequired.classList.add('show');
        input.classList.add('is-invalid');
        return false;
    }

    let isDuplicate = false;
    if (editId) {
        const otherMenus = menuData.filter(item => item.id !== editId).map(item => item.name);
        isDuplicate = otherMenus.includes(nameLower);
    } else {
        isDuplicate = menuData.some(item => item.name === nameLower);
    }

    if (isDuplicate) {
        input.classList.add('is-invalid');
        if (errorUnique) {
            if (duplicateNameSpan) duplicateNameSpan.textContent = name;
            errorUnique.style.display = 'flex';
        }
        if (successMsg) successMsg.classList.remove('show');
        return false;
    }

    input.classList.add('is-valid');
    if (successMsg) successMsg.classList.add('show');
    if (errorUnique) errorUnique.style.display = 'none';
    return true;
}

// ── PREVIEW GAMBAR ──
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── CONFIRM DELETE MENU (PAKAI MODAL SENDIRI) ──
function confirmDeleteMenu(action, name, variantCount, addonCount) {
    document.getElementById('delete-menu-form').action = action;
    document.getElementById('delete-menu-name').textContent = name;
    
    const warning = document.getElementById('delete-menu-warning');
    let warnings = [];
    if (variantCount > 0) {
        warnings.push(variantCount + ' grup varian');
    }
    if (addonCount > 0) {
        warnings.push(addonCount + ' addon');
    }
    
    if (warnings.length > 0) {
        warning.textContent = '⚠️ Menu ini memiliki ' + warnings.join(' dan ') + ' yang akan ikut terhapus!';
        warning.style.display = 'block';
    } else {
        warning.style.display = 'none';
    }
    
    openModal('modal-delete-menu');
}

// ── FUNGSI VALIDASI FORM CREATE ──
function validateCreateForm() {
    let isValid = true;

    const nameInput = document.getElementById('create-menu-name');
    if (!checkMenuName(nameInput)) {
        isValid = false;
    }

    const categorySelect = document.getElementById('create-menu-category');
    const categoryError = document.getElementById('create-menu-category-error');
    categorySelect.classList.remove('is-invalid', 'is-valid');
    categoryError.classList.remove('show');
    if (!categorySelect.value) {
        categorySelect.classList.add('is-invalid');
        categoryError.classList.add('show');
        isValid = false;
    } else {
        categorySelect.classList.add('is-valid');
    }

    const priceInput = document.getElementById('create-menu-price');
    const priceError = document.getElementById('create-menu-price-error');
    priceInput.classList.remove('is-invalid', 'is-valid');
    priceError.classList.remove('show');
    const price = parseFloat(priceInput.value);
    if (isNaN(price) || price < 0) {
        priceInput.classList.add('is-invalid');
        priceError.classList.add('show');
        isValid = false;
    } else {
        priceInput.classList.add('is-valid');
    }

    const shortDescInput = document.getElementById('create-menu-short-desc');
    const shortDescError = document.getElementById('create-menu-short-desc-error');
    shortDescInput.classList.remove('is-invalid', 'is-valid');
    shortDescError.classList.remove('show');
    if (!shortDescInput.value.trim()) {
        shortDescInput.classList.add('is-invalid');
        shortDescError.classList.add('show');
        isValid = false;
    } else {
        shortDescInput.classList.add('is-valid');
    }

    const descInput = document.getElementById('create-menu-desc');
    const descError = document.getElementById('create-menu-desc-error');
    descInput.classList.remove('is-invalid', 'is-valid');
    descError.classList.remove('show');
    if (!descInput.value.trim()) {
        descInput.classList.add('is-invalid');
        descError.classList.add('show');
        isValid = false;
    } else {
        descInput.classList.add('is-valid');
    }

    const imageInput = document.getElementById('create-menu-image');
    const imageError = document.getElementById('create-menu-image-error');
    imageInput.classList.remove('is-invalid', 'is-valid');
    imageError.classList.remove('show');
    if (!imageInput.files || imageInput.files.length === 0) {
        imageInput.classList.add('is-invalid');
        imageError.classList.add('show');
        isValid = false;
    } else {
        const file = imageInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            imageInput.classList.add('is-invalid');
            imageError.textContent = 'Format gambar harus JPG atau PNG';
            imageError.classList.add('show');
            isValid = false;
        } else {
            imageInput.classList.add('is-valid');
        }
    }

    return isValid;
}

// ── FUNGSI VALIDASI FORM EDIT ──
function validateEditForm(editId) {
    let isValid = true;

    const nameInput = document.getElementById('edit-menu-name');
    if (!checkMenuName(nameInput, editId)) {
        isValid = false;
    }

    const categorySelect = document.getElementById('edit-menu-category');
    const categoryError = document.getElementById('edit-menu-category-error');
    categorySelect.classList.remove('is-invalid', 'is-valid');
    categoryError.classList.remove('show');
    if (!categorySelect.value) {
        categorySelect.classList.add('is-invalid');
        categoryError.classList.add('show');
        isValid = false;
    } else {
        categorySelect.classList.add('is-valid');
    }

    const priceInput = document.getElementById('edit-menu-price');
    const priceError = document.getElementById('edit-menu-price-error');
    priceInput.classList.remove('is-invalid', 'is-valid');
    priceError.classList.remove('show');
    const price = parseFloat(priceInput.value);
    if (isNaN(price) || price < 0) {
        priceInput.classList.add('is-invalid');
        priceError.classList.add('show');
        isValid = false;
    } else {
        priceInput.classList.add('is-valid');
    }

    const shortDescInput = document.getElementById('edit-menu-short-desc');
    const shortDescError = document.getElementById('edit-menu-short-desc-error');
    shortDescInput.classList.remove('is-invalid', 'is-valid');
    shortDescError.classList.remove('show');
    if (!shortDescInput.value.trim()) {
        shortDescInput.classList.add('is-invalid');
        shortDescError.classList.add('show');
        isValid = false;
    } else {
        shortDescInput.classList.add('is-valid');
    }

    const descInput = document.getElementById('edit-menu-desc');
    const descError = document.getElementById('edit-menu-desc-error');
    descInput.classList.remove('is-invalid', 'is-valid');
    descError.classList.remove('show');
    if (!descInput.value.trim()) {
        descInput.classList.add('is-invalid');
        descError.classList.add('show');
        isValid = false;
    } else {
        descInput.classList.add('is-valid');
    }

    const imageInput = document.getElementById('edit-menu-image');
    if (imageInput.files && imageInput.files.length > 0) {
        const file = imageInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            imageInput.classList.add('is-invalid');
            let errEl = document.getElementById('edit-menu-image-error');
            if (!errEl) {
                errEl = document.createElement('div');
                errEl.id = 'edit-menu-image-error';
                errEl.className = 'field-error danger';
                errEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> Format gambar harus JPG atau PNG';
                imageInput.parentNode.appendChild(errEl);
            }
            errEl.classList.add('show');
            isValid = false;
        } else {
            imageInput.classList.add('is-valid');
            const errEl = document.getElementById('edit-menu-image-error');
            if (errEl) errEl.classList.remove('show');
        }
    }

    return isValid;
}

// ── MODAL FUNCTIONS ──
function openCreateMenu() {
    document.getElementById('form-create-menu').reset();
    document.getElementById('preview-create').style.display = 'none';
    document.querySelectorAll('#form-create-menu .is-invalid, #form-create-menu .is-valid')
        .forEach(el => el.classList.remove('is-invalid', 'is-valid'));
    document.querySelectorAll('#form-create-menu .field-error.show')
        .forEach(el => el.classList.remove('show'));
    document.querySelectorAll('#form-create-menu .field-success.show')
        .forEach(el => el.classList.remove('show'));
    document.getElementById('create-menu-name-unique-error').style.display = 'none';
    document.getElementById('create-menu-name-valid').classList.remove('show');
    openModal('modal-create-menu');
    setTimeout(() => document.getElementById('create-menu-name').focus(), 100);
}

function openEditMenu(id, name, categoryId, desc, shortDesc, price, isAvailable, imgUrl) {
    const form = document.getElementById('edit-menu-form');
    form.action = '/admin/menus/' + id;

    document.getElementById('edit-menu-name').value        = name;
    document.getElementById('edit-menu-category').value    = categoryId;
    document.getElementById('edit-menu-price').value       = price;
    document.getElementById('edit-menu-desc').value        = desc;
    document.getElementById('edit-menu-short-desc').value  = shortDesc;
    document.getElementById('edit-menu-available').checked = isAvailable;

    const imgEl = document.getElementById('edit-current-img');
    if (imgUrl) { imgEl.src = imgUrl; imgEl.style.display = 'block'; }
    else { imgEl.style.display = 'none'; }

    form.querySelector('input[type="file"]').value = '';
    document.getElementById('preview-edit').style.display = 'none';

    document.querySelectorAll('#edit-menu-form .is-invalid, #edit-menu-form .is-valid')
        .forEach(el => el.classList.remove('is-invalid', 'is-valid'));
    document.querySelectorAll('#edit-menu-form .field-error.show')
        .forEach(el => el.classList.remove('show'));
    document.querySelectorAll('#edit-menu-form .field-success.show')
        .forEach(el => el.classList.remove('show'));
    document.getElementById('edit-menu-name-unique-error').style.display = 'none';
    document.getElementById('edit-menu-name-valid').classList.remove('show');

    document.querySelectorAll('.edit-vg-checkbox').forEach(cb => cb.checked = false);
    document.querySelectorAll('.edit-addon-checkbox').forEach(cb => cb.checked = false);

    fetch('/admin/menus/' + id + '/edit-data')
        .then(r => r.json())
        .then(json => {
            (json.variant_group_ids || []).forEach(gid => {
                const cb = document.querySelector(`.edit-vg-checkbox[data-group-id="${gid}"]`);
                if (cb) cb.checked = true;
            });
            (json.addon_ids || []).forEach(aid => {
                const cb = document.querySelector(`.edit-addon-checkbox[data-addon-id="${aid}"]`);
                if (cb) cb.checked = true;
            });
        })
        .catch(() => {});

    openModal('modal-edit-menu');
    setTimeout(() => document.getElementById('edit-menu-name').focus(), 100);
}

// ── EVENT LISTENER ──
document.addEventListener('DOMContentLoaded', function() {
    // ── CREATE: validasi real-time ──
    const createName = document.getElementById('create-menu-name');
    if (createName) {
        ['input', 'blur'].forEach(evt => {
            createName.addEventListener(evt, function() { checkMenuName(this); });
        });
        createName.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('create-menu-name-error').classList.remove('show');
            document.getElementById('create-menu-name-unique-error').style.display = 'none';
            document.getElementById('create-menu-name-valid').classList.remove('show');
        });
    }

    const createCategory = document.getElementById('create-menu-category');
    if (createCategory) {
        createCategory.addEventListener('change', function() {
            const error = document.getElementById('create-menu-category-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const createPrice = document.getElementById('create-menu-price');
    if (createPrice) {
        createPrice.addEventListener('input', function() {
            const error = document.getElementById('create-menu-price-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            const val = parseFloat(this.value);
            if (!isNaN(val) && val >= 0) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const createShortDesc = document.getElementById('create-menu-short-desc');
    if (createShortDesc) {
        createShortDesc.addEventListener('input', function() {
            const error = document.getElementById('create-menu-short-desc-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value.trim()) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const createDesc = document.getElementById('create-menu-desc');
    if (createDesc) {
        createDesc.addEventListener('input', function() {
            const error = document.getElementById('create-menu-desc-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value.trim()) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const createImage = document.getElementById('create-menu-image');
    if (createImage) {
        createImage.addEventListener('change', function() {
            const error = document.getElementById('create-menu-image-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (validTypes.includes(file.type)) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.add('is-invalid');
                    error.textContent = 'Format gambar harus JPG atau PNG';
                    error.classList.add('show');
                }
            } else {
                this.classList.add('is-invalid');
                error.textContent = 'Gambar menu wajib diunggah (JPG/PNG)';
                error.classList.add('show');
            }
        });
    }

    // ── EDIT: validasi real-time ──
    const editName = document.getElementById('edit-menu-name');
    if (editName) {
        ['input', 'blur'].forEach(evt => {
            editName.addEventListener(evt, function() {
                const form = document.getElementById('edit-menu-form');
                const match = form.action.match(/\/admin\/menus\/(\d+)/);
                const editId = match ? parseInt(match[1]) : null;
                checkMenuName(this, editId);
            });
        });
        editName.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('edit-menu-name-error').classList.remove('show');
            document.getElementById('edit-menu-name-unique-error').style.display = 'none';
            document.getElementById('edit-menu-name-valid').classList.remove('show');
        });
    }

    const editCategory = document.getElementById('edit-menu-category');
    if (editCategory) {
        editCategory.addEventListener('change', function() {
            const error = document.getElementById('edit-menu-category-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const editPrice = document.getElementById('edit-menu-price');
    if (editPrice) {
        editPrice.addEventListener('input', function() {
            const error = document.getElementById('edit-menu-price-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            const val = parseFloat(this.value);
            if (!isNaN(val) && val >= 0) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const editShortDesc = document.getElementById('edit-menu-short-desc');
    if (editShortDesc) {
        editShortDesc.addEventListener('input', function() {
            const error = document.getElementById('edit-menu-short-desc-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value.trim()) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const editDesc = document.getElementById('edit-menu-desc');
    if (editDesc) {
        editDesc.addEventListener('input', function() {
            const error = document.getElementById('edit-menu-desc-error');
            this.classList.remove('is-invalid', 'is-valid');
            error.classList.remove('show');
            if (this.value.trim()) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    }

    const editImage = document.getElementById('edit-menu-image');
    if (editImage) {
        editImage.addEventListener('change', function() {
            this.classList.remove('is-invalid', 'is-valid');
            let errEl = document.getElementById('edit-menu-image-error');
            if (errEl) errEl.classList.remove('show');
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (validTypes.includes(file.type)) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.add('is-invalid');
                    if (!errEl) {
                        errEl = document.createElement('div');
                        errEl.id = 'edit-menu-image-error';
                        errEl.className = 'field-error danger';
                        errEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> Format gambar harus JPG atau PNG';
                        this.parentNode.appendChild(errEl);
                    }
                    errEl.classList.add('show');
                }
            }
        });
    }

    // ── SUBMIT CREATE ──
    document.getElementById('form-create-menu')?.addEventListener('submit', function(e) {
        if (!validateCreateForm()) {
            e.preventDefault();
            const firstError = this.querySelector('.is-invalid');
            if (firstError) firstError.focus();
            return false;
        }
        document.getElementById('btn-create-menu').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        document.getElementById('btn-create-menu').disabled = true;
    });

    // ── SUBMIT EDIT ──
    document.getElementById('edit-menu-form')?.addEventListener('submit', function(e) {
        const match = this.action.match(/\/admin\/menus\/(\d+)/);
        const editId = match ? parseInt(match[1]) : null;
        if (!validateEditForm(editId)) {
            e.preventDefault();
            const firstError = this.querySelector('.is-invalid');
            if (firstError) firstError.focus();
            return false;
        }
        document.getElementById('btn-edit-menu').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        document.getElementById('btn-edit-menu').disabled = true;
    });
});
</script>
@endpush