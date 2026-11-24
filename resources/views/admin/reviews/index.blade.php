@extends('layouts.admin')

@section('title', 'Manajemen Ulasan')

@section('content')
@php
    $badge = [
        'belum_dibalas' => ['Belum Dibalas', 'bg-amber-100 text-amber-800'],
        'sudah_dibalas' => ['Sudah Dibalas', 'bg-green-100 text-green-800'],
        'disembunyikan' => ['Disembunyikan', 'bg-slate-100 text-slate-600'],
    ];
@endphp

{{-- Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Total Ulasan</p>
        <p class="text-3xl font-semibold text-primary">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Rata-rata Rating</p>
        <p class="text-3xl font-semibold text-primary">{{ $stats['rata_rata'] }} <span class="text-accent">★</span></p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Belum Dibalas</p>
        <p class="text-3xl font-semibold text-primary">{{ $stats['belum_dibalas'] }}</p>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="bg-white rounded-2xl shadow-sm p-4 mb-6 grid grid-cols-1 md:grid-cols-6 gap-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / isi / kode"
           class="md:col-span-2 rounded-xl border border-slate-200 px-3 py-2 text-sm">
    <select name="rating" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
        <option value="">Semua rating</option>
        @for ($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" @selected(request('rating') == $i)>{{ $i }} bintang</option>
        @endfor
    </select>
    <select name="status" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
        <option value="">Semua status</option>
        @foreach ($badge as $key => $b)
            <option value="{{ $key }}" @selected(request('status') == $key)>{{ $b[0] }}</option>
        @endforeach
    </select>
    <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
    <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
    <div class="md:col-span-6 flex gap-2">
        <button class="bg-primary text-white px-5 py-2 rounded-xl text-sm font-medium">Terapkan</button>
        <a href="{{ route('admin.reviews.index') }}" class="border border-slate-200 px-5 py-2 rounded-xl text-sm">Reset</a>
    </div>
</form>

{{-- Daftar --}}
<div class="space-y-3">
    @forelse ($reviews as $r)
        <a href="{{ route('admin.reviews.show', $r) }}"
           class="block bg-white rounded-2xl shadow-sm p-5 hover:shadow transition">
            <div class="flex justify-between items-start gap-3 mb-1">
                <div>
                    <p class="font-semibold">{{ $r->nama ?: 'Anonim' }}
                        <span class="text-xs text-slate-400 font-normal ml-1">{{ $r->kode_ulasan }}</span>
                    </p>
                    <p class="text-xs text-slate-500">{{ $r->category->nama }} · {{ $r->created_at->diffForHumans() }}</p>
                </div>
                <span class="shrink-0 text-xs font-medium px-3 py-1 rounded-full {{ $badge[$r->status][1] }}">
                    {{ $badge[$r->status][0] }}
                </span>
            </div>
            <p class="text-accent leading-none mb-2">
                {{ str_repeat('★', $r->rating) }}<span class="text-slate-300">{{ str_repeat('★', 5 - $r->rating) }}</span>
            </p>
            <p class="text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($r->isi, 160) }}</p>
        </a>
    @empty
        <div class="bg-white rounded-2xl shadow-sm p-8 text-center text-slate-500">Belum ada ulasan yang cocok.</div>
    @endforelse
</div>

<div class="mt-6">{{ $reviews->links() }}</div>
@endsection
