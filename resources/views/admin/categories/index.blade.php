@extends('layouts.admin')
@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

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

    /* ── NAVIGASI BACK ── */
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

    /* ── TOMBOL KONSISTEN ── */
    .btn-edit {
        background: #3b82f6;
        color: white;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
    }
    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
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
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
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
    }
    .btn-primary:hover {
        background: #2d6a4f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.35);
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
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .badge {
        padding: 4px 12px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 30px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-success {
        background: #dcfce7;
        color: #166534;
    }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .stat-label {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-top: 4px;
    }

    .stat-sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    /* ── TABLE ── */
    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 500px;
    }

    .table-wrap th {
        background: #f8fafc;
        color: #374151;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }

    .table-wrap td {
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
        vertical-align: middle;
    }

    .table-wrap tbody tr {
        transition: background-color 0.15s;
    }

    .table-wrap tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ── MODAL ── */
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

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }

    .modal-close:hover {
        color: #111827;
    }

    .modal-body {
        padding: 24px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        display: block;
        font-size: 13px;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color .2s;
        outline: none;
    }

    .form-group input:focus {
        border-color: #1b4332;
        box-shadow: 0 0 0 2px rgba(27, 67, 50, 0.1);
    }

    .form-group .required {
        color: #dc2626;
    }

    .form-group .field-error {
        color: #dc2626;
        font-size: 11px;
        margin-top: 4px;
        display: none;
    }

    .form-group .field-error.show {
        display: block;
    }

    .form-group input.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    .form-group input.is-valid {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .field-success {
        color: #16a34a;
        font-size: 11px;
        margin-top: 4px;
        display: none;
    }

    .field-success.show {
        display: block;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-state .icon {
        font-size: 40px;
        margin-bottom: 8px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    .empty-state p {
        font-size: 13px;
        color: #6b7280;
    }

    .error-summary {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
        display: none;
    }

    .error-summary.show {
        display: block;
    }

    .error-summary .error-title {
        font-weight: 600;
        color: #991b1b;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .error-summary ul {
        margin: 4px 0 0 20px;
        color: #991b1b;
        font-size: 12px;
    }

    .pagination-wrapper {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .breadcrumb-admin {
            font-size: 12px;
        }
        .nav-back {
            font-size: 13px;
            padding: 6px 14px;
        }
    }

    @media (max-width: 480px) {
        .breadcrumb-admin {
            font-size: 11px;
        }
        .nav-back {
            font-size: 12px;
            padding: 5px 12px;
        }
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme: dark) {
        .stat-card {
            background: #1f2937;
            border-color: #374151;
        }
        .stat-label {
            color: #9ca3af;
        }
        .stat-value {
            color: #f3f4f6;
        }
        .stat-sub {
            color: #9ca3af;
        }
        .table-wrap th {
            background: #111827;
            color: #e5e7eb;
            border-color: #374151;
        }
        .table-wrap td {
            border-color: #374151;
            color: #e5e7eb;
        }
        .table-wrap tbody tr:hover {
            background-color: #111827;
        }
        .modal {
            background: #1f2937;
        }
        .modal-header {
            background: #1f2937;
            border-color: #374151;
        }
        .modal-title {
            color: #f3f4f6;
        }
        .modal-footer {
            background: #1f2937;
            border-color: #374151;
        }
        .form-group label {
            color: #e5e7eb;
        }
        .form-group input {
            background: #111827;
            border-color: #374151;
            color: #f3f4f6;
        }
        .form-group input:focus {
            border-color: #d4a373;
        }
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
        .error-summary {
            background: #1f1414;
            border-color: #dc2626;
        }
        .error-summary .error-title {
            color: #fca5a5;
        }
        .error-summary ul {
            color: #fca5a5;
        }
        .empty-state h3 {
            color: #f3f4f6;
        }
        .empty-state p {
            color: #9ca3af;
        }
    }
</style>

{{-- ── BREADCRUMB (DENGAN ICON) ── --}}
<div class="breadcrumb-admin">
    <i class="fas fa-folder-open" style="color: #1b4332; font-size: 14px;"></i>
    <span class="current">Kelola Kategori</span>
</div>

{{-- ── ERROR SUMMARY ── --}}
@if($errors->any())
<div class="error-summary show" id="error-summary">
    <div class="error-title">
        <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada formulir:
    </div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ── STATS ─────────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    @php
    $stats = [
        ['label' => 'Total Kategori', 'value' => $categories->total(), 'icon' => 'fa-tags', 'color' => '#1b4332'],
        ['label' => 'Total Menu', 'value' => $totalMenus ?? 0, 'icon' => 'fa-utensils', 'color' => '#d4a373'],
        ['label' => 'Kategori Terbanyak', 'value' => $mostCategory?->name ?? '-', 'sub' => $mostCategory ? $mostCategory->menus_count . ' menu' : '', 'icon' => 'fa-arrow-up', 'color' => '#16a34a'],
        ['label' => 'Kategori Tersedikit', 'value' => $leastCategory?->name ?? '-', 'sub' => $leastCategory ? $leastCategory->menus_count . ' menu' : '', 'icon' => 'fa-arrow-down', 'color' => '#dc2626'],
    ];
    @endphp

    @foreach($stats as $stat)
    <div class="stat-card">
        <div class="stat-label">
            <i class="fas {{ $stat['icon'] }}" style="color:{{ $stat['color'] }};"></i>
            {{ $stat['label'] }}
        </div>
        <div class="stat-value">{{ $stat['value'] }}</div>
        @if($stat['sub'] ?? false)
            <div class="stat-sub">{{ $stat['sub'] }}</div>
        @endif
    </div>
    @endforeach
</div>

{{-- ── CARD TABEL ────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="card-title" style="margin:0;">
            <i class="fas fa-folder-open" style="color:#1b4332; margin-right:8px;"></i>
            Daftar Kategori
        </div>
        
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            {{-- Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" style="display:flex; align-items:center; gap:4px; margin:0;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari kategori..." 
                       style="padding:5px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:12px; width:160px; outline:none; height:32px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="height:32px;">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm" style="height:32px;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            <button type="button" class="btn btn-primary btn-sm" onclick="openCreateCategory()">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th style="text-align:center;">Jumlah Menu</th>
                    <th class="no-sort" style="text-align:center; min-width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cat)
                <tr>
                    <td style="text-align:center; color:#6b7280;">{{ $categories->firstItem() + $index }}</td>
                    <td style="font-weight:500;">
                        <i class="fas fa-folder" style="color:#1b4332;margin-right:6px;"></i>
                        {{ $cat->name }}
                    </td>
                    <td style="font-size:12px;color:#6b7280;font-family:monospace;">{{ $cat->slug }}</td>
                    <td style="text-align:center;">
                        <span class="badge badge-success">
                            <i class="fas fa-utensils" style="font-size:10px;margin-right:3px;"></i>
                            {{ $cat->menus_count }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:4px; justify-content:center; flex-wrap:wrap;">
                            <button type="button" class="btn btn-sm btn-edit" onclick="openEditCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="confirmDeleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->menus_count }})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#6b7280;padding:32px;">
                        @if(request('search'))
                            Kategori "{{ request('search') }}" tidak ditemukan.
                        @else
                            <div class="empty-state">
                                <div class="icon">📂</div>
                                <h3>Belum Ada Kategori</h3>
                                <p>Klik tombol "Tambah Kategori" untuk memulai.</p>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="pagination-wrapper">
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- ── MODAL CREATE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-create-category">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-plus-circle" style="color:#1b4332;margin-right:8px;"></i>
                Tambah Kategori
            </div>
            <button class="modal-close" onclick="closeModal('modal-create-category')">×</button>
        </div>
        <form id="form-create-category" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori <span class="required">*</span></label>
                    <input type="text" name="name" id="create-category-name" placeholder="Contoh: Kopi, Makanan..." required>
                    <div class="field-error" id="create-category-name-error">Nama kategori wajib diisi</div>
                    <div class="field-error" id="create-category-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama kategori sudah terdaftar
                    </div>
                    <div class="field-success" id="create-category-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama kategori tersedia
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-create-category')">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-create-category">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ───────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-edit-category">
    <div class="modal modal-sm">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit" style="color:#3b82f6;margin-right:8px;"></i>
                Edit Kategori
            </div>
            <button class="modal-close" onclick="closeModal('modal-edit-category')">×</button>
        </div>
        <form id="form-edit-category" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori <span class="required">*</span></label>
                    <input type="text" name="name" id="edit-category-name" required>
                    <div class="field-error" id="edit-category-name-error">Nama kategori wajib diisi</div>
                    <div class="field-error" id="edit-category-name-unique-error" style="display:none; color:#dc2626; font-size:11px; margin-top:4px;">
                        <i class="fas fa-exclamation-circle"></i> Nama kategori sudah terdaftar
                    </div>
                    <div class="field-success" id="edit-category-name-valid" style="display:none;">
                        <i class="fas fa-check-circle"></i> Nama kategori tersedia
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-edit-category')">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-edit-category">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL DELETE ─────────────────────────────────────────────────── --}}
<div class="modal-backdrop" id="modal-delete-category">
    <div class="modal modal-sm">
        <div class="modal-body" style="text-align: center; padding: 24px 20px;">
            <div style="font-size: 32px; margin-bottom: 8px;">🗑️</div>
            <div style="font-size: 16px; font-weight: 700; color: #1b4332; margin-bottom: 4px;">Hapus Kategori?</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                Hapus kategori <strong id="delete-category-name"></strong>?
                <br><span style="font-size: 11px; color: #dc2626;" id="delete-category-warning"></span>
            </div>
            <form id="delete-category-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modal-delete-category')">Batal</button>
                <button type="submit" class="btn btn-delete btn-sm">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DATA KATEGORI EXISTING ──
const existingCategories = @json($categories->pluck('name')->map(function($name) { 
    return strtolower($name); 
})->toArray() ?? []);

const categoryData = @json($categories->map(function($cat) {
    return ['id' => $cat->id, 'name' => strtolower($cat->name)];
})->toArray() ?? []);

// ── MODAL FUNCTIONS ──
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// ── CREATE ──
function openCreateCategory() {
    document.getElementById('create-category-name').value = '';
    document.getElementById('create-category-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('create-category-name-error').classList.remove('show');
    document.getElementById('create-category-name-unique-error').style.display = 'none';
    document.getElementById('create-category-name-valid').style.display = 'none';
    openModal('modal-create-category');
    setTimeout(function() {
        document.getElementById('create-category-name').focus();
    }, 100);
}

// ── EDIT ──
function openEditCategory(id, name) {
    document.getElementById('form-edit-category').action = '/admin/categories/' + id;
    document.getElementById('edit-category-name').value = name;
    document.getElementById('edit-category-name').classList.remove('is-invalid', 'is-valid');
    document.getElementById('edit-category-name-error').classList.remove('show');
    document.getElementById('edit-category-name-unique-error').style.display = 'none';
    document.getElementById('edit-category-name-valid').style.display = 'none';
    document.getElementById('form-edit-category').dataset.editId = id;
    openModal('modal-edit-category');
    setTimeout(function() {
        document.getElementById('edit-category-name').focus();
    }, 100);
}

// ── DELETE ──
function confirmDeleteCategory(id, name, menuCount) {
    document.getElementById('delete-category-form').action = '/admin/categories/' + id;
    document.getElementById('delete-category-name').textContent = name;
    
    const warning = document.getElementById('delete-category-warning');
    if (menuCount > 0) {
        warning.textContent = '⚠️ Kategori ini memiliki ' + menuCount + ' menu. Semua menu akan ikut terhapus!';
        warning.style.display = 'block';
    } else {
        warning.style.display = 'none';
    }
    
    openModal('modal-delete-category');
}

// ── CEK DUPLIKAT ──
// ── CEK DUPLIKAT ──
function checkCategoryName(input, isEdit = false) {
    const name = input.value.trim().toLowerCase();
    
    // Ambil elemen-elemen yang dibutuhkan
    const errorDefault = document.getElementById(input.id + '-error');
    const errorUnique = document.getElementById(input.id + '-unique-error');
    const successMsg = document.getElementById(input.id + '-valid');
    
    // Reset semua status
    input.classList.remove('is-invalid', 'is-valid');
    if (errorDefault) errorDefault.classList.remove('show');
    if (errorUnique) errorUnique.style.display = 'none';
    if (successMsg) successMsg.style.display = 'none';
    
    // Jika kosong
    if (!name) {
        input.classList.add('is-invalid');
        if (errorDefault) errorDefault.classList.add('show');
        return false;
    }
    
    // Cek duplikat
    let isDuplicate = false;
    if (isEdit) {
        const editId = parseInt(document.getElementById('form-edit-category')?.dataset.editId || 0);
        // Filter data kecuali dirinya sendiri
        const otherNames = categoryData
            .filter(item => item.id !== editId)
            .map(item => item.name);
        isDuplicate = otherNames.includes(name);
    } else {
        isDuplicate = existingCategories.includes(name);
    }
    
    if (isDuplicate) {
        input.classList.add('is-invalid');
        if (errorUnique) errorUnique.style.display = 'block';
        if (successMsg) successMsg.style.display = 'none';
        return false;
    } else {
        input.classList.add('is-valid');
        if (successMsg) successMsg.style.display = 'block';
        if (errorUnique) errorUnique.style.display = 'none';
        return true;
    }
}

// ── INIT ──
document.addEventListener('DOMContentLoaded', function() {
    // CREATE
    const createInput = document.getElementById('create-category-name');
    if (createInput) {
        createInput.addEventListener('input', function() {
            checkCategoryName(this, false);
        });
        // Saat input di-focus, reset semua status
        createInput.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('create-category-name-error').classList.remove('show');
            document.getElementById('create-category-name-unique-error').style.display = 'none';
            document.getElementById('create-category-name-valid').style.display = 'none';
        });
    }
    
    // EDIT
    const editInput = document.getElementById('edit-category-name');
    if (editInput) {
        editInput.addEventListener('input', function() {
            checkCategoryName(this, true);
        });
        editInput.addEventListener('focus', function() {
            this.classList.remove('is-invalid', 'is-valid');
            document.getElementById('edit-category-name-error').classList.remove('show');
            document.getElementById('edit-category-name-unique-error').style.display = 'none';
            document.getElementById('edit-category-name-valid').style.display = 'none';
        });
    }
    
    // SUBMIT CREATE
    document.getElementById('form-create-category')?.addEventListener('submit', function(e) {
        const input = document.getElementById('create-category-name');
        const name = input.value.trim();
        
        // Reset semua
        input.classList.remove('is-invalid', 'is-valid');
        document.getElementById('create-category-name-error').classList.remove('show');
        document.getElementById('create-category-name-unique-error').style.display = 'none';
        document.getElementById('create-category-name-valid').style.display = 'none';
        
        let isValid = true;
        
        if (!name) {
            document.getElementById('create-category-name-error').classList.add('show');
            input.classList.add('is-invalid');
            isValid = false;
        } else if (existingCategories.includes(name.toLowerCase())) {
            document.getElementById('create-category-name-unique-error').style.display = 'block';
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.add('is-valid');
            document.getElementById('create-category-name-valid').style.display = 'block';
        }
        
        if (!isValid) {
            e.preventDefault();
            input.focus();
            return false;
        }
        
        document.getElementById('btn-create-category').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        document.getElementById('btn-create-category').disabled = true;
    });
    
    // SUBMIT EDIT
    document.getElementById('form-edit-category')?.addEventListener('submit', function(e) {
        const input = document.getElementById('edit-category-name');
        const name = input.value.trim();
        const editId = parseInt(this.dataset.editId || 0);
        
        // Reset semua
        input.classList.remove('is-invalid', 'is-valid');
        document.getElementById('edit-category-name-error').classList.remove('show');
        document.getElementById('edit-category-name-unique-error').style.display = 'none';
        document.getElementById('edit-category-name-valid').style.display = 'none';
        
        let isValid = true;
        
        if (!name) {
            document.getElementById('edit-category-name-error').classList.add('show');
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            // Cek duplikat kecuali dirinya sendiri
            const isDuplicate = categoryData.some(item => 
                item.name === name.toLowerCase() && item.id !== editId
            );
            if (isDuplicate) {
                document.getElementById('edit-category-name-unique-error').style.display = 'block';
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.add('is-valid');
                document.getElementById('edit-category-name-valid').style.display = 'block';
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            input.focus();
            return false;
        }
        
        document.getElementById('btn-edit-category').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        document.getElementById('btn-edit-category').disabled = true;
    });
    
    // Auto close error summary
    const errorSummary = document.getElementById('error-summary');
    if (errorSummary) {
        setTimeout(function() {
            errorSummary.style.transition = 'opacity 0.5s ease';
            errorSummary.style.opacity = '0';
            setTimeout(function() {
                errorSummary.style.display = 'none';
            }, 500);
        }, 5000);
    }
});

console.log('✅ Halaman Kategori siap digunakan!');
</script>
@endpush