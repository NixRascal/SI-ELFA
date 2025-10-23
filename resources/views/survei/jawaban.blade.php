<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Survei</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <main class="mx-auto max-w-5xl px-4 py-10">
        {{-- Judul halaman --}}
        <header class="mb-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jawaban Survei</h1>
            <p class="mt-2 text-gray-600">{{ $kuesioner->judul }}</p>
        </header>

        {{-- Ringkasan error form --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Beberapa isian belum benar</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $skalaLabel = [
                1 => 'Sangat Tidak Setuju',
                2 => 'Tidak Setuju',
                3 => 'Netral',
                4 => 'Setuju',
                5 => 'Sangat Setuju',
            ];
        @endphp

        {{-- Panel skala penilaian global, opsional --}}
        <section class="mb-8 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h2 class="mb-3 text-sm font-medium text-gray-700">Skala penilaian</h2>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-5">
                @foreach($skalaLabel as $angka => $teks)
                    <div class="flex flex-col items-center gap-1 rounded-lg border border-gray-200 px-4 py-3">
                        <span class="text-sm font-medium text-gray-900">{{ $angka }}</span>
                        <span class="text-xs text-gray-500 text-center leading-snug">{{ $teks }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Form jawaban --}}
        <form action="{{ route('survei.submit', $kuesioner->id) }}" method="POST" class="space-y-8">
            @csrf

            @foreach($pertanyaan as $i => $q)
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    {{-- Header pertanyaan: nomor, kategori, wajib diisi --}}
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-gray-500">
                            Pertanyaan {{ $q->urutan ?? $i + 1 }}
                        </div>

                        <div class="flex items-center gap-2">
                            @if(!empty($q->kategori))
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                    {{ $q->kategori }}
                                </span>
                            @endif

                            @if($q->wajib_diisi)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                    Wajib diisi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Teks pertanyaan --}}
                    <p class="mb-5 text-base font-medium text-gray-900">
                        {{ $q->teks_pertanyaan }}
                        @if($q->wajib_diisi) <span class="text-red-500">*</span> @endif
                    </p>

                    {{-- Jenis pertanyaan --}}
                    @if($q->jenis_pertanyaan === 'likert')
                        {{-- Likert 1–5. Keterangan ditempatkan di bawah radio --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-5">
                            @for($nilai = 1; $nilai <= 5; $nilai++)
                                <label class="flex flex-col items-center gap-2 rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50">
                                    <input
                                        type="radio"
                                        name="jawaban[{{ $q->id }}]"
                                        value="{{ $nilai }}"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-600"
                                        @checked(old("jawaban.{$q->id}") == $nilai)
                                        @required($q->wajib_diisi)
                                    >
                                    <span class="text-sm font-medium text-gray-900">{{ $nilai }}</span>
                                    <span class="text-xs text-gray-500 text-center leading-snug">
                                        {{ $skalaLabel[$nilai] }}
                                    </span>
                                </label>
                            @endfor
                        </div>
                    @elseif($q->jenis_pertanyaan === 'pilihan_ganda')
                        @php
                            $opsi = is_array($q->opsi_jawaban) ? $q->opsi_jawaban : json_decode($q->opsi_jawaban, true);
                        @endphp
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach($opsi as $ops)
                                <label class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50">
                                    <input
                                        type="radio"
                                        name="jawaban[{{ $q->id }}]"
                                        value="{{ $ops }}"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-600"
                                        @checked(old("jawaban.{$q->id}") == $ops)
                                        @required($q->wajib_diisi)
                                    >
                                    <span class="text-sm text-gray-900">{{ $ops }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <textarea
                            name="jawaban[{{ $q->id }}]"
                            rows="3"
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3.5 py-2 text-base text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            placeholder="Tulis jawaban Anda..."
                            @required($q->wajib_diisi)
                        >{{ old("jawaban.{$q->id}") }}</textarea>
                    @endif

                    {{-- Error per pertanyaan --}}
                    @error("jawaban.{$q->id}")
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </section>
            @endforeach

            {{-- Aksi bawah --}}
            <div class="flex items-center justify-between">
                {{-- <a href="{{ route('survei.profil', $kuesioner->id) }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Kembali ke Profil
                </a> --}}

                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </main>
</body>
</html>
