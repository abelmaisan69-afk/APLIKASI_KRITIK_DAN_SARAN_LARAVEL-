@extends('layouts.admin')

@section('title', 'Kategori Produk')

@section('content')
<div class="max-w-xl space-y-6">
    <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded-2xl shadow-sm p-5 flex gap-2">
        @csrf
        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama kategori baru" maxlength="100"
               class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5">
        <button class="bg-primary text-white px-5 rounded-xl text-sm font-medium">Tambah</button>
    </form>
    @error('nama') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

    <div class="bg-white rounded-2xl shadow-sm divide-y divide-slate-100">
        @forelse ($categories as $c)
            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="font-medium">{{ $c->nama }}</p>
                    <p class="text-xs text-slate-500">{{ $c->products_count }} produk</p>
                </div>
                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}"
                      onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 text-sm">Hapus</button>
                </form>
            </div>
        @empty
            <p class="p-6 text-center text-slate-500">Belum ada kategori.</p>
        @endforelse
    </div>
</div>
@endsection
