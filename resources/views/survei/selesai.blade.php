<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei Selesai — {{ $kuesioner->judul }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-sm border border-gray-200">
            {{-- Icon Sukses --}}
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- Pesan Sukses --}}
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">{{ $message ?? 'Terima Kasih!' }}</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Jawaban Anda untuk survei "{{ $kuesioner->judul }}" telah berhasil disimpan.
                </p>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-6">
                <a href="{{ url('/') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>