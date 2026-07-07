<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuVariant;
use App\Models\VariantGroup;
use Illuminate\Http\Request;

class VariantGroupController extends Controller
{
    // ────────────────────────────────────────────────────────────────────
    // INDEX — halaman master kelola grup varian global
    // ────────────────────────────────────────────────────────────────────
    public function index()
    {
        $groups = VariantGroup::with('variants')->orderBy('name')->get();
        return view('admin.variant-groups.index', compact('groups'));
    }

    // ────────────────────────────────────────────────────────────────────
    // STORE — buat grup baru
    // ────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:variant_groups,name',
        ]);

        VariantGroup::create([
            'name'      => $request->name,
            'is_active' => true,
        ]);

        return redirect()->route('admin.variant-groups.index')
            ->with('success', "Grup varian \"{$request->name}\" berhasil dibuat.");
    }

    // ────────────────────────────────────────────────────────────────────
    // UPDATE — rename grup
    // ────────────────────────────────────────────────────────────────────
    public function update(Request $request, VariantGroup $variantGroup)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:variant_groups,name,' . $variantGroup->id,
        ]);

        $variantGroup->update(['name' => $request->name]);

        return redirect()->route('admin.variant-groups.index')
            ->with('success', 'Nama grup berhasil diperbarui.');
    }

    // ────────────────────────────────────────────────────────────────────
    // DESTROY — hapus grup (cascade ke variants)
    // ────────────────────────────────────────────────────────────────────
    public function destroy(VariantGroup $variantGroup)
    {
        $variantGroup->delete();
        return redirect()->route('admin.variant-groups.index')
            ->with('success', "Grup \"{$variantGroup->name}\" berhasil dihapus.");
    }

    // ────────────────────────────────────────────────────────────────────
    // STORE VARIANT — tambah opsi ke dalam grup
    // ────────────────────────────────────────────────────────────────────
    public function storeVariant(Request $request, VariantGroup $variantGroup)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'extra_price' => 'required|integer|min:0',
            'is_default'  => 'nullable|boolean',
        ]);

        $isDefault = $request->boolean('is_default');

        // Kalau opsi ini dijadikan default, reset default yang lain dulu
        if ($isDefault) {
            $variantGroup->variants()->update(['is_default' => false]);
        }

        $variantGroup->variants()->create([
            'name'         => $request->name,
            'extra_price'  => $request->extra_price,
            'is_default'   => $isDefault,
            'is_available' => true,
        ]);

        return redirect()->route('admin.variant-groups.index')
            ->with('success', "Opsi \"{$request->name}\" ditambahkan ke grup {$variantGroup->name}.");
    }

    // ────────────────────────────────────────────────────────────────────
    // DESTROY VARIANT — hapus satu opsi dari grup
    // ────────────────────────────────────────────────────────────────────
    public function destroyVariant(VariantGroup $variantGroup, MenuVariant $variant)
    {
        $variant->delete();
        return redirect()->route('admin.variant-groups.index')
            ->with('success', 'Opsi berhasil dihapus.');
    }

    // ────────────────────────────────────────────────────────────────────
    // TOGGLE ACTIVE — aktif/nonaktifkan grup
    // ────────────────────────────────────────────────────────────────────
    public function toggle(VariantGroup $variantGroup)
    {
        $variantGroup->update(['is_active' => !$variantGroup->is_active]);
        $status = $variantGroup->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.variant-groups.index')
            ->with('success', "Grup \"{$variantGroup->name}\" berhasil {$status}.");
    }

    // ────────────────────────────────────────────────────────────────────
    // SET DEFAULT — jadikan satu opsi sebagai default di grup
    // ────────────────────────────────────────────────────────────────────
    public function setDefault(VariantGroup $variantGroup, MenuVariant $variant)
    {
        // Unset semua default di grup ini
        $variantGroup->variants()->update(['is_default' => false]);
        // Set default untuk variant ini
        $variant->update(['is_default' => true]);
        
        return redirect()->route('admin.variant-groups.index')
            ->with('success', 'Default opsi berhasil diubah menjadi "' . $variant->name . '"!');
    }
}