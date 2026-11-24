@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between mb-6">
    <form method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
        <select name="kategori" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('kategori') == $c->id)>{{ $c->nama }}</option>
            @endforeach
        </select>
        <button class="bg-primary text-white px-4 py-2 rounded-xl text-sm">Cari</button>
        <a href="{{ route('admin.products.index') }}" class="border border-slate-200 px-4 py-2 rounded-xl text-sm">Reset</a>
    </form>
    <a href="{{ route('admin.products.create') }}"
       class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium text-center">+ Tambah Produk</a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-mint text-primary text-left">
            <tr>
                <th class="p-3">Foto</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($products as $p)
            <tr class="border-t border-slate-100">
                <td class="p-3">
                    @if ($p->foto_url)
                        <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" class="w-14 h-14 object-cover rounded-lg">
                    @else
                        <div class="w-14 h-14 rounded-lg bg-slate-100"></div>
                    @endif
                </td>
                <td class="p-3 font-medium">
                    {{ $p->nama }}
                    @if ($p->is_featured)
                        <span class="ml-1 text-xs bg-accent/20 text-amber-800 px-2 py-0.5 rounded-full">Unggulan</span>
                    @endif
                </td>
                <td class="p-3 text-slate-500">{{ $p->category->nama ?? '-' }}</td>
                <td class="p-3">{{ $p->harga_rupiah }}</td>
                <td class="p-3">
                    <span class="text-xs px-3 py-1 rounded-full {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="p-3">
                    <div class="flex gap-3 items-center whitespace-nowrap">
                        <a href="{{ route('admin.products.edit', $p) }}" class="text-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.products.toggle', $p) }}">
                            @csrf @method('PATCH')
                            <button class="text-slate-600">{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.destroy', $p) }}"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-8 text-center text-slate-500">Belum ada produk.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
