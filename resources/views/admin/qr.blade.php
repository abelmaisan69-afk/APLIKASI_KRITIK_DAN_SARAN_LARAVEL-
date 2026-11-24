@extends('layouts.admin')

@section('title', 'QR Code')

@section('content')
<style>#qr svg { width: 100%; height: auto; }</style>

<div class="bg-white rounded-2xl shadow-sm p-6 max-w-md mx-auto text-center">
    <h2 class="font-semibold text-lg text-primary mb-1">QR Code Website</h2>
    <p class="text-sm text-slate-500 mb-5">Cetak dan tempel di toko supaya pelanggan bisa langsung membuka website dan memberi ulasan.</p>

    <div id="qr" class="w-64 mx-auto bg-white p-2 rounded-xl border border-slate-100">{!! $svg !!}</div>

    <p id="link" class="mt-4 text-sm bg-mint rounded-xl px-3 py-2 break-all">{{ $link }}</p>

    <div class="flex flex-col sm:flex-row gap-3 mt-5">
        <button id="unduh" type="button" class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-medium">Unduh PNG</button>
        <button id="salin" type="button" class="flex-1 border border-primary text-primary py-2.5 rounded-xl text-sm font-medium">Salin Link</button>
    </div>

    <p class="text-xs text-slate-500 mt-4">
        Penting: sebelum dicetak, buka halaman ini lewat alamat domain asli website kamu.
        Kalau dibuka lewat <code>localhost</code>, QR akan mengarah ke localhost dan tidak bisa dipindai orang lain.
    </p>
</div>

<script>
    document.getElementById('unduh').addEventListener('click', () => {
        const svg = document.querySelector('#qr svg');
        const xml = new XMLSerializer().serializeToString(svg);
        const img = new Image();
        img.onload = () => {
            const c = document.createElement('canvas');
            c.width = c.height = 1024;
            const ctx = c.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, 1024, 1024);
            ctx.drawImage(img, 0, 0, 1024, 1024);
            c.toBlob(blob => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'qr-website.png';
                a.click();
                URL.revokeObjectURL(a.href);
            });
        };
        img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
    });

    document.getElementById('salin').addEventListener('click', async function () {
        try {
            await navigator.clipboard.writeText(document.getElementById('link').innerText);
            this.innerText = 'Tersalin ✓';
        } catch (e) {
            this.innerText = 'Salin manual ya';
        }
        setTimeout(() => this.innerText = 'Salin Link', 2000);
    });
</script>
@endsection
