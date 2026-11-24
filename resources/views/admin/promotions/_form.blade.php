@php $promotion = $promotion ?? null; @endphp

<div class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-5">
    <div>
        <label class="block text-sm font-medium mb-1">Nama promo</label>
        <input type="text" name="nama" value="{{ old('nama', $promotion->nama ?? '') }}" maxlength="150"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
        @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4" maxlength="2000"
                  class="w-full rounded-xl border border-slate-200 px-4 py-2.5">{{ old('deskripsi', $promotion->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium mb-1">Harga normal (Rp)</label>
            <input type="number" name="harga_normal" min="0" value="{{ old('harga_normal', $promotion->harga_normal ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('harga_normal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Harga diskon (Rp)</label>
            <input type="number" name="harga_diskon" min="0" value="{{ old('harga_diskon', $promotion->harga_diskon ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('harga_diskon') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium mb-1">Tanggal mulai</label>
            <input type="date" name="tanggal_mulai"
                   value="{{ old('tanggal_mulai', optional($promotion?->tanggal_mulai)->format('Y-m-d')) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('tanggal_mulai') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Tanggal berakhir</label>
            <input type="date" name="tanggal_berakhir"
                   value="{{ old('tanggal_berakhir', optional($promotion?->tanggal_berakhir)->format('Y-m-d')) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('tanggal_berakhir') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Banner promo</label>
        @if ($promotion && $promotion->banner_url)
            <img src="{{ $promotion->banner_url }}" alt="" class="w-64 aspect-[16/9] object-cover rounded-xl mb-2">
            <p class="text-xs text-slate-500 mb-2">Pilih file baru hanya jika ingin mengganti banner.</p>
        @endif
        <input type="file" name="banner" accept="image/png,image/jpeg,image/webp" class="text-sm">
        <p class="text-xs text-slate-500 mt-1">JPG, PNG, atau WEBP. Maksimal 2 MB. Rasio 16:9 paling pas.</p>
        @error('banner') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1"
               @checked(old('is_active', $promotion->is_active ?? true))> Aktif (tampil di website selama periode berlaku)
    </label>

    <div class="flex gap-2">
        <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan</button>
        <a href="{{ route('admin.promotions.index') }}" class="border border-slate-200 px-6 py-2.5 rounded-xl text-sm">Batal</a>
    </div>
</div>
