<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    // ────────────────────────────────────────────────────────────────────
    // INDEX — halaman master kelola addon global
    // ────────────────────────────────────────────────────────────────────
    public function index()
    {
        $addons = Addon::orderBy('name')->get();
        return view('admin.addons.index', compact('addons'));
    }

    // ────────────────────────────────────────────────────────────────────
    // STORE — buat addon baru
    // ────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:addons,name',
            'price' => 'required|integer|min:0',
        ]);

        Addon::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'is_available' => true,
        ]);

        return back()->with('success', "Addon \"{$request->name}\" berhasil ditambahkan.");
    }

    // ────────────────────────────────────────────────────────────────────
    // UPDATE — ubah nama/harga addon
    // ────────────────────────────────────────────────────────────────────
    public function update(Request $request, Addon $addon)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:addons,name,' . $addon->id,
            'price' => 'required|integer|min:0',
        ]);

        $addon->update([
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return back()->with('success', 'Addon berhasil diperbarui.');
    }

    // ────────────────────────────────────────────────────────────────────
    // DESTROY — hapus addon
    // ────────────────────────────────────────────────────────────────────
    public function destroy(Addon $addon)
    {
        $addon->delete();
        return back()->with('success', "Addon \"{$addon->name}\" berhasil dihapus.");
    }

    // ────────────────────────────────────────────────────────────────────
    // TOGGLE — aktif/nonaktifkan addon
    // ────────────────────────────────────────────────────────────────────
    public function toggle(Addon $addon)
    {
        $addon->update(['is_available' => !$addon->is_available]);
        $status = $addon->is_available ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Addon \"{$addon->name}\" berhasil {$status}.");
    }
}