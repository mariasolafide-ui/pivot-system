<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetailProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RetailProductController extends Controller
{
    // 1. Menampilkan semua daftar produk kopi instan di halaman admin
    public function index()
    {
        $products = RetailProduct::latest()->paginate(10);
        return view('admin.retail_products.index', compact('products'));
    }

    // 2. Menampilkan form tambah produk baru
    public function create()
    {
        return view('admin.retail_products.create');
    }

    // 3. Menyimpan data kopi instan baru ke database MySQL
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time(); // Membuat slug unik otomatis

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/retail', 'public');
        }

        RetailProduct::create($data);

        return redirect()->route('admin.retail-products.index')->with('success', 'Produk kopi retail berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit produk kopi
    public function edit(RetailProduct $retailProduct)
    {
        return view('admin.retail_products.edit', compact('retailProduct'));
    }

    // 5. Memperbarui data (Update) produk kopi instan di database
    public function update(Request $request, RetailProduct $retailProduct)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($retailProduct->image) {
                Storage::disk('public')->delete($retailProduct->image);
            }
            $data['image'] = $request->file('image')->store('assets/retail', 'public');
        }

        // Jika stok diubah jadi lebih dari 0, otomatis buat produk jadi tersedia lagi
        $data['is_available'] = $request->stock > 0 ? true : false;

        $retailProduct->update($data);

        return redirect()->route('admin.retail-products.index')->with('success', 'Data produk kopi retail berhasil diperbarui!');
    }

    // 6. Menghapus produk kopi dari database
    public function destroy(RetailProduct $retailProduct)
    {
        if ($retailProduct->image) {
            Storage::disk('public')->delete($retailProduct->image);
        }
        
        $retailProduct->delete();

        return redirect()->route('admin.retail-products.index')->with('success', 'Produk kopi retail berhasil dihapus!');
    }
}