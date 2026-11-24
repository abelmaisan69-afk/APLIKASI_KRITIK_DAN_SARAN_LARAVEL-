@extends('layouts.public')

@section('title', 'Beranda')

@section('raw')
@php
    $heroUrl = \App\Models\Setting::url($biz['hero_image'] ?? null);
    $heroStyle = $heroUrl
        ? "background-image:linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),url('{$heroUrl}');background-size:cover;background-position:center"
        : '';
    $aboutUrl = \App\Models\Setting::url($biz['about_photo'] ?? null);
@endphp

{{-- A. HERO --}}
<section class="bg-primary text-white {{ $heroUrl ? '' : 'hero-grad' }}" style="{{ $heroStyle }}">
    <div class="max-w-6xl mx-auto px-4 py-20 md:py-28">
        @if ($promotions->isNotEmpty())
            <a href="{{ route('promo.index') }}"
               class="inline-block bg-accent text-ink text-sm font-semibold px-4 py-1.5 rounded-full mb-5">
                🔥 Promo: {{ $promotions->first()->nama }}
            </a>
        @endif
        <h1 class="text-3xl md:text-5xl font-bold leading-tight max-w-3xl">{{ $biz['hero_headline'] }}</h1>
        <p class="mt-4 text-white/90 max-w-2xl text-lg">{{ $biz['hero_subheadline'] }}</p>
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('catalog.index') }}"
               class="bg-accent text-ink font-semibold px-6 py-3 rounded-xl text-center hover:opacity-90 transition">
                {{ $biz['hero_btn1_text'] }}
            </a>
            <a href="{{ route('review.create') }}"
               class="border border-white/70 text-white font-medium px-6 py-3 rounded-xl text-center hover:bg-white/10 transition">
                {{ $biz['hero_btn2_text'] }}
            </a>
        </div>
    </div>
</section>

{{-- B. TENTANG KAMI --}}
<section class="max-w-6xl mx-auto px-4 py-14">
    <div class="grid md:grid-cols-2 gap-8 items-center">
        @if ($aboutUrl)
            <img src="{{ $aboutUrl }}" alt="{{ $biz['nama_usaha'] }}" loading="lazy"
                 class="w-full rounded-2xl shadow-sm object-cover max-h-96">
        @else
            <div class="w-full h-64 rounded-2xl bg-mint"></div>
        @endif
        <div>
            <p class="text-sm font-semibold text-primary uppercase tracking-wide">Tentang Kami</p>
            <h2 class="text-2xl md:text-3xl font-semibold mt-1">{{ $biz['nama_usaha'] }}</h2>
            @if ($biz['tahun_berdiri'])
                <p class="text-sm text-slate-500 mt-1">Berdiri sejak {{ $biz['tahun_berdiri'] }}</p>
            @endif
            <p class="mt-4 text-slate-600 whitespace-pre-line">{{ \Illuminate\Support\Str::limit($biz['about_story'] ?: $biz['deskripsi_usaha'], 350) }}</p>
            <div class="mt-4 text-sm text-slate-600 space-y-1">
                @if ($biz['alamat'])<p>📍 {{ $biz['alamat'] }}</p>@endif
                @if ($biz['jam_operasional'])<p class="whitespace-pre-line">🕒 {{ $biz['jam_operasional'] }}</p>@endif
            </div>
            <a href="{{ route('about') }}" class="inline-block mt-5 text-primary font-medium underline">Selengkapnya →</a>
        </div>
    </div>
</section>

{{-- C. PRODUK UNGGULAN --}}
@if ($featured->isNotEmpty())
<section class="bg-white py-14">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-end justify-between mb-6">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-wide">Pilihan Terbaik</p>
                <h2 class="text-2xl font-semibold">Produk Unggulan</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-primary font-medium underline text-sm">Lihat Semua Produk</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($featured as $p)
                <div class="bg-paper rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    <div class="relative aspect-square bg-slate-100">
                        @if ($p->foto_url)
                            <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" loading="lazy" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-2 left-2 bg-accent text-ink text-xs font-semibold px-2.5 py-1 rounded-full">★ Unggulan</span>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-slate-500">{{ $p->category->nama ?? 'Umum' }}</p>
                        <h3 class="font-semibold leading-snug">{{ $p->nama }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($p->deskripsi, 60) }}</p>
                        <p class="mt-2 font-semibold text-primary">{{ $p->harga_rupiah }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- D. PROMO SPESIAL --}}
@if ($promotions->isNotEmpty())
<section class="max-w-6xl mx-auto px-4 py-14">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-sm font-semibold text-primary uppercase tracking-wide">Penawaran</p>
            <h2 class="text-2xl font-semibold">Promo Spesial</h2>
        </div>
        <a href="{{ route('promo.index') }}" class="text-primary font-medium underline text-sm">Semua Promo</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($promotions as $promotion)
            @include('promo._card', ['promotion' => $promotion])
        @endforeach
    </div>
