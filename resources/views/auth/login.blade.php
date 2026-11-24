@php
    $nama = $biz['nama_usaha'];
    $logo = \App\Models\Setting::url($biz['logo'] ?? null);
    $bg   = \App\Models\Setting::url($biz['bg_image'] ?? null);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | {{ $nama }}</title>
    <meta name="robots" content="noindex">
    @if (!empty($biz['favicon']))
        <link rel="icon" href="{{ \App\Models\Setting::url($biz['favicon']) }}">
    @endif
    @include('partials.theme')
</head>
<body class="bg-paper text-ink font-sans min-h-screen flex items-center justify-center p-4"
      @if ($bg) style="background-image:linear-gradient(rgba(255,255,255,.85),rgba(255,255,255,.85)),url('{{ $bg }}');background-size:cover" @endif>

    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            @if ($logo)
                <img src="{{ $logo }}" alt="Logo" class="h-16 w-16 object-contain rounded-xl mx-auto mb-3">
            @endif
            <h1 class="text-2xl font-semibold text-primary">{{ $nama }}</h1>
            <p class="text-sm text-slate-500">Masuk ke dashboard admin</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="bg-white rounded-2xl shadow-sm p-6 md:p-8 space-y-5">
            @csrf

            @if (session('status'))
                <div class="bg-green-100 text-green-800 rounded-xl p-3 text-sm">{{ session('status') }}</div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 pr-20 focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <button type="button" id="toggle-pw"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-primary font-medium">Lihat</button>
                </div>
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="rounded"> Ingat saya
            </label>

            <button class="w-full bg-primary text-white font-medium py-3 rounded-xl hover:opacity-90 transition">Login</button>
        </form>

        <p class="text-center mt-5 text-sm">
            <a href="{{ url('/') }}" class="text-primary underline">← Kembali ke website</a>
        </p>
    </div>

    <script>
        const pw = document.getElementById('password');
        const btn = document.getElementById('toggle-pw');
        btn.addEventListener('click', () => {
            const tampil = pw.type === 'password';
            pw.type = tampil ? 'text' : 'password';
            btn.textContent = tampil ? 'Sembunyi' : 'Lihat';
        });
    </script>
</body>
</html>
