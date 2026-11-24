@extends('layouts.admin')

@section('title', 'Pengaturan Usaha')

@section('content')
@php
    $fields = [
        ['nama_usaha',      'Nama usaha', 'text'],
        ['tahun_berdiri',   'Tahun berdiri', 'number'],
        ['alamat',          'Alamat', 'textarea'],
        ['whatsapp',        'Nomor WhatsApp', 'text'],
        ['email',           'Email', 'email'],
        ['instagram',       'Instagram (contoh: @namausaha)', 'text'],
        ['jam_operasional', 'Jam operasional (boleh beberapa baris)', 'textarea'],
        ['deskripsi_usaha', 'Deskripsi usaha', 'textarea'],
    ];
@endphp

<form method="POST" action="{{ route('admin.settings.usaha.update') }}"
      class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-5">
    @csrf @method('PUT')
    @include('admin.settings._fields')
    <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan Perubahan</button>
</form>
@endsection
