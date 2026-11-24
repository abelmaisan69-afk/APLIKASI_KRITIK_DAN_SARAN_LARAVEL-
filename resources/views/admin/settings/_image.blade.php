<div>
    <label class="block text-sm font-medium mb-1">{{ $label }}</label>
    @if (!empty($biz[$name]))
        <img src="{{ \App\Models\Setting::url($biz[$name]) }}" alt="" class="h-24 rounded-xl mb-2 object-cover">
        <p class="text-xs text-slate-500 mb-2">Pilih file baru hanya jika ingin mengganti.</p>
    @endif
    <input type="file" name="{{ $name }}" accept="image/png,image/jpeg,image/webp" class="text-sm">
    <p class="text-xs text-slate-500 mt-1">JPG, PNG, atau WEBP.</p>
    @error($name) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>
