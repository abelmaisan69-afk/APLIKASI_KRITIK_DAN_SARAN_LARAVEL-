@extends('layouts.admin')

@section('title', 'Pengaturan Homepage')

@section('content')
@php
    $hero = [
        ['hero_headline',    'Headline', 'text'],
        ['hero_subheadline', 'Subheadline / deskripsi singkat', 'textarea'],
        ['hero_btn1_text',   'Teks tombol 1 (menuju Produk)', 'text'],
        ['hero_btn2_text',   'Teks tombol 2 (menuju Ulasan)', 'text'],
    ];
    $about = [
        ['about_story', 'Cerita / sejarah usaha', 'textarea'],
        ['visi',        'Visi', 'textarea'],
        ['misi',        'Misi (satu baris per poin)', 'textarea'],
        ['nilai',       'Nilai usaha', 'textarea'],
    ];
    $cta = [
        ['cta_title',   'Judul ajakan (Call to Action)', 'text'],
        ['cta_text',    'Teks ajakan', 'textarea'],
        ['footer_text', 'Teks footer (kosongkan untuk memakai deskripsi usaha)', 'textarea'],
    ];
@endphp

<div class="flex items-center justify-between max-w-2xl mb-4">
    <p class="text-sm text-slate-500">Simpan dulu, lalu klik Preview untuk melihat hasilnya.</p>
    <a href="{{ url('/') }}" target="_blank" class="border border-primary text-primary px-4 py-2 rounded-xl text-sm font-medium">Preview Website</a>
</div>

<form method="POST" action="{{ route('admin.settings.homepage.update') }}" enctype="multipart/form-data"
      class="space-y-6 max-w-2xl">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
        <h2 class="font-semibold text-primary">Hero Banner</h2>
        @include('admin.settings._image', ['name' => 'hero_image', 'label' => 'Gambar banner'])
        @include('admin.settings._fields', ['fields' => $hero])
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
        <h2 class="font-semibold text-primary">Tentang Kami</h2>
        @include('admin.settings._image', ['name' => 'about_photo', 'label' => 'Foto usaha'])
        @include('admin.settings._fields', ['fields' => $about])
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
        <h2 class="font-semibold text-primary">Ajakan & Footer</h2>
        @include('admin.settings._fields', ['fields' => $cta])
    </div>

    <p class="text-xs text-slate-500">
        Produk unggulan diatur lewat centang "Produk unggulan" di Manajemen Produk, dan section promo
        otomatis menampilkan promo yang sedang aktif.
    </p>

    <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan Perubahan</button>
</form>
@endsection
