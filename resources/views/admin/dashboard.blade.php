@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Kartu statistik --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ([
        ['Total Ulasan', $stats['total']],
        ['Rata-rata Rating', $stats['rata'] . ' ★'],
        ['Rating 5 Bintang', $stats['lima']],
        ['Belum Dibalas', $stats['belum']],
    ] as [$label, $nilai])
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <p class="text-sm text-slate-500">{{ $label }}</p>
            <p class="text-3xl font-semibold text-primary mt-1">{{ $nilai }}</p>
        </div>
    @endforeach
</div>

{{-- Grafik --}}
<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Jumlah Ulasan per Bulan</h2>
        <div class="flex items-end gap-3 h-40">
            @foreach ($bulan as $b)
                <div class="flex-1 h-full flex flex-col justify-end items-center">
                    <span class="text-xs text-slate-500 mb-1">{{ $b['jumlah'] }}</span>
                    <div class="w-full bg-primary rounded-t-lg"
                         style="height: {{ max(2, round($b['jumlah'] / $maxJumlah * 85)) }}%"></div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-3 mt-2">
            @foreach ($bulan as $b)
                <span class="flex-1 text-center text-xs text-slate-500">{{ $b['label'] }}</span>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Perkembangan Rata-rata Rating</h2>
        <div class="flex items-end gap-3 h-40">
            @foreach ($bulan as $b)
                <div class="flex-1 h-full flex flex-col justify-end items-center">
                    <span class="text-xs text-slate-500 mb-1">{{ $b['rata'] ?: '-' }}</span>
                    <div class="w-full bg-accent rounded-t-lg"
                         style="height: {{ $b['rata'] ? max(2, round($b['rata'] / 5 * 85)) : 2 }}%"></div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-3 mt-2">
            @foreach ($bulan as $b)
                <span class="flex-1 text-center text-xs text-slate-500">{{ $b['label'] }}</span>
            @endforeach
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Distribusi bintang --}}
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-4">Distribusi Bintang</h2>
        <div class="space-y-2">
            @for ($i = 5; $i >= 1; $i--)
                @php
                    $jml = $dist[$i] ?? 0;
                    $persen = $stats['total'] > 0 ? round($jml / $stats['total'] * 100) : 0;
                @endphp
                <div class="flex items-center gap-3 text-sm">
                    <span class="w-8 shrink-0">{{ $i }} ★</span>
                    <div class="flex-1 h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-accent rounded-full" style="width: {{ $persen }}%"></div>
                    </div>
                    <span class="w-8 shrink-0 text-right text-slate-500">{{ $jml }}</span>
                </div>
            @endfor
        </div>
    </div>

    {{-- Ulasan terbaru --}}
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

    {{-- Aktivitas --}}
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
@endsection
