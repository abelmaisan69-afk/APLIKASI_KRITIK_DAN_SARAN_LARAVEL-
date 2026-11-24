@extends('layouts.public')

@section('title', 'Katalog Produk')
@section('width', 'max-w-6xl')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-primary mb-1">Produk Kami</h1>
    <p class="text-slate-500">Temukan produk favoritmu.</p>
</div>

<form method="GET" class="flex flex-col sm:flex-row gap-2 mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
           class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 bg-white">
    @if (request('kategori'))
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
    @endif
    <button class="bg-primary text-white px-6 py-2.5 rounded-xl font-medium">Cari</button>
</form>

<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('catalog.index', array_filter(['q' => request('q')])) }}"
       class="px-4 py-1.5 rounded-full text-sm {{ request('kategori') ? 'bg-white border border-slate-200' : 'bg-primary text-white' }}">Semua</a>
    @foreach ($categories as $c)
        <a href="{{ route('catalog.index', array_filter(['q' => request('q'), 'kategori' => $c->id])) }}"
           class="px-4 py-1.5 rounded-full text-sm {{ request('kategori') == $c->id ? 'bg-primary text-white' : 'bg-white border border-slate-200' }}">
            {{ $c->nama }}
        </a>
    @endforeach
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse ($products as $p)
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition flex flex-col">
            <div class="relative aspect-square bg-slate-100">
                @if ($p->foto_url)
                    <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" loading="lazy" class="w-full h-full object-cover">
                @endif
                @if ($p->is_featured)
                    <span class="absolute top-2 left-2 bg-accent text-ink text-xs font-semibold px-2.5 py-1 rounded-full">★ Unggulan</span>
                @endif
            </div>
            <div class="p-4 flex-1 flex flex-col">
                <p class="text-xs text-slate-500">{{ $p->category->nama ?? 'Umum' }}</p>
                <h2 class="font-semibold leading-snug">{{ $p->nama }}</h2>
                <p class="text-sm text-slate-500 mt-1 flex-1">{{ \Illuminate\Support\Str::limit($p->deskripsi, 70) }}</p>
                <p class="mt-3 font-semibold text-primary">{{ $p->harga_rupiah }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-2xl p-10 text-center text-slate-500">Produk tidak ditemukan.</div>
    @endforelse
</div>

<div class="mt-8">{{ $products->links() }}</div>
@endsection
