@php
    $current = !empty($biz[$name]) ? \App\Models\Setting::url($biz[$name]) : null;
    $hint    = $hint ?? 'JPG, PNG, atau WEBP. Maksimal 2 MB.';
    $maxKb   = $maxKb ?? 2048;
    $id      = 'file_' . $name;
@endphp

<div data-upload>
    <label for="{{ $id }}" class="block text-sm font-medium mb-2">{{ $label }}</label>

    <div class="flex items-center gap-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4
                transition hover:border-primary focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20">

        {{-- Preview --}}
        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-white
                    flex items-center justify-center">
            <img data-preview src="{{ $current }}" alt=""
                 class="h-full w-full object-contain {{ $current ? '' : 'hidden' }}">
            <svg data-placeholder class="h-8 w-8 text-slate-300 {{ $current ? 'hidden' : '' }}"
                 fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6.75a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5V19.5a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V9.75z"/>
            </svg>
        </div>

        {{-- Info + tombol --}}
        <div class="min-w-0 flex-1">
            <p data-filename class="truncate text-sm text-slate-700">
                {{ $current ? 'Gambar saat ini' : 'Belum ada file dipilih' }}
            </p>
            <p data-note class="mt-0.5 text-xs text-slate-400">{{ $hint }}</p>

            <label for="{{ $id }}"
                   class="mt-3 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary px-4 py-2
                          text-xs font-medium text-white shadow-sm transition hover:opacity-90">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <span data-btn-text>{{ $current ? 'Ganti gambar' : 'Pilih gambar' }}</span>
            </label>

            <input id="{{ $id }}" type="file" name="{{ $name }}"
                   accept="image/png,image/jpeg,image/webp"
                   data-input data-max-kb="{{ $maxKb }}" class="sr-only">
        </div>
    </div>

    @error($name) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

@once
<script>
    // Satu script untuk semua komponen upload di halaman
    document.addEventListener('change', function (e) {
        const input = e.target.closest('[data-input]');
        if (!input) return;

        const box      = input.closest('[data-upload]');
        const preview  = box.querySelector('[data-preview]');
        const holder   = box.querySelector('[data-placeholder]');
        const nameEl   = box.querySelector('[data-filename]');
        const noteEl   = box.querySelector('[data-note]');
        const btnText  = box.querySelector('[data-btn-text]');
        const file     = input.files[0];

        if (!file) return;

        const maxKb = parseInt(input.dataset.maxKb, 10);
        if (file.size > maxKb * 1024) {
            input.value = '';
            nameEl.textContent = 'File terlalu besar';
            nameEl.classList.add('text-red-600');
            noteEl.textContent = 'Maksimal ' + (maxKb >= 1024 ? (maxKb / 1024) + ' MB' : maxKb + ' KB') + '. Pilih file yang lebih kecil.';
            return;
        }

        nameEl.classList.remove('text-red-600');
        nameEl.textContent = file.name + ' (' + Math.max(1, Math.round(file.size / 1024)) + ' KB)';
        noteEl.textContent = 'Klik Simpan untuk menerapkan.';
        btnText.textContent = 'Ganti gambar';

        const reader = new FileReader();
        reader.onload = ev => {
            preview.src = ev.target.result;
            preview.classList.remove('hidden');
            holder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endonce