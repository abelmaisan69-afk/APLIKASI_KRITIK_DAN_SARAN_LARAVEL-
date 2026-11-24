@extends('layouts.admin')

@section('title', 'Detail Ulasan')

@section('content')
<a href="{{ route('admin.reviews.index') }}" class="text-sm text-primary underline">← Kembali ke daftar</a>

<div class="grid lg:grid-cols-3 gap-6 mt-4">
    {{-- Isi ulasan + balasan --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold text-lg">{{ $review->nama ?: 'Anonim' }}</p>
                    <p class="text-xs text-slate-500">
                        {{ $review->kode_ulasan }} · {{ $review->created_at->translatedFormat('d F Y, H:i') }}
                    </p>
                </div>
                <p class="text-2xl text-accent leading-none">
                    {{ str_repeat('★', $review->rating) }}<span class="text-slate-300">{{ str_repeat('★', 5 - $review->rating) }}</span>
                </p>
            </div>
            <p class="text-xs text-slate-500 mb-4">Kategori: {{ $review->category->nama }}</p>
            <p class="whitespace-pre-line">{{ $review->isi }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-3">{{ $review->reply ? 'Ubah Balasan' : 'Balas Ulasan' }}</h2>
            <form method="POST" action="{{ route('admin.reviews.reply', $review) }}" class="space-y-3">
                @csrf
                <textarea name="balasan" rows="4" maxlength="1000"
                          class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30"
                          placeholder="Tulis balasan untuk pelanggan...">{{ old('balasan', $review->reply->balasan ?? '') }}</textarea>
                @error('balasan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                <button class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium">Simpan Balasan</button>
            </form>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-3">Status Ulasan</h2>
            <form method="POST" action="{{ route('admin.reviews.status', $review) }}" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option value="belum_dibalas" @selected($review->status == 'belum_dibalas')>Belum Dibalas</option>
                    <option value="sudah_dibalas" @selected($review->status == 'sudah_dibalas')>Sudah Dibalas</option>
                    <option value="disembunyikan" @selected($review->status == 'disembunyikan')>Disembunyikan</option>
                </select>
                <button class="w-full border border-primary text-primary rounded-xl py-2 text-sm font-medium hover:bg-mint">
                    Perbarui Status
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-1 text-red-700">Hapus Ulasan</h2>
            <p class="text-xs text-slate-500 mb-3">Gunakan untuk ulasan yang melanggar ketentuan. Tindakan ini permanen.</p>
            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                  onsubmit="return confirm('Hapus ulasan ini secara permanen?')">
                @csrf @method('DELETE')
                <button class="w-full bg-red-600 text-white rounded-xl py-2 text-sm font-medium hover:bg-red-700">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
