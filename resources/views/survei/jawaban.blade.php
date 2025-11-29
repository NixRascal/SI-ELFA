@extends('layouts.app')
@section('content')
<div class="bg-gray-50 relative w-full min-h-screen flex flex-col">
    <div class="relative isolate px-4 sm:px-6 lg:px-8 flex-1 py-12">
        <div aria-hidden="true"
            class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                class="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#19328f] to-[#19328f] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]">
            </div>
        </div>

        <main class="mx-auto max-w-4xl relative">
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

        {{-- Form jawaban --}}
        <form action="{{ route('survei.jawaban.simpan', $kuesioner->id) }}" method="POST" class="space-y-8">
            @csrf

            @foreach ($pertanyaan as $i => $q)
                <section class="rounded-2xl border border-gray-100 bg-white p-6 sm:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    {{-- Header pertanyaan: nomor, kategori, wajib diisi --}}
                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
                            Pertanyaan {{ $q->urutan ?? $i + 1 }}
                        </div>

                        <div class="flex items-center gap-2">
                            @if (!empty($q->kategori))
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $q->kategori }}
                                </span>
                            @endif

                            @if ($q->wajib_diisi)
                                <span
                                    class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    Wajib diisi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Teks pertanyaan --}}
                    <p class="mb-6 text-lg font-medium text-gray-900 leading-relaxed">
                        {{ $q->teks_pertanyaan }}
                        @if ($q->wajib_diisi)
                            <span class="text-red-500">*</span>
                        @endif
                    </p>

                    {{-- Jenis pertanyaan --}}
                    {{-- Untuk pertanyaan Likert --}}
                    @if ($q->jenis_pertanyaan === 'likert')
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-5">
                            @for ($nilai = 1; $nilai <= 5; $nilai++)
                                @php
                                    $radioId = "jawaban_{$q->id}_{$nilai}";
                                @endphp
                                <label for="{{ $radioId }}"
                                    class="group relative flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-gray-100 bg-white p-4 hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all duration-200 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                    <input type="radio" id="{{ $radioId }}" name="jawaban[{{ $q->id }}]"
                                        value="{{ $nilai }}" class="sr-only peer"
                                        @checked(old("jawaban.{$q->id}") == $nilai) @required($q->wajib_diisi)>
                                    
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-sm font-bold text-gray-500 group-hover:bg-blue-200 group-hover:text-blue-700 peer-checked:bg-blue-600 peer-checked:text-white transition-colors">
                                        {{ $nilai }}
                                    </div>
                                    
                                    <span class="text-xs font-medium text-gray-500 text-center leading-snug group-hover:text-blue-700 peer-checked:text-blue-800">
                                        {{ $skalaLabel[$nilai] }}
                                    </span>
                                </label>
                            @endfor
                        </div>
                    @elseif($q->jenis_pertanyaan === 'pilihan_ganda')
                        {{-- Untuk pertanyaan pilihan ganda --}}
                        @php
                            $opsiJawaban = $q->opsi_jawaban;
                            if (is_string($opsiJawaban)) {
                                $decoded = json_decode($opsiJawaban, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $opsiJawaban = $decoded;
                                } else {
                                    $opsiJawaban = [$opsiJawaban];
                                }
                            }
                            $opsiJawaban = is_array($opsiJawaban) ? $opsiJawaban : [];
                        @endphp
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach ($opsiJawaban as $ops)
                                @php
                                    $radioId = "jawaban_{$q->id}_{$loop->index}";
                                @endphp
                                <label for="{{ $radioId }}"
                                    class="group flex items-center gap-3 rounded-xl border-2 border-gray-100 bg-white px-5 py-4 hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all duration-200 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                    <div class="relative flex items-center">
                                        <input type="radio" id="{{ $radioId }}" name="jawaban[{{ $q->id }}]"
                                            value="{{ $ops }}" class="peer h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-600"
                                            @checked(old("jawaban.{$q->id}") == $ops) @required($q->wajib_diisi)>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-800 peer-checked:text-blue-900">{{ $ops }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <textarea name="jawaban[{{ $q->id }}]" rows="4"
                            class="block w-full rounded-xl border-2 border-gray-300 p-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors resize-y"
                            placeholder="Tulis jawaban Anda di sini..." @required($q->wajib_diisi)>{{ old("jawaban.{$q->id}") }}</textarea>
                    @endif

                    {{-- Error per pertanyaan --}}
                    @error("jawaban.{$q->id}")
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </section>
            @endforeach
            <div class="flex items-center justify-center pt-6">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-lg hover:bg-blue-500 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <span>Kirim Jawaban</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
        </main>

    </div>

    <div class="mt-12">
        @include('layouts.footer')
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[type="radio"]');
        
        radios.forEach(radio => {
            // Initialize state based on current checked status
            radio.dataset.wasChecked = radio.checked ? 'true' : 'false';

            radio.addEventListener('click', function(e) {
                // If the radio was already checked before this click
                if (this.dataset.wasChecked === 'true') {
                    this.checked = false;
                    this.dataset.wasChecked = 'false';
                } else {
                    // Update the state for this group
                    const groupName = this.name;
                    // Reset 'wasChecked' for all radios in this group
                    document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                        r.dataset.wasChecked = 'false';
                    });
                    
                    // Mark this one as checked
                    this.dataset.wasChecked = 'true';
                }
            });
        });
    });
</script>
@endpush
@endsection
