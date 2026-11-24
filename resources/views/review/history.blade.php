@extends('layouts.public')

@section('title', 'Cek Riwayat Ulasan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
    <h1 class="text-2xl font-semibold text-primary mb-1">Cek Riwayat Ulasan Anda</h1>
    <p class="text-slate-500 mb-6">Masukkan kode ulasan yang kamu terima setelah mengirim ulasan.</p>

    <form method="GET" action="{{ route('review.history') }}" class="flex gap-2 mb-6">
        <input type="text" name="kode" value="{{ $kode }}" placeholder="ULS-XXXXXXXX" maxlength="20"
               class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 uppercase focus:outline-none focus:ring-2 focus:ring-primary/30">
        <button class="bg-primary text-white px-5 rounded-xl font-medium hover:opacity-90 transition">Cari</button>
    </form>

    @if ($kode !== '' && ! $review)
        <div class="bg-red-50 text-red-700 rounded-xl p-4">
            Kode tidak ditemukan. Periksa lagi penulisannya.
        </div>
    @endif

    @if ($review)
        @php
            $statusLabel = match ($review->status) {
                'belum_dibalas'  => ['Belum Dibalas', 'bg-amber-100 text-amber-800'],
                'sudah_dibaca'   => ['Sudah Dibaca', 'bg-slate-100 text-slate-700'],
                'sudah_dibalas'  => ['Sudah Dibalas', 'bg-green-100 text-green-800'],
                'disembunyikan'  => ['Disembunyikan', 'bg-slate-100 text-slate-600'],
                default          => [$review->status, 'bg-slate-100 text-slate-600'],
            };
        @endphp

        <div class="border border-slate-100 rounded-xl p-5">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold">{{ $review->nama ?: 'Anonim' }}</p>
                    <p class="text-xs text-slate-500">{{ $review->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <span class="text-xs font-medium px-3 py-1 rounded-full {{ $statusLabel[1] }}">{{ $statusLabel[0] }}</span>
            </div>

            <p class="text-2xl text-accent leading-none mb-1">
                {{ str_repeat('★', $review->rating) }}<span class="text-slate-300">{{ str_repeat('★', 5 - $review->rating) }}</span>
            </p>
            <p class="text-xs text-slate-500 mb-3">Kategori: {{ $review->category->nama }}</p>

            <p class="whitespace-pre-line">{{ $review->isi }}</p>

            @if ($review->reply)
                <div class="mt-4 bg-mint rounded-xl p-4">
                    <p class="text-xs font-semibold text-primary mb-1">Balasan Admin</p>
                    <p class="whitespace-pre-line">{{ $review->reply->balasan }}</p>
                </div>
            @endif
        </div>
    @endif

    <p class="text-center mt-6">
        <a href="{{ route('review.create') }}" class="text-primary font-medium underline text-sm">Tulis ulasan baru</a>
    </p>
</div>
@endsection
