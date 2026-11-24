<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('nama', 'like', '%' . $request->q . '%'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('product_category_id', $request->kategori))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = ProductCategory::orderBy('nama')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('nama')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('sukses', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('nama')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('sukses', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return back()->with('sukses', 'Produk dihapus.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('sukses', $product->is_active ? 'Produk diaktifkan.' : 'Produk dinonaktifkan.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama'                => 'required|string|max:150',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'deskripsi'           => 'nullable|string|max:2000',
            'harga'               => 'required|integer|min:0|max:100000000',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // checkbox: tidak dicentang = tidak terkirim
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        unset($data['foto']); // file ditangani terpisah di store/update

        return $data;
    }
}
