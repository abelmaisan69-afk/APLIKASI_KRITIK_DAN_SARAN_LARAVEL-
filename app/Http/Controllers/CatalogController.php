<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->active()
            ->when($request->filled('q'), fn ($q) => $q->where('nama', 'like', '%' . $request->q . '%'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('product_category_id', $request->kategori))
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = ProductCategory::orderBy('nama')->get();

        return view('catalog.index', compact('products', 'categories'));
    }
}
