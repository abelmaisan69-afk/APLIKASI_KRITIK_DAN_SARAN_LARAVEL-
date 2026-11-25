@php
    $menu = [
        'Utama' => [
            ['Dashboard', 'dashboard', 'dashboard',
             'M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
        ],
        'Konten' => [
            ['Manajemen Ulasan', 'admin.reviews.index', 'admin.reviews.*',
             'M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z'],
            ['Manajemen Produk', 'admin.products.index', 'admin.products.*',
             'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
            ['Kategori Produk', 'admin.categories.index', 'admin.categories.*',
             'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6 6h.008v.008H6V6z'],
            ['Manajemen Promo', 'admin.promotions.index', 'admin.promotions.*',
             'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z'],
        ],
        'Tampilan Website' => [
            ['Pengaturan Homepage', 'admin.settings.homepage', 'admin.settings.homepage*',
             'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
            ['Custom Branding', 'admin.settings.branding', 'admin.settings.branding*',
             'M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z'],
            ['QR Code', 'admin.qr', 'admin.qr',
             'M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z'],
        ],
        'Pengaturan' => [
            ['Pengaturan Usaha', 'admin.settings.usaha', 'admin.settings.usaha*',
             'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72'],
            ['Pengaturan Akun', 'admin.account', 'admin.account*',
             'M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z'],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | {{ $biz['nama_usaha'] }}</title>
    <meta name="robots" content="noindex">
    @if (!empty($biz['favicon']))
        <link rel="icon" href="{{ \App\Models\Setting::url($biz['favicon']) }}">
    @endif
    @include('partials.theme')
</head>
<body class="bg-paper text-ink font-sans">
<div class="min-h-screen md:flex">

    {{-- Sidebar --}}
   {{-- Latar gelap (hanya di HP) --}}
<div id="overlay"
     class="fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none
            transition-opacity duration-300 motion-reduce:transition-none md:hidden"></div>

{{-- Sidebar --}}
<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85%] -translate-x-full flex-col overflow-y-auto
              bg-primary text-white shadow-2xl transition-transform duration-300 ease-out
              motion-reduce:transition-none
              md:sticky md:top-0 md:z-auto md:h-screen md:w-64 md:max-w-none md:translate-x-0
              md:shrink-0 md:shadow-none">

       {{-- Brand --}}
<div class="flex h-16 shrink-0 items-center justify-between border-b border-white/10 px-5">
    <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
        @if (!empty($biz['logo']))
            <img src="{{ \App\Models\Setting::url($biz['logo']) }}" alt="" class="h-9 w-9 rounded-lg bg-white/10 object-contain">
        @endif
        <span class="truncate font-semibold leading-tight">{{ $biz['nama_usaha'] }}</span>
    </a>
    <button id="close-menu" type="button" aria-label="Tutup menu"
            class="md:hidden rounded-lg px-2.5 py-1 text-lg leading-none text-white/80 hover:bg-white/10">✕</button>
</div>

        {{-- Menu --}}
        <nav class="flex-1 px-3 py-4">
            @foreach ($menu as $grup => $items)
                <p class="px-3 {{ $loop->first ? '' : 'mt-5' }} mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-white/50">
                    {{ $grup }}
                </p>
                <div class="space-y-0.5">
                    @foreach ($items as [$label, $rute, $pola, $ikon])
                        @php $aktif = request()->routeIs($pola); @endphp
                        <a href="{{ route($rute) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                                  {{ $aktif ? 'bg-white/15 font-medium text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6"
                                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $ikon }}"/>
                            </svg>
                            <span class="truncate">{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>

        {{-- Bawah: lihat website + logout --}}
        <div class="px-3 py-4 border-t border-white/10 space-y-0.5 shrink-0">
            <a href="{{ url('/') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                <span>Lihat Website</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 min-w-0">
        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-100 px-5 h-16 flex items-center justify-between sticky top-0 z-30">
            <button id="toggle" type="button" aria-controls="sidebar" aria-expanded="false"
        class="md:hidden border border-slate-200 rounded-lg px-3 py-1.5 text-sm">☰ Menu</button>
            <h1 class="font-semibold">@yield('title', 'Admin')</h1>
            <span class="text-sm text-slate-500 truncate max-w-[40%]">{{ auth()->user()->name }}</span>
        </header>

        <main class="p-5 md:p-8">
            @if (session('sukses'))
                <div class="bg-green-100 text-green-800 rounded-xl p-3 mb-5">{{ session('sukses') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggle  = document.getElementById('toggle');

    function setMenu(buka) {
        sidebar.classList.toggle('-translate-x-full', !buka);
        overlay.classList.toggle('opacity-0', !buka);
        overlay.classList.toggle('pointer-events-none', !buka);
        document.body.classList.toggle('overflow-hidden', buka);
        toggle.setAttribute('aria-expanded', buka);
    }

    toggle.addEventListener('click', () => setMenu(sidebar.classList.contains('-translate-x-full')));
    document.getElementById('close-menu').addEventListener('click', () => setMenu(false));
    overlay.addEventListener('click', () => setMenu(false));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') setMenu(false); });
    sidebar.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setMenu(false)));
    window.matchMedia('(min-width: 768px)').addEventListener('change', e => { if (e.matches) setMenu(false); });
</script>
</body>
</html>