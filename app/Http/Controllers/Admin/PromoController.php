<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $query = Promo::with('category')->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $promos = $query->paginate(15);
        $categories = Category::orderBy('name')->get();
        
        return view('admin.promos.index', compact('promos', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('promos', 'code'),
            ],
            'description' => 'required|string|min:5|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        $data['min_order'] = $request->min_order ?? 0;

        Promo::create($data);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $data['code'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('promos', 'code')->ignore($promo->id),
            ],
            'description' => 'required|string|min:5|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        $data['min_order'] = $request->min_order ?? 0;

        $promo->update($data);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $data['code'] . '" berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $code = $promo->code;
        $promo->delete();
        
        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $code . '" berhasil dihapus.');
    }
}