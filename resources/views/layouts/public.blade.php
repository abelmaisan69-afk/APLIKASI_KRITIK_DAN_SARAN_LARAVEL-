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

        /* ===== Menu mobile ===== */
#nav-mobile {
    grid-template-rows: 0fr;
    visibility: hidden;
    transition: grid-template-rows .35s ease, visibility .35s;
}
#nav-mobile.is-open {
    grid-template-rows: 1fr;
    visibility: visible;
    box-shadow: 0 12px 24px rgb(0 0 0 / .08);
}
#nav-mobile a {
    opacity: 0;
    transform: translateY(-6px);
    transition: opacity .25s ease, transform .25s ease;
}
#nav-mobile.is-open a {
    opacity: 1;
    transform: none;
    transition-delay: calc(var(--i) * 45ms + 100ms);
}

#nav-overlay {
    position: fixed;
    inset: 4rem 0 0 0;
    z-index: 30;
    background: rgb(0 0 0 / .4);
    opacity: 0;
    visibility: hidden;
    transition: opacity .3s ease, visibility .3s;
}
#nav-overlay.is-open { opacity: 1; visibility: visible; }

/* ikon hamburger -> X */
.burger span {
    display: block; height: 2px; width: 20px; border-radius: 2px;
    background: currentColor;
    transition: transform .3s ease, opacity .2s ease;
}
.burger.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.burger.is-open span:nth-child(2) { opacity: 0; }
.burger.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

@media (prefers-reduced-motion: reduce) {
    #nav-mobile, #nav-mobile a, #nav-overlay, .burger span { transition: none !important; }
}

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

            <button id="nav-toggle" type="button" aria-label="Menu" aria-controls="nav-mobile" aria-expanded="false"
        class="burger md:hidden flex h-10 w-10 flex-col items-center justify-center gap-[5px]
               rounded-lg border border-slate-200 text-ink">
    <span></span><span></span><span></span>
</button>
        </div>

        <div id="nav-mobile" class="grid md:hidden absolute inset-x-0 top-full bg-white border-t border-slate-100">
    <div class="overflow-hidden">
        <div class="px-4 py-3 space-y-1 text-sm">
            @foreach ($links as [$label, $href, $aktif])
                <a href="{{ $href }}" style="--i: {{ $loop->index }}"
                   class="block py-2.5 {{ $aktif ? 'text-primary font-semibold' : 'text-slate-600' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('review.create') }}" style="--i: {{ count($links) }}"
               class="block text-center bg-primary text-white py-2.5 rounded-xl font-medium mt-2">Berikan Ulasan</a>
        </div>
    </div>
</div>
    </header>

    <div id="nav-overlay" class="md:hidden"></div>

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
    const navBtn     = document.getElementById('nav-toggle');
    const navPanel   = document.getElementById('nav-mobile');
    const navOverlay = document.getElementById('nav-overlay');

    function setNav(buka) {
        [navBtn, navPanel, navOverlay].forEach(e => e.classList.toggle('is-open', buka));
        navBtn.setAttribute('aria-expanded', buka);
        document.body.classList.toggle('overflow-hidden', buka);
    }

    navBtn.addEventListener('click', () => setNav(!navPanel.classList.contains('is-open')));
    navOverlay.addEventListener('click', () => setNav(false));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') setNav(false); });
    navPanel.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setNav(false)));
    window.matchMedia('(min-width: 768px)').addEventListener('change', e => { if (e.matches) setNav(false); });
</script>
    @stack('scripts')
</body>
</html>
