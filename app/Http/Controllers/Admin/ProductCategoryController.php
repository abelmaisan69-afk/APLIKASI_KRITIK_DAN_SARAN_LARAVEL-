<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('nama')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:product_categories,nama',
        ]);

        ProductCategory::create($data);

        return back()->with('sukses', 'Kategori ditambahkan.');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return back()->with('sukses', 'Kategori dihapus. Produk di dalamnya menjadi tanpa kategori.');
    }
}
