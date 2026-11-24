<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Dashboard</title>
    <meta name="robots" content="noindex">
    @include('partials.theme')
</head>
<body class="bg-paper text-ink font-sans">
<div class="min-h-screen md:flex">

    {{-- Sidebar --}}
    <aside id="sidebar"
           class="hidden md:flex md:flex-col w-full md:w-64 bg-primary text-white p-5 md:min-h-screen">
        <p class="text-lg font-semibold mb-6">Dashboard Admin</p>
        <nav class="space-y-1 flex-1 text-sm">

            <a href="{{ route('dashboard') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Dashboard
</a>
            <a href="{{ route('admin.reviews.index') }}"
               class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.reviews.*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
                Manajemen Ulasan
            </a>
            <span class="block px-4 py-2.5 rounded-xl text-white/40"><a href="{{ route('admin.products.index') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Manajemen Produk
</a>
<a href="{{ route('admin.categories.index') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Kategori Produk
</a></span>
            <span class="block px-4 py-2.5 rounded-xl text-white/40"><a href="{{ route('admin.promotions.index') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.promotions.*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Manajemen Promo
</a></span>
            <span class="block px-4 py-2.5 rounded-xl text-white/40"><a href="{{ route('admin.settings.usaha') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.settings.usaha*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Pengaturan Usaha
</a>
<a href="{{ route('admin.settings.homepage') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.settings.homepage*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Pengaturan Homepage
</a>
<a href="{{ route('admin.settings.branding') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.settings.branding*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Custom Branding
</a>
<a href="{{ route('admin.qr') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.qr') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    QR Code
</a>
<a href="{{ route('admin.account') }}"
   class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.account*') ? 'bg-white/15 font-medium' : 'hover:bg-white/10' }}">
    Pengaturan Akun
</a>

</span>
        </nav>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left px-4 py-2.5 rounded-xl text-sm hover:bg-white/10">Logout</button>
        </form>
    </aside>

    <div class="flex-1 min-w-0">
        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-100 px-5 py-3 flex items-center justify-between">
            <button id="toggle" class="md:hidden border border-slate-200 rounded-lg px-3 py-1.5 text-sm">Menu</button>
            <h1 class="font-semibold">@yield('title', 'Admin')</h1>
            <span class="text-sm text-slate-500">{{ auth()->user()->name }}</span>
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
    document.getElementById('toggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('hidden');
    });
</script>
</body>
</html>
