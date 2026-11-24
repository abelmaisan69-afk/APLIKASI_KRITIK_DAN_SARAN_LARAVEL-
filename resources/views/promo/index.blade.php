@extends('layouts.public')

@section('title', 'Promo Spesial')
@section('width', 'max-w-6xl')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-primary mb-1">Promo Spesial</h1>
    <p class="text-slate-500">Penawaran yang sedang berlaku.</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse ($promotions as $promotion)
        @include('promo._card', ['promotion' => $promotion])
    @empty
        <div class="col-span-full bg-white rounded-2xl p-10 text-center text-slate-500">
            Belum ada promo aktif saat ini.
        </div>
    @endforelse
</div>
@endsection
