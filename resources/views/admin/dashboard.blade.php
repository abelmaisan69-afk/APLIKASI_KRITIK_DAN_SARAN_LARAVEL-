@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Filter periode --}}
<div class="flex flex-wrap items-center gap-2 mb-6">
    <span class="text-sm text-slate-500 mr-1">Periode grafik:</span>
    @foreach ($opsi as $kunci => $label)
        <a href="{{ route('dashboard', ['periode' => $kunci]) }}"
           class="px-4 py-1.5 rounded-full text-sm transition
                  {{ $periode === $kunci ? 'bg-primary text-white' : 'bg-white border border-slate-200 hover:border-slate-400' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Kartu statistik --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Total Ulasan</p>
        <p class="text-3xl font-semibold text-primary mt-1">{{ $stats['total'] }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $stats['periode'] }} pada periode ini</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Rata-rata Rating</p>
        <p class="text-3xl font-semibold text-primary mt-1">{{ $stats['rata'] }} <span class="text-accent">★</span></p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Rating 5 Bintang</p>
        <p class="text-3xl font-semibold text-primary mt-1">{{ $stats['lima'] }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <p class="text-sm text-slate-500">Belum Dibalas</p>
        <p class="text-3xl font-semibold text-primary mt-1">{{ $stats['belum'] }}</p>
    </div>
</div>

{{-- Grafik --}}
<div id="dash-data" data-chart="{{ json_encode($grafik) }}" class="hidden"></div>

<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Jumlah Ulasan</h2>
        <div class="relative h-64"><canvas id="chart-jumlah"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Perkembangan Rata-rata Rating</h2>
        <div class="relative h-64"><canvas id="chart-rata"></canvas></div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Distribusi Bintang</h2>
        @if ($stats['total'] > 0)
            <div class="relative h-64"><canvas id="chart-dist"></canvas></div>
        @else
            <p class="text-sm text-slate-500">Belum ada ulasan.</p>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold">Ulasan Terbaru</h2>
            <a href="{{ route('admin.reviews.index') }}" class="text-xs text-primary underline">Semua</a>
        </div>
        <div class="space-y-3">
            @forelse ($terbaru as $r)
                <a href="{{ route('admin.reviews.show', $r) }}" class="block hover:bg-slate-50 rounded-lg p-2 -m-2">
                    <p class="text-sm font-medium">{{ $r->nama ?: 'Anonim' }}
                        <span class="text-accent">{{ str_repeat('★', $r->rating) }}</span>
                    </p>
                    <p class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($r->isi, 60) }}</p>
                </a>
            @empty
                <p class="text-sm text-slate-500">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Aktivitas Terbaru</h2>
        <ul class="space-y-3">
            @forelse ($aktivitas as $a)
                <li class="text-sm">
                    <p>{{ $a['teks'] }}</p>
                    <p class="text-xs text-slate-500">{{ $a['waktu']->diffForHumans() }}</p>
                </li>
            @empty
                <li class="text-sm text-slate-500">Belum ada aktivitas.</li>
            @endforelse
        </ul>
    </div>
</div>

@vite('resources/js/dashboard.js')
@endsection