@php $label = $promotion->status_label; @endphp

<div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
    <div class="relative aspect-[16/9] bg-mint">
        @if ($promotion->banner_url)
            <img src="{{ $promotion->banner_url }}" alt="{{ $promotion->nama }}" loading="lazy" class="w-full h-full object-cover">
        @endif
        @if ($promotion->persen)
            <span class="absolute top-3 left-3 bg-accent text-ink text-sm font-bold px-3 py-1 rounded-full">
                Hemat {{ $promotion->persen }}%
            </span>
        @endif
        <span class="absolute top-3 right-3 text-xs font-medium px-3 py-1 rounded-full
            {{ $label === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
            {{ $label === 'aktif' ? 'Promo Aktif' : ucfirst($label) }}
        </span>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <h2 class="font-semibold text-lg text-primary">{{ $promotion->nama }}</h2>
        <p class="text-sm text-slate-500 mt-1 flex-1">{{ $promotion->deskripsi }}</p>

        @if ($promotion->harga_diskon)
            <p class="mt-3">
                @if ($promotion->harga_normal)
                    <span class="text-sm text-slate-400 line-through mr-2">{{ \App\Models\Promotion::rupiah($promotion->harga_normal) }}</span>
                @endif
                <span class="text-xl font-bold text-primary">{{ \App\Models\Promotion::rupiah($promotion->harga_diskon) }}</span>
            </p>
        @endif

        <p class="text-xs text-slate-500 mt-3">
            {{ $promotion->tanggal_mulai->translatedFormat('d M Y') }} – {{ $promotion->tanggal_berakhir->translatedFormat('d M Y') }}
        </p>
    </div>
</div>
