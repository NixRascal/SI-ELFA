<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $kuesioner->judul }} — Isi Survei</title>
</head>

<body class="bg-gray-50">
    <div class="isolate bg-white px-6 py-16 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">
                {{ $kuesioner->judul }}
            </h2>
            @if ($kuesioner->deskripsi)
                <p class="mt-3 text-gray-600">
                    {{ $kuesioner->deskripsi }}
                </p>
            @endif
            <p class="mt-2 text-sm text-gray-500">
                Batas waktu: {{ \Carbon\Carbon::parse($kuesioner->tanggal_selesai)->translatedFormat('d M Y') }}
            </p>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="mx-auto max-w-xl mt-6 rounded-md bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Info kesalahan umum --}}
        @if ($errors->any())
            <div class="mx-auto max-w-xl mt-6 rounded-md bg-red-50 p-4 text-red-700">
                Ada jawaban yang belum diisi. Silakan lengkapi lalu kirim lagi.
            </div>
        @endif

        <form action="{{ route('survey.store', $kuesioner->id) }}" method="POST" class="mx-auto mt-10 max-w-3xl">
            @csrf
            <input type="hidden" name="kuesioner_id" value="{{ $kuesioner->id }}">

            {{-- Daftar pertanyaan --}}
            <div class="space-y-6">
                @foreach ($pertanyaan as $index => $q)
                    <div class="rounded-lg border border-gray-200 bg-white p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Pertanyaan {{ $index + 1 }}
                                    @if ($q->kategori)
                                        • <span
                                            class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-blue-700">{{ $q->kategori }}</span>
                                    @endif
                                </p>
                                <h3 class="mt-1 text-gray-900 font-medium">
                                    {{ $q->teks_pertanyaan }}
                                </h3>
                            </div>
                            @if ($q->wajib_diisi)
                                <span
                                    class="shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-700">Wajib</span>
                            @endif
                        </div>

                        @if ($q->jenis_pertanyaan === 'likert')
                            {{-- Opsi likert --}}
                            <div class="mt-4 grid grid-cols-5 gap-2 text-center">
                                @for ($val = 1; $val <= 5; $val++)
                                    <label
                                        class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-2 py-2 hover:bg-gray-50">
                                        <input type="radio" name="jawaban[{{ $q->id }}]"
                                            value="{{ $val }}"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-600"
                                            @checked(old("jawaban.$q->id") == $val) @required($q->wajib_diisi)>
                                        <span class="text-sm text-gray-700">{{ $val }}</span>
                                    </label>
                                @endfor
                            </div>

                            {{-- Legend skala di bawah bulatan --}}
                            <div class="mt-3 grid grid-cols-2 gap-2 text-xs sm:grid-cols-5 text-center text-gray-600">
                                <span>Sangat Tidak Setuju</span>
                                <span>Tidak Setuju</span>
                                <span>Netral</span>
                                <span>Setuju</span>
                                <span>Sangat Setuju</span>
                            </div>

                            @error("jawaban.$q->id")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        @endif

                    </div>
                @endforeach
            </div>

            {{-- Tombol kirim --}}
            <div class="mt-8 flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali</a>
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</body>

</html>