</section>
@endif

{{-- E. RATING SUMMARY + ULASAN --}}
<section id="ulasan" class="bg-white py-14 scroll-mt-16">
    <div class="max-w-6xl mx-auto px-4">
        <p class="text-sm font-semibold text-primary uppercase tracking-wide">Reputasi Kami</p>
        <h2 class="text-2xl font-semibold mb-6">Kata Pelanggan</h2>

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-mint rounded-2xl p-6 text-center">
                <p class="text-5xl font-bold text-primary">{{ $avg }}</p>
                <p class="text-2xl text-accent leading-none mt-2">
                    {{ str_repeat('★', (int) round($avg)) }}<span class="text-slate-300">{{ str_repeat('★', 5 - (int) round($avg)) }}</span>
                </p>
                <p class="text-sm text-slate-600 mt-2">dari {{ $total }} ulasan</p>
            </div>

            <div class="md:col-span-2 bg-paper rounded-2xl p-6 space-y-2">
                @for ($i = 5; $i >= 1; $i--)
                    @php
                        $jml = $dist[$i] ?? 0;
                        $persen = $total > 0 ? round($jml / $total * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-3 text-sm">
                        <span class="w-10 shrink-0">{{ $i }} ★</span>
                        <div class="flex-1 h-3 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-accent rounded-full" style="width: {{ $persen }}%"></div>
                        </div>
                        <span class="w-16 shrink-0 text-right text-slate-500">{{ $jml }} ({{ $persen }}%)</span>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Filter rating --}}
        <div class="flex flex-wrap gap-2 mb-5">
            <a href="{{ route('home') }}#ulasan"
               class="px-4 py-1.5 rounded-full text-sm {{ request('rating') ? 'bg-white border border-slate-200' : 'bg-primary text-white' }}">Semua</a>
            @for ($i = 5; $i >= 1; $i--)
                <a href="{{ route('home', ['rating' => $i]) }}#ulasan"
                   class="px-4 py-1.5 rounded-full text-sm {{ request('rating') == $i ? 'bg-primary text-white' : 'bg-white border border-slate-200' }}">
                    {{ $i }} ★
                </a>
            @endfor
        </div>

        {{-- Daftar ulasan --}}
        <div class="grid md:grid-cols-2 gap-4">
            @forelse ($reviews as $r)
                <div class="bg-paper rounded-2xl p-5">
                    <div class="flex justify-between items-start mb-1">
                        <p class="font-semibold">{{ $r->nama ?: 'Anonim' }}</p>
                        <p class="text-xs text-slate-500">{{ $r->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <p class="text-accent leading-none">
                        {{ str_repeat('★', $r->rating) }}<span class="text-slate-300">{{ str_repeat('★', 5 - $r->rating) }}</span>
                    </p>
                    <p class="text-xs text-slate-500 mt-1">{{ $r->category->nama }}</p>
                    <p class="mt-3 text-slate-700 whitespace-pre-line">{{ $r->isi }}</p>

                    @if ($r->reply)
                        <div class="mt-4 bg-mint rounded-xl p-3">
                            <p class="text-xs font-semibold text-primary mb-1">Balasan dari {{ $biz['nama_usaha'] }}</p>
                            <p class="text-sm whitespace-pre-line">{{ $r->reply->balasan }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="md:col-span-2 bg-paper rounded-2xl p-8 text-center text-slate-500">
                    Belum ada ulasan{{ request('rating') ? ' dengan rating ' . (int) request('rating') . ' bintang' : '' }}.
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $reviews->links() }}</div>
    </div>
</section>

{{-- F. CALL TO ACTION --}}
<section class="max-w-4xl mx-auto px-4 py-14">
    <div class="bg-primary text-white rounded-3xl p-8 md:p-12 text-center">
        <h2 class="text-2xl md:text-3xl font-semibold">{{ $biz['cta_title'] }}</h2>
        <p class="mt-3 text-white/85">{{ $biz['cta_text'] }}</p>
        <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('review.create') }}" class="bg-accent text-ink font-semibold px-6 py-3 rounded-xl hover:opacity-90 transition">Berikan Rating</a>
            <a href="{{ route('review.create') }}" class="border border-white/70 px-6 py-3 rounded-xl hover:bg-white/10 transition">Tulis Ulasan</a>
        </div>
        <p class="mt-5 text-sm text-white/70">
            Sudah pernah kirim? <a href="{{ route('review.history') }}" class="underline">Cek riwayat ulasan</a>
        </p>
    </div>
</section>
@endsection
