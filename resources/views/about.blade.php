@extends('layouts.public')

@section('title', 'Tentang Kami')
@section('width', 'max-w-4xl')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    @if (!empty($biz['about_photo']))
        <img src="{{ \App\Models\Setting::url($biz['about_photo']) }}" alt="{{ $biz['nama_usaha'] }}"
             class="w-full max-h-96 object-cover">
    @endif

    <div class="p-6 md:p-8 space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-primary">Tentang {{ $biz['nama_usaha'] }}</h1>
            @if ($biz['tahun_berdiri'])
                <p class="text-sm text-slate-500">Berdiri sejak {{ $biz['tahun_berdiri'] }}</p>
            @endif
        </div>

        <p class="whitespace-pre-line">{{ $biz['about_story'] ?: $biz['deskripsi_usaha'] }}</p>

        <div class="grid md:grid-cols-2 gap-4">
            @if ($biz['visi'])
                <div class="bg-mint rounded-xl p-5">
                    <h2 class="font-semibold text-primary mb-1">Visi</h2>
                    <p class="whitespace-pre-line">{{ $biz['visi'] }}</p>
                </div>
            @endif
            @if ($biz['misi'])
                <div class="bg-mint rounded-xl p-5">
                    <h2 class="font-semibold text-primary mb-1">Misi</h2>
                    <p class="whitespace-pre-line">{{ $biz['misi'] }}</p>
                </div>
            @endif
        </div>

        @if ($biz['nilai'])
            <div>
                <h2 class="font-semibold text-primary mb-1">Nilai Usaha</h2>
                <p class="whitespace-pre-line">{{ $biz['nilai'] }}</p>
            </div>
        @endif

        <div class="border-t border-slate-100 pt-5 text-sm text-slate-600 space-y-1">
            <h2 class="font-semibold text-primary text-base mb-1">Lokasi & Kontak</h2>
            @if ($biz['alamat'])<p>{{ $biz['alamat'] }}</p>@endif
            @if ($biz['jam_operasional'])<p class="whitespace-pre-line">{{ $biz['jam_operasional'] }}</p>@endif
            @if ($biz['whatsapp'])<p>WhatsApp: {{ $biz['whatsapp'] }}</p>@endif
            @if ($biz['email'])<p>Email: {{ $biz['email'] }}</p>@endif
        </div>
    </div>
</div>
@endsection
