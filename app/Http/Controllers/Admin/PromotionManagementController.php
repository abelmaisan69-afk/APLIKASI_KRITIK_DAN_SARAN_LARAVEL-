<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionManagementController extends Controller
{
    public function index(Request $request)
    {
        $promotions = Promotion::query()
            ->when($request->filled('q'), fn ($q) => $q->where('nama', 'like', '%' . $request->q . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('promos', 'public');
        }

        Promotion::create($data);

        return redirect()->route('admin.promotions.index')->with('sukses', 'Promo berhasil ditambahkan.');
    }

    // dipakai sebagai halaman preview
    public function show(Promotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $this->validated($request);

        if ($request->hasFile('banner')) {
            if ($promotion->banner) {
                Storage::disk('public')->delete($promotion->banner);
            }
            $data['banner'] = $request->file('banner')->store('promos', 'public');
        }

        $promotion->update($data);

        return redirect()->route('admin.promotions.index')->with('sukses', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->banner) {
            Storage::disk('public')->delete($promotion->banner);
        }

        $promotion->delete();

        return back()->with('sukses', 'Promo dihapus.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['is_active' => ! $promotion->is_active]);

        return back()->with('sukses', $promotion->is_active ? 'Promo diaktifkan.' : 'Promo dinonaktifkan.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama'             => 'required|string|max:150',
            'deskripsi'        => 'nullable|string|max:2000',
            'harga_normal'     => 'nullable|integer|min:0|max:100000000',
            'harga_diskon'     => 'nullable|integer|min:0|max:100000000|lt:harga_normal',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'banner'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'harga_diskon.lt'                  => 'Harga diskon harus lebih kecil dari harga normal.',
            'tanggal_berakhir.after_or_equal'  => 'Tanggal berakhir tidak boleh sebelum tanggal mulai.',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        unset($data['banner']); // file ditangani terpisah

        return $data;
    }
}
