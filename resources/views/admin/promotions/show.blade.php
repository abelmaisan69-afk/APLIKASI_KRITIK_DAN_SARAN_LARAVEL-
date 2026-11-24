@extends('layouts.admin')

@section('title', 'Preview Promo')

@section('content')
<a href="{{ route('admin.promotions.index') }}" class="text-sm text-primary underline">← Kembali ke daftar</a>

<p class="text-sm text-slate-500 mt-3 mb-4">Beginilah tampilan promo ini di website.</p>

<div class="max-w-md">
    @include('promo._card', ['promotion' => $promotion])
</div>
@endsection
