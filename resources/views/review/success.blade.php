@extends('layouts.public')

@section('title', 'Ulasan Terkirim')

@section('content')
<div class="bg-white rounded-2xl shadow-sm p-8 text-center">
    <div class="mx-auto w-20 h-20 rounded-full bg-mint flex items-center justify-center mb-4">
        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-2xl font-semibold text-primary mb-2">Terima kasih!</h1>
    <p class="text-slate-500 mb-6">Ulasanmu sudah kami terima. Simpan kode di bawah untuk mengecek riwayat dan balasan admin.</p>

    <div class="bg-mint rounded-xl p-4 mb-3">
        <p class="text-xs uppercase tracking-wide text-slate-500">Kode Ulasan</p>
        <p id="kode" class="text-2xl font-bold tracking-widest text-primary">{{ $kode }}</p>
    </div>

    <button id="salin" type="button"
            class="mb-6 text-sm font-medium text-primary border border-primary rounded-xl px-4 py-2 hover:bg-mint transition">
        Salin Kode
    </button>

    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('review.history', ['kode' => $kode]) }}"
           class="flex-1 bg-primary text-white py-3 rounded-xl font-medium hover:opacity-90 transition">Cek Riwayat Ulasan</a>
        <a href="{{ url('/') }}"
           class="flex-1 border border-slate-200 py-3 rounded-xl font-medium hover:bg-slate-50 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('salin').addEventListener('click', async function () {
        const kode = document.getElementById('kode').innerText;
        try {
            await navigator.clipboard.writeText(kode);
            this.innerText = 'Tersalin ✓';
        } catch (e) {
            this.innerText = 'Salin manual ya';
        }
        setTimeout(() => this.innerText = 'Salin Kode', 2000);
    });
</script>
@endpush
