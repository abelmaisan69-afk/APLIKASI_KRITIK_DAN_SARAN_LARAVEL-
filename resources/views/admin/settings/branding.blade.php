@extends('layouts.admin')

@section('title', 'Custom Branding')

@section('content')
@php
    $btnSama = empty($biz['color_button']);
    $btnVal  = $biz['color_button'] ?: $biz['color_primary'];
@endphp

<div class="grid lg:grid-cols-5 gap-6 max-w-5xl">
    <form method="POST" action="{{ route('admin.settings.branding.update') }}" enctype="multipart/form-data"
          class="lg:col-span-3 bg-white rounded-2xl shadow-sm p-6 space-y-5">
        @csrf @method('PUT')

        {{-- Preset --}}
        <div>
            <label class="block text-sm font-medium mb-2">Palet siap pakai</label>
            <div class="flex flex-wrap gap-2">
                @foreach (\App\Models\Setting::PRESETS as $nama => $w)
                    <button type="button" data-preset='@json($w)'
                            class="flex items-center gap-2 border border-slate-200 rounded-xl px-3 py-2 text-xs hover:border-slate-400">
                        <span class="flex">
                            @foreach ([$w[0], $w[1], $w[2]] as $c)
                                <span class="w-4 h-4 rounded-full -ml-1 first:ml-0 border border-white" style="background: {{ $c }}"></span>
                            @endforeach
                        </span>
                        {{ $nama }}
                    </button>
                @endforeach
            </div>
            <p class="text-xs text-slate-500 mt-2">Klik palet untuk mencoba, lihat hasilnya di preview, lalu simpan.</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama usaha</label>
            <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $biz['nama_usaha']) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('nama_usaha') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        @include('admin.settings._image', ['name' => 'logo', 'label' => 'Logo'])
        @include('admin.settings._image', ['name' => 'favicon', 'label' => 'Favicon (PNG persegi, maks 512 KB)'])
        @include('admin.settings._image', ['name' => 'bg_image', 'label' => 'Gambar background (opsional)'])

        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ([
                ['color_primary',   'Warna utama',    $biz['color_primary']],
                ['color_secondary', 'Warna sekunder', $biz['color_secondary']],
                ['color_accent',    'Warna aksen',    $biz['color_accent']],
                ['color_button',    'Warna tombol',   $btnVal],
            ] as [$name, $label, $val])
                <div>
                    <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                    <input type="color" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $val) }}"
                           class="w-full h-12 rounded-xl border border-slate-200 cursor-pointer">
                    @error($name) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" id="button_sama" name="button_sama" value="1" @checked($btnSama)>
            Warna tombol sama dengan warna utama
        </label>

        <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan Branding</button>
    </form>

    {{-- Preview langsung --}}
    <div class="lg:col-span-2">
        <p class="text-sm font-medium mb-2">Preview</p>
        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white">
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
    </div>
</div>

<script>
    const el = id => document.getElementById(id);

    function refresh() {
        const p = el('color_primary').value;
        el('pv-head').style.background = p;
        el('pv-body').style.background = el('color_secondary').value;
        el('pv-acc').style.background  = el('color_accent').value;
        el('pv-btn').style.background  = el('button_sama').checked ? p : el('color_button').value;
    }

    ['color_primary', 'color_secondary', 'color_accent', 'color_button'].forEach(id =>
        el(id).addEventListener('input', () => {
            if (id === 'color_button') el('button_sama').checked = false;
            refresh();
        })
    );
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
