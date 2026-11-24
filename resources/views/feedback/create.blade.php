<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kritik & Saran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
<div class="bg-white w-full max-w-lg p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">Kritik & Saran</h1>

    @if (session('sukses'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('sukses') }}</div>
    @endif

    <form method="POST" action="{{ route('feedback.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">Nama (opsional)</label>
            <input name="nama" value="{{ old('nama') }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Email (opsional)</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Jenis</label>
            <select name="tipe" class="w-full border rounded p-2">
                <option value="kritik" @selected(old('tipe') == 'kritik')>Kritik</option>
                <option value="saran" @selected(old('tipe') == 'saran')>Saran</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Pesan</label>
            <textarea name="pesan" rows="5" class="w-full border rounded p-2">{{ old('pesan') }}</textarea>
            @error('pesan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Kirim</button>
    </form>
</div>
</body>
</html>
