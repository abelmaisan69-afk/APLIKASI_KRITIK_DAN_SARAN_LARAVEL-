@extends('layouts.admin')

@section('title', 'Manajemen Promo')

@section('content')
@php
    $warna = [
        'aktif'     => 'bg-green-100 text-green-800',
        'terjadwal' => 'bg-blue-100 text-blue-800',
        'berakhir'  => 'bg-slate-100 text-slate-600',
        'nonaktif'  => 'bg-slate-100 text-slate-600',
    ];
@endphp

<div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari promo"
               class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
        <button class="bg-primary text-white px-4 py-2 rounded-xl text-sm">Cari</button>
        <a href="{{ route('admin.promotions.index') }}" class="border border-slate-200 px-4 py-2 rounded-xl text-sm">Reset</a>
    </form>
    <a href="{{ route('admin.promotions.create') }}"
       class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium text-center">+ Tambah Promo</a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-mint text-primary text-left">
            <tr>
                <th class="p-3">Banner</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Periode</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($promotions as $p)
            <tr class="border-t border-slate-100">
                <td class="p-3">
                    @if ($p->banner_url)
                        <img src="{{ $p->banner_url }}" alt="" class="w-24 h-14 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-14 rounded-lg bg-slate-100"></div>
                    @endif
                </td>
                <td class="p-3 font-medium">{{ $p->nama }}</td>
                <td class="p-3">
                    @if ($p->harga_diskon)
                        <span class="text-slate-400 line-through text-xs">{{ $p->harga_normal ? \App\Models\Promotion::rupiah($p->harga_normal) : '' }}</span><br>
                        {{ \App\Models\Promotion::rupiah($p->harga_diskon) }}
                    @else
                        -
                    @endif
                </td>
                <td class="p-3 text-slate-500 whitespace-nowrap">
                    {{ $p->tanggal_mulai->format('d/m/Y') }} – {{ $p->tanggal_berakhir->format('d/m/Y') }}
                </td>
                <td class="p-3">
                    <span class="text-xs px-3 py-1 rounded-full {{ $warna[$p->status_label] }}">{{ ucfirst($p->status_label) }}</span>
                </td>
                <td class="p-3">
                    <div class="flex gap-3 items-center whitespace-nowrap">
                        <a href="{{ route('admin.promotions.show', $p) }}" class="text-slate-600">Preview</a>
                        <a href="{{ route('admin.promotions.edit', $p) }}" class="text-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.promotions.toggle', $p) }}">
                            @csrf @method('PATCH')
                            <button class="text-slate-600">{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <form method="POST" action="{{ route('admin.promotions.destroy', $p) }}"
                              onsubmit="return confirm('Hapus promo ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-8 text-center text-slate-500">Belum ada promo.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $promotions->links() }}</div>
@endsection
