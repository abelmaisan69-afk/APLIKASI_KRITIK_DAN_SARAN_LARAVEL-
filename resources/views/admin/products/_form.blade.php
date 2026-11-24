@php $product = $product ?? null; @endphp

<div class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-5">
    <div>
        <label class="block text-sm font-medium mb-1">Nama produk</label>
        <input type="text" name="nama" value="{{ old('nama', $product->nama ?? '') }}" maxlength="150"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
        @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="product_category_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}"
                        @selected(old('product_category_id', $product->product_category_id ?? '') == $c->id)>{{ $c->nama }}</option>
                @endforeach
            </select>
            @error('product_category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
            <input type="number" name="harga" min="0" value="{{ old('harga', $product->harga ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('harga') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4" maxlength="2000"
                  class="w-full rounded-xl border border-slate-200 px-4 py-2.5">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Foto produk</label>
        @if ($product && $product->foto_url)
            <img src="{{ $product->foto_url }}" alt="" class="w-32 h-32 object-cover rounded-xl mb-2">
            <p class="text-xs text-slate-500 mb-2">Pilih file baru hanya jika ingin mengganti foto.</p>
        @endif
        <input type="file" name="foto" accept="image/png,image/jpeg,image/webp" class="text-sm">
        <p class="text-xs text-slate-500 mt-1">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
        @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-wrap gap-6">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_featured" value="1"
                   @checked(old('is_featured', $product->is_featured ?? false))> Produk unggulan
        </label>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $product->is_active ?? true))> Aktif (tampil di website)
        </label>
    </div>

    <div class="flex gap-2">
        <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="border border-slate-200 px-6 py-2.5 rounded-xl text-sm">Batal</a>
    </div>
</div>
