@extends('layouts.admin')

@section('title', 'Custom Branding')

@section('content')
@php
    $btnSama = empty($biz['color_button'] ?? '');
    $btnVal  = ($biz['color_button'] ?? '') ?: $biz['color_primary'];
@endphp

<style>
    input[type=color] { -webkit-appearance: none; appearance: none; background: none; border: 0; padding: 0; }
    input[type=color]::-webkit-color-swatch-wrapper { padding: 0; }
    input[type=color]::-webkit-color-swatch { border: 0; border-radius: .6rem; }
    input[type=color]::-moz-color-swatch { border: 0; border-radius: .6rem; }
</style>

<div class="grid lg:grid-cols-5 gap-6 max-w-6xl">

    {{-- ============ FORM ============ --}}
    <form method="POST" action="{{ route('admin.settings.branding.update') }}" enctype="multipart/form-data"
          class="lg:col-span-3 space-y-6">
        @csrf @method('PUT')

        {{-- Identitas --}}
        <section class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
            <div>
                <h2 class="font-semibold text-primary">Identitas</h2>
                <p class="text-sm text-slate-500">Nama dan logo yang tampil di navbar, footer, dan halaman login.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama usaha</label>
                <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $biz['nama_usaha']) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30">
                @error('nama_usaha') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            @include('admin.settings._image', ['name' => 'logo', 'label' => 'Logo'])
            @include('admin.settings._image', [
                'name' => 'favicon', 'label' => 'Favicon',
                'hint' => 'PNG persegi, maksimal 512 KB.', 'maxKb' => 512,
            ])
        </section>

        {{-- Warna --}}
        <section class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
            <div>
                <h2 class="font-semibold text-primary">Warna</h2>
                <p class="text-sm text-slate-500">Pilih palet siap pakai, atau atur tiap warna sendiri.</p>
            </div>

            <div>
                <p class="text-sm font-medium mb-2">Palet siap pakai</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach (\App\Models\Setting::PRESETS as $nama => $w)
                        <button type="button" data-preset='@json($w)'
                                class="flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-left text-xs
                                       transition hover:border-primary hover:bg-slate-50">
                            <span class="flex shrink-0">
                                @foreach ([$w[0], $w[1], $w[2]] as $c)
                                    <span class="-ml-1 h-5 w-5 rounded-full border-2 border-white first:ml-0 shadow-sm"
                                          style="background: {{ $c }}"></span>
                                @endforeach
                            </span>
                            <span class="truncate font-medium">{{ $nama }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                @foreach ([
                    ['color_primary',   'Warna utama',    $biz['color_primary']],
                    ['color_secondary', 'Warna sekunder', $biz['color_secondary']],
                    ['color_accent',    'Warna aksen',    $biz['color_accent']],
                    ['color_button',    'Warna tombol',   $btnVal],
                ] as [$name, $label, $val])
                    <div id="row_{{ $name }}" class="flex items-center gap-3 rounded-xl border border-slate-200 p-3 transition">
                        <input type="color" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $val) }}"
                               class="h-11 w-14 shrink-0 cursor-pointer">
                        <div class="min-w-0">
                            <label for="{{ $name }}" class="block text-sm font-medium">{{ $label }}</label>
                            <span data-hex="{{ $name }}" class="text-xs uppercase text-slate-500">{{ old($name, $val) }}</span>
                        </div>
                    </div>
                    @error($name) <p class="text-red-600 text-sm sm:col-span-2">{{ $message }}</p> @enderror
                @endforeach
            </div>

            <label class="flex items-center gap-2 text-sm cursor-pointer">
                <input type="checkbox" id="button_sama" name="button_sama" value="1" class="rounded" @checked($btnSama)>
                Warna tombol sama dengan warna utama
            </label>
        </section>

        {{-- Background --}}
        <section class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
            <div>
                <h2 class="font-semibold text-primary">Gambar Latar</h2>
                <p class="text-sm text-slate-500">Opsional. Dipakai sebagai latar halaman website.</p>
            </div>
            @include('admin.settings._image', ['name' => 'bg_image', 'label' => 'Gambar background'])
        </section>

        <div class="flex items-center gap-3">
            <button class="bg-primary text-white px-8 py-3 rounded-xl text-sm font-medium shadow-sm hover:opacity-90 transition">
                Simpan Branding
            </button>
            <a href="{{ url('/') }}" target="_blank" class="text-sm text-primary underline">Lihat website</a>
        </div>
    </form>

    {{-- ============ PREVIEW ============ --}}
    <div class="lg:col-span-2">
        <div class="lg:sticky lg:top-24">
            <p class="text-sm font-medium mb-2">Preview</p>
            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm">
                <div id="pv-head" class="p-4 text-white font-semibold flex items-center gap-2">
                    @if (!empty($biz['logo']))
                        <img src="{{ \App\Models\Setting::url($biz['logo']) }}" alt="" class="h-8 w-8 object-contain rounded">
                    @endif
                    {{ $biz['nama_usaha'] }}
                </div>
                <div id="pv-body" class="p-5 space-y-3">
                    <p class="font-semibold">Contoh judul section</p>
                    <p class="text-sm text-slate-600">Beginilah kira-kira tampilan kartu dan tombol di website kamu.</p>
                    <div class="flex items-center gap-2">
                        <button type="button" id="pv-btn" class="text-white px-4 py-2 rounded-xl text-sm">Tombol</button>
                        <span id="pv-acc" class="inline-block text-sm font-semibold px-3 py-1 rounded-full text-slate-900">★ Aksen</span>
                    </div>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-2">Preview berubah langsung. Klik <b>Simpan Branding</b> untuk menerapkannya.</p>
        </div>
    </div>
</div>

<script>
    const el = id => document.getElementById(id);
    const warna = ['color_primary', 'color_secondary', 'color_accent', 'color_button'];

    function refresh() {
        const p = el('color_primary').value;
        const sama = el('button_sama').checked;

        el('pv-head').style.background = p;
        el('pv-body').style.background = el('color_secondary').value;
        el('pv-acc').style.background  = el('color_accent').value;
        el('pv-btn').style.background  = sama ? p : el('color_button').value;

        warna.forEach(id => {
            document.querySelector('[data-hex="' + id + '"]').textContent = el(id).value;
        });
        el('row_color_button').classList.toggle('opacity-40', sama);
    }

    warna.forEach(id => el(id).addEventListener('input', () => {
        if (id === 'color_button') el('button_sama').checked = false;
        refresh();
    }));
    el('button_sama').addEventListener('change', refresh);

    document.querySelectorAll('[data-preset]').forEach(b => {
        b.addEventListener('click', () => {
            const [p, s, a, t] = JSON.parse(b.dataset.preset);
            el('color_primary').value = p;
            el('color_secondary').value = s;
            el('color_accent').value = a;
            el('color_button').value = t;
            el('button_sama').checked = false;
            refresh();
        });
    });

    refresh();
</script>
@endsection