@extends('layouts.public')

@section('title', 'Berikan Ulasan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
    <h1 class="text-2xl font-semibold text-primary mb-1">Berikan Ulasan</h1>
    <p class="text-slate-500 mb-6">Pengalamanmu sangat berarti untuk kami.</p>

    <form method="POST" action="{{ route('review.store') }}" class="space-y-5">
        @csrf

        {{-- honeypot: disembunyikan dari manusia, bot biasanya mengisinya --}}
        <div style="position:absolute;left:-9999px" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama (opsional)</label>
            <input type="text" name="nama" value="{{ old('nama') }}" maxlength="100"
                   placeholder="Kosongkan untuk anonim"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30">
            @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Rating</label>
            <div class="stars">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" @checked(old('rating') == $i)>
                    <label for="star{{ $i }}" title="{{ $i }} bintang">★</label>
                @endfor
            </div>
            @error('rating') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="review_category_id"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30">
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('review_category_id') == $c->id)>{{ $c->nama }}</option>
                @endforeach
            </select>
            @error('review_category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kritik dan saran</label>
            <textarea name="isi" rows="5" maxlength="2000"
                      class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30">{{ old('isi') }}</textarea>
            @error('isi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button class="w-full bg-primary text-white font-medium py-3 rounded-xl hover:opacity-90 transition">
            Kirim Ulasan
        </button>

        <p class="text-center text-sm text-slate-500">
            Sudah pernah kirim? <a href="{{ route('review.history') }}" class="text-primary font-medium underline">Cek riwayat ulasan</a>
        </p>
    </form>
</div>
@endsection
