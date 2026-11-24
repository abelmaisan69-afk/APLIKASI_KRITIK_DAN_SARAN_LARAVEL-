@php
    $cP = $biz['color_primary'];
    $cS = $biz['color_secondary'];
    $cA = $biz['color_accent'];
    $cB = $biz['color_button'] ?: $cP;
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --c-primary:      {{ \App\Models\Setting::rgb($cP) }};
        --c-primary-dark: {{ \App\Models\Setting::mix($cP, '#000000', 0.35) }};
        --c-secondary:    {{ \App\Models\Setting::rgb($cS) }};
        --c-accent:       {{ \App\Models\Setting::rgb($cA) }};
        --c-button:       {{ \App\Models\Setting::rgb($cB) }};
        --c-paper:        {{ \App\Models\Setting::mix($cS, '#FFFFFF', 0.82) }};
    }

    /* tombol memakai warna tombol, bukan warna utama */
    a.bg-primary, button.bg-primary { background-color: rgb(var(--c-button)); }

    /* gradien halus */
    .hero-grad { background-image: linear-gradient(135deg, rgb(var(--c-primary)), rgb(var(--c-primary-dark))); }
    footer.bg-primary, aside.bg-primary {
        background-image: linear-gradient(180deg, rgb(var(--c-primary)), rgb(var(--c-primary-dark)));
    }

    /* kartu lebih lembut */
    .shadow-sm { box-shadow: 0 1px 3px rgb(var(--c-primary) / .08), 0 4px 14px rgb(var(--c-primary) / .06); }
</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
