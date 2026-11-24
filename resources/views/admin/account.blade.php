@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Profil --}}
    <form method="POST" action="{{ route('admin.account.profile') }}" class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <h2 class="font-semibold text-primary">Profil</h2>

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Simpan Profil</button>
    </form>

    {{-- Password --}}
    <form method="POST" action="{{ route('admin.account.password') }}" class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <h2 class="font-semibold text-primary">Ganti Password</h2>

        @foreach ([
            ['current_password',      'Password saat ini',        'current-password'],
            ['password',              'Password baru (min. 8 karakter)', 'new-password'],
            ['password_confirmation', 'Ulangi password baru',     'new-password'],
        ] as [$name, $label, $auto])
            <div>
                <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                <div class="relative">
                    <input type="password" name="{{ $name }}" autocomplete="{{ $auto }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 pr-16">
                    <button type="button" data-toggle
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500">Lihat</button>
                </div>
                @if ($name !== 'password_confirmation')
                    @error($name, 'password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                @endif
            </div>
        @endforeach

        <button class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">Ganti Password</button>
    </form>
</div>

<script>
    document.querySelectorAll('[data-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input');
            const tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            btn.textContent = tampil ? 'Sembunyi' : 'Lihat';
        });
    });
</script>
@endsection
