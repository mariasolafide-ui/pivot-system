<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('menus');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%");
        }
        
        $categories = $query->latest()->paginate(15);
        
        // ── Statistik ──
        $totalMenus = Menu::count();
        $mostCategory = Category::withCount('menus')->orderBy('menus_count', 'desc')->first();
        $leastCategory = Category::withCount('menus')->orderBy('menus_count', 'asc')->first();
        
        return view('admin.categories.index', compact('categories', 'totalMenus', 'mostCategory', 'leastCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
        ]);
        
        Category::create($request->all());
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
        ]);
        
        $category->update($request->all());
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $category->name . '" berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $menuCount = $category->menus()->count();
        $name = $category->name;
        
        if ($menuCount > 0) {
            $category->menus()->delete();
        }
        
        $category->delete();
        
        $message = 'Kategori "' . $name . '" berhasil dihapus.';
        if ($menuCount > 0) {
            $message .= ' ' . $menuCount . ' menu di dalamnya juga ikut terhapus.';
        }
        
        return redirect()->route('admin.categories.index')
            ->with('success', $message);
    }
}