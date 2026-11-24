<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Masukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Masukan</h1>

    @if (session('sukses'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('sukses') }}</div>
    @endif

    @foreach ($feedbacks as $f)
        <div class="bg-white p-4 rounded-lg shadow mb-3 {{ $f->sudah_dibaca ? 'opacity-60' : '' }}">
            <div class="flex justify-between text-sm text-gray-500">
                <span>
                    <b class="{{ $f->tipe == 'kritik' ? 'text-red-600' : 'text-green-600' }}">
                        {{ ucfirst($f->tipe) }}
                    </b>
                    dari {{ $f->nama ?? 'Anonim' }} {{ $f->email ? "($f->email)" : '' }}
                </span>
                <span>{{ $f->created_at->diffForHumans() }}</span>
            </div>
            <p class="my-2">{{ $f->pesan }}</p>
            <div class="flex gap-2">
                @unless ($f->sudah_dibaca)
                    <form method="POST" action="{{ route('feedback.read', $f) }}">
                        @csrf @method('PATCH')
                        <button class="text-blue-600 text-sm">Tandai dibaca</button>
                    </form>
                @endunless
                <form method="POST" action="{{ route('feedback.destroy', $f) }}"
                      onsubmit="return confirm('Hapus masukan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 text-sm">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $feedbacks->links() }}
</div>
</body>
</html>
