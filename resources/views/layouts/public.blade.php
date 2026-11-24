@php
    $nama = $biz['nama_usaha'];
    $wa = preg_replace('/\D/', '', $biz['whatsapp'] ?? '');
    if (str_starts_with($wa, '0')) { $wa = '62' . substr($wa, 1); }
    $ig = ltrim($biz['instagram'] ?? '', '@');
    $bgStyle = !empty($biz['bg_image'])
    ? "background-image:url('" . \App\Models\Setting::url($biz['bg_image']) . "');background-size:cover;background-attachment:fixed"
    : '';

    $links = [
        ['Beranda',      url('/'),                 request()->is('/')],
        ['Tentang Kami', route('about'),           request()->routeIs('about')],
        ['Produk',       route('catalog.index'),   request()->routeIs('catalog.*')],
        ['Promo',        route('promo.index'),     request()->routeIs('promo.*')],
        ['Ulasan',       route('review.create'),   request()->routeIs('review.*')],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | {{ $nama }}</title>
    <meta name="description" content="@yield('description', \Illuminate\Support\Str::limit($biz['deskripsi_usaha'], 150))">
    <meta property="og:title" content="@yield('title', 'Beranda') | {{ $nama }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($biz['deskripsi_usaha'], 150) }}">
    @if (!empty($biz['hero_image']))
        <meta property="og:image" content="{{ \App\Models\Setting::url($biz['hero_image']) }}">
    @endif
    @if (!empty($biz['favicon']))
        <link rel="icon" href="{{ \App\Models\Setting::url($biz['favicon']) }}">
    @endif

    @include('partials.theme')

    <style>
        .stars { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
        .stars input { display: none; }
        .stars label { font-size: 2.5rem; line-height: 1; color: #cbd5e1; cursor: pointer; transition: color .15s; }
        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label { color: rgb(var(--c-accent)); }
    </style>
</head>
<body class="bg-paper text-ink font-sans min-h-screen flex flex-col" style="{{ $bgStyle }}">

    {{-- Navbar --}}
    <header class="bg-white/95 backdrop-blur sticky top-0 z-40 border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-semibold text-primary">
                @if (!empty($biz['logo']))
                    <img src="{{ \App\Models\Setting::url($biz['logo']) }}" alt="Logo" class="h-9 w-9 object-contain rounded-lg">
                @endif
                <span>{{ $nama }}</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">
                @foreach ($links as [$label, $href, $aktif])
                    <a href="{{ $href }}" class="{{ $aktif ? 'text-primary font-semibold' : 'text-slate-600 hover:text-primary' }}">{{ $label }}</a>
                @endforeach
                <a href="{{ route('review.create') }}" class="bg-primary text-white px-4 py-2 rounded-xl font-medium hover:opacity-90 transition">Berikan Ulasan</a>
            </nav>

            <button id="nav-toggle" type="button" aria-label="Menu"
                    class="md:hidden border border-slate-200 rounded-lg px-3 py-1.5 text-sm">☰</button>
        </div>

        <div id="nav-mobile" class="hidden md:hidden border-t border-slate-100 px-4 py-3 space-y-1 text-sm bg-white">
            @foreach ($links as [$label, $href, $aktif])
                <a href="{{ $href }}" class="block py-2 {{ $aktif ? 'text-primary font-semibold' : 'text-slate-600' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('review.create') }}" class="block text-center bg-primary text-white py-2.5 rounded-xl font-medium">Berikan Ulasan</a>
        </div>
    </header>

    @hasSection('raw')
    <div class="flex-1">@yield('raw')</div>
@else
    <main class="@yield('width', 'max-w-xl') mx-auto p-4 py-10 w-full flex-1">
        @yield('content')
    </main>
@endif


    {{-- Footer --}}
    <footer class="bg-primary text-white mt-10">
        <div class="max-w-6xl mx-auto px-4 py-10 grid gap-8 md:grid-cols-3 text-sm">
            <div>
                <div class="flex items-center gap-2 font-semibold text-lg mb-2">
                    @if (!empty($biz['logo']))
                        <img src="{{ \App\Models\Setting::url($biz['logo']) }}" alt="" class="h-9 w-9 object-contain rounded-lg bg-white/10">
                    @endif
                    {{ $nama }}
                </div>
                <p class="text-white/80">{{ $biz['footer_text'] ?: \Illuminate\Support\Str::limit($biz['deskripsi_usaha'], 160) }}</p>
            </div>

            <div class="space-y-1.5 text-white/90">
                <p class="font-semibold text-white mb-2">Kontak</p>
                @if ($biz['alamat'])<p>{{ $biz['alamat'] }}</p>@endif
                @if ($wa)<p>WhatsApp: <a class="underline" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">{{ $biz['whatsapp'] }}</a></p>@endif
               @if ($ig)<p>Instagram: <a class="underline" href="https://instagram.com/{{ $ig }}" target="_blank" rel="noopener">&#64;{{ $ig }}</a></p>@endif
                @if ($biz['email'])<p>Email: <a class="underline" href="mailto:{{ $biz['email'] }}">{{ $biz['email'] }}</a></p>@endif
            </div>

            <div class="text-white/90">
                <p class="font-semibold text-white mb-2">Jam Operasional</p>
                <p class="whitespace-pre-line">{{ $biz['jam_operasional'] ?: '-' }}</p>
            </div>
        </div>
        <div class="border-t border-white/15 text-center text-xs text-white/70 py-4">
            © {{ date('Y') }} {{ $nama }}. Semua hak dilindungi.
        </div>
    </footer>

    <script>
        document.getElementById('nav-toggle').addEventListener('click', () => {
            document.getElementById('nav-mobile').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
